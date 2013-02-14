<?php
$title = "MITMUNC - Control Panel - Meal Tickets";
require("/var/www/mitmunc/template/header.php"); ?>
<script type="text/javascript">
function editMealTickets(){
    $("#mealTicketShow").hide();
    $("#mealTicketEdit").show();
}

function saveMealTickets(){
    var postInfo = {};
    var i = 1;
    while($("#meal"+i).length!='0'){
        postInfo["meal"+i] = $("#meal"+i).val();
        i++;
    }
    postInfo['mealNotes'] = $("#mealNotes").val();
    postInfo['schoolId'] = $("#schoolId").val();
    $.post(
        '/include/ajax/mealTicket',
        postInfo,
        function(data){
            if(data!=''){
                alert(data);
            }else{
                location.reload(true);
            }
        }
    );
}

</script>


<h1>Lunch Tickets</h1>
<p>MITMUNC will be selling lunch during the conference.  You can preorder lunches 
for your delegations here.  
More information is available on the 
<a href="/accommodations">accommodations page</a>.  The costs will be shown on 
your <a href="/invoice">invoice</a>.  </p>
<br />
<br />
<?php
$SESSION->securityCheck(true, array('secretariat', 'school'));

//Display school info
$school = new school($SESSION->schoolId);
$mealTicket = new mealTicket($SESSION->schoolId);
echo '<input type="hidden" id="schoolId" value="'.$school->schoolId.'">';

echo '<div id="mealTicketShow">';
foreach($mealTicket->meal as $mealId => $mealNumberTickets){
    if($mealTicket->mealDescription[$mealId]=='disabled') continue;
    echo $mealTicket->mealDescription[$mealId].': ';
    echo $mealNumberTickets;
    echo ' x $'.$mealTicket->mealCost[$mealId].' = $'.($mealTicket->mealCost[$mealId]*$mealNumberTickets);
    echo '<br />';
}
echo '<br />';
echo 'Please list any dietary restrictions<br />';
echo $mealTicket->mealNotes;
echo '<br />';
echo '<input type="submit" onclick="javascript:editMealTickets()" value="Edit"/>';
echo '</div>';


echo '<div id="mealTicketEdit" style="display:none">';
foreach($mealTicket->meal as $mealId => $mealNumberTickets){
    if($mealTicket->mealDescription[$mealId]=='disabled'){
        echo '<input type="hidden" id="meal'.$mealId.'" value="0" />';
        continue;
    }
    echo $mealTicket->mealDescription[$mealId].': ';
    echo '<input type="text" id="meal'.$mealId.'" value="'.$mealNumberTickets.'"/><br />';
}
echo '<br />';
echo 'Please list any dietary restrictions<br />';
echo '<textarea id="mealNotes" cols="50" rows="5">'.$mealTicket->mealNotes.'</textarea>';
echo '<br />';
echo '<input type="submit" onclick="javascript:saveMealTickets()" value="Submit" />';
echo '</div>';

?>

<br />
<a href="/controlpanel/">Back to Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); 
?>
