<?php
$title = "MITMUNC - Control Panel - List of Countries";
require("/var/www/mitmunc/template/header.php"); ?>

<script type="text/javascript">
function newCountry(){
    var countryName = prompt("Enter the name of the new country");
    $.post(
        '/include/ajax/countrylist',
        {
            action:'newCountry',
            countryName:countryName
        },
        function(data){
            if(data==''){
                window.location.reload()
            }else{
                alert(data);
            }
        }
    );
}
function deleteCountry(countryId){
    $.post(
        '/include/ajax/countrylist',
        {
            action:'deleteCountry',
            countryId:countryId
        },
        function(data){
            if(data==''){
                window.location.reload()
            }else{
                alert(data);
            }
        }
    );
}
function saveCC(){
    var countryId;
    var showMatrix = {};
    for(var i=0; i<$("#countryList input").length; i++){
        countryId = $("#countryList input")[i].id.substr(7);
        showMatrix[countryId] = $("#countryList input")[i].checked;
    }
    showMatrix = JSON.stringify(showMatrix);
    $.post(
        '/include/ajax/countrylist',
        {
            action:'saveCC',
            showMatrix:showMatrix
        },
        function(data){
            if(data==''){
                window.location.reload()
            }else{
                alert(data);
            }
        }
    );
}
</script>

<h1>Countries List</h1>
<p>This is a list of countries available on the MITMUNC website.  This list will 
automatically update the list of countries available for school country preferences, 
the country/committee matrix, the committee timer, etc.  Leave one country name blank 
to allow country preferences to be set to null.</p>
<p>After making changes here, you will need to go to the Country/Committee 
Matrix page and reload the matrix in order for the matrix to be updated.</p>
<?php

$SESSION->securityCheck(true, array('secretariat'));

// Display a list of countries
echo '<input type="submit" value="New Country" onclick="javascript:newCountry()">';
echo '<br />';
echo '<table class="padded bordered" id="countryList">';
echo '<tr><th></th><th>Country Name</th><th>Shown in Country/Committee Matrix</th><th>Assigned School</th></tr>';
$countries = country::getAllCountries();
foreach($countries as $countryId => $countryName){
    $country = new country($countryId);
    echo '<tr>';
    echo '<td><a href="javascript:deleteCountry('.$country->countryId.')"><img src="/images/cancel.png" /></a></td>';
    echo '<td>'.$country->countryName.'</td>';
    echo '<td><input type="checkbox" id="country'.$country->countryId.'" ';
    if($country->showInMatrix==1){
        echo 'checked';
    }
    echo '></td>';
    echo '<td>';
    foreach($country->getCountryAssigned() as $schoolId){
        echo '<a href="/controlpanel/school/school?schoolId='.$schoolId.'">'.school::getSchoolName($schoolId).'</a>, ';
    }
    echo '</td>';
    echo '</tr>';
}
echo '</table>';
echo '<input type="submit" value="Save Show In CC Matrix" onclick="javascript:saveCC()"><br />';
echo '<input type="submit" value="New Country" onclick="javascript:newCountry()">';
?>
<p>After making changes here, you will need to go to the Country/Committee 
Matrix page and reload the matrix in order for the matrix to be updated.</p>
<br />
<br />
<a href="/controlpanel/">Back To Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
