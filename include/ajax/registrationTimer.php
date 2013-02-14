<?php
require("/var/www/mitmunc/include/functions.php");
connectDatabase();

//Read, Check, Sanitize Variables
sanitizeArray($_POST);
$user = user::newUser();
$password = generatePassword();
$user->username = $_POST['username'];
$user->passwordHash = crypt($password);
$user->loginType = 'timer';
$user->realName = $_POST['contactName'];
$user->email = $_POST['email'];
$user->phoneNumber = $_POST['phoneNumber'];
$user->committeeId = 0;
$user->schoolId = 0;
$user->lastLogin = date("Y-m-d H:i:s");
$user->lastLoginIP = getIP();
$user->saveInfo();
$user = new user($user->userId);

//Send email to secretariat
$headers = "MIME-Version: 1.0
Content-type: text/html; charset=iso-8859-1
From: secretariat@mitmunc.org";
//Send email to registrant
$message = "Hello  ".$user->realName."!<br />\n";
$message .= "    Thank you so much for registering to use the MITMUNC committee timer.  
<b>Your username is $user->username and your password is $password.</b>  
You can now visit <a href=\"http://www.mitmunc.org/login\">http://www.mitmunc.org/login</a> to log into your committee timer account.";
$message .="Jason Paller-Rzepka<br />";
$message .="MITMUNC 2013 Webmaster<br />";
sendEmail($user->email, 'MITMUNC Committee Timer Registration',$message);
   
function generatePassword($length=9) {
	$vowels = 'aeuy';
	$consonants = 'bdghjmnpqrstvz';
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
}
