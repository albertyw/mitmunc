<?php
$title = "MITMUNC - MIT Model United Nations Conference";
require("/var/www/mitmunc/template/header.php"); 
header('Location: http://www.MITMUNC.org',true,301);?>
<!--Remove header('Location: http://www.MITMUNC.org'); to stop the redirect! -->
<p>
<h1>Attention! We are excited to announce that MITMUNC has migrated to a new website at <a href="http://bit.ly/MITMUNCRedirectFromOldSite">www.MITMUNC.org</a> Please visit this website for updated conference information. </h3>
<!--
<p><b>MITMUNC</b> is a new, unique, and international high school Model United Nations conference, focusing on committees that have a scientific or technological foundation. 
The high school students attending do not have to be science experts - rather, our goal is to have our chairs use their expertise to make 
the scientific issues accessible to the students, so that the students can debate the policy issues with a better understanding of the facts behind them.</p>
-->
<h2>Announcements</h2>
<dl>
<?php
// Announcements
$result = mysql_query("SELECT postDate, announcement
FROM announcements
WHERE postDate > DATE_SUB( NOW( ) , INTERVAL 1
MONTH )
ORDER BY postDate DESC
LIMIT 0 , 30") or die(mysql_error());
while($row = mysql_fetch_array($result)){
    echo '<dt>';
    echo date("F j, Y", strtotime($row['postDate']));
    echo '</dt><dd>';
    echo $row['announcement'];
    echo '</dd>';
}
?>
</dl>
<p>Announcements older than one month are archived <a href="/announcements">here</a>.</p>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
