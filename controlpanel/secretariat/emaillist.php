<?php
$title = "MITMUNC - Control Panel - List of Emails";
require("/var/www/mitmunc/template/header.php"); ?>

<h1>Sent Emails List</h1>
<?php

$SESSION->securityCheck(true, array('secretariat'));

//Display list of emails
echo '<table class="padded bordered">';
echo '<tr><th></th><th>Date</th><th>From</th><th>To</th><th>Subject</th></tr>';
$result = mysql_query("SELECT `id`, `timeSent`, `from`, `to`, `subject` FROM emails") or die(mysql_error());
while($row = mysql_fetch_array($result)){
    echo '<tr>';
    echo '<td><a href="/controlpanel/secretariat/email?emailId='.$row['id'].'"><img src="/images/edit.png" /></a></td>';
    echo '<td>'.$row['timeSent'].'</td>';
    echo '<td>'.$row['from'].'</td>';
    echo '<td>'.$row['to'].'</td>';
    echo '<td>'.$row['subject'].'</td>';
    echo '</tr>';
}
echo '</table>';
echo '<br />';
?>
<a href="/controlpanel/">Back To Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
