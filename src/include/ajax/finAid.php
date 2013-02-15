<?php
require("/var/www/mitmunc/template/header_very_basic.php");

$SESSION->securityCheck(true, array('secretariat', 'school'));

// Sanitize and save database inputs
$_POST = sanitizeArray($_POST);
$school = new school($_POST['schoolId']);
for($i=0;$i<=5;$i++){
    $school->finaidQuestion[$i] = $_POST['question'.$i];
}
$school->saveInfo();

// E-mail submit notification to info@mitmunc.org
$message = "<p>The financial aid application from $school->schoolName has been updated.</p>";
$message .= 'Why do you feel you/your school should receive financial aid for MITMUNC 2012?<br />';
$message .= $school->finaidQuestion[1].'<br />';
$message .= '<br />';
$message .= 'Does your organization receive any funds from your school in order to operate?  If so, how much and what does the funding usually go towards?<br />';
$message .= $school->finaidQuestion[2].'<br />';
$message .= '<br />';
$message .= 'Does your organization receive any funds from other sources such as fundraisers and outside donors?  If so, how much and what does the funding usually go towards?  If not, please explain your attempts.<br />';
$message .= $school->finaidQuestion[3].'<br />';
$message .= '<br />';
$message .= 'Approximately what percentage of students at your school currently receive some sort of financial assistance?<br />';
$message .= $school->finaidQuestion[4].'<br />';
$message .= '<br />';
$message .= 'Which other conferences with how many delegates does your delegation normally attend a year?<br />';
$message .= $school->finaidQuestion[5].'<br />';
$message .= '<br />';

$subject = "MITMUNC 2012 Financial Aid Application ($school->schoolName)";
sendEmail("info@mitmunc.org", $subject ,$message);
