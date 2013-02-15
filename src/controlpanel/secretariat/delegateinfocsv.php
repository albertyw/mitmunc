<?php
require("/var/www/mitmunc/template/header_basic.php"); 

$SESSION->securityCheck(true, array('secretariat'));
$personNum = 1;
echo '<pre>';
$result = mysql_query("SELECT id FROM users WHERE loginType='chair' OR loginType='secretariat'") or die(mysql_error());
while($row = mysql_fetch_array($result)){
    echo $personNum.',';
    $personNum++;
    $user = new user($row['id']);
    echo ucwords(strtolower($user->realName));
    echo ',';
    echo $user->loginType;
    echo ',';
    echo 'MIT';
    echo ',';
    if($user->loginType == 'chair'){
        echo committee::getCommitteeShortName($user->committeeId);
    }else{
        echo 'SECRETARIAT POSITION HERE';
    }
    echo ',';
    echo ucwords($user->loginType);
    echo "\n";
}
$result = mysql_query("SELECT id FROM school") or die(mysql_error());
while($row = mysql_fetch_array($result)){
    $school = new school($row['id']);
    $advisersCount = 0;
    for($i=0; $i<count($school->attendees); $i++){
        echo $personNum.',';
        $personNum++;
        echo ucwords(strtolower($school->attendees[$i]['name']));
        echo ',';
        echo $school->attendees[$i]['logintype'];
        echo ',';
        echo $school->schoolName;
        echo ',';
        if($advisersCount >= $school->numAdvisers){
            echo committee::getCommitteeShortName($school->attendees[$i]['committeeId']);
            echo ',';
            echo country::getCountryName($school->attendees[$i]['countryId']);
        }else{
            echo '**ADVISER**,**ADVISER**';
        }
        $advisersCount++;
        echo "\n";
    }
}
echo '</pre>';
