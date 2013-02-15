<?php
require("/var/www/mitmunc/template/header_very_basic.php");

$SESSION->securityCheck(true, 'all');

$_POST = sanitizeArray($_POST);
$currentPassword = $_POST['currentpassword'];
$newPassword = $_POST['newpassword'];

$user = new user($SESSION->userId);
if(crypt($currentPassword, $user->passwordHash)!=$user->passwordHash){
    die('Incorrect Current Password');
}

$user->passwordHash = crypt($newPassword);
$user->saveInfo();
echo 'Password Changed';
