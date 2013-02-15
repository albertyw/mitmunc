<?php
$title = "MITMUNC - Control Panel - Financial Aid Application";
require("/var/www/mitmunc/template/header.php"); ?>
<script type="text/javascript">
$(document).ready(function() {
    $("textarea").ckeditor();
});
function submitFinAid(){
    $.post(
        '/include/ajax/finAid',
        {
            question1:$("#question1").val(),
            question2:$("#question2").val(),
            question3:$("#question3").val(),
            question4:$("#question4").val(),
            question5:$("#question5").val(),
            schoolId:$("#schoolId").val(),
        },
        function(data){
            $("#finAidForm").html("Your financial aid application has been updated.  \
            The secretariat will contact you when we have made a decision regarding your application.  \
            If you wish to update your application, you may resubmit your form.");
        }
    );
}
</script>
<h1>MITMUNC Financial Aid Application</h1>
<p>We hope that MITMUNC's conference fees will not preclude any students or schools from attending our conference so 
we are offering financial aid to decrease school and delegate fees.  
Our policy for financial aid is to take off up to 20% of each student and/or school's registration fee for students and schools that require aid.  
However, we will also entertain requests for further financial aid due to extenuating circumstances on the part of specific students or schools.
We cannot offer financial aid for covering travel and accommodation costs. </p>
<?php
//Check user's credentials
$SESSION->securityCheck(true, array('secretariat', 'school'));

$school = new school($SESSION->schoolId);
$school->getUsers();

echo '<b>School Name:</b> '.$school->schoolName.'<br />';
echo '<b>Delegation Main Contact:</b> '.$school->users[0]->realName.'<br />';
echo '<b>Number of Delegates:</b> '.$school->numStudents.'<br />';
echo '<b>Number of Advisers:</b> '.$school->numAdvisers.'<br /><br />';
echo '<b>Normal Conference Fee Without Financial Aid:</b> ';
echo $school->totalFeeFormatted.'<br />';
echo '<b>You have paid:</b> '.$school->totalPaidFormatted.'<br />';

// Create the form
echo '<b>Financial Aid Granted: ';
echo $school->totalFinAidFormatted.'</b><br />';
echo '<br />';

echo '<div id="finAidForm">';
echo '<input type="hidden" id="schoolId" value="'.$school->schoolId.'">';
echo 'Why do you feel you/your school should receive financial aid for MITMUNC 2013?<br />';
echo '<textarea type="text" id="question1" rows="5" cols="100">'.$school->finaidQuestion[1].'</textarea><br />';
echo '<br />';
echo 'Does your organization receive any funds from your school in order to operate?  If so, how much and what does the funding usually go towards?<br />';
echo '<textarea type="text" id="question2" rows="5" cols="100">'.$school->finaidQuestion[2].'</textarea><br />';
echo '<br />';
echo 'Does your organization receive any funds from other sources such as fundraisers and outside donors?  If so, how much and what does the funding usually go towards?  If not, please explain your attempts.<br />';
echo '<textarea type="text" id="question3" rows="5" cols="100">'.$school->finaidQuestion[3].'</textarea><br />';
echo '<br />';
echo 'Approximately what percentage of students at your school currently receive some sort of financial assistance?<br />';
echo '<textarea type="text" id="question4" rows="5" cols="100">'.$school->finaidQuestion[4].'</textarea><br />';
echo '<br />';
echo 'Which other conferences with how many delegates does your delegation normally attend a year?<br />';
echo '<textarea type="text" id="question5" rows="5" cols="100">'.$school->finaidQuestion[5].'</textarea><br />';
echo '<br />';
echo '<input type="submit" value="Submit" onclick="javascript:submitFinAid()"><br /><br />';
echo '</div>';
?>
                
<a href="/controlpanel/">Back to Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php");?>
