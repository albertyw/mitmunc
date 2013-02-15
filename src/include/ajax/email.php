<?php
require("/var/www/mitmunc/template/header_very_basic.php");

$SESSION->securityCheck(true, array('secretariat'));

$_POST = sanitizeArray($_POST);
$emailId = $_POST['emailId'];
$resendTo = $_POST['resendTo'];

$result = mysql_query("SELECT * FROM emails WHERE id='$emailId.'") or die(mysql_error());
$row = mysql_fetch_array($result);

$message = '<b>This is a copy of a message sent on '.$row['timeSent'].' to '.$row['to'].'</b><br /><br />'.$row['message'];

sendEmail($resendTo, $row['subject'], $message, $row['from']);
