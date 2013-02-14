<?php
$title = "MITMUNC - Control Panel - Full Financial Aid List";
require("/var/www/mitmunc/template/header.php"); ?>

<h1>Financial Aid/Payment List</h1>
<?php
//Check user's credentials
$SESSION->securityCheck(true, array('secretariat'));
?>
Schools who have indicate they want financial aid:
<table class="bordered">
<tr><th>School Name</th>
<th>Financial Aid Given</th>
<th>Payment Received</th>
<th>Delegates</th>
<th>Why do you feel you/your school should receive financial aid for MITMUNC 2012?</th>
<th>Does your organization receive any funds from your school in order to operate?</th>
<th>Does your organization receive any funds from other sources such as fundraisers?</th>
<th>Approximately what percentage of students at your school currently receive some sort of financial assistance?</th>
<th>Which other conferences with how many delegates does your delegation normally attend a year?</th>
<th>Edit</th>
</tr>
<?php
$result = mysql_query("SELECT id FROM school WHERE finaid='1' OR finaidQuestion1!=''");
while($row = mysql_fetch_array($result)){
    $school = new school($row['id']);
    echo '<tr><td>'.$school->schoolName.'</td>';
    echo '<td>'.$school->totalFinAid.'</td>';
    echo '<td>'.$school->totalPaid.'</td>';
    echo '<td>'.$school->numStudents.'</td>';
    echo '<td>'.substr($school->finaidQuestion[1],0,70);
    if(strlen($school->finaidQuestion[1])>70) echo '...';
    echo '</td>';
    echo '<td>'.substr($school->finaidQuestion[2],0,70);
    if(strlen($school->finaidQuestion[2])>70) echo '...';
    echo '</td>';
    echo '<td>'.substr($school->finaidQuestion[3],0,70);
    if(strlen($school->finaidQuestion[3])>70) echo '...';
    echo '</td>';
    echo '<td>'.substr($school->finaidQuestion[4],0,70);
    if(strlen($school->finaidQuestion[4])>70) echo '...';
    echo '</td>';
    echo '<td>'.substr($school->finaidQuestion[5],0,70);
    if(strlen($school->finaidQuestion[5])>70) echo '...';
    echo '</td>';
    echo '<td><a href="/controlpanel/school/finaid?schoolId='.$row['id'].'">Edit</a></td>';
    echo '</tr>';
}
echo '</table>';
?>
<br />
<a href="/controlpanel/">Back To Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
