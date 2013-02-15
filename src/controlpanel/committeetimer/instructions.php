<?php
$title = "MITMUNC - Control Panel";
require("/var/www/mitmunc/template/header.php"); ?>

<h1>Instructions for Committee Timer</h1>

<?php
$SESSION->securityCheck(true, array('secretariat', 'timer', 'chair'));
?>


<?php require("/var/www/mitmunc/template/footer.php"); ?>
