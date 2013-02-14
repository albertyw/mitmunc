
<?php
require("/var/www/mitmunc/template/header_very_basic.php");
$_GET = sanitizeArray($_GET);
$committeeShortNames = committee::getAllCommitteeShortNames();
$committee = null;
foreach($committeeShortNames as $committeeId => $committeeShortName){
    if($committeeShortName == $_GET['committee'])
        $committee = new committee($committeeId);
}
if($committee == null){
    header("Location: /404.php");
    die();
}
$title = "MITMUNC - ".$committee->shortName." Committee";
require("/var/www/mitmunc/template/header.php"); ?>
<?php
echo '<h1>'.$committee->committeeName.'</h1>';
echo commaSeparate(array_map(function($userId){$user = new user($userId); return $user->realName;}, $committee->chairs)).'<br />';
echo 'Email the chairs: '.obfuscateEmail($committee->email.'@mitmunc.org');
echo '<br /><br />';

echo '<h2>Announcements</h2>';
echo $committee->announcement.'<br />';
echo '<br />';


$numTopics = 0;
foreach($committee->topic as $topic){
    if($topic != '') $numTopics++;
}
if($numTopics==0){
    echo '<h2>Topics</h2>';
    echo '<i>Topics TBA</i><br />';
}elseif($numTopics == 1){
    echo '<h2>Topic</h2>';
}else{
    echo '<h2>Topics</h2>';
}
foreach($committee->topic as $id => $topic){
    if($committee->topic[$id] != ''){
        echo '<h3>'.$committee->topic[$id].'</h3>';
        if($committee->topicBg[$id] !='')
            echo '<a href="'.$committee->topicBg[$id].'">Background Guide</a><br />';
        echo $committee->topicDescription[$id];
        echo '<br />';
    }
}
?>
<?php require("/var/www/mitmunc/template/footer.php");?>
