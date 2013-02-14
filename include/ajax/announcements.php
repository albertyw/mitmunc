<?php
require("/var/www/mitmunc/template/header_very_basic.php");
$SESSION->securityCheck(true, array('secretariat'));

$postDate = json_decode($_POST['postDate']);
$postDate = sanitizeArray($postDate);
$announcements = json_decode($_POST['announcements']);


mysql_query("TRUNCATE TABLE announcements");
for($id=0; $id < count($postDate); $id++){
    $idplus = $id+1;
    $query = "INSERT INTO announcements (id,postDate,announcement) VALUES('".$idplus."','".$postDate[$id]."','".$announcements[$id]."')";
    echo $query;
    mysql_query($query) or die(mysql_error());
}

?>
