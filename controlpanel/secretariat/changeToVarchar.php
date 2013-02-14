<?php
$title = "MITMUNC - Control Panel - Country List";
require("/var/www/mitmunc/template/header.php"); ?>


<h1>Change to Varchar</h1>
<?php
$SESSION->securityCheck(true, array('secretariat'));

$schoolIds = school::getAllSchoolIds();

//Display table
foreach($schoolIds as $schoolId){
		   $tableName = "school_" . $schoolId;
		   echo "$tableName <br />";

		   $query = "ALTER TABLE $tableName CHANGE country country VARCHAR(50) NOT NULL";
		   $result = mysql_query($query);
		   echo mysql_num_rows($result) . "<br />";

}
?>

<br />
<a href="/controlpanel/">Back To Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
