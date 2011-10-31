<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Ukulima.net Reset</title>
	</head>
	<body>
		<p>Hi <b><?php echo $firstname.' '.$lastname; ?></b></p>
                <p>We have reset our database and you will now have to register again on the site to gain access.</p>
                <p>All your previous updates, messages and questions have been cleared. We deeply regret any inconvenience you will incur.</p>
		<p>Please click the following link to register on the site again.</p>
		<p><?php echo anchor('auth/register/', 'New Registration'); ?></p>
                <br /><br />
                <p>Regards</p>
                <p><b>Ukulima.net Administrator</b></p>
	</body>
</html>