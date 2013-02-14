<?php
//DATABASE CONNECTION
include_once("/var/www/mitmunc/include/functions.php");
connectDatabase();

$_POST = sanitizeArray($_POST);
$committee = $_POST['committee'];

$query = "SELECT timer_log.id, countries.country
    FROM timer_log LEFT JOIN countries  
    ON timer_log.country=countries.id WHERE timer_log.committee='$committee' AND timer_log.status='new'";
$result = mysql_query($query) or die(mysql_error());
echo '<table id="speakers_list_table">';
while($row = mysql_fetch_array($result)){
    echo '<tr><td class="speaker_country">';
    echo $row['country'];
    echo '</td><td class="speaker_remove">';
    echo '<a href="javascript:timer_log_delete('.$row['id'].')">';
    echo '<img src="img/speakerRemove.png"></a>';
    echo '</td></tr>';
}
echo '</table>';
?>
