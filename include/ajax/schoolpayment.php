<?php
require("/var/www/mitmunc/template/header_very_basic.php");

$SESSION->securityCheck(true, array('secretariat'));

$_POST = sanitizeArray($_POST);

$payment = new payment($_POST['paymentId']);
if($_POST['paymentDelete'] == 'true'){
    $payment->deletePayment();
    echo 'paymentDeleted';
    die();
}

$payment->paymentId = $_POST['paymentId'];
$payment->schoolId = $_POST['schoolId'];
$payment->amount = $_POST['amount'];
$payment->started = $_POST['started'];
$payment->completed = $_POST['completed'];
$payment->finaid = $_POST['finaid'];

$payment->saveInfo();
echo 'paymentSaved';
