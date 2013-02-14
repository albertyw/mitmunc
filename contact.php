<?php
$title = "MITMUNC - Contact Us";
require("/var/www/mitmunc/template/header.php"); ?>

<h1>Contact Us</h1>
<b>Email:</b>
<?php echo obfuscateEmail('info@mitmunc.org'); ?> (preferred method)
<br />
<br />
<b>Phone:</b><br />
601-5MI-TMUN<br />
601-564-8686
<br />
<br />
<b>Mailing Address (for checks only):</b><br />
<?php
echo generalInfoReader('mailingAddress');
?>

<?php require("/var/www/mitmunc/template/footer.php"); ?>
