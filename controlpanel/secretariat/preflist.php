<?php
$title = "MITMUNC - Control Panel - Country List";
require("/var/www/mitmunc/template/header.php"); ?>

<script type="text/javascript">
function submitConfirmations(){
    var countryConfirms = {};
    for(var i=0; i<$(".countryConfirm").length; i++){
        confirmId = $(".countryConfirm")[i].id;
        countryConfirms[confirmId.substring(14)] = $("#"+confirmId)[0].checked;
    }
    countryConfirms = JSON.stringify(countryConfirms);
    $.post(
        '/include/ajax/prefList',
        {
            countryConfirms:countryConfirms
        },
        function(data){
            if(data==''){
                location.reload();
            }else{
                alert(data);
            }
        }
    );
}
</script>

<h1>Countries And Special Positions Assignments List</h1>
Refer to the <a href="/ccmatrix">Country Committee Matrix</a> when determining assignments.  
<?php
$SESSION->securityCheck(true, array('secretariat', 'chair'));

$schoolIds = school::getAllSchoolIds();
$ccMatrix = new ccMatrix();

//Display table
echo '<table class="padded bordered">';
echo '<tr><th>School Name</th><th>Paid</th><th>Delegates</th><th>Countries Confirmed</th><th>Special Committee Positions</th>';
for($i=1; $i<=school::NUM_COUNTRY_PREFS; $i++){
    echo '<th>Country '.$i.'</th>';
}
echo '<th>Edit Countries</th><th>Total Positions</th>';
echo '</tr>';
foreach($schoolIds as $schoolId){
    $school = new school($schoolId);
    echo '<tr><td><a href="/controlpanel/school/school?schoolId='.$school->schoolId.'">'.$school->schoolName.'</a></td>';
    echo '<td>'.$school->totalPaid.'</td>';
    echo '<td>'.$school->numStudents.'</td>';
    echo '<td><input type="checkbox" class="countryConfirm" id="countryConfirm'.$school->schoolId.'"';
    $numSpecial = sizeof(specialCommitteePosition::getAllSchoolApplications($school->schoolId));
    if($school->countryConfirm){
        echo 'checked';
    }
    echo '></td>';
    echo '<td><a href="/controlpanel/school/specialCommitteePosition?schoolId='.$school->schoolId.'"><img src="/images/edit.png"></a>';
    echo ' - '.$numSpecial.'</td>';
    $countryPrefPositionsTotal = 0;
    for($i=1; $i<=school::NUM_COUNTRY_PREFS; $i++){
        $countryPrefPositions = $ccMatrix->countrySpots($school->countryId[$i]);
        $countryPrefPositionsTotal += $countryPrefPositions;
        echo '<td>';
        echo $school->countryName[$i];
        echo ' ('.$countryPrefPositions.')';
        echo '</td>';
    }
    echo '<td><a href="/controlpanel/school/countrypref?schoolId='.$school->schoolId.'"><img src="/images/edit.png"></a>';
    echo ' - '.$countryPrefPositionsTotal.'</td>';
    echo '<td>'.($countryPrefPositionsTotal+$numSpecial).'</td>';
    echo '</tr>';
}
?>
</table>
<input type="submit" value="Submit Country/Position Confirmations" onclick="javascript:submitConfirmations()" />
<br />
<br />
<a href="/controlpanel/">Back To Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
