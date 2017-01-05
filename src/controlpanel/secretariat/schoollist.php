<?php
$title = "MITMUNC - Control Panel - List of Schools";
require("/var/www/mitmunc/template/header.php"); ?>

<h1>School List</h1>
<?php
//Check user's credentials
$SESSION->securityCheck(true, array('secretariat', 'chair'));

//Display list of schools
echo '<table class="padded bordered">';
echo '<tr><th>School Name</th><th>Adviser Email</th><th># Students</th><th># Advisers</th><th>Registration Date</th><th>Amount Owed</th><th>Contact Person</th><th>Address</th><th>Status</th></tr>';
$result = mysql_query("SELECT id FROM school ORDER BY regTime");
$totalAdvisers = 0;
$totalStudents = 0;
$readyAdvisers = 0;
$readyStudents = 0;
$contactEmails = "";
while($row = mysql_fetch_array($result)){
    $school = new school($row['id']);
    $school->getUsers();
    $totalAdvisers += $school->numAdvisers;
    $totalStudents += $school->numStudents;
    echo '<td><a href="/controlpanel/school/school?schoolId='.$school->schoolId.'">'.$school->schoolName.'</a></td>';
    echo '<td><a href="mailto:'.$school->users[0]->email.'">'.$school->users[0]->email.'</a></td>';
    echo '<td>'.$school->numStudents.'</td>';
    echo '<td>'.$school->numAdvisers.'</td>';
    echo '<td>'.$school->regTime.'</td>';
    echo '<td>'.$school->totalOwed.'</td>';
    echo '<td>';
    foreach($school->users as $schoolAdviser){
        echo '<a href="/controlpanel/secretariat/user?userId='.$schoolAdviser->userId.'">'.$schoolAdviser->realName.'</a><br />';
        $contactEmails .= obfuscateEmail($schoolAdviser->email).', ';
    }
    echo '</td>';
    echo '<td>'.$school->address['city'].', '.$school->address['state'].', '.$school->address['country'].'</td>';
    if ($school->status == "Waiting for country assignments"){
       echo '<td class="waitingCountryAssignments">'.$school->status.'</td>';
    } elseif ($school->status == "Waiting for country preferences"){
       echo '<td class="waitingCountryPreferences">'.$school->status.'</td>';
    } elseif ($school->status == "Waiting for finaid application"){
       echo '<td class="waitingFinAid">'.$school->status.'</td>';
    } elseif ($school->status == "Waiting for school fee payment"){
       echo '<td class="waitingSchoolPayment">'.$school->status.'</td>';
    } else {
        echo '<td>'.$school->status.'</td>';
    }
    echo '</tr>';
}
echo '</table>';
echo '<b>Summary</b><br />';
echo "Total Number of advisers: $totalAdvisers<br />";
echo "Total Number of students: $totalStudents<br />";
echo "Total Number of ready advisers: $readyAdvisers<br />";
echo "Total Number of ready students: $readyStudents<br />";
echo "All Adviser emails: $contactEmails<br />";
?>
<a href="/controlpanel/">Back To Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
