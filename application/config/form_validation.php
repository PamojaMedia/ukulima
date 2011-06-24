<?php

/**
 * So, this is how the form validation will work
 *
 * The first set of variables will be strings that have the validation rules to be observed
 *
 * The second set of variables will be arrays that contail the field, label and rules
 *
 * The last part is the config array with the name of the validation rule and the arrays to be used to perform the validation
 *
 */


/**
 * Just a naming suggestion, the name of the variable should make sense to what it is validating and should be for general validation
 * Leave specifics to be appended in the config array...hope it makes sens
 */

$email = 'trim|required|valid_email|xss_clean';
$m_email = 'trim|valid_email|xss_clean';

$username = 'trim|required|min_length[5]|max_length[12]|alpha_dash|xss_clean';

$name = 'trim|required|alpha_numeric';

$password = 'required';

$phone_num = 'required|max_length[12]|min_length[10]|numeric';

$userid = 'required|numeric';

$update = 'required|max_length[400]|xss_clean';

$activation_code = 'required|xss_clean';

$number = 'required|numeric';

$message = 'required|max_length[2000]|xss_clean';

// this is for web
$receivers = 'required|callback_validate_receivers';

// this is for mobile
$mobile_receivers = 'required';

// search
$search = 'required|max_length[20]|xss_clean';

$subject = 'max_length[50]|xss_clean';

//this os for the user bio inforamtion

$activity = 'max_length[400]|xss_clean';
$interest = 'max_length[400]|xss_clean';
$location = 'max_length[400]|xss_clean';
$country = '';
$avatar = '';

$confirm = 'required|max_length[20]|xss_clean';

/**
 * This is the section for the configs. The first part is for where there will be registration. The second part is for general validation
 */

$new_email_config = array(
        'field'   => 'email',
        'label'   => 'Email Address',
        'rules'   => $email.'|callback_email_check'
    );

$new_m_email_config = array(
        'field'   => 'email',
        'label'   => 'Email Address',
        'rules'   => $m_email.'|callback_email_check'
    );

$new_username_config = array(
        'field'   => 'username',
        'label'   => 'Username',
        'rules'   => $username.'|callback_username_check'
    );

$new_firstname_config = array(
        'field' => 'firstname',
        'label' => 'First Name',
        'rules' => $name
    );

$new_lastname_config = array(
        'field' => 'lastname',
        'label' => 'Last Name',
        'rules' => $name
    );

$new_password_config = array(
        'field' => 'password1',
        'label' => 'Password',
        'rules' => $password.'|matches[password2]'
    );

$new_password2_config = array(
        'field' => 'password2',
        'label' => 'Confirm Password',
        'rules' => $password.'|matches[password1]'
    );

$phone_num_config = array(
        'field' => 'phonenumber',
        'label' => 'Phone Number',
        'rules' => $phone_num
    );

$new_phone_num_config = array(
        'field' => 'phonenumber',
        'label' => 'Phone Number',
        'rules' => $phone_num.'|callback_phone_number_check'
    );

$email_config = array(
        'field' => 'email',
        'label' => 'Email Address',
        'rules' => $email
    );
$username_config = array(
        'field' => 'username',
        'label' => 'Username',
        'rules' => $username
    );

$password_config = array(
        'field' => 'password',
        'label' => 'Password',
        'rules' => $password
    );

$activation_config = array(
        'field' => 'code',
        'label' => 'Verification Code',
        'rules' => $activation_code
    );

$update_config = array(
        'field' => 'update',
        'label' => 'Update',
        'rules' => $update
    );

$comment_config = array(
        'field' => 'comment[]',
        'label' => 'Comment',
        'rules' => $update
    );

$number_config = array(
        'field' => 'number',
        'label' => 'Number',
        'rules' => $number
    );

$message_config = array(
        'field' => 'message',
        'label' => 'Message',
        'rules' => $message
    );

$subject_config = array(
        'field' => 'subject',
        'label' => 'Subject',
        'rules' => $subject
    );

$receivers_config = array(
        'field' => 'receiver',
        'label' => 'Receiver',
        'rules' => $receivers
    );

$mobile_receivers_config = array(
        'field' => 'receivers[]',
        'label' => 'Receiver',
        'rules' => $mobile_receivers
    );
//this is bio information
$activity_config= array(
    'field'=> 'activity',
    'label'=> 'Activity',
    'rules' => $activity
);

$interest_config = array(
    'field' => 'interest',
    'label' => 'Interests',
    'rules' => $interest
);

$location_config = array(
    'field'=>'location',
    'label'=>'Location',
    'rules' => $location
);
$country_config = array(
    'field' => 'country',
    'label' => 'Country',
    'rules' => $country
);
$avatar_config = array(
    'field' => 'avatar',
    'label' => 'Avatar',
    'rules' => $avatar
);

$search_config = array(
    'field' => 'search',
    'label' => 'Search',
    'rules' => $search
);

$confirm_config = array(
    'field' => 'confirm',
    'label' => 'Confirmation',
    'rules' => $search
);
/**
 * Final section where now you name the validation and the fields to be validated
 */

$config = array (
        'login' => array($username_config,$password_config),
        'activation' => array($activation_config),
        'm-activation' => array($username_config, $activation_config),
        'mobile-activate' => array($username_config,$password_config,$activation_config),
        'register' => array($new_username_config,$new_firstname_config,$new_lastname_config,$new_phone_num_config,$new_email_config,$new_password_config,$new_password2_config),
        'm-register' => array($new_username_config,$new_firstname_config,$new_lastname_config,$new_phone_num_config,$new_m_email_config,$new_password_config,$new_password2_config,$confirm_config),
        'change_password' => array($password_config, $new_password_config, $new_password2_config),
        'forgot_password' => array($email_config),
        'm-forgot_password' => array($phone_num_config),
        'create_update' => array($update_config),
        'create_comment' => array($number_config,$comment_config),
        'delete_content' => array($number_config),
        'send_message' => array($receivers_config,$subject_config,$message_config),
        'reply_message' => array($message_config),
        'add_receivers' => array($mobile_receivers),
        'bio' => array($activity_config,$interest_config,$location_config,$country_config),
        'avatar' => array($avatar_config),
        'network_search' => array($search_config)
    );


/* End of file form_validation.php */
/* Location: ./application/config/form_validation.php */