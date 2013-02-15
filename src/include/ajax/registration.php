<?php

$registrationOpen = FALSE;
if ($registrationOpen == FALSE) {
  die("<strong>Registration is now closed.</strong>");
}

require("/var/www/mitmunc/include/functions.php");
connectDatabase();

if(($_POST['schoolName'] == "" or !isset($_POST['schoolName']))) {
  die("<strong>Your registration could not be processed because one or more required field was left blank.</strong>");
}

//Read, Check, Sanitize Variables
$_POST = sanitizeArray($_POST);
$user = user::newUser();
$school = school::newSchool();
// Save School Values
$school->schoolName = $_POST['schoolName'];
$school->numStudents = $_POST['numStudents'];
$school->numAdvisers = $_POST['numAdvisers'];
$school->regTime = date("Y-m-d H:i:s");
$school->address['1'] = $_POST['address1'];
$school->address['2'] = $_POST['address2'];
$school->address['city'] = $_POST['city'];
$school->address['state'] = $_POST['state'];
$school->address['zip'] = $_POST['zip'];
$school->address['countryId'] = $_POST['countryId'];
$school->hearAboutUs = $_POST['hearAboutUs'];
$school->finAid = $_POST['finAid'];
$school->saveInfo();

// Save User values
$password = generatePassword();
$user->username = $_POST['username'];
$user->passwordHash = crypt($password);
$user->loginType = 'school';
$user->realName = $_POST['contactName'];
$user->email = $_POST['email'];
$user->phoneNumber = $_POST['phoneNumber'];
$user->committeeId = 0;
$user->schoolId = $school->schoolId;
$user->lastLogin = date("Y-m-d H:i:s");
$user->lastLoginIp = getIP();
$user->saveInfo();

// Refresh school and user
$school = new school($school->schoolId);
$school->getUsers();
$user = new user($school->users[0]->userId);


//Send email to new user
$variable = array(
  "Number of Students" => $school->numStudents,
  "Number of Advisers" => $school->numAdvisers,
  "Contact Name" => $user->realName,
  "E-mail Address" => $user->email,
  "City" => $school->address['city'],
  "State" => $school->address['state'],
  "Country" => $school->address['countryName'],
  "User Name" => $user->userName);
$subject = "[MITMUNC 2013] $school->schoolName Registration";

//Send email to registrant
$message = "Hello  ".$user->realName."!<br /><br />\n";
$waitMsg = "Hello  ".$user->realName."!<br /><br />\n";

$message .= "    Thank you so much for registering $school->schoolName for MITMUNC. We're extremely excited " .
"to have you on board for our fifth annual conference.<br /><br />" .
"<b>Your username is $user->username and your password is $password.</b><br /><br />" .
"You can now visit <a href=\"http://www.mitmunc.org/login\">http://www.mitmunc.org/login</a> to log onto your school's account.\n";  
$message .= "Once there, please select your country preferences by clicking \"Apply For Countries\" in the Control Panel. \n";
$message .= "The MITMUNC Secretariat assigns countries on a rolling basis.  You will receive your school's country assignments as soon as possible after we receive your school's payment. The earlier the funds are sent, the better chance your school has of representing its preferred countries.<br /><br />";

$waitMsg .= "Thank you so much for registering $school->schoolName for MITMUNC.".
"<b>Your username is $user->username and your password is $password.</b><br /><br />" .
"You can now visit <a href=\"http://www.mitmunc.org/login\">http://www.mitmunc.org/login</a> to log onto your school's account.<br /><br />\n".
"<b>You are receiving the following message because your school has been placed in our Registration Early Group II:</b><br /><br />".
"MITMUNC is characterized by our small committee size of less than or equal to 55 delegates per committee. In our attempts to keep our committee sizes small, we can only accommodate as many delegates as we can fit into our committees. Unfortunately, we have just hit our estimated capacity, as of 07 September 2012.<br /><br />".
"Currently, we are still finalizing the number of committees we have the resources to execute at MITMUNC 2013, which could be more than our estimate. This decision will be made by the <b>Early Registration deadline of October 15.</b><br /><br />".
"We are still accepting further online registrations into our system. Any registrations made between today and October 15 will be saved on a <u>temporary waitlist</u>, as <b>Early Group II</b>. On October 15, we will re-evaluate and finalize how many more delegates can be accommodated by our conference, and keep you posted accordingly.<br /><br />".
"We are requesting all schools <u>already registered</u>, placed in <b>Early Group I</b>, to please submit their school fees to us as soon as possible before October 15. Then, by October 15, whichever schools in <b>Group I</b>, who have not paid school fees, will be shifted to <b>Group II</b>. We will then shift schools from <b>Group II</b> to Group I based on when we receive school fees, until we hit capacity again.<br /><br />".
"We apologize for any inconveniences caused by our sudden change in registration policy. Please let us know if you have any concerns or questions. We are trying our best to increase our conference size for future years.<br /><br />";

$message .= "To see your invoice, click \"Invoice\" in the Make Payment page.  If you have any questions, please feel free to contact me by e-mail at <a href=\"mailto:info@mitmunc.org\">info@mitmunc.org</a>.<br />\n\n";
$message .= "<br/>Here is some relevant information:<br/>\n";
$waitMsg .= "<br/>Here is some relevant information:<br />\n";


foreach ($variable as $label => $value) {
  if ($value != "") {
    $message .= "- {$label}: {$value}<br/>\n";
    $waitMsg .= "- {$label}: {$value}<br/>\n";
  }
}

$message .= "<br/>Looking forward to seeing you in February,<br />\n";
$waitMsg .= "<br />Thank you for your interest in MITMUNC,<br />\n";

$message .= "Nikita Consul<br />\n";
$waitMsg .= "Nikita Consul<br />\n";

$message .= "MITMUNC 2013 Charg&eacute;e d'Affaires<br />";
$waitMsg .= "MITMUNC 2013 Charg&eacute;e d'Affaires<br />";

#sendEmail($user->email, $subject, $message);
#sendEmail($user->email, $subject, $waitMsg);

//NEW (SECOND) WAIT MESSAGE
//Send email to registrant
$waitMsg2 = "Hello  ".$user->realName."!<br /><br />\n";

$waitMsg2 .= "Thank you so much for registering $school->schoolName for MITMUNC.".
"<b>Your username is $user->username and your password is $password.</b><br /><br />" .
"You can now visit <a href=\"http://www.mitmunc.org/login\">http://www.mitmunc.org/login</a> to log onto your school's account.<br /><br />\n".
"<b>You are receiving the following message because your school has been placed on our Registration Wait-list:</b><br /><br />".
"MITMUNC is characterized by our small committee size of less than or equal to 55 delegates per committee. In our attempts to keep our committee sizes small, we can only accommodate as many delegates as we can fit into our committees. Unfortunately, we are close to hitting our estimated capacity, as of October 15, 2012.<br /><br />".
"We are still accepting further online registrations into our system. Any registrations made after October 15 will be saved on a wait-list along with other schools who have not yet paid the <b>school fee</b>. From October 15, 2012, onwards, receipt of the school fee according to your Registration date will determine priority for school placement in MITMUNC until our capacity is filled. <br /><br />".
"We apologize for any inconveniences caused by our sudden change in registration policy. Please let us know if you have any concerns or questions. We are trying our best to increase our conference size for future years.<br /><br />";

$waitMsg2 .= "<br/>Here is some relevant information:<br />\n";


foreach ($variable as $label => $value) {
  if ($value != "") {
    $waitMsg2 .= "- {$label}: {$value}<br/>\n";
  }
}

$waitMsg2 .= "<br />Thank you for your interest in MITMUNC,<br />\n";

$waitMsg2 .= "Nikita Consul<br />\n";

$waitMsg2 .= "MITMUNC 2013 Charg&eacute;e d'Affaires<br />";

sendEmail($user->email, $subject, $waitMsg2);




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
