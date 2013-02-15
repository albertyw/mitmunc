<?php
/**
 * This is used to update the special committee position assignment
 * Called by /controlpanel/secretariat/specialCommitteePosition.php
 **/
require("/var/www/mitmunc/template/header_very_basic.php");

$SESSION->securityCheck(true, array('secretariat'));

$_POST['positionId'] = sanitizeValue($_POST['positionId']);
$_POST['positionDelete'] = sanitizeValue($_POST['positionDelete']);
$position = new specialCommitteePosition($_POST['positionId']);
if($_POST['positionDelete']=='true'){
    // Delete the position
    $position->deletePosition();
    echo 'positionDeleted';
}else{
    // Save edits to the position
    $_POST['committeeId'] = sanitizeValue($_POST['committeeId']);
    $position->positionName = $_POST['positionName'];
    $position->committeeId = $_POST['committeeId'];
    $position->saveInfo();
    echo 'positionSaved';
}
