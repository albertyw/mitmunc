<?php
require("/var/www/mitmunc/template/header_very_basic.php");
?>
<!DOCTYPE HTML>

<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>MITMUNC Committee Timer</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

<script type="text/javascript" src="js/stopwatch.js"></script>
<script type="text/javascript" src="js/jquery.hotkys.js"></script>
<script type="text/javascript" src="js/jquery.autocomplete.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
<script type="text/javascript" src="js/stylesheetToggle.js"></script>
<script type="text/javascript" src="js/speakersList.js"></script>
<script type="text/javascript" src="js/settings.js"></script>
<link rel="stylesheet" type="text/css" href="js/jquery.autocomplete.css">
<link rel="stylesheet" type="text/css" href="global.css">
<link rel="stylesheet" type="text/css" title="blackonwhite" href="blackonwhite.css">
<link rel="alternate stylesheet" type="text/css" title="whiteonblack" href="whiteonblack.css">

</head>
<body>
<div id="body">
<div id="content_body">
<div id="content_title">MITMUNC Timer</div>

<?php
$SESSION->securityCheck(true, array('timer', 'chair', 'secretariat'));
echo '<input type="hidden" id="committeeId" value="';
if($SESSION->loginType == 'chair'){
    $committee = new committee($SESSION->committeeId);
    echo $committee->committeeId;
}else{
    echo 'timer'.$SESSION->userId;
}


echo '">';
?>

<div id="content_subtitle">
<span id="committeeShortName">
<?php
if(isset($committee)) echo strtoupper($committee->shortName);
?>
</span>
<span id="js_clock">
</span>
</div>

<table id="timer_table">
<tr><th>
Speech
</th><th>
Caucus
</th></tr>
<tr><td id="speech_timer">
    <!-- Embed Speech Timer !-->
    
    <span id="speech_timer_number"> </span>
    <span id="speech_timer_number_edit">
    <input type="text" id="speech_timer_minutes" size="2" value="0" maxlength="2" /> :
    <input type="text" id="speech_timer_seconds" size="2" value="0" maxlength="2" />
    </span>
    <div id="speech_timer_controls">
    	<button id="speech_timer_start"><span class="playbg"></span></button>
    	<button id="speech_timer_reset"><span class="stopbg"></span></button>

	    <input type="submit" onclick="javascript:speech_timer_number_edit()" id="speech_timer_edit_button" value="Edit" />
  	  <input type="submit" onclick="javascript:speech_timer_number_save()" id="speech_timer_save_button" value="Save" />
  	 </div>
    <!-- End Speech Timer !-->
</td><td id="caucus_timer">
    <!-- Embed Caucus Timer !-->
    <span id="caucus_timer_number"> </span>
    <span id="caucus_timer_number_edit">
    <input type="text" id="caucus_timer_minutes" size="2" value="0" maxlength="2" /> :
    <input type="text" id="caucus_timer_seconds" size="2" value="0" maxlength="2" />
    </span>
		<div id="caucus_timer_controls">
    	<button id="caucus_timer_start"><span class="playbg"></span></button>
    	<button id="caucus_timer_reset"><span class="stopbg"></span></button>
    
	    <input type="submit" onclick="javascript:caucus_timer_number_edit()" id="caucus_timer_edit_button" value="Edit" />
  	  <input type="submit" onclick="javascript:caucus_timer_number_save()" id="caucus_timer_save_button" value="Save" />
    </div>
    <!-- End Caucus Timer !-->
</td></tr>
</table>
<br /><br />
<table id="text_table">
<tr><th>
Speakers List
</th><th>
Announcements
</th></tr>

<tr><td valign="top">
<!--Embed Speakers List!-->
<input type="text" id="speakers_list_input">
<input type="submit" id="speakers_list_submit" onclick="javascript:timer_log_new()" value="Add Speaker">
<div id="speakers_list">

</div>
<!-- End Speakers List !-->
</td><td id="announcements">
<textarea id="announcements_textarea">
</textarea>
</td></tr>
</table>
</div>
</div>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<input type="button" id="toggler" value="Toggle Style" />
<br />
TIP: Once on projector, press F11 for full screen then use Ctrl+ and Ctrl- to 
make the above timer fit the whole projector screen.  
</body>
</html>
