<?php
$title = "MITMUNC - Country/Committee Matrix";
require("/var/www/mitmunc/template/header.php"); ?>
<style>
.ccShow:nth-child(odd)		{ background-color:#eee; }
.ccShow:nth-child(even)		{ background-color:#fff; }
th>div.ccHeight:nth-child(4n+1)		{ background-color:#eee; }
th>div.ccHeight:nth-child(4n+3)		{ background-color:#fff; }

</style>

<h1>Country/Committee Matrix</h1>


The table below shows which countries and positions have membership on our committees.  
<a href="#specialCommitteePositions">See Special Committee Positions</a>


<?php
$ccMatrix = new ccMatrix();
//The removeEmpty() function is falsely removing countries!
//Commenting out for now.
//$ccMatrix->removeEmpty();
$countrySum = array();
// Display the matrix

echo '<table class="ccmatrxTable">';
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
            echo '<div style="display:inline;width:253px !important;height:30px !important;"class="ccHeight">';
            echo country::getCountryName($countryId);
            $countrySum[$countryId] = 0;
            echo '</div>';
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
                    $countrySum[$countryId]+=3;
                }else{
                    echo '&nbsp;';
                }
                echo '</div>';
            }
            echo '<div class="ccSum ccHeight">';
            echo array_sum($ccMatrix->matrix[$committeeId]);
            echo '</div>';
        echo '</td>';
    }
    // Country Sums
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

echo '<a style="margin-top:20px;" name="specialCommitteePositions"></a>';
echo '<h1 style="text-align:left;">Special Committee Positions</h1>';
foreach(committee::getAllCommitteeNames() as $committeeId => $committeeName){
    $committee = new committee($committeeId);
    if(sizeof($committee->specialPositions)!=0){
        echo '<h2>'.$committee->committeeName.' ('.sizeof($committee->specialPositions).' Positions)</h2>';
        echo '<ul>';
        foreach($committee->specialPositions as $positionId){
            $position = new specialCommitteePosition($positionId);
            echo '<li>'.$position->positionName.'</li>';
        }
        echo '</ul>';
    }
}

?>

<?php require("/var/www/mitmunc/template/footer.php"); ?>
