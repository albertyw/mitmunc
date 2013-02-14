<?php
$title = "MITMUNC - Control Panel - Liability And Medical Form";
require("/var/www/mitmunc/template/header.php"); ?>
<h1>Liability/Medical Form</h1>
<?php
$SESSION->securityCheck(true, array('secretariat', 'school'));
?>
<p>MITMUNC requires that all students attending our conference fill out, sign, and turn in a liability and medical form.  
The form requires a parental signature if the student is under 18 years of age so we highly recommend that students fill out these forms before the conference.  
Finished forms may be mailed to us before the conference or given to us at the beginning of the conference during check in.  </p>
<a href="/mitmunc2012/liabilitymedical.pdf">Download the liability form</a><br />
<br />
<a href="/controlpanel/">Back To Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php");?>
