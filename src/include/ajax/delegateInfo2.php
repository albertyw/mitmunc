<?php
/**
 * This file gets a school and a selected committee and returns 
 * a list of countries and special committee positions that are 
 * allowed for the school/committee
 **/
require("/var/www/mitmunc/template/header_very_basic.php");

$SESSION->securityCheck(true, array('secretariat', 'school'));

$_POST = sanitizeArray($_POST);
$schoolId = $_POST['schoolId'];
$school = new school($schoolId);
$committeeId = $_POST['committeeId'];
$attendeeNum = $_POST['attendeeNum'];


// Find what positions the school has
$countries = $school->countryId;
$specialPositions = specialCommitteePosition::getAllSchoolApplications($schoolId);

// Find which of those positions are in the committee
$matrix = new ccMatrix();
foreach($countries as $countryId){
    if(!array_key_exists($committeeId, $matrix->matrix)) continue;
    if(!array_key_exists($countryId, $matrix->matrix[$committeeId])) continue;
    if($matrix->matrix[$committeeId][$countryId]!=0){
        $countryName = country::getCountryName($countryId);
        if($school->attendees[$attendeeNum]['countryId'] == $countryId){
            echo '<option value="'.$countryId.'" selected="selected">'.$countryName.'</option>';
        }else{
            echo '<option value="'.$countryId.'">'.$countryName.'</option>';
        }
    }
}
foreach($specialPositions as $applicationId => $positionId){
    $position = new specialCommitteePosition($positionId);
    if($position->committeeId == $committeeId){
        if($school->attendees[$attendeeNum]['countryId'] == 'special'.$positionId){
            echo '<option value="special'.$positionId.'" selected="selected">'.$position->positionName.'</option>';
        }else{
            echo '<option value="special'.$positionId.'">'.$position->positionName.'</option>';
        }
    }
}


