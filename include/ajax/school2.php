<?php
/**
 * This file is used to delete a school's registration and all of it's related information
 * Prints 'logout' if the currently logged in user is being deleted, else prints nothing
 **/
require("/var/www/mitmunc/template/header_very_basic.php");

$SESSION->securityCheck(true, array('secretariat', 'school'));

$_POST = sanitizeArray($_POST);
$schoolId = $_POST['schoolId'];

// Delete User
$users = user::getSchoolUsers($schoolId);
foreach($users as $userId){
    $user = new user($userId);
    $user->deleteUser();
    if($userId == $SESSION->userId) echo 'logout';
}

// Delete school payments
$payments = payment::getSchoolPayments($schoolId);
foreach($payments as $paymentId){
    $payment = new payment($paymentId);
    $payment->deletepayment();
}

// Delete special committee applications
$applications = specialCommitteePosition::getAllSchoolApplications($schoolId);
foreach($applications as $applicationId => $positionId){
    specialCommitteePosition::deleteApplication($applicationId);
}

// Delete school registration and delegate table
$school = new school($schoolId);
$school->deleteSchool();
