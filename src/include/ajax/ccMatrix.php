<?php
require("/var/www/mitmunc/template/header_very_basic.php");

$SESSION->securityCheck(true, array('secretariat'));

$ccMatrix = new ccMatrix();
if($_POST['reload'] == 'true'){
    $ccMatrix->reloadMatrix();
    die();
}
$inputs = json_decode($_POST['inputs']);
$committees = json_decode($_POST['committees']);
$countries = json_decode($_POST['countries']);
foreach($committees as $committee){
    foreach($countries as $country){
        $ccMatrix->matrix[$committee][$country] = $inputs[$committee][$country];
    }
}
$ccMatrix->saveInfo();
