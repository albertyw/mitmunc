<?php
$title = "MITMUNC - Control Panel - User";
require("/var/www/mitmunc/template/header.php"); ?>
<script type="text/javascript">
function saveEdits(){
    $("#usernameTaken").hide();
    $("#userSaved").hide();
    $.ajax({
        type:'POST',
        async:false,
        url:"/include/ajax/user",
        data:{
            userDelete:false,
            userId:$("#userId").val(),
            username:$("#username").val(),
            password:$("#password").val(),
            loginType:$("#loginType").val(),
            realName:$("#realName").val(),
            email:$("#email").val(),
            phoneNumber:$("#phoneNumber").val(),
            committeeId:$("#committeeId").val(),
            schoolId:$("#schoolId").val(),
            lastLogin:$("#lastLogin").val(),
            lastLoginIp:$("#lastLoginIp").val(),
        },
        success:function(data){
            if(data == 'usernameTaken'){
                $("#usernameTaken").show();
            }else if(data == 'userSaved'){
                $("#userSaved").show();
            }else{
                alert("Error: "+data);
            }
        }
    });
}
function deleteUser(){
    $.post(
        "/include/ajax/user",
        {
            userDelete:true,
            userId:$("#userId").val()
        },
        function(data){
            if(data == 'userDeleted'){
                window.location = '/controlpanel/secretariat/userlist';
            }else{
                alert("Error: "+data);
            }
        }
    );
}
function impersonateUser(){
    saveEdits();
    $.post(
        "/login",
        {
            username:$("#username").val(),
            impersonate:true
        },
        function(data){
            window.location = '/controlpanel/';
        }
    );
}
</script>
<h1>User List</h1>
<p>Edit a user's information here.  Be sure to Save the information after you 
edit it.  Impersonating a user allows you to log in as the user and edit the 
control panel from the user's perspective.</p>
<?php

$SESSION->securityCheck(true, array('secretariat'));

$_GET = sanitizeArray($_GET);
if(array_key_exists('userId',$_GET)){
    $userId = $_GET['userId'];
    if($userId == 'NEW'){
        $user = user::newUser();
        echo 'New user created, please edit information<br />';
    }else{
        $user = new user($userId);
    }
}else{
    echo '<a href="/controlpanel/">Back To Control Panel</a>';
    require("/var/www/mitmunc/template/footer.php");
}
echo '<input type="hidden" id="userId" value="'.$user->userId.'" />';

echo '<div id="usernameTaken" style="display:none">The username has already been taken</div>';
echo '<div id="userSaved" style="display:none">Saved</div>';

echo '<table id="userTable">';
echo '<tr><th>ID:</th>              <td>'.$user->userId.'</td></tr>';
echo '<tr><th>Username:</th>        <td><input type="text" id="username" value="'.$user->username.'" /></td></tr>';
echo '<tr><th>Password:</th>        <td><input type="text" id="password" value="--"></td></tr>';
echo '<tr><th>Login Type:</th>      <td><select id="loginType">';
if($user->loginType == 'secretariat'){
    echo '<option value="secretariat" SELECTED>Secretariat</option>';
}elseif($user->loginType == 'chair'){
    echo '<option value="chair" SELECTED>Chair</option>';
}elseif($user->loginType == 'school'){
    echo '<option value="school" SELECTED>Adviser</option>';
}elseif($user->loginType == 'timer'){
    echo '<option value="timer" SELECTED>Timer</option>';
}
echo '<option value="secretariat">Secretariat</option><option value="chair">Chair</option>';
echo '<option value="school">Adviser</option><option value="timer">Timer</option>';
echo '</select></td></tr>';
echo '<tr><th>Real Name:</th>       <td><input type="text" id="realName" value="'.$user->realName.'" /></td></tr>';
echo '<tr><th>E-mail:</th>          <td><input type="text" id="email" value="'.$user->email.'" /></td></tr>';
echo '<tr><th>Phone Number:</th>    <td><input type="text" id="phoneNumber" value="'.$user->phoneNumber.'" /></td></tr>';
echo '<tr><th>Committee:</th>       <td>';
$committees = committee::getAllCommitteeShortNames();
$committees['0'] = 'NONE';
echo committee::getCommitteeOptions(array("id"=>"committeeId"), $user->committeeId, $committees);
echo '</td></tr>';
echo '<tr><th>School:</th>          <td>';
echo school::getSchoolOptions(array("id"=>"schoolId"), $user->schoolId, $allowEmpty = true);
echo '</td></tr>';
echo '<tr><th>Last Login:</th>      <td><input type="text" id="lastLogin" value="'.$user->lastLogin.'" /></td></tr>';
echo '<tr><th>Last Login IP:</th>   <td><input type="text" id="lastLoginIp" value="'.$user->lastLoginIP.'" /></td></tr>';
echo '</table>';
?>
<br />
<input type="submit" onclick="javascript:saveEdits()" value="Save" /> - 
<input type="submit" onclick="javascript:deleteUser()" value="Delete" /> - 
<input type="submit" onclick="javascript:impersonateUser()" value="Impersonate" /><br />
<br />
<a href="/controlpanel/secretariat/userlist">Back to User List</a>
<br />
<br />
<a href="/controlpanel/">Back To Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
