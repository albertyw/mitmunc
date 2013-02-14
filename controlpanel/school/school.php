<?php
$title = "MITMUNC - Control Panel - School Information";
require("/var/www/mitmunc/template/header.php"); ?>

<script type="text/javascript" src="/include/changeRegistration.js"></script>
<script type="text/javascript">
function changeRegistration(){
    $.post(
        "/include/ajax/school",
        {
            schoolId:$("#schoolId").val()
        },
        function(data){
            $("#reginfo").html(data);
            $("#changeRegistrationSubmit").hide();
            addEventHandlers(errorChecking);
        }
    );
}
function deleteRegistration(){
    var confirmationMessage = "Deleting a school registration will permanently ";
    confirmationMessage += "delete all information from a school, including ";
    confirmationMessage += "payments, country/position assignments and ";
    confirmationMessage += "preferences, and the school's adviser login(s).  ";
    confirmationMessage += "Are you sure you want to delete the school registration?";
    var answer = confirm(confirmationMessage);
    if(!answer) return;
    $.post(
        "/include/ajax/school2",
        {
            schoolId:$("#schoolId").val()
        },
        function(data){
            if(data == 'logout'){
                window.location='/logout';
            }else if(data == ''){
                window.location='/controlpanel/';
            }else{
                alert(data);
            }
        }
    );
}
</script>


<h1>School</h1>
<?php
$SESSION->securityCheck(true, array('secretariat', 'school'));

//Display school info
$school = new school($SESSION->schoolId);
$school->getUsers();

require("/var/www/mitmunc/include/registration_change_form.php");

echo '<input type="hidden" id="schoolId" value="'.$school->schoolId.'">';
echo '<input type="submit" value="Delete Registration" onclick="javascript:deleteRegistration()">';

echo '<h2>Finances</h2>';
echo '<table>';
echo '<tr><td>Financial Aid Requested: </td><td>';
if($school->finAid==1) echo 'Yes';
if($school->finAid==0) echo 'No';
echo '</td></tr>';
echo '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';

echo '<tr><td>Paid School Fee: </td><td>';
if($school->schoolFeeOwed == 0) echo 'Yes</td><td>';
if($school->schoolFeeOwed > 0) echo 'No</td><td>';
echo '<tr><td>School Registration Fee: </td><td>$'.$school->schoolFee.'</td></tr>';
echo '<tr><td>School Registration Fee Paid: </td><td>$'.$school->schoolFeePaid.'</td></tr>';
echo '<tr><td>School Registration Fee Owed: </td><td>$'.$school->schoolFeeOwed.'</td></tr>';
echo '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';

echo '<tr><td>Paid Delegate Fee: </td><td>';
if($school->delegateFeeOwed == 0) echo 'Yes</td><td>';
if($school->delegateFeeOwed > 0) echo 'No</td><td>';
echo '<tr><td>Delegate Registration Fee: $'.$school->delegateFee.' x '.$school->numStudents.' = </td><td>$'.$school->delegateFeeTotal.'</td></tr>';
echo '<tr><td>Delegate Registration Fee Paid: </td><td> $'.$school->delegateFeePaid.'</td></tr>';
echo '<tr><td>Delegate Registration Fee Owed: </td><td> $'.$school->delegateFeeOwed.'</td></tr>';
echo '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';

echo '<tr><td>Paid Meal Ticket Fee: </td><td>';
if($school->mealTicketOwed == 0) echo 'Yes</td><td>';
if($school->mealTicketOwed > 0) echo 'No</td><td>';
echo '<tr><td>Meal Ticket Fee: </td><td>$'.$school->mealTicketTotal.'</td></tr>';
echo '<tr><td>Meal Ticket Fee Paid: </td><td> $'.$school->mealTicketPaid.'</td></tr>';
echo '<tr><td>Meal Ticket Fee Owed: </td><td> $'.$school->mealTicketOwed.'</td></tr>';
echo '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';

echo '<tr><td>Total Fee: </td><td>$'.$school->totalFee.'</td></tr>';
echo '<tr><td>Amount Paid: </td><td>$'.$school->totalPaid.'</td></tr>';
echo '<tr><td>Financial Aid: </td><td>$'.$school->totalFinAid.'</td></tr>';
echo '<tr><td>Amount Owed: </td><td>$'.$school->totalOwed.'</td></tr>';
echo '</table>';
echo '<a href="/controlpanel/school/payment">Make Payment</a><br />';
echo '<a href="/controlpanel/school/finaid">View Financial Aid Application</a><br />';
echo '<a href="/controlpanel/school/invoice">Invoice</a><br />';
echo '<br /><br />';


echo '<h2>Countries Selected</h2>';
echo '<div id="countryselection">';
for($i = 1; $i <=10; $i++){
    echo ordinalNumber($i).' Choice: '.$school->countryName[$i].'<br />';
}
echo '<a href="/controlpanel/school/countrypref">Change Countries</a><br /><br />';
echo '</div>';
echo '<br /><br />';


echo '<h2>Student And Adviser Information</h2>';
echo '<table>';
echo '<tr><th>Name</th><th>Position</th><th>Committee</th><th>Country/Position</th><th>E-mail</th><th>Phone</th></tr>';
for($i=0; $i<count($school->attendees); $i++){
    echo '<tr>';
    echo '<td>'.$school->attendees[$i]['name'].'</td>';
    echo '<td>'.$school->attendees[$i]['logintype'].'</td>';
    $committeeShortName = committee::getCommitteeShortName($school->attendees[$i]['committeeId']);
    echo '<td>'.$committeeShortName.'</td>';
    echo '<td>'.country::getCountryName($school->attendees[$i]['countryId']).'</td>';
    echo '<td>'.$school->attendees[$i]['email'].'</td>';
    echo '<td>'.$school->attendees[$i]['phone'].'</td>';
    echo '</tr>';
}
echo '</table>';
echo '<a href="/controlpanel/school/delegateinfo">View Details</a>';
echo '<br /><br />';


echo '<h2>Other</h2>';
echo 'How Did You Hear About MITMUNC? <br />';
echo $school->hearAboutUs;
echo '<br /><br />';


?>
<br />
<a href="/controlpanel/">Back to Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); 
?>
