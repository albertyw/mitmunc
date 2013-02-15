<?php
$title = "MITMUNC - Committee Timer Registration";
require("/var/www/mitmunc/template/header.php"); ?>
<h1>Committee Timer Registration</h1>

<p>MITMUNC is now releasing a special timer designed specifically to help moderate 
Model United Nations conferences.  This timer is separate from the MITMUNC 
conference registration and may only be used in conferences that do not require 
registration fees.  </p>

<p>Since the timer remembers its settings, 
registration is required to use the timer.  Please fill out the form below to 
use the timer.</p>

<div id="regform">
<table border="0">
<tr><td colspan="2"><h2>Primary Contact Information</h2></td></tr>
<tr><td>
Name:
</td><td>
<input type="text" id="contactName" />
</td></tr>
<tr><td>
E-mail:
</td><td>
<input type="text" id="email" /><span id="emailError"></span>
</td></tr>
<tr><td>
Phone Number:
</td><td>
<input type="text" id="phoneNumber" size="20" />
</td></tr>
<tr><td>
</td></tr>
<tr><td colspan="2"><h2>Other Information</h2></td></tr>
<tr><td>
Login Username:
</td><td>
<input type="text" id="username" /><span id="usernameError"></span><span id="usernameTakenError"></span>
</td></tr>
<tr><td>
How did you hear about us?</td><td><input type="text" id="hearAboutUs" />
</td></tr>
</table>
<script type="text/javascript" src="include/registrationTimer.js"></script>
<input type="submit" onclick="javascript:timerRegistrationCheck()" value="Register" id="submitButton" /><br />
</div>

<?php require("/var/www/mitmunc/template/footer.php");?>
