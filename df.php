<?php
$title = "MITMUNC - Deadlines/Fees";
require("/var/www/mitmunc/template/header.php"); ?>
<h1>Deadlines &amp; Fees</h1>


<h2>Fees and Payment Deadlines</h2>
<p>
The registration cost is dependent on when you postmark your school fee payment.  
When you register, you should first send in the school fee payment in order to 
qualify for early or regular registration fees.  Delegate fees can be sent in 
later but before <?php echo date('F j, Y',generalInfoReader('paymentDueDate'))?>.  We accept payment via wire transfer or a check made out "MIT Model United Nations".  We are unable to accept credit card payments this year.
</p>
<ul>
<li>Early Registration School Fee Payment Deadline: <?php echo date('F j, Y',generalInfoReader('earlyRegDeadline'))?></br>
Fees: $<?php echo generalInfoReader('earlyDelegateFee')?> per delegate, 
$<?php echo generalInfoReader('earlySchoolFee')?> per school</li>

<li>Regular Registration School Fee Payment Deadline: <?php echo date('F j, Y',generalInfoReader('regularRegDeadline'))?></br>
Fees: $<?php echo generalInfoReader('regularDelegateFee')?> per delegate, 
$<?php echo generalInfoReader('regularSchoolFee')?> per school</li>

<li>Late Registration School Fee Payment Deadline: <?php echo date('F j, Y',generalInfoReader('lateRegDeadline'))?></br>
Fees: $<?php echo generalInfoReader('lateDelegateFee')?> per delegate, 
$<?php echo generalInfoReader('lateSchoolFee')?> per school</li>

<li>Financial Aid Application Deadline: <?php echo date('F j, Y', generalInfoReader('financialAidDeadline'))?></li>

<li>Deadline for Cancellation of Registration: <?php echo date('F j, Y', generalInfoReader('cancellationDeadline'))?></li>

<li>Deadline for Delegate Fee Payments: <?php echo date('F j, Y', generalInfoReader('paymentDueDate'))?></li>

<li> Deadline for Delegate Fee Refund Requests: <?php echo date('F j, Y', generalInfoReader('refundRequestDeadline'))?></li>
<li> Please make out all checks to "MIT Model UN", and mail them to: <br />
&nbsp;&nbsp;Michael Veldman<br />
&nbsp;&nbsp;Senior House, 70 Amherst St.<br />
&nbsp;&nbsp;Rm. 312-C<br />
&nbsp;&nbsp;Cambridge, MA 02142</li>
</ul>

<h2>Other Deadlines</h2>
<ul>
<li>Attendee Lists Due on Control Panel: January 15, 2013</li>
<li>Position Papers Due to the Delegate's Committee Chair: January 31, 2013</li>
</ul>
<!--<img src="/mitmunc2012/deadlines.png" />!-->


<p>Delegations with fewer or equal to five delegates and one adviser are exempt 
from school fees.  The registration cost for these small delegations is instead 
dependent on the time of registration, and not receipt of the school fee.  </p>

<p>The delegate fees are refundable if we receive a request before <?php echo date('F j, Y', generalInfoReader('refundRequestDeadline'))?>. The school fee is not refundable, unless you paid in attempts to move off the waitlist but were not given a spot in our conference. After <?php echo date('F j, Y', generalInfoReader('refundRequestDeadline'))?>, if circumstances beyond your control result in your delegation bringing fewer students to the conference than the number for which you paid, your school is eligible for a 50% refund on those students' delegate fees.</p>

<p>
In order for MITMUNC to be an amazing and diverse conference with ample opportunity 
for participation for all delegates, 
we have a policy that every group can bring at maximum 30 delegates to the conference.  
Delegations with five or fewer delegates are exempt from the school fee, and 
qualify for the delegate fee deadline based on registration time.  
</p>

<p>
Financial Assistance is available.  The deadline for financial aid applications is <?php echo date('F j, Y', generalInfoReader('financialAidDeadline'))?>.  
The financial aid application consists of five short questions that allow us to gauge 
how much financial aid will be given.  The application will be available to fill out in 
the control panel after registration.  
Please note that financial aid cannot cover transportation or hotel costs.  
</p>

Please contact <?php echo obfuscateEmail('info@mitmunc.org'); ?> with any questions or concerns about fees.

<?php require("/var/www/mitmunc/template/footer.php"); ?>
