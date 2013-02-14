<?php
$title = "MITMUNC - Control Panel - School Payment List";
require("/var/www/mitmunc/template/header.php"); ?>

<h1>School Payment Information</h1>
<p>Below is a list of financial transactions from schools.</p>
<br />
<?php
//Check user's credentials

$SESSION->securityCheck(true, array('secretariat'));

echo '<table class="padded bordered">';
echo '<tr><th></th><th>School</th></th><th>Amount</th><th>Postmarked</th><th>Charged</th><th>Financial Aid</th></tr>';
$totalPaid = 0;
$totalFinAid = 0;
$result = mysql_query("SELECT id FROM school_payments ORDER BY started") or die(mysql_error());
while($row = mysql_fetch_array($result)){
    $payment = new payment($row['id']);
    if($payment->finaid=='1'){
        $totalFinAid += $payment->amount;
    }else{
        $totalPaid += $payment->amount;
    }
    echo '<tr>';
    echo '<td><a href="/controlpanel/secretariat/schoolpayment?paymentId='.$payment->paymentId.'"><img src="/images/edit.png" /></a></td>';
    echo '<td>'.$payment->schoolName.'</td>';
    echo '<td>$'.$payment->amount.'</td>';
    if(strtotime($payment->started)==-62169966000){
        echo '<td></td>';
    }else{
        echo '<td>'.date('M j', strtotime($payment->started)).'</td>';
    }
    if(strtotime($payment->completed)==-62169966000){
        echo '<td></td>';
    }else{
        echo '<td>'.date('M j', strtotime($payment->completed)).'</td>';
    }
    echo '<td>';
    if ($payment->finaid=='1'){
        echo 'Y';
    }else{
        echo 'N';
    }
    echo '</td>';
    echo '</tr>';
}
echo '</table>';
echo '<br />';
echo 'Total Paid: $'.$totalPaid.'<br />';
echo 'Total Financial Aid: $'.$totalFinAid.'<br />';
?>
<br />
<br />
<a href="/controlpanel/secretariat/schoolpayment?paymentId=NEW">New Payment</a>
<br />
<br />
<a href="/controlpanel/">Back to Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
