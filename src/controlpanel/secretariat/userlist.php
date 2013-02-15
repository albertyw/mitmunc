<?php
$title = "MITMUNC - Control Panel - List of Users";
require("/var/www/mitmunc/template/header.php"); ?>

<h1>User List</h1>
<?php

$SESSION->securityCheck(true, array('secretariat'));

//Display list of schools
echo '<a href="/controlpanel/secretariat/user.php?userId=NEW">New User</a>';
echo '<table class="padded bordered">';
echo '<tr><th></th><th></th><th>Username</th><th>Login Type</th><th>Real Name</th><th>Phone Number</th><th>School/Committee</th><th>Last Login</th></tr>';
$result = mysql_query("SELECT id FROM users ORDER BY loginType") or die(mysql_error());
while($row = mysql_fetch_array($result)){
    $user = new user($row['id']);
    echo '<td><a href="/controlpanel/secretariat/user?userId='.$user->userId.'"><img src="/images/edit.png" /></a></td>';
    echo '<td><a href="mailto:'.$user->email.'"><img src="/images/email.png" /></a></td>';
    echo '<td>'.$user->username.'</td>';
    echo '<td>'.$user->loginType.'</td>';
    echo '<td>'.$user->realName.'</td>';
    echo '<td>'.$user->phoneNumber.'</td>';
    if($user->schoolId != 0){
        echo '<td><a href="/controlpanel/school/school?schoolId='.$user->schoolId.'">'.school::getSchoolName($user->schoolId).'</a></td>';
    }elseif($user->committeeId != 0){
        echo '<td><a href="/controlpanel/chair/committee?committeeId='.$user->committeeId.'">'.committee::getCommitteeShortName($user->committeeId).'</a></td>';
    }else{
        echo '<td></td>';
    }
    echo '<td>'.$user->lastLogin.'<br />';
    echo '<a href="http://network-tools.com/default.asp?prog=express&host='.$user->lastLoginIP.'" style="white-space:nowrap">';
    echo '<img src="/images/network.png" />'.$user->lastLoginIP.'</a></td>';
    echo '</tr>';
}
echo '</table>';
echo '<br />';
echo '<a href="/controlpanel/secretariat/user.php?userId=NEW">New User</a>';
echo '<br />';
?>
<a href="/controlpanel/">Back To Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
