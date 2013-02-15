<?php
$title = "MITMUNC - Control Panel - Email";
require("/var/www/mitmunc/template/header.php"); ?>
<script type="text/javascript">
function resendEmail(){
    $("#emailResent").hide();
    $.post(
        "/include/ajax/email",
        {
            emailId:$("#emailId").val(),
            resendTo:$("#resendTo").val()
        },
        function(data){
            if(data == ''){
                $("#emailResent").show();
            }else{
                alert("Error: "+data);
            }
        }
    );
}
</script>
<h1>Email</h1>
<?php

$SESSION->securityCheck(true, array('secretariat'));

$_GET = sanitizeArray($_GET);
if(array_key_exists('emailId',$_GET)){
    $emailId = $_GET['emailId'];
}else{
    echo '<a href="/controlpanel/">Back To Control Panel</a>';
    require("/var/www/mitmunc/template/footer.php");
}
echo '<input type="hidden" id="emailId" value="'.$emailId.'" />';

echo '<div id="emailResent" style="display:none">Email Sent</div>';

$result = mysql_query("SELECT * FROM emails WHERE id='$emailId.'") or die(mysql_error());
$row = mysql_fetch_array($result);
echo '<table>';
echo '<tr><th>Date Original Was Sent:</th>';
echo '<td>'.$row['timeSent'].'</td></tr>';
echo '<tr><th>From:</th>';
echo '<td>'.$row['from'].'</td></tr>';
echo '<tr><th>To:</th>';
echo '<td>'.$row['to'].'</td></tr>';
echo '<tr><th>Subject:</th>';
echo '<td>'.$row['subject'].'</td></tr>';
echo '<tr><th>Formatted Email:</th>';
echo '<td><a href="http://www.mitmunc.org/template/email?accessCode='.$row['accessCode'].'">View</a>';
echo '</table>';
echo '<b>Message:</b><br />';
echo $row['message'].'<br /><br />';
echo 'Resend email to: <input id="resendTo" type="text" value="'.$row['to'].'"><br />';
echo '<input type="submit" onclick="javascript:resendEmail()" value="Resend Email">';
?>
<br />
<br />
<a href="/controlpanel/secretariat/emaillist">Back to Email List</a>
<br />
<a href="/controlpanel/">Back To Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
