<?php
require("/var/www/mitmunc/template/header_very_basic.php");

$SESSION->securityCheck(true, array('secretariat', 'school'));

$schoolId = $_POST['schoolId'];
$schoolId = sanitizeValue($schoolId);
$countries = json_decode($_POST['countries'], true);

$school = new school($schoolId);

$countries = sanitizeArray($countries);
for($i = 1; $i<=school::NUM_COUNTRY_PREFS; $i++){
    $school->countryId[$i] = $countries[$i];
}
$school->saveInfo();

$school = new school($SESSION->schoolId);

$to  = 'info@mitmunc.org';
$subject = 'MITMUNC country preference submission';
$message = '
The school '.$school->schoolName.' has submitted new country preferences:<br />';
for($i=1; $i<=school::NUM_COUNTRY_PREFS; $i++){
    $message .= 'Country '.$i.': '.$school->countryName[$i].'<br />';
}
// Mail it
sendEmail($to, $subject, $message);
