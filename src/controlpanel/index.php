<?php
$title="MITMUNC - Control Panel";
require("/var/www/mitmunc/template/header.php");
require("/var/www/mitmunc/include/functions_controlpanel.php");
?>

<h1>Administration</h1>
<?php
$SESSION->securityCheck(true, 'all');

if($_SESSION['realUsername']!=''){
    ?>
    <script type="text/javascript">
    function endImpersonation(){
        $.post(
            "/login",
            {impersonate:false},
            function(data){window.location = '/controlpanel/'}
        );
    }
    </script>
    <?php
    echo '<div class="center bold">You are currently impersonating '.$SESSION->username.'<br />';
    echo '<input type="submit" value="Revert To '.$SESSION->realUsername.'" onclick="javascript:endImpersonation()"></div>';
}

if($SESSION->loginType=='school'){
    require("/var/www/mitmunc/controlpanel/school/control.php");
}
if($SESSION->loginType=='chair'){
    require("/var/www/mitmunc/controlpanel/chair/control.php");
}
if($SESSION->loginType=='secretariat'){
    require("/var/www/mitmunc/controlpanel/secretariat/control.php");
}
if($SESSION->loginType=='timer'){
    require("/var/www/mitmunc/controlpanel/committeetimer/control.php");
}
?>
<a href="/controlpanel/changepassword">Change Password</a>
<br />
<?php require("/var/www/mitmunc/template/footer.php"); ?>
