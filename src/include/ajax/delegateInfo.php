<?php
require("/var/www/mitmunc/template/header_very_basic.php");

$SESSION->securityCheck(true, array('secretariat', 'school'));

$schoolId = sanitizeValue($_POST['schoolId']);
$totalAttendees = sanitizeValue($_POST['totalAttendees']);
$delegateInfo = $_POST['delegateInfo'];
$school = new school($schoolId);

$delegateInfo = json_decode($delegateInfo, true);
$school->attendees = array();
for($i = 0; $i < $totalAttendees; $i++){
    $school->attendees[$i] = $delegateInfo[$i];
}


$school->saveInfo();

echo 'True';
