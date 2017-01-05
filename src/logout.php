<?php
$title = "MITMUNC - Log Out";
require("/var/www/mitmunc/template/header.php"); ?>
<h1>Log Out</h1>
<?php
$SESSION->logOut();
?>
<script type="text/javascript">
window.location="http://mitmunc.mit.edu/";
</script>
You have been logged out.
<?php require("/var/www/mitmunc/template/footer.php"); ?>
