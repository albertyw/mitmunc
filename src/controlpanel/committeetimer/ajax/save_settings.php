<?php
//DATABASE CONNECTION
require("/var/www/mitmunc/include/functions.php");
connectDatabase();
$_POST = sanitizeArray($_POST);

$committeeId = $_POST['committeeId'];
$speechTime = $_POST['speechTime'];
$caucusTime = $_POST['caucusTime'];
$announcements = $_POST['announcements'];

$result = mysql_query("SELECT speech FROM timer_settings WHERE committeeId='$committeeId'") or die(mysql_error());
if(mysql_num_rows($result)==0){
    $query = "INSERT INTO timer_settings (committeeId, speech, caucus, announcements)
    VALUES('$committeeId', '$speechTime', '$caucusTime', '$announcements')";
    $result = mysql_query($query) or die(mysql_error());
}else{
    $query = "UPDATE timer_settings SET speech='$speechTime' WHERE committeeId='$committeeId'";
    $result = mysql_query($query) or die(mysql_error());
    $query = "UPDATE timer_settings SET caucus='$caucusTime' WHERE committeeId='$committeeId'";
    $result = mysql_query($query) or die(mysql_error());
    $query = "UPDATE timer_settings SET announcements='$announcements' WHERE committeeId='$committeeId'";
    $result = mysql_query($query) or die(mysql_error());
}

