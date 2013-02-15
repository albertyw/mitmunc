<?php
require("/var/www/mitmunc/template/header_very_basic.php");

$SESSION->securityCheck(true, array( 'chair', 'timer'));
if($SESSION->loginType == 'chair'){
    $committee = new committee($SESSION->committeeId);
    
    // Get all the countries/positions for the committee
    $ccMatrix = new ccMatrix();
    $rollCall = array();
    foreach($ccMatrix->matrix[$committee->committeeId] as $countryId => $one){
        if($one == 0) continue;
        $rollCall[$countryId] = array();
        $rollCall[$countryId]['countryName'] = country::getCountryName($countryId);
    }
    foreach($committee->specialPositions as $position){
        $position = 'special'.$position;
        $rollCall[$position] = array();
        $rollCall[$position]['countryName'] = country::getCountryName($position);
    }
    
    // Populate countries/positions with delegate information
    $schoolIds = school::getAllSchoolIds();
    foreach($schoolIds as $schoolId){
        $school = new school($schoolId);
        foreach($school->attendees as $attendee){
            if($attendee['committeeId'] != $committee->committeeId) continue;
            $rollCall[$attendee['countryId']]['schoolName'] = $school->schoolName;
            $rollCall[$attendee['countryId']]['name'] = $attendee['name'];
        }
    }
}else{
    // Get all countries
    $rollCall = array();
    $countries = country::getAllCountries();
    foreach($countries as $countryId => $countryName){
        $rollCall[$countryId] = array();
        $rollCall[$countryId]['countryName'] = $countryName;
    }
}

// Print Everything Out
$rowId=1;
$delegateNum = count($rollCall);

echo '[';

foreach($rollCall as $positionId => $attendee){
  echo '"'.$attendee['countryName'].'"';
  if ($rowId < $delegateNum) {
    echo ", ";
  }
  $rowId++;
}
echo ']';