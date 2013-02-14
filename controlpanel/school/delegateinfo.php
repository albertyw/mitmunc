<?php
$title = "MITMUNC - Control Panel - Delegate Information";
require("/var/www/mitmunc/template/header.php"); ?>
<script type="text/javascript">
function submitAttendeeInfo(){
    var totalAttendees = $('#totalAttendees').val();
    var returnArray = {};
    var hotel;
    for(var i=0; i < totalAttendees; i++){
        
        hotel = ($("#user"+i+" .hotel").is(':checked')) ? "1" : "0";
        returnArray[i] = {};
        returnArray[i]['id'] = i+1;
        returnArray[i]["name"] = $("#user"+i+" .name").val();
        returnArray[i]["logintype"] = $("#user"+i+" .logintype").val();
        returnArray[i]["committeeId"] = $("#user"+i+" .committee").val();
        returnArray[i]["countryId"] = $("#user"+i+" .country").val();
        returnArray[i]["email"] = $("#user"+i+" .email").val();
        returnArray[i]["phone"] = $("#user"+i+" .phone").val();
        returnArray[i]["hotel"] = hotel;
        returnArray[i]["room"] = $("#user"+i+" .room").val();
    }
    
    returnArray = JSON.stringify(returnArray);
    $.post(
        '/include/ajax/delegateInfo',
        {
            schoolId:$("#schoolId").val(),
            totalAttendees:$("#totalAttendees").val(),
            delegateInfo:returnArray
        },
        function(data){
            if(data=='True'){
                $("#submission_feedback").show('slow');
            }else{
                alert(data);
            }
        }
    );
}
function getCommitteePositions(userId){
    committeeId = $("#user"+userId+" .committee").val();
    $.post(
        '/include/ajax/delegateInfo2',
        {
            schoolId:$("#schoolId").val(),
            committeeId: committeeId,
            attendeeNum: userId
        },
        function(data){
            $("#user"+userId+" .country").html(data);
        }
    );
}
$(function() {
    var totalAttendees = $('#totalAttendees').val();
    for(var i=0; i < totalAttendees; i++){
        getCommitteePositions(i);
        $("#user"+i+" .committee").change({userId:i}, function(event) {
            getCommitteePositions(event.data.userId);
        });
    }
});
</script>


<h1>Delegate Information</h1>
<p>Please enter your delegation's information here.    
We require phone numbers to be able to contact all students and advisers in case of emergency and email address for conference updates.</p>
<p>Please refer to the <a href="/ccmatrix">country and committee matrix</a> when selecting delegates' committee/country assignments; most countries are not on all committees.  You may ignore the hotel room field until the conference but please select whether each student will be staying at the hotel.</p>
</p>
<br />
<?php
//Check user's credentials
$SESSION->securityCheck(true, array('secretariat', 'school'));

$school = new school($SESSION->schoolId);
//Display School Attendee info
echo '<table>';
echo '<tr><th>Name</th><th>Position</th><th>Committee</th><th>Country/Position</th><th>E-mail</th><th>Phone Number</th><th>Staying at Hotel?</th><th>Hotel Room Number</th></tr>';
for($i = 0; $i<$school->totalAttendees; $i++){
    echo '<tr id="user'.$i.'">';
    echo '<td><input type="text" class="name" value="'.$school->attendees[$i]['name'].'"></td>';
    if($i<$school->numAdvisers){
        echo '<input type="hidden" class="logintype" value="school" />';
        echo '<td>Adviser</td>';
        echo '<input type="hidden" class="committee" value="0" />';
        echo '<td>N/A</td>';
        echo '<input type="hidden" class="country" value="0" />';
        echo '<td>N/A</td>';
    }else{
        echo '<input type="hidden" class="logintype" value="delegate" />';
        echo '<td>Delegate</td>';
        if($school->countryConfirm){
            echo '<td>'.committee::getCommitteeOptions(array("class"=>"committee"), $school->attendees[$i]['committeeId']).'</td>';
            echo '<td><select class="country"></select></td>';
        }else{
            echo '<td><select class="committee"></select></td>';
            echo '<td><select class="country"></select></td>';
        }
    }
    echo '<td><input type="text" class="email" value="'.$school->attendees[$i]['email'].'"></td>';
    echo '<td><input type="text" class="phone" value="'.$school->attendees[$i]['phone'].'"></td>';
    echo '<td><input type="checkbox" class="hotel" ';
    if($school->attendees[$i]['hotel']) echo 'checked';
    echo '></td>';
    echo '<td><input type="text" class="room" value="'.$school->attendees[$i]['room'].'"></td>';
}
echo '</table>';
echo '<input type="hidden" id="schoolId" value="'.$school->schoolId.'">';
echo '<input type="hidden" id="totalAttendees" value="'.$school->totalAttendees.'">';
echo '<input type="submit" value="Submit Attendee Info" onclick="javascript:submitAttendeeInfo()">';


?>
<div id="submission_feedback" style="display:none;">Your delegate information has been submitted</div>
<br />
<br />
<a href="/controlpanel/">Back to Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
