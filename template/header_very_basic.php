<?php
/**
 * This file should be required at the beginning of all php files on the website
 **/
//START USER SESSION
if(!isset($_SESSION))
    session_start();

//DATABASE CONNECTION
if(!function_exists('connectDatabase')){
    require("/var/www/mitmunc/include/functions.php");
    connectDatabase();
}

// Create the session object
$SESSION = new session();
