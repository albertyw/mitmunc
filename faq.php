<?php
$title = "MITMUNC - FAQ";
require("/var/www/mitmunc/template/header.php");
?>
<h1>Frequently Asked Questions</h1>
<br />
<?php
$result = mysql_query("SELECT * FROM faq ORDER BY section") or die(mysql_error());
$section = '';
while($row = mysql_fetch_array($result)){
    if($section != $row['section']){
        echo '<h2>'.$row['section'].'</h2>';
    }
    $section = $row['section'];
    echo '<h3>'.$row['question'].'</h3>';
    echo '<p>'.$row['answer'].'</p>';
}
?>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
