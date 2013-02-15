<?php
require("/var/www/mitmunc/template/header_very_basic.php");

$SESSION->securityCheck(true, array('secretariat', 'school'));

$_POST = sanitizeArray($_POST);
$mealTicket = new mealTicket($SESSION->schoolId);
for($i=1; $i<=mealTicket::numMeals; $i++){
    $mealTicket->meal[$i] = $_POST['meal'.$i];
}
$mealTicket->mealNotes = $_POST['mealNotes'];
$mealTicket->saveInfo();


$mealTicket = new mealTicket($SESSION->schoolId);
$message = '<p>The school '.school::getSchoolName($mealTicket->schoolId).' has 
updated its meal ticket orders</p>';
foreach($mealTicket->meal as $mealId => $mealNumberTickets){
    if($mealTicket->mealDescription[$mealId]=='disabled') continue;
    $message .= $mealTicket->mealDescription[$mealId].': ';
    $message .= $mealNumberTickets;
    $message .= ' x $'.$mealTicket->mealCost[$mealId].' = $'.($mealTicket->mealCost[$mealId]*$mealNumberTickets);
    $message .= '<br />';
}
$message .= '<br />';
$message .= 'Dietary restrictions:<br />';
$message .= $mealTicket->mealNotes;
$message .= '<br />';

$subject = 'MITMUNC School Lunch Update ('.school::getSchoolName($mealTicket->schoolId).')';
sendEmail('coo@mitmunc.org', $subject, $message);
