<?php
/**
 * Delete a Committee and its chairs
 **/
require("/var/www/mitmunc/template/header_very_basic.php");

$SESSION->securityCheck(true, array('secretariat'));

$_POST = sanitizeArray($_POST);
$committeeId = $_POST['committeeId'];

$committee = new committee($committeeId);
// Delete chairs
foreach($committee->chairs as $chairId){
    $chair = new user($chairId);
    if($chair->loginType=='chair')
        $chair->deleteUser();
}
// Delete Committee
$committee->deleteCommittee();
