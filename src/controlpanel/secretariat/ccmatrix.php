<?php
$title = "MITMUNC - Control Panel - Country/Committee Matrix";
require("/var/www/mitmunc/template/header.php"); ?>

<script type="text/javascript">
/**
 * Basically calls the PHP ccMatrix->reloadMatrix() function and reloads the page
 **/
function reloadMatrix(){
    $.post(
        '/include/ajax/ccMatrix',
        {
            reload:true
        },
        function(data){
            if(data==''){
                window.location.reload();
            }else{
                alert(data);
            }
        }
    );
}
/**
 * Make the matrix editable
 **/
function editMatrix(){
    $(".ccEdit").show();
    $(".ccShow").hide();
}
/**
 * Save the matrix to the database
 **/
function saveMatrix(){
    var inputFields = $(".ccEdit input");
    var inputs = new Array();
    var committees = new Array();
    var countries = new Array();
    var id, committee, country;
    for(var i=0; i<inputFields.length; i++){
        id = $(inputFields[i]).attr('id')
        committee = id.substring(9, id.indexOf(' '));
        country = id.substring(id.indexOf('y')+1);
        if(!(committee in inputs)) inputs[committee] = new Array();
        inputs[committee][country] = $(inputFields[i]).val();
        committees.push(committee);
        countries.push(country);
    }
    inputs = JSON.stringify(inputs);
    committees = JSON.stringify(committees);
    countries = JSON.stringify(countries);
    $.post(
        '/include/ajax/ccMatrix',
        {
            reload:false,
            inputs:inputs,
            committees:committees,
            countries:countries
        },
        function(data){
            if(data==''){
                window.location.reload();
            }else{
                alert(data);
            }
        }
    );
}
</script>

<h1>Country/Committee Matrix</h1>
<?php

$SESSION->securityCheck(true, array('secretariat'));

$ccMatrix = new ccMatrix();
$countrySum = array();
// Display the matrix

echo '<table >';
// Committees
echo '<tr>';
    echo '<th></th>';
    foreach($ccMatrix->committees as $committeeId){
        $committeeShortName = committee::getCommitteeShortName($committeeId);
        echo '<th class="ccCommittee">'.$committeeShortName.'</th>';
    }
    echo '<th>Sum</th>';
echo '</tr>';
echo '<tr>';
    // Countries
    echo '<th nowrap="nowrap">';
        foreach($ccMatrix->countries as $countryId){
            echo '<span class="ccHeight">';
            echo country::getCountryName($countryId);
            $countrySum[$countryId] = 0;
            echo '</span>';
            echo '<br />';
        }
        echo '<span class="ccHeight">';
        echo 'Sum';
        echo '</span>';
    echo '</th>';
    // Matrix Values
    foreach($ccMatrix->committees as $committeeId){
        echo '<td nowrap="nowrap">';
            foreach($ccMatrix->matrix[$committeeId] as $countryId=>$value){
                echo '<div class="ccShow ccHeight">';
                if($value== '1'){
                    echo '1';
                    $countrySum[$countryId]++;
                }else if($value== '2'){
                    echo '2';
                    $countrySum[$countryId]+=2;
                }else if($value== '3'){
                    echo '3';
                    $countrySum[$countryId]+=2;
                }else{
                    echo '&nbsp;';
                }
                
                echo '</div>';
                echo '<div class="ccEdit ccHeight">';
                echo '<input type="text" id="committee'.$committeeId.' country'.$countryId.'" ';
                echo 'value='.$value.' size="1">';
                echo '</div>';
            }
            echo '<div class="ccSum ccHeight">';
            echo array_sum($ccMatrix->matrix[$committeeId]);
            echo '</div>';
        echo '</td>';
    }
    // country Sums
    echo '<td nowrap="nowrap">';
    foreach($ccMatrix->countries as $countryId){
        echo '<div class="ccSum ccHeight">';
        echo $countrySum[$countryId];
        
        echo '</div>';
    }
    echo '<span class="ccSum ccHeight">';
    echo array_sum($countrySum);
    echo '</span>';
    echo '</td>';
echo '</tr>';

echo '</table>';
?>
<a href="javascript:editMatrix()" class="ccShow">Edit Matrix</a>
<a href="javascript:saveMatrix()" class="ccEdit">Save Matrix</a>
<br />
<br />
<a href="javascript:reloadMatrix()">Reload the Matrix</a><br />
Reloading the matrix means the matrix committees and country list is rebuilt from 
the list of committees and countries.  Although this will try to keep old data, 
reloading the matrix has the potential to lose a lot of data, but will be useful 
 for a new conference.  
<br />
<br />
<a href="/controlpanel/">Back To Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
