<?php
require("/var/www/mitmunc/template/header_very_basic.php");

$SESSION->securityCheck(true, array('secretariat', 'chair'));

$committee = new committee(sanitizeValue($_POST['committeeId']));
$committee->committeeId = sanitizeValue($_POST['committeeId']);
$committee->committeeName = sanitizeValue($_POST['committeeName']);
$committee->shortName = sanitizeValue($_POST['shortName']);
$committee->announcement = $_POST['announcement'];
foreach($committee->topic as $id=>$topic){
    $committee->topic[$id] = $_POST['topic'.$id];
    $committee->topicDescription[$id] = $_POST['topic'.$id.'Description'];
}
$committee->saveInfo();
$committee = new committee($committee->committeeId);

// multiple recipients
$to  = 'sg@mitmunc.mit.edu, usg@mitmunc.mit.edu';

// subject
$subject = 'Change In Committee Information ('.$committee->shortName.')';

// message
$message = 'The committee "'.$committee->shortName.'" has changed their committee information.  <br /><br />';
$message .= 'Current information:<br />';
$message .= 'Committee Name: '.$committee->committeeName.'<br />';
$message .= 'Committee Chairs: '.commaSeparate(array_map(function($userId){$user = new user($userId); return $user->realName;}, $committee->chairs)).'<br />';
$message .= 'Committee Abbreviation: '.$committee->shortName.'<br />';
$message .= 'Committee Email: '.$committee->email.'@mitmunc.mit.edu</br />';
$message .= '<a href="/committee/'.$committee->shortName.'">Committee Page</a><br /><br />';
$message .= '<b>Announcements</b>:<br /> '.$committee->announcement.'<br />';
$message .= '<br />';
foreach($committee->topic as $id=>$topic){
    $message .= '<b>Topic '.$id.': '.$committee->topic[$id].'</b>';
    $message .= '<a href="'.$committee->topicBg[$id].'">Background Guide</a><br />';
    $message .= $committee->topicDescription[$id].'<br />';
    $message .= '<br />';
}
// Mail it
sendEmail($to, $subject, $message);

?>
