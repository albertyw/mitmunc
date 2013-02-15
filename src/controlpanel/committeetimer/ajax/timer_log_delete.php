<?php
//DATABASE CONNECTION
require("/var/www/mitmunc/include/functions.php");
connectDatabase();
$_POST = sanitizeArray($_POST);

$delete_id = $_POST['timer_log_id'];

$query = "UPDATE timer_log SET status='deleted' WHERE id='$delete_id'";
mysql_query($query) or die(mysql_error());

