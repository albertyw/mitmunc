<?php
require("/var/www/mitmunc/template/header_very_basic.php");

$SESSION->securityCheck(true, array('secretariat', 'chair'));

$_POST = sanitizeArray($_POST);
$committeeId = $_POST['committeeId'];
$committee = new committee($committeeId);
echo 'Committee Name: <input type="text" id="committeeName" size="50" value="'.$committee->committeeName.'" /><br />';
echo 'Committee Chairs: '.commaSeparate(array_map(function($userId){$user = new user($userId); return $user->realName;}, $committee->chairs)).'<br />';
echo 'Committee Abbreviation: <input type="text" id="shortName" size="7" value="'.$committee->shortName.'" /><br />';
echo 'Committee Email: <input type="text" id="email" value="'.$committee->email.'" />@mitmunc.mit.edu<br />';
echo '<b>Announcements</b>:<br />';
echo '<textarea id="announcement" class="ckeditor" cols="100" rows="5">'.$committee->announcement.'</textarea><br />';
echo '<br />';
foreach($committee->topic as $id=>$topic){
    echo '<h3>Topic '.$id.'</h3> <input type="text" id="topic'.$id.'" size="50" value="'.$committee->topic[$id].'" /><br />';
    echo '<a href="'.$committee->topicBg[$id].'">Background Guide</a><br />';
    echo '<textarea id="topic'.$id.'Description" cols="100" rows="5">'.$committee->topicDescription[$id].'</textarea><br />';
    echo '<br />';
}
echo 'For security reasons, send background guides to the CTO/Webmaster to upload onto the website.<br />';
echo '<input type="submit" onclick="javascript:submitchange()" value="Submit Changes"><br />';
?>
<script type="text/javascript">
function submitchange(){
    var returnArray = {};
    returnArray['committeeId'] = $("#committeeId").val();
    returnArray['committeeName'] = $("#committeeName").val();
    returnArray['shortName'] = $("#shortName").val();
    returnArray['announcement'] = $("#announcement").val();
    for(var id=1; $("#topic"+id).length!=0; id++){
        returnArray['topic'+id] = $("#topic"+id).val();
        returnArray['topic'+id+'Description'] = $("#topic"+id+"Description").val();
    }
    
    //Send by AJAX
    $.post(
        "/include/ajax/committee2",
        returnArray,
        function(data){
            if(data==''){
                window.location.reload();
            }else{
                alert(data);
            }
        }
    );
}
</script>
