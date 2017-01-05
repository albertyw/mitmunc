<?php 
$title = "MITMUNC - Control Panel - Committee Information";
require("/var/www/mitmunc/template/header.php"); ?>
<script type="text/javascript">
function changecommittee(){
    $.post(
        "/include/ajax/committee",
        {
            committeeId:$("#committeeId").val()
        },
        function(data){
            $("#committeeinfo").html(data);
            $("textarea").ckeditor();
        }
    );
}
</script>
<h1>Committee</h1>
                
<?php
if(isset($_GET['committeeId'])){
    if($_GET['committeeId'] == 'NEW'){
        $SESSION->securityCheck(true, array('secretariat'));
        $SESSION->committeeId = committee::newCommittee();
    }
}
$SESSION->securityCheck(true, array('secretariat', 'chair'));

//Display committee info
$committee = new committee($SESSION->committeeId);
echo '<h2>Commiteee Information</h2><br />';
echo '<input type="hidden" id="committeeId" value="'.$committee->committeeId.'" />';
echo '<div id="committeeinfo">';
echo 'Committee Name: '.$committee->committeeName.'<br />';
echo 'Committee Chairs: '.commaSeparate(array_map(function($userId){$user = new user($userId); return $user->realName;}, $committee->chairs)).'<br />';
echo 'Committee Abbreviation: '.$committee->shortName.'<br />';
echo 'Committee Email: '.obfuscateEmail($committee->email.'@mit.edu').'</br />';
echo '<a href="/committee/'.$committee->shortName.'">Committee Page</a><br /><br />';
echo '<b>Announcements</b>:<br /> '.$committee->announcement.'<br />';
echo '<br />';
foreach($committee->topic as $id=>$topic){
    echo '<h3>Topic '.$id.': '.$committee->topic[$id].'</h3>';
    echo '<a href="'.$committee->topicBg[$id].'">Background Guide</a><br />';
    echo $committee->topicDescription[$id].'<br />';
    echo '<br />';
}
echo '<input type="submit" onclick="javascript:changecommittee()" value="Change Committee Information"><br />';
echo '</div>';

echo '<div id="changeinfo" style="display:none">';

echo '</div>';


echo '<br /><br />';
echo '<a href="/controlpanel/">Back To Control Panel</a>';
?>
<?php require("/var/www/mitmunc/template/footer.php");?>
