<?php
$title = "MITMUNC - Control Panel - Full Delegate Information List";
require("/var/www/mitmunc/template/header.php"); ?>
<h1>MITMUNC Attendee Information List</h1>

<p>Below is a list of all secretariat, chairs, delegates, and advisers expected to 
attend MITMUNC.  The secretariat and chairs list is generated from user logins.  
The delegate and advisers list is generated by the delegate info table that 
advisers fill out.  Repeated positions (not including the first occurence) are 
in bold.  See all attendees in a <a href="/controlpanel/secretariat/delegateinfocsv">csv file</a>.</p>
<br />
<?php
$SESSION->securityCheck(true, array('secretariat', 'chair'));

$personNum=1;

echo '<table class="bordered padded">';
echo '<tr><th>ID</th><th>Name</th><th>School</th><th>Committee</th><th>Country</th><th>Phone</th><th>E-mail</th><th>Hotel Room</th></tr>';
$result = mysql_query("SELECT id FROM users WHERE loginType='chair' OR loginType='secretariat'") or die(mysql_error());
while($row = mysql_fetch_array($result)){
    echo '<tr><td>';
    echo $personNum;
    echo '</td><td>';
    $personNum++;
    $user = new user($row['id']);
    echo ucwords(strtolower($user->realName));
    echo '</td><td>';
    echo 'MIT';
    echo '</td><td>';
    if($user->loginType == 'chair'){
        echo committee::getCommitteeShortName($user->committeeId);
    }else{
        echo 'SECRETARIAT POSITION HERE';
    }
    echo '</td><td>';
    echo $user->loginType;
    echo '</td><td>';
    echo $user->phoneNumber;
    echo '</td><td>';
    echo $user->email;
    echo '</td><td>';
    echo '</td></tr>';
}

$filledPositions = committee::getAllCommitteeShortNames();
foreach($filledPositions as $id => $shortNames){
    $filledPositions[$id] = array();
}
echo '<tr><th>ID</th><th>Name</th><th>School</th><th>Committee</th><th>Country</th><th>Phone</th><th>E-mail</th><th>Hotel Room</th></tr>';
$result = mysql_query("SELECT id FROM school") or die(mysql_error());
while($row = mysql_fetch_array($result)){
    $school = new school($row['id']);
    $advisersCount = 0;
    for($i=0; $i<count($school->attendees); $i++){
        echo '<tr><td>';
        echo $personNum;
        $personNum++;
        echo '</td><td>';
        echo ucwords(strtolower($school->attendees[$i]['name']));
        echo '</td><td>';
        echo $school->schoolName;
        echo '</td><td>';
        if($advisersCount >= $school->numAdvisers){
            if(array_key_exists($school->attendees[$i]['countryId'], $filledPositions[$school->attendees[$i]['committeeId']])){
                $warning = true;
            }else{
                $warning = false;
            }
            if($warning) echo '<b>';
            echo committee::getCommitteeShortName($school->attendees[$i]['committeeId']);
            if($warning) echo '</b>';
            echo '</td><td>';
            if($warning) echo '<b>';
            echo country::getCountryName($school->attendees[$i]['countryId']);
            if($warning) echo '</b>';
            $filledPositions[$school->attendees[$i]['committeeId']][$school->attendees[$i]['countryId']] = 1;
        }else{
            echo '**ADVISER**</td><td>**ADVISER**';
        }
        $advisersCount++;
        echo '</td><td>';
        echo $school->attendees[$i]['phone'];
        echo '</td><td>';
        echo $school->attendees[$i]['email'];
        echo '</td><td>';
        echo $school->attendees[$i]['room'];
        echo '</td></tr>';
    }
}
echo '</table>';
?>
<br />
<a href="/controlpanel/">Back to Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); ?>