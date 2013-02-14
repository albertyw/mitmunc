<?php
//DATABASE CONNECTION
include_once("/var/www/mitmunc/include/functions.php");
connectDatabase();

$_POST = sanitizeArray($_POST);
$country = $_POST['country'];
$committee = $_POST['committee'];



if($country!=''){
    $query = "SELECT id FROM countries WHERE country='$country'";
    $result = mysql_query($query) or die(mysql_error());
    if (mysql_num_rows($result) != 0) {
      $row = mysql_fetch_array($result);
      $country_id = $row['id'];
      $query = "INSERT INTO timer_log (committee, country, status) VALUES('$committee', '$country_id', 'new')";
      mysql_query($query) or die(mysql_error());
    }
}

require("./timer_log.php");
