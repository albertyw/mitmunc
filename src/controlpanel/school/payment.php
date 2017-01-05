<?php
$title = "MITMUNC - Control Panel - Payment Information";
require("/var/www/mitmunc/template/header.php"); ?>
<h1>School Payment</h1>
<?php
$SESSION->securityCheck(true, array('secretariat', 'school'));
                
//Display school info
$school = new school($SESSION->schoolId);
?>
<h2>School Registration Information</h2>
<p>
<?php
echo 'School Name: '.$school->schoolName.'<br />';
echo 'Number of Students Attending: '.$school->numStudents.'<br />';
echo 'Number of Advisers Attending: '.$school->numAdvisers.'<br />';
echo 'Time of Registration: '.$school->regTime.'<br />';
?>
</p>

<h2>Finances</h2><br />
<p>
<?php
echo 'Financial Aid Requested: ';
if($school->finAid==1) echo 'Yes<br />';
if($school->finAid==0) echo 'No<br />';
echo '<table border="0">';
echo '<tr><td>School Registration Fee: </td><td style="text-align:right">$</td><td style="text-align:right">'.$school->schoolFee.'</td></tr>';
echo '<tr><td>Student Registration Fee: '.$school->numStudents.' x $'.$school->delegateFee.' = </td><td style="text-align:right">$</td><td style="text-align:right">'.$school->delegateFeeTotal.'</td></tr>';
#echo '<tr><td>Meal Ticket Fee: </td><td style="text-align:right">$</td><td style="text-align:right">'.$school->mealTicketTotal.'</td></tr>';
echo '<tr><td>Financial Aid Given: </td><td style="text-align:right">-$</td><td style="text-align:right">'.$school->totalFinAid.'</td></tr>';
echo '<tr><td>Total Registration Fee: </td><td style="text-align:right">$</td><td style="text-align:right">'.$school->totalFee.'</td></tr>';
echo '<tr><td>Amount Paid: </td><td style="text-align:right">-$</td><td style="text-align:right">'.$school->totalPaid.'</td></tr>';
echo '<tr><td>Amount Owed: </td><td style="text-align:right">$</td><td style="text-align:right;border-top: 1px solid black;">'.$school->totalOwed.'</td></tr>';
echo '</table>';
?>
</p>
<p>
'Your school fee is due October 26, 2014.'<br />
<?php
// echo 'Your school fee is due '.date('F j, Y', $school->schoolFeeDue).'.<br />';
echo 'Your total payment is due '.date('F j, Y', $school->totalPaymentDue).'.<br />';
?>
</p>

<p>
If you miss the school fee payment deadline, you will need to pay increased fees for the next deadline.  
See the <a href="/df">deadlines and fees page</a> for more details.  
</p>

<p>
If you requested financial aid but that is not accurately reflected in the above information, please send an email to <?php echo obfuscateEmail('info-mitmunc@mit.edu'); ?>.
</p>

<p><b>To make the conference fee payment, please write a check for the amount owed above, payable to "MIT Model UN", with your school name in the memo field.  
Please mail the check to the address below and include a copy of the <a href="/controlpanel/school/invoice">invoice</a>.</b></p>

<p>
<?php
echo generalInfoReader('mailingAddress');
?>
</p>

<p>
We can also process wire transfers for payment. <!--For wire transfers, it is very important that, in addition to the bank information, you enter into the Payment Detail (or similar) section <b>both</b> the number "2720783" <b>and</b> the name of your school. The former will enable MIT to receive and direct the funds to our organization and the latter will allow us to easily determine which schools have sent in their fees.-->  Please email <?php echo obfuscateEmail('cfo-mitmunc@mit.edu'); ?> for more information if you plan to pay via wire transfer.<br />
</p>

<p>
Note: in order to expedite processing of your check, please email <?php echo obfuscateEmail('cfo-mitmunc@mit.edu'); ?> to let us know that we are expecting a check.
</p>


<br />
<a href="/controlpanel/">Back to Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); 
?>
