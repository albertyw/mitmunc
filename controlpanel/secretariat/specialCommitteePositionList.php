<?php
$title = "MITMUNC - Control Panel - Special Committee Position List";
require("/var/www/mitmunc/template/header.php"); ?>

<h1>Special Committee Positions</h1>
<p>Below is a list of special committee positions.</p>
<br />
<?php
//Check user's credentials
$SESSION->securityCheck(true, array('secretariat'));

echo '<table class="padded bordered">';
echo '<tr><th></th><th>Position Name</th><th>Committee</th><th>Assigned School</th></tr>';
$committees = committee::getAllCommitteeShortNames();
foreach($committees as $committeeId=>$committeeShortName){
    $committee = new committee($committeeId);
    foreach($committee->specialPositions as $positionId){
        $position = new specialCommitteePosition($positionId);
        echo '<tr>';
        echo '<td><a href="/controlpanel/secretariat/specialCommitteePosition?positionId='.$positionId.'"><img src="/images/edit.png" /></a></td>';
        echo '<td>'.$position->positionName.'</td>';
        echo '<td>'.$committeeShortName.'</td>';
        if($position->assignedSchoolId == 0){
            echo '<td><b>Unassigned</b></td>';
        }else{
            echo '<td>'.school::getSchoolName($position->assignedSchoolId);
            if(sizeof($position->schoolApplications)>1){
                echo '<br /><b>WARNING: Position has also been assigned to ';
                foreach($position->schoolApplications as $schoolId){
                    echo school::getSchoolName($schoolId).', ';
                }
                echo '</b>';
            }
            echo '</td>';
        }
        echo '</tr>';
    }
}
echo '</table>';
?>
<br />
<br />
<a href="/controlpanel/secretariat/specialCommitteePosition?positionId=NEW">New Position</a>
<br />
<a href="/controlpanel/secretariat/specialCommitteePositionBulk">Bulk Load Positions</a>
<br />
<br />
<a href="/controlpanel/">Back to Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
