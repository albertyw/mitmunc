<?php
require("/var/www/mitmunc/include/functions.php");
$_POST = sanitizeArray($_POST);
if(isset($_POST['errMsg'])){
    $errMsg = $_POST['errMsg'];
}else{
    $errMsg = '';
}
if(isset($_POST['errLine'])){
    $errLine = $_POST['errLine'];
}else{
    $errLine = ''; 
}
if(isset($_POST['url'])){
    $url = $_POST['url'];
}else{
    $url = ''; 
}
if(isset($_POST['queryString'])){
    $queryString = $_POST['queryString'];
}else{
    $queryString = ''; 
}
if(isset($_POST['HttpRef'])){
    $HttpRef = $_POST['HttpRef'];
}else{
    $HttpRef = ''; 
}
$ip = getIP();
$line = date('[d-M-Y H:i:s]')." Javascript Error From '$ip': '$errMsg' at line '$errLine' at url '$url' with query '$queryString' from '$HttpRef'\n";
$file = fopen("/var/www/mitmunc/error_log", "a");
fputs($file, $line);
fclose($file);
