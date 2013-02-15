<?php
require("/var/www/mitmunc/template/header_very_basic.php");

$SESSION->securityCheck(true, array('secretariat'));

$countryConfirms = $_POST['countryConfirms'];
$countryConfirms = json_decode($countryConfirms, true);

foreach($countryConfirms as $schoolId => $checked){
    $school = new school($schoolId);
    if($checked == 'true'){
        $school->countryConfirm = '1';
    }else{
        $school->countryConfirm = '0';
    }
    $school->saveInfo();
}
