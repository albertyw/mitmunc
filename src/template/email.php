<?php
require("/var/www/mitmunc/template/header_very_basic.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" style="height:100%; margin:0; padding:0; border:0;">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>MITMUNC - Email</title>
</head>
<body style="height:100%; margin:0; padding:0; border:0;">
<?php
$accessCode = $_GET['accessCode'];
$result = mysql_query("SELECT * FROM emails WHERE accessCode='$accessCode'") or die(mysql_error());
$row = mysql_fetch_array($result);
// The code below looks like 1990s HTML because email clients are not up to date 
// with standards compliant html/css/javascript
?>

<table width="100%" style="height: 100%; margin:0; padding:0; border:0;">
    <tr>  
        <td>  
            <table width="600" align="center" bgcolor="white" style="height:100%;">
                <tr>
                    <td height="15px"><font size="2">
                    Cannot view this email?  
                    <a href="http://mitmunc.mit.edu/template/email?accessCode=<?php echo $accessCode; ?>">
                    Click Here</a></font>
                    <img src="http://mitmunc.mit.edu/images/emailTracking.gif">
                    </td>
                </tr>
                <tr>
                    <td align="center" height="94px"><img src="http://mitmunc.mit.edu/images/header/Header_Logo.gif" alt="MITMUNC"></td>
                </tr>
                <tr>  
                    <td valign="top"><?php echo $row['message']; ?></td>  
                </tr>  
            </table>  
        </td>  
    </tr>  
</table>


</body>
</html>
