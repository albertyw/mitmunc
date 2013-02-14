<?php
$title = "MITMUNC - Control Panel - Resolutions List";
require("/var/www/mitmunc/template/header.php"); ?>
<h1>Committee Resolutions List</h1>
<p>Below is a list of all resolutions created for this committee.</p>
<?php
$SESSION->securityCheck(true, array('secretariat', 'chair'));
$committee = new committee($SESSION->committeeId);
echo 'Your committee: '.$committee->shortName.'<br /><br />';

for($i=1; $i<=committee::NUM_TOPICS; $i++){
    echo '<h2>Topic '.$i.': '.$committee->topic[$i].'</h2>';
    echo '<ul>';
    foreach(resolution::getResolutions($committee->committeeId, $i) as $resolutionId){
        $resolution = new resolution($resolutionId);
        echo '<li>';
        echo '<a href="/controlpanel/chair/resolution?resolutionId='.$resolutionId.'">Resolution '.$resolution->resolutionNum.'</a>';
        echo '</li>';
    }
    echo '</ul>';
}
?>
<br />
<input type="submit" onclick="parent.location='resolution.php?resolutionId=NEW'" value="Create New Resolution"><br />
<br />
<a href="/controlpanel/">Back to Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
