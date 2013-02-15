<?php
$title = "MITMUNC - Conference";
require("/var/www/mitmunc/template/header.php"); ?>
<h1>About MITMUNC</h1>
<div  style="text-align:center">
<a href="schedule">Schedule</a>  
<a href="df">Deadlines and Fees</a>  
<a href="accommodations">Accommodations</a>  
<a href="preparation">Preparation</a>  
</div>
<br />
<p>MITMUNC will be held on <?php echo date('F j',generalInfoReader('conferenceStartDate'))?>-<?php echo date('j, Y',generalInfoReader('conferenceEndDate'))?> at MIT's campus across the Charles River from Boston in Cambridge, Massachusetts.  
Above are links to conference information including the conference schedule, hotel and restaurant accommodations, and information about preparing for the conference.  </p>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
