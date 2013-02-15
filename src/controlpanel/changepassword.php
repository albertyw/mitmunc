<?php
$title = "MITMUNC - Control Panel - Change Password";
require("/var/www/mitmunc/template/header.php"); ?>
<script type="text/javascript">
function changePassword(){
    currentpassword = $("#currentpassword").val();
    newpassword = $("#newpassword").val();
    newpassword2 = $("#newpassword2").val();
    if(newpassword2!=newpassword){
        $('#passwordfeedback').html('The new passwords do not match.');
        return;
    }
    $.post(
        '/include/ajax/changePassword',
        {
            currentpassword:currentpassword,
            newpassword:newpassword
        },
        function(data){
            $('#passwordfeedback').html(data);
            $('#passwordfeedback').show('slow');
        }
    );
}
</script>

<h1>Change Password</h1>
<?php
$SESSION->securityCheck(true, 'all');
?>
<div id="passwordfeedback" style="display:none"></div>

Current password: <input type="password" id="currentpassword"><br />
New password: <input type="password" id="newpassword"><br />
New password (confirm): <input type="password" id="newpassword2"><br /><br />
<input type="submit" value="Change Password" onclick="javascript:changePassword()"><br />


<a href="/controlpanel/">Back To Control Panel</a>

<?php require("/var/www/mitmunc/template/footer.php"); ?>
