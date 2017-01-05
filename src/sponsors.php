<?php
require("/var/www/mitmunc/template/header.php");
$title = "MITMUNC - Sponsors or MITMUNC".generalInfoReader('conferenceYear');
?>

<h2 style="font-size:large;text-align:center">
Sponsors of MITMUNC <?php echo generalInfoReader('conferenceYear'); ?>
</h2>


<p>The MIT Model United Nations Conference is proudly supported by the following organizations:</p>
<ul style="list-style-type:none;text-align:center;width:100%;">
	<li><a href="https://ultrapress.com/"><img style="width:250px;margin:25px;" src="/images/sponsors/ultrapress.png"></a></li>
	<li><a href="https://www.studypool.com/"><img style="width:350px;margin:25px;" src="/images/sponsors/studypool.jpeg"></a></li>
</ul>

<p><b>Contact us at <a href="mailto:coo-mitmunc@mit.edu">coo-mitmunc@mit.edu</a> for sponsorship opportunities.</b></p>

<?php   require("/var/www/mitmunc/template/footer.php" );?>