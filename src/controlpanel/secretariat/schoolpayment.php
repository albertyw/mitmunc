<?php
$title = "MITMUNC - Control Panel - School Payments";
require("/var/www/mitmunc/template/header.php"); ?>
<script type="text/javascript">
$(function(){
    $("#started").datepicker({ dateFormat: 'yy-mm-dd'});
    $("#completed").datepicker({ dateFormat: 'yy-mm-dd'});
});
function saveEdits(){
    $("#paymentSaved").hide();
    var finaid = ($("#finAid").is(':checked')) ? "1" : "0";
    $.post(
        "/include/ajax/schoolpayment",
        {
            paymentDelete:false,
            paymentId:$("#paymentId").val(),
            schoolId:$("#schoolId").val(),
            amount:$("#amount").val(),
            started:$("#started").val(),
            completed:$("#completed").val(),
            finaid:finaid
        },
        function(data){
            if(data == 'paymentSaved'){
                $("#paymentSaved").show('slow');
            }else{
                alert("Error: "+data);
            }
        }
    );
}
function deletePayment(){
    $.post(
        "/include/ajax/schoolpayment",
        {
            paymentDelete:true,
            paymentId:$("#paymentId").val()
        },
        function(data){
            if(data == 'paymentDeleted'){
                window.location = '/controlpanel/secretariat/schoolpaymentlist';
            }else{
                alert("Error: "+data);
            }
        }
    );
}
</script>

<h1>School Payment Information</h1>
<p>Below is a list of financial transactions from schools.  Postmark date is the 
date that the system will use to calculate when a payment is made for different 
registrations.  Charged date should be the date that the payment is deposited/received.  </p>
<br />
<?php
//Check user's credentials

$SESSION->securityCheck(true, array('secretariat'));

$_GET = sanitizeArray($_GET);
if(array_key_exists('paymentId',$_GET)){
    $paymentId = $_GET['paymentId'];
    if($paymentId == 'NEW'){
        $payment = payment::newPayment();
        echo 'New Payment created, please edit information<br />';
    }else{
        $payment = new payment($paymentId);
    }
}else{
    echo '<a href="/controlpanel/">Back to Control Panel</a>';
    require("/var/www/mitmunc/template/footer.php");
}
echo '<input type="hidden" id="paymentId" value="'.$payment->paymentId.'" />';
echo '<div id="paymentSaved" style="display:none">Saved</div>';
echo '<table>';
echo '<tr><th>Payment ID</th><td>'.$payment->paymentId.'</td></tr>';
echo '<tr><th>School Name</th><td>'.school::getSchoolOptions(array("id"=>"schoolId"), $payment->schoolId).'</td></tr>';
echo '<tr><th>Amount ($)</th><td><input type="text" id="amount" value="'.$payment->amount.'"></td></tr>';
echo '<tr><th>Postmark Date</th><td><input type="text" id="started" value="'.$payment->started.'"></td></tr>';
echo '<tr><th>Charged Date</th><td><input type="text" id="completed" value="'.$payment->completed.'"></td></tr>';
echo '<tr><th>Financial Aid</th><td><input type="checkbox" id="finAid" ';
if($payment->finaid) echo 'checked';
echo '></td></tr>';
echo '</table>';
?>
<br />
<input type="submit" onclick="javascript:saveEdits()" value="Save" /> - 
<input type="submit" onclick="javascript:deletePayment()" value="Delete" /> - 
<input type="submit" onclick="javascript:window.location='/controlpanel/secretariat/schoolpaymentlist'" value="Back" />
<br />
<br />
<a href="/controlpanel/">Back to Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
