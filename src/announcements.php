<?php
$title = "MITMUNC - MIT Model United Nations Conference - Announcements";
require("/var/www/mitmunc/template/header.php"); ?>

<h1>Announcements</h1>
<dl>
<?php
// Announcements
$result = mysql_query("SELECT postDate, announcement FROM announcements ORDER BY postDate DESC") or die(mysql_error());
while($row = mysql_fetch_array($result)){
    echo '<dt>';
    echo date("F j, Y", strtotime($row['postDate']));
    echo '</dt><dd>';
    echo $row['announcement'];
    echo '</dd>';
}
?>
</dl>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
