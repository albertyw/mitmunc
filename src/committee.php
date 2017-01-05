<?php
$title = "MITMUNC - Committees";
require("/var/www/mitmunc/template/header.php"); ?>

<h1>Committees</h1>

<?php

$committeeNames = committee::getAllCommitteeNames();
$committeeShortNames = committee::getAllCommitteeShortNames();
echo '<p>For MITMUNC 2015, we will have '.count($committeeNames).' committees:</p>';
echo '<ul>';
foreach($committeeShortNames as $committeeId => $committeeShortName){
    //echo '<li><a href="/committee/'.$committeeShortName.'">'.$committeeNames[$committeeId].'</a></li>';
	echo '<li><a href="/committeeview?committee='.$committeeShortName.'">'.$committeeNames[$committeeId].'</a></li>';
}
echo '</ul>';


?>

<!--<br />-->
<p>
For MITMUNC 2015, we will have committees 
reflecting a broad spectrum of the United Nations' scientific, economic,
and political organizations.  We have many chairs and crisis staffers who are
passionate about the goals and themes of their respective committees.
In the past, the WTO has been chaired by an Economics major and the
Environment Programme by a Civil and Environmental Engineering major.
</p>


<p>
The country-committee matrix can be found at <a href="/ccmatrix">here</a>.  
Each cell denotes whether there is a delegate for a country (row) in the committee (column).  
Blank cells mean no delegate from the country is on the committee.  
</p>

<a href="/mitmunc2012/committee2012">Past Committees</a>


<?php require("/var/www/mitmunc/template/footer.php"); ?>
