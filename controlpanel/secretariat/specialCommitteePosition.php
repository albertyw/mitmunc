<?php
$title = "MITMUNC - Control Panel - Special Committee Position";
require("/var/www/mitmunc/template/header.php"); ?>
<script type="text/javascript">
function saveEdits(){
    $("#positionSaved").hide();
    $.post(
        "/include/ajax/specialCommitteePosition2",
        {
            positionDelete:false,
            positionId:$("#positionId").val(),
            positionName:$("#positionName").val(),
            committeeId:$("#committeeId").val()
        },
        function(data){
            if(data == 'positionSaved'){
                $("#positionSaved").show('slow');
            }else{
                alert("Error: "+data);
            }
        }
    );
}
function deletePosition(){
    $.post(
        "/include/ajax/specialCommitteePosition2",
        {
            positionDelete:true,
            positionId:$("#positionId").val()
        },
        function(data){
            if(data == 'positionDeleted'){
                window.location = '/controlpanel/secretariat/specialCommitteePositionList';
            }else{
                alert("Error: "+data);
            }
        }
    );
}
</script>

<h1>Special Committee Position Information</h1>
<br />
<?php
//Check user's credentials
$SESSION->securityCheck(true, array('secretariat'));

$_GET = sanitizeArray($_GET);
if(array_key_exists('positionId',$_GET)){
    $positionId = $_GET['positionId'];
    if($positionId == 'NEW'){
        $position = specialCommitteePosition::newPosition();
        echo 'New Position created, please edit information<br />';
    }else{
        $position = new specialCommitteePosition($positionId);
    }
}else{
    echo '<a href="/controlpanel/">Back to Control Panel</a>';
    require("/var/www/mitmunc/template/footer.php");
}
echo '<input type="hidden" id="positionId" value="'.$position->positionId.'" />';
echo '<div id="positionSaved" style="display:none">Saved</div>';
echo '<table>';
echo '<tr><th>Position ID</th><td>'.$position->positionId.'</td></tr>';
echo '<tr><th>Position Name</th><td><input type="text" id="positionName" value="'.$position->positionName.'" size="100"></td></tr>';
echo '<tr><th>Committee</th><td>'.committee::getCommitteeOptions(array("id"=>"committeeId"), $position->committeeId).'</td></tr>';
echo '</table>';
?>
<br />
<input type="submit" onclick="javascript:saveEdits()" value="Save" /> - 
<input type="submit" onclick="javascript:deletePosition()" value="Delete" /> - 
<input type="submit" onclick="javascript:window.location='/controlpanel/secretariat/specialCommitteePositionList'" value="Back" />
<br />
<br />
<a href="/controlpanel/">Back to Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
