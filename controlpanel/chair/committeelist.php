<?php
$title = "MITMUNC - Control Panel - Committee List";
require("/var/www/mitmunc/template/header.php"); ?>
<script type="text/javascript">
function deleteCommittee(committeeId){
    var answer = confirm("Are you sure you want to delete this committee and all of its chairs?");
    if(!answer) return;
    $.post(
        '/include/ajax/committeeList',
        {
            committeeId: committeeId
        },
        function(data){
            if(data == ''){
                window.location.reload();
            }else{
                alert(data);
            }
        }
    );
}
</script>
<h1>Committee List</h1>
<p>Below is a list of committees for MITMUNC</p>
<?php
$SESSION->securityCheck(true, array('secretariat', 'chair'));
?>

<a href="/controlpanel/chair/committee?committeeId=NEW">New Committee</a><br />

<table class="padded bordered">
<tr><th></th><th>Name</th><th>Announcements</th><th>Topic 1</th><th>Topic 2</th><th>Topic 3</th></tr>
<?php
//Display list of committees
foreach(committee::getAllCommitteeNames() as $committeeId => $committeeName){
    $committee = new committee($committeeId);
    echo '<td><a href="javascript:deleteCommittee('.$committee->committeeId.')"><img src="/images/cancel.png" /></a></td>';
    echo '<td><a href="/controlpanel/chair/committee?committeeId='.$committee->committeeId.'">';
    echo $committee->committeeName.' ('.$committee->shortName.')</a></td>';
    echo '<td>'.$committee->announcement.'</td>';
    for($i=1; $i<=committee::NUM_TOPICS; $i++){
        echo '<td>'.$committee->topic[$i].'</td>';
    }
    echo '</tr>';
}
?>
</table>
<a href="/controlpanel/chair/committee?committeeId=NEW">New Committee</a><br />
<br />
<a href="/controlpanel/">Back To Control Panel</a>

<?php require("/var/www/mitmunc/template/footer.php"); ?>
