<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class was made by Moses Mutuku and Virginia Waiti
 *
 * 1. View All Questions
 *      This method is for viewing all questions
 *
 * 2. View a Question
 *      This method is for viewing a particular question (mainly accessed when a user views notifications or read more answers)
 *      and displays the form for making a answer
 *
 * 3. Create Question
 *      This method is for validating and creating a question or answer
 *
 * 4. Answer a question
 *      This method is for validating and creating an answer for a question
 *
 * 5. Delete question
 *      This method is for deleting a question or an answer.
 *
 * 6. User Status
 *      This method is for checking if a user is registered and active. It wont stay here for too long
 *
 * 7. Content Owner
 *      This method is for getting the owner of an answer or question
 *
 */
class Question_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    /**
     * Method for recent questions and answers from specific user
     * @param <int> $userid the userid of the user to get questions and answers from
     * @return <array> an array containing the questions and answers
     */
    public function all($userid = 0, $count = 20, $start = 0) {
        // select id, question & parentid of questions from selected user. the questions should not be deleted.
        // either the user wrote the question or it was written on his wall.
        // limit them to 20

        // escape the data to be used in query that will not be automatically escaped
        $userid = $this->db->escape($userid);
        $start = $this->db->escape($start);

        $this->db->select('ID,question,parentid,ownersid,firstname,lastname,people.userid,questions.count')
                ->from('questions,people')
                ->where('parentid',0)
                ->where('deleted',0)
              
                ->where('people.userid = questions.userid','',false)
                ->limit($count,$start)
                ->order_by("date","desc");
        $questions = $this->db->get()->result_array();

        // array to hold all questions and answers to be displayed
        $final_result = array();

        // loop through the questions and get the answers
        foreach($questions as $question) {
            if($question['ownersid'] > 0) {
                $this->db->select('firstname,lastname,userid')
                        ->from('people')
                        ->where('userid',$question['ownersid']);
                $question_receiver = $this->db->get()->row_array();
                $question['rec_first'] = $question_receiver['firstname'];
                $question['rec_last'] = $question_receiver['lastname'];
                $question['rec_id'] = $question_receiver['userid'];
            }
            $this->db->select('ID,question,parentid,firstname,lastname,people.userid')
                    ->from('questions,people')
                    ->where('deleted = ',0)
                    ->where('parentid = ',$question['ID'])
                    ->where('people.userid = questions.userid','',false)
                    ->order_by("parentid","desc")
                    ->order_by("date","desc")
                    ->limit(3);
            $answer = $this->db->get();
            // push the current question into the final result array
            array_push($final_result,$question);

            // if the question has answers
            if($answer->num_rows() > 0) {
                // add these answers to the final result array
                $final_result = array_merge_recursive($final_result,array_reverse($answer->result_array()));
            }
        }

        // return the final result
        return $final_result;
    }

    /**
     * Method to view a specific question and it's answers
     * @param <int> $questionid the id of the question to to display
     * @return <array> the array containing the question and the answers
     */
    public function view2($questionid = 0) {
        // select the id, question, parentd of the questions and answers and ensure it's not been deleted
        $questionid = $this->db->escape($questionid );
        $this->db->select('ID,question,parentid,firstname,lastname,people.userid')
                ->from('questions,people')
                ->where('deleted = ',0)
                ->where('(ID = '.$questionid .' or parentid = '.$questionid .')','',false)
                ->where('people.userid = questions.userid','',false)
                ->order_by("ID");
        // get the array of results
        $questions = $this->db->get()->result_array();

        // return the result
        return $questions;
    }

    /**
     * The method for insterting an quesion into the db
     * @param <string> $text the question to post
     * @param <int> $id the ownersid  if a user is questioning on someone else's wall
     * @return <bool> return success or fail
     */
    public function create($text = '', $id = 0) {
        // if the question is not empty
        if($text != '') {
            // setup the data to be input
            $data = array(
                    'question' => $text ,
                    'userid' =>  $this->session->userdata['userid'],
                    'ownersid' => $id,
                    'date' => time()
            );
            // insert the data
            $this->db->insert('questions', $data);

            if($this->db->affected_rows()) {
                // get the ID of last question
                $up_id = $this->db->insert_id();

                // return the ID
                return $up_id;
            }
        }
        else {
            // if question is empty, just return false
            return false;
        }
    }

    /**
     * The method for creating an answer for a question
     * @param <int> $questionid the id of the question that the answer is written for
     * @par$update = am <string> $text the answer to post
     * @return <bool> return success or fail
     */
    public function answer ($questionid = 0, $text = '') {
        // if the question is not empty and there is a question specified
        if($questionid!=0 && $text != '') {
            // setup the data to be input
            $data = array(
                    'question' => $text ,
                    'userid' =>  $this->session->userdata['userid'],
                    'parentid' => $questionid,
                    'date' => time()
            );
            // insert the data
            $this->db->insert('questions', $data);
            // return the effect (will return 0 (false) if insert failed)
            if($this->db->affected_rows()) {
                // get the ID of last comment
                $com_id = $this->db->insert_id();

                // question to increase the number of answers that the question has
                $this->db->query('update questions set count = (count + 1) where id = '.$this->db->escape($questionid));
                
                // return the ID
                return $com_id;
            }
        }
        else {
            // if comment is empty or question is not specified, just return false
            return false;
        }
    }

    /**
     * Method to delete a question or answer
     * @param <type> $id the id of the question or answer
     * @return <type> success or failure indication
     */
    public function delete_question($id = 0) {
        // if the question/answer has been specified
        if($id!=0) {
            // check if the question exists and get it's details
            $this->db->select('parentid')
                    ->from('questions')
                    ->where('ID = ',$id);
            $question = $this->db->get()->row_array();

            // setup the data to be set
            $data = array(
                    'deleted' => 1
            );

            // set the data if the logged in userid is in the questions/answers userid or ownersid values
            $this->db->where('ID = ', $id)
                    ->where('(userid = '.$this->session->userdata['userid'].' or ownersid = '.$this->session->userdata['userid'].')',null,false)
                    ->update('questions',$data);

            // if that did not work, and it's a answer that is being deleted (only go through this part if answer, not question, is being deleted)
            if(!$this->db->affected_rows() && $question['parentid'] > 0) {
                // get the userid and ownersid of the question the answer is for if the userid or ownersid of the question are the logged in user
                $this->db->select('userid,ownersid')
                        ->from('questions')
                        ->where('ID = ',$question['parentid'])
                        ->where('(userid = '.$this->session->userdata['userid'].' or ownersid = '.$this->session->userdata['userid'].')',null,false);
                $up_parent = $this->db->get();

                // if the row is found then delete the answer
                if($up_parent->num_rows()) {
                    $this->db->where('ID = ', $id)
                            ->update('questions',$data);
                }
            }

            // if a comment was deleted, reduce the number of answers for the question
            if($this->db->affected_rows() && $question['parentid'] > 0) {
                $this->db->query('update questions set count = (count - 1) where id = '.$this->db->escape($question['parentid']));
            }

            // create an array indicating whether it was a answer/question and whether the process was successful
            return array(
                    'type' => $question['parentid'],
                    'success' => $this->db->affected_rows()
            );
        }
        else { // if no question/ answer is specified, return false
            return false;
        }
    }

    public function user_status($id = 0) {
        $this->db->select('userstatus')
                ->from('people')
                ->where('userid = ',$id);
        $questions = $this->db->get();

        if($questions->num_rows()) {
            $result = $questions->row_array();
            return ($result['userstatus']==0)?true:false;
        }
        else {
            return false;
        }
    }

    public function content_owner($contentid = 0) {

        if($contentid > 0) {

            $this->db->select('userid,ownersid')
                    ->from('questions')
                    ->where('ID = ',$contentid)
                    ->where('deleted = ',0);
            $questions = $this->db->get();

            if($questions->num_rows()) {
                $result = $questions->row_array();
                if($result['ownersid'] > 0) {
                    return $result['ownersid'];
                }
                else {
                    return $result['userid'];
                }
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }
}
/* End of file question_model.php */
/* Location: ./system/application/model/question_model.php */