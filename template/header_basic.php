<?php
require("/var/www/mitmunc/template/header_very_basic.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<?php
if(isset($title)) echo '<title>'.$title.'</title>';
else echo '<title>MITMUNC - MIT Model United Nations Conference</title>';
?>
<!-- META TAGS !-->
<meta name="keywords" content="MITMUNC, Model United Nations, UN, MUN, MIT, Massachusetts, Conference
IAEA, UNSC, UNEP, WTO, WHO, DISEC, HRC, UNDP, UNEP, UNESCO, WFP, Triumvirate, Science, Policy" />
<meta name="description" content="Massachusetts Institute of Technology Model United Nations Conference" />
<link rel="shortcut icon" href="/images/favicon.ico" />

<!-- JAVASCRIPT IMPORTS !-->
<!-- jQuery !-->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<!-- Form Input Watermark Plugin for jQuery !-->
<script type="text/javascript" src="/include/jquery.watermarkinput.js"></script>
<!-- jQuery UI !-->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.js"></script>
<!-- WYSIWYG CKEditor !-->
<script type="text/javascript" src="/include/ckeditor/ckeditor.js"></script>
<!-- CKEditor Plugin for jQuery !-->
<script type="text/javascript" src="/include/ckeditor/adapters/jquery.js"></script>

<!-- Save Javascript Errors using AJAX Request !-->
<script type="text/javascript" src="/include/jsErrorHandling.js"></script>
<script type="text/javascript">$(function() {window.onerror = doError;});</script>
<!-- Json encoder and decoder !-->
<script type="text/javascript" src="/include/json.min.js"></script>
<!-- Widen the body if there are wide tables !-->
<script type="text/javascript">
$(function(){
    for(var i=0; i<$("table").length; i++){
        if($($("table")[0]).width() > $("#container").width()){
            $("#container").attr("style", "width:100%;");
            $("header").attr("style", "width:999px; margin-left:auto; margin-right:auto; margin:auto;");
            break;
        }
    }
});
</script>

<!-- CSS IMPORTS !-->
<link rel="stylesheet" type="text/css" href="/template/jquery-ui-1.8.16.custom.css" />
<!-- CSS/JAVASCRIPT FIXES TO MAKE OLD IE BROWSERS WORK BETTER !-->
<!--[if lt IE 7]>  <div style='border: 1px solid #F7941D; background: #FEEFDA; text-align: center; clear: both; height: 75px; position: relative;'>    <div style='position: absolute; right: 3px; top: 3px; font-family: courier new; font-weight: bold;'><a href='#' onclick='javascript:this.parentNode.parentNode.style.display="none"; return false;'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-cornerx.jpg' style='border: none;' alt='Close this notice'/></a></div>    <div style='width: 640px; margin: 0 auto; text-align: left; padding: 0; overflow: hidden; color: black;'>      <div style='width: 75px; float: left;'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-warning.jpg' alt='Warning!'/></div>      <div style='width: 275px; float: left; font-family: Arial, sans-serif;'>        <div style='font-size: 14px; font-weight: bold; margin-top: 12px;'>You are using an outdated browser</div>        <div style='font-size: 12px; margin-top: 6px; line-height: 12px;'>For a better experience using this site, please upgrade to a modern web browser.</div>      </div>      <div style='width: 75px; float: left;'><a href='http://www.firefox.com' target='_blank'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-firefox.jpg' style='border: none;' alt='Get Firefox 3.5'/></a></div>      <div style='width: 75px; float: left;'><a href='http://www.browserforthebetter.com/download.html' target='_blank'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-ie8.jpg' style='border: none;' alt='Get Internet Explorer 8'/></a></div>      <div style='width: 73px; float: left;'><a href='http://www.apple.com/safari/download/' target='_blank'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-safari.jpg' style='border: none;' alt='Get Safari 4'/></a></div>      <div style='float: left;'><a href='http://www.google.com/chrome' target='_blank'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-chrome.jpg' style='border: none;' alt='Get Google Chrome'/></a></div>    </div>  </div>  <![endif]-->
<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="/template/default_iefix.css" />
	<link rel="stylesheet" type="text/css" href="/template/header_iefix.css" />
<![endif]-->
<!--[if lt IE 9]><script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script><![endif]-->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

<!-- GOOGLE ANALYTICS !-->
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-21982914-1']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script');
    ga.type = 'text/javascript';
    ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(ga, s);
  })();
</script>

<!-- CHECK LOGGED IN !-->
<?php
if($SESSION->login) {
  echo "<script type=\"text/javascript\" src=\"/include/checkencryption.js\"></script>";
  echo "<script type=\"text/javascript\">\nvar loggedin = true;\n</script>";
} else {
  echo "<script type=\"text/javascript\">\nvar loggedin = false;\n</script>";
}
if(isset($headerCode)) echo $headerCode;
?>
</head>
<body>
