<?php
$title = "MITMUNC - Control Panel - Print Documents";
require("/var/www/mitmunc/template/header.php");
$SESSION->securityCheck(true, array('secretariat', 'chair'));
?>
<h1>Print Documents</h1>
<p>This system only accepts PDFs.  Convert other document types to PDF for printing.</p>

<h2>Current Printer(s) Status:</h2>
<?php
$status = shell_exec("lpstat -p");
echo '<pre>'.$status.'</pre>';
?>
<h2>Current Printer(s) Jobs:</h2>
<?php
$jobs = shell_exec("lpstat -o");
echo '<pre>'.$jobs.'</pre>';
?>
<form enctype="multipart/form-data" action="/controlpanel/chair/printprocess" method="POST">
Printer Name: <select name="printerName">
<?php
$result = mysql_query("SELECT * FROM printers") or die(mysql_error());
while($row = mysql_fetch_array($result)){
    echo '<option value="'.$row['printerName'].'">'.$row['printerName'].'</option>';
}
?>
</select><br />
Upload a PDF to Print: <input name="uploadedfile" type="file" /><br />
Number of Copies: <input type="text" name="numcopies" value="1"/><br />
<input type="submit" value="Upload File" />
</form>

<br />
<a href="/controlpanel/">Back to Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
