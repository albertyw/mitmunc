<?php
$title = "MITMUNC - Control Panel - Full Delegate Information List";
require("/var/www/mitmunc/template/header.php"); ?>
<h1>Committee Roll Call List</h1>
<p>Below is a list of all of the delegates that should be in your committee.</p>
<?php
$SESSION->securityCheck(true, array('secretariat', 'chair'));
$committee = new committee($SESSION->committeeId);
echo 'Your committee: '.committee::getCommitteeShortName($committee->committeeId).'<br /><br />';

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

// Print Everything Out
$rowId=1;
$delegateNum = 0;
echo '<table class="bordered padded">';
echo '<tr><th>#</th><th>Country/Position</th><th>Delegate Name</th><th>School</th></tr>';
foreach($rollCall as $positionId => $attendee){
    echo '<tr>';
    echo '<td>'.$rowId.'</td>';
    $rowId++;
    echo '<td>'.$attendee['countryName'].'</td>';
    if(isset($attendee['name'])){
        echo '<td>'.$attendee['name'].'</td>';
        echo '<td>'.$attendee['schoolName'].'</td>';
        $delegateNum++;
    }else{
        echo '<td></td>';
        echo '<td></td>';
    }
    echo '</tr>';
}
echo '</table>';
echo 'Total Delegates: '.$delegateNum.'<br />';
?>
<br />
<a href="/controlpanel/">Back to Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
