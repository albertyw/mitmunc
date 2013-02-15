<?php
require("/var/www/mitmunc/template/header_very_basic.php");
$SESSION->securityCheck(true, array('secretariat'));

$section = json_decode($_POST['section']);
$question = json_decode($_POST['question']);
$answer = json_decode($_POST['answer']);


mysql_query("TRUNCATE TABLE faq");
for($id=0; $id < count($section); $id++){
    $idplus = $id+1;
    $thisQuestion = mysql_real_escape_string($question[$id]);
    $thisAnswer = mysql_real_escape_string($answer[$id]);
    $query = "INSERT INTO faq (id, section, question, answer) 
    VALUES('".$idplus."','".$section[$id]."','".$thisQuestion."','".$thisAnswer."')";
    mysql_query($query) or die(mysql_error());
}

?>
