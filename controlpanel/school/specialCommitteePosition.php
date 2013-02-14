<?php
$title = "MITMUNC - Control Panel - Special Committee Positions Application";
require("/var/www/mitmunc/template/header.php"); ?>
<script type="text/javascript">
function submitPositions(){
    $("#saved").hide();
    
    var positions = [];
    for(var i=0; i < $(".specialPositions:checked").length; i++){
        committeeId = $(".specialPositions:checked")[i].id;
        positions.push(committeeId.substr(8));
    }
    positions = JSON.stringify(positions);
    $.post(
        "/include/ajax/specialCommitteePosition",
        {
            schoolId:$("#schoolId").val(),
            numSpecialPositions:$("#numSpecialPositions").val(),
            positions:positions,
        },
        function(data){
            if(data==''){
                $("#saved").show();
            }else{
                alert(data);
            }
        }
    );
}
</script>

<h1>Special Committee Positions Application</h1>
You can apply for position on special committees here.  <br />

<br />
<?php
//Check user's credentials
$SESSION->securityCheck(true, array('secretariat', 'school'));
$school = new school($SESSION->schoolId);

if($school->countryConfirm==1 && $SESSION->loginType!='secretariat'){
    echo 'You have been assigned the positions in the following committees:<br />';
    foreach(committee::getAllCommitteeNames() as $committeeId => $committeeName){
        $committee = new committee($committeeId);
        if(sizeof($committee->specialPositions)==0) continue;
        echo '<h2>'.$committee->committeeName.'</h2>';
        foreach($committee->specialPositions as $positionId){
            $position = new specialCommitteePosition($positionId);
            if(!in_array($school->schoolId, $position->schoolApplications)) continue;
            echo $position->positionName.'<br />';
        }
        if(sizeof($committee->specialPoistions)==0){
            echo '<p><i>No Positions Assigned.</i></p>';
        }
    }
}else{
    echo 'Number of positions you would like on special committees:';
    echo '<input type="hidden" id="schoolId" value="'.$school->schoolId.'" />';
    echo '<input type="text" id="numSpecialPositions" value="'.$school->numSpecialPositions.'">';
    echo '<br /><br />';
    foreach(committee::getAllCommitteeNames() as $committeeId => $committeeName){
        $committee = new committee($committeeId);
        if(sizeof($committee->specialPositions)==0) continue;
        echo '<h2>'.$committee->committeeName.'</h2>';
        echo 'Please check as many positions you are interested in:<br />';
        foreach($committee->specialPositions as $positionId){
            $position = new specialCommitteePosition($positionId);
            echo '<input type="checkbox" class="specialPositions" id="position'.$positionId.'" ';
            if(in_array($school->schoolId, $position->schoolApplications)) echo 'checked';
            echo '>';
            echo $position->positionName.'<br />';
        }
    }
    echo '<input type="submit" value="Submit Special Committee Preferences" onclick="javascript:submitPositions()">';
    echo '<div id="saved" style="display:none">Saved</div>';
}
?>
<br />
<br />
<a href="/controlpanel/">Back to Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
