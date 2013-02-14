<?php
$title = "MITMUNC - Control Panel - Web Security Log";
require("/var/www/mitmunc/template/header.php"); ?>

<h1>Web Security Log</span></h1>
<?php
$SESSION->securityCheck(true, array('secretariat');

//Display committee info
$result = mysql_query("SELECT * FROM log") or die(mysql_error());
echo '<table class="padded bordered">';
echo '<tr><th>ID</th><th>Log Type</th><th>Log Value</th><th>Log Time</th></tr>';
while($row = mysql_fetch_array($result)){
    echo '<tr><td>';
    echo $row['id'];
    echo '</td><td>';
    echo $row['logType'];
    echo '</td><td>';
    echo $row['logVal'];
    echo '</td><td>';
    echo $row['time'];
    echo '</td></tr>';
}
echo '</table>';
?>

<?php require("/var/www/mitmunc/template/footer.php");?>
