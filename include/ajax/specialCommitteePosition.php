<?php
/**
 * This is used to update the applications sent in by schools for special committee positions
 * Called by /controlpanel/school/specialCommitteePosition.php
 **/
require("/var/www/mitmunc/template/header_very_basic.php");

$SESSION->securityCheck(true, array('secretariat', 'school'));

$positions = json_decode($_POST['positions']);
$positions = sanitizeArray($positions);
$numSpecialPositions = sanitizeValue($_POST['numSpecialPositions']);

// Save the number of special positions requested
$school = new school($SESSION->schoolId);
$school->numSpecialPositions = $numSpecialPositions;
$school->saveInfo();

// Delete previous special committee applications
$applications = specialCommitteePosition::getAllSchoolApplications($school->schoolId);
foreach($applications as $applicationId => $positionId){
    specialCommitteePosition::deleteApplication($applicationId);
}

// Add new special committee applications
foreach($positions as $positionId){
    specialCommitteePosition::newApplication($school->schoolId, $positionId);
}
