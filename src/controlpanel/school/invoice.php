<?
require("/var/www/mitmunc/template/header_basic.php");
?>
<span id="title"></span>
<div style="text-align:center"><h1>Invoice</h1>
<h3>Model United Nations<br />
Massachusetts Institute of Technology Model United Nations Conference</h3></div>
<?php
$SESSION->securityCheck(true, array('secretariat', 'school'));

$school = new school($SESSION->schoolId);
$mealTicket = new mealTicket($SESSION->schoolId);

?>



<table border="0" cellpadding="20">
<tr><td>
<b>Bill To:</b><br />
<?php echo $school->schoolName ?><br />
<?php echo $school->address['1'] ?><br />
<?php if($school->address['2']!='' && $school->address['2']!='Optional') echo $school->address['2'].'<br />' ?>
<?php echo $school->address['city'].', '.$school->address['state'].' '.$school->address['zip'] ?><br />
</td><td>
<b>Invoice Date:</b> <?php echo date('F j, Y') ?><br />
<b>Registration Date:</b> <?php echo date('F j, Y', strtotime($school->regTime)) ?><br />
<b>Amount Due:</b> <?php echo $school->totalOwedFormatted ?><br />
<b>School Fee Due: </b> October 26, 2014 <br/>
<!-- <b>School Fee Due:</b> <?php echo date('F j, Y', $school->schoolFeeDue) ?><br /> -->
<b>Payment Fee Due: $<span id="pay_fee">0</span><br/>
<b>Total Fees Due:</b> <?php echo date('F j, Y', $school->totalPaymentDue) ?><br /> <br />

</td>
<?php
echo generalInfoReader('mailingAddress');
?>
<td>
Phone: 601-564-8686<br />
E-mail: <?php echo obfuscateEmail("info-mitmunc@mit.edu");?><br />
</td></tr>
</table>

<table border="0" width="100%">
<tr><th>Quantity</th><th>Description</th><th>Unit Price</th><th>Amount</th></tr>

<tr><td align="center">1</td><td align="center">School Registration</td><td align="center"><?php echo $school->schoolFeeFormatted?></td><td align="center"> <?php echo $school->schoolFeeFormatted ?></td></tr>

<tr><td align="center"><?php echo $school->numStudents ?></td><td align="center">Student Registration</td><td align="center"><?php echo $school->delegateFeeFormatted ?></td><td align="center"> <?php echo $school->delegateFeeTotalFormatted ?></td></tr>

<?php /*<tr><td align="center"><?php echo array_sum($mealTicket->meal) ?></td><td a<lign="center">Meal Tickets</td><td align="center"><?php echo $mealTicket->mealCost[1] ?></td><td align="center"><?php echo $mealTicket->totalCost ?></td></tr> */?>

<?php
$payments = payment::getSchoolPayments($school->schoolId);
for($i = 0; $i < sizeof($payments); $i++){
    $payment = new payment($payments[$i]);
    if($payment->finaid == '1'){
        echo '<tr><td align="center">1</td><td align="center">Financial Aid Given On ';
    }else{
        echo '<tr><td align="center">1</td><td align="center">Payment Postmarked ';
    }
    echo extractDate($payment->started);
    echo '</td><td align="center"> </td><td align="center">';
    echo -$payment->amountFormatted;
    echo '</td></tr>';
}
?>
<tr><td></td><td></td><td></td><th>Total Due:<?php echo $school->totalOwedFormatted ?></th></tr>
</table>
<br />
<div>
<b>Amount Due: <?php echo $school->totalOwedFormatted ?><br />
<br />
Amount Enclosed: ______________</b><br />
</div>
<div>
Please Mail Payment With A Copy Of This Invoice To:<br />

<?php
echo generalInfoReader('mailingAddress');
?>

601-564-8686<br />
</div>
</body>
</html>
