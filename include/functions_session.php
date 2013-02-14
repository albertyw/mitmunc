<?php
/**
 * This class embodies a website visitor's session
 **/
class session extends user{
    /** 
     * Constructor
     * This should be called after session_start so $_SESSION is available
     **/
    function __construct(){
        if(!isset($_SESSION['login']))
            $this->startNewSession();
        $this->login = $_SESSION['login'];
        $this->realUsername = $_SESSION['realUsername'];
        parent::__construct($_SESSION['userId']);
        // Check if a secretariat is impersonating a chair or school
        if($this->loginType == 'secretariat'){
            if(isset($_GET['committeeId'])){
                $this->committeeId = $_GET['committeeId'];
                $_SESSION['committeeId'] = $_GET['committeeId'];
            }elseif($_SESSION['committeeId']!=0){
                // Persist the impersonation even if not explicitly stated
                $this->committeeId = $_SESSION['committeeId'];
            }
            if(isset($_GET['schoolId'])){
                $this->schoolId = $_GET['schoolId'];
                $_SESSION['schoolId'] = $_GET['schoolId'];
            }elseif($_SESSION['schoolId']!=0){
                // Persist the impersonation even if not explicitly stated
                $this->schoolId = $_SESSION['schoolId'];
            }
        }
    }
    
    /**
     * Start a new session.  This is called when variables in $_SESSION are not 
     * instantiated.  Assumes that the user is not logged in
     **/
    function startNewSession(){
        $_SESSION['login'] = false;
        $_SESSION['userId'] = 0;
        $_SESSION['committeeId'] = 0;
        $_SESSION['schoolId'] = 0;
        $_SESSION['realUsername'] = '';
    }
    
    /**
     * Log the current session in as a user
     **/
    function logIn($userId){
        $_SESSION['login'] = true;
        $_SESSION['userId'] = $userId;
        $_SESSION['committeeId'] = 0;
        $_SESSION['schoolId'] = 0;
    }
    
    /**
     * Log the current session out
     **/
    function logOut(){
        $this->startNewSession();
    }
    
    /**
     * Set the impersonation
     **/
    function startImpersonation($realUsername){
        $this->realUsername = $realUsername;
        $_SESSION['realUsername'] = $realUsername;
    }
    
    /**
     * Restore the impersonator
     **/
    function endImpersonation(){
        $this->realUsername = '';
        $_SESSION['realUsername'] = '';
    }
    
    /**
     * Given a set of arguments allowing users, return True if 
     * the user is allowed and False if the user is not allowed
     **/
    function checkPermission($requireLoggedIn = True, $requireLoginTypes = array(), $requireUserNames = 'all'){
        if($requireLoggedIn && !$this->login){
            return False;
        }
        if($requireLoginTypes != 'all'){
            if(!in_array($this->loginType, $requireLoginTypes)){
                return False;
            }
        }
        if($requireUserNames != 'all'){
            if(!in_array($this->username, $requireUserNames)){
                return False;
            }
        }
        return True;
    }
    
    /**
     * Do a security check
     **/
    function securityCheck($requireLoggedIn = True, $requireLoginTypes = array(), $requireUserNames = 'all'){
        $permission = $this->checkPermission($requireLoggedIn, $requireLoginTypes, $requireUserNames);
        if(!$permission){
            echo 'You are not logged in or you are not allowed to view this page.<br />';
            mysql_query("INSERT INTO log (logType, logVal) VALUES('intrusion', 'user not logged in trying to access control panel')") or die(mysql_error());
            require("/var/www/mitmunc/template/footer.php");
            die();
        }
    }
}




