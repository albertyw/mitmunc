<?php
//DATABASE CONNECTION
require("/var/www/mitmunc/include/functions.php");
connectDatabase();
$_POST = sanitizeArray($_POST);

$committeeId = $_POST['committeeId'];

$result = mysql_query("SELECT speech FROM timer_settings WHERE committeeId='$committeeId'") or die(mysql_error());
if(mysql_num_rows($result)==0){
    $arr = array('speech'=>0,'caucus'=>0,'announcements'=>'');
    echo json_encode($arr);
}else{
    $query = "SELECT speech, caucus, announcements FROM timer_settings WHERE committeeId='$committeeId'";
    $result = mysql_query($query) or die(mysql_error());
    $row = mysql_fetch_assoc($result);
    echo json_encode($row);
}



