<?php
require("/var/www/mitmunc/include/functions.php");
connectDatabase();

// This function checks whether the desired username has already been taken
$_POST = sanitizeArray($_POST);

$username = $_POST['username'];
if(user::usernameTaken($username)){
    echo 'true';
}else{
    echo 'false';
}
