<?php
$title = "MITMUNC - Control Panel - Print Documents";
require("/var/www/mitmunc/template/header.php");
$SESSION->securityCheck(true, array('secretariat', 'chair'));

$target_path = "/home/mitmunc/print/";
$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 
if(strpos(basename($_FILES['uploadedfile']['name'], 'pdf')) === false){
    echo '<br /><a href="/controlpanel/">Back to Control Panel</a>';
    require("/var/www/mitmunc/template/footer.php");
    die();
}
if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
    $numcopies = $_POST['numcopies'];
    $printerName = $_POST['printerName'];
    echo "The file ".  basename( $_FILES['uploadedfile']['name']). " has been uploaded<br /><br />";
    $command = "lp -d $printerName -n $numcopies -o outputorder=reverse -o collate=True \"$target_path\"";
    echo '<pre>'.$command.'</pre><br /><br />';
    $output = shell_exec($command);
    echo '<pre>'.$output.'</pre><br /><br />';
} else{
    echo "There was an error uploading the file, please try again!";
}
?>
<br />
<a href="/controlpanel/chair/print">Print More</a>
<a href="/controlpanel/">Back to Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
