<?php
require("/var/www/mitmunc/template/header_very_basic.php");

$SESSION->securityCheck(true, array('secretariat'));

$user = new user($_POST['userId']);
if($_POST['userDelete'] == 'true'){
    $user->deleteUser();
    echo 'userDeleted';
    die();
}
$user->username = $_POST['username'];
$user->loginType = $_POST['loginType'];
$user->realName = $_POST['realName'];
$user->email = $_POST['email'];
$user->phoneNumber = $_POST['phoneNumber'];
$user->lastLogin = $_POST['lastLogin'];
$user->lastLoginIp = $_POST['lastLoginIp'];
$user->committeeId = $_POST['committeeId'];
$user->schoolId = $_POST['schoolId'];


// Check that username isn't taken
if(user::usernameTaken($user->username, $user->userId)){
    echo 'usernameTaken';
    die();
}

if($_POST['password'] != '--'){
    $_POST['passwordHash'] = crypt($_POST['password']);
    $user->passwordHash = $_POST['passwordHash'];
}
if($user->saveInfo()){
    echo 'userSaved';
}else{
    echo 'usernameTaken';
}
