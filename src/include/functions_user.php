<?php
/**
 * This class embodies the users table in the mysql database
 **/
class user {
    function __construct($userId){
        $this->userId = $userId;
        $result = mysql_query("SELECT * FROM users WHERE id = '$userId'") or die(mysql_error());
        $row = mysql_fetch_array($result);
        $this->username = $row['username'];
        $this->passwordHash = $row['password'];
        $this->loginType = $row['loginType'];
        $this->realName = $row['realName'];
        $this->email = $row['email'];
        $this->phoneNumber = $row['phoneNumber'];
        $this->committeeId = $row['committeeId'];
        $this->schoolId = $row['schoolId'];
        $this->lastLogin = $row['lastLogin'];
        $this->lastLoginIP = $row['lastLoginIP'];
    }
    
    /**
     * Save the information in this object to the database
     **/
    function saveInfo(){
        if(user::usernameTaken($this->username, $this->userId)) return false;
        if($this->loginType == 'secretariat'){
            $this->schoolId = '';
        }
        $result = mysql_query("UPDATE users SET username='$this->username' WHERE id='$this->userId'") or die(mysql_error());
        $result = mysql_query("UPDATE users SET password='$this->passwordHash' WHERE id='$this->userId'") or die(mysql_error());
        $result = mysql_query("UPDATE users SET loginType='$this->loginType' WHERE id='$this->userId'") or die(mysql_error());
        $result = mysql_query("UPDATE users SET realName='$this->realName' WHERE id='$this->userId'") or die(mysql_error());
        $result = mysql_query("UPDATE users SET email='$this->email' WHERE id='$this->userId'") or die(mysql_error());
        $result = mysql_query("UPDATE users SET phoneNumber='$this->phoneNumber' WHERE id='$this->userId'") or die(mysql_error());
        $result = mysql_query("UPDATE users SET committeeId='$this->committeeId' WHERE id='$this->userId'") or die(mysql_error());
        $result = mysql_query("UPDATE users SET schoolId='$this->schoolId' WHERE id='$this->userId'") or die(mysql_error());
        $result = mysql_query("UPDATE users SET lastLogin='$this->lastLogin' WHERE id='$this->userId'") or die(mysql_error());
        $result = mysql_query("UPDATE users SET lastLoginIP='$this->lastLoginIP' WHERE id='$this->userId'") or die(mysql_error());
        return true;
    }
    
    /**
     * Delete the user from the database
     **/
    function deleteUser(){
        $result = mysql_query("DELETE FROM users WHERE id='$this->userId'") or die(mysql_error());
        return true;
    }
    
    /**
     * Create a new user object that is initially empty
     **/
    public static function newUser(){
        $result = mysql_query("SELECT id FROM users WHERE username=''") or die(mysql_error());
        $row = mysql_fetch_array($result);
        if($row['id'] != 0){
            $id = $row['id'];
        }else{
            $result = mysql_query("INSERT INTO users () VALUES()") or die(mysql_error());
            $id = mysql_insert_id();
        }
        $user = new user($id);
        return $user;
    }
    
    /**
     * Check if $this->username is already taken, other than by this user
     **/
    public static function usernameTaken($username, $ignoreId='0'){
        $user = user::getByUsername($username);
        if($user == null){
            return false;
        }elseif($user->userId == $ignoreId){
            return false;
        }
        return true;
    }
    
    /**
     * Find a user by username
     **/
    public static function getByUsername($username){
        $result = mysql_query("SELECT id FROM users WHERE username='$username'") or die(mysql_error());
        $row = mysql_fetch_array($result);
        if($row['id']!=0){
            return new user($row['id']);
        }else{
            return null;
        }
    }
    
    /**
     * Get number of users grouped by type
     **/
     public static function totalUsers(){
         $totalUsers = array();
         $result = mysql_query("SELECT loginType, COUNT(username) FROM users GROUP BY loginType") or die(mysql_error());
         while($row = mysql_fetch_array($result)){
             $totalUsers[$row['loginType']] = $row['COUNT(username)'];
         }
         return $totalUsers;
     }
    
    /**
     * Get the user(s) from a school id
     **/
    public static function getSchoolUsers($schoolId){
        $userIds = array();
        $result = mysql_query("SELECT id FROM users where schoolId='$schoolId'") or die(mysql_error());
        while($row = mysql_fetch_array($result)){
            array_push($userIds, $row['id']);
        }
        return $userIds;
    }
}
