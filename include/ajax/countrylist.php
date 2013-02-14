<?php
require("/var/www/mitmunc/template/header_very_basic.php");

$SESSION->securityCheck(true, array('secretariat'));

$action = $_POST['action'];
if($action == 'newCountry'){
    $countryName = $_POST['countryName'];
    $countryId = country::newCountry($countryName, '1');
}elseif($action == 'deleteCountry'){
    $countryId = $_POST['countryId'];
    $country = new country($countryId);
    $country->deleteCountry();
}elseif($action == 'saveCC'){
    $showMatrix = $_POST['showMatrix'];
    $showMatrix = json_decode($showMatrix, true);
    foreach($showMatrix as $countryId => $show){
        $country = new country($countryId);
        if($show == 'true'){
            $country->showInMatrix = '1';
        }else{
            $country->showInMatrix = '0';
        }
        $country->saveInfo();
    }
}else{
    echo 'Action not available';
}
