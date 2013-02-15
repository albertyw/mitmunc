<?php
$title = "MITMUNC - Control Panel - Special Committee Position Bulk Load";
require("/var/www/mitmunc/template/header.php"); ?>

<h1>Special Committee Position Bulk Loading</h1>
Load several special positions into committees at once.  
<br />
<br />
<form action="./specialCommitteePositionBulk" method="POST">
<?php
//Check user's credentials
$SESSION->securityCheck(true, array('secretariat'));

if($_POST != array()){
    // Load positions
    $_POST = sanitizeArray($_POST);
    $committeeId = $_POST['committeeId'];
    $positions = $_POST['positions'];
    $positions = str_replace("\\n", "\n", $positions);
    $positions = str_replace("\\r", "\n", $positions);
    $positions = explode("\n", $positions);
    foreach($positions as $position){
        if($position == ''){
            continue;
        }
        $specialPosition = specialCommitteePosition::newPosition();
        $specialPosition->positionName = $position;
        $specialPosition->committeeId = $committeeId;
        $specialPosition->saveInfo();
    }
    echo 'Positions have been loaded.';
}else{
    echo 'Committee: '.committee::getCommitteeOptions(array("name"=>"committeeId")).'<br />';
    echo 'Positions: (Separate positions on different lines)<br />';
    echo '<textarea name="positions" cols="100" rows="20">';
    echo '</textarea>';
    echo '<br />';
    echo '<input type="submit" value="Save" />';
}
?>
</form>
<br />
<br />
<a href="/controlpanel/secretariat/specialCommitteePositionList">Back to Special Committee Positions</a><br />
<a href="/controlpanel/">Back to Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
