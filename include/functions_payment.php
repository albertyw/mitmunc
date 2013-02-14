<?php
/**
 * This class embodies the school_payments table in the mysql table
 **/
class payment {
    
    /** Constructor **/
    function __construct($paymentId){
        $result = mysql_query("SELECT * FROM school_payments WHERE id='$paymentId'") or die(mysql_error());
        $row = mysql_fetch_array($result);
        $this->paymentId = $paymentId;
        $this->schoolId = $row['schoolId'];
        $this->schoolName = school::getSchoolName($this->schoolId);
        $this->amount = $row['amount'];
	$this->amountFormatted = money_format('%.2n',$this->amount);
        $this->started = $row['started'];
        $this->startedTimeStamp = strtotime($this->started);
        $this->completed = $row['completed'];
        $this->completedTimeStamp = strtotime($this->completed);
        $this->finaid = $row['finaid'];
    }
    
    /**
     * Save the information stored in this object to the database
     **/
    function saveInfo(){
        mysql_query("UPDATE school_payments SET schoolId='$this->schoolId' WHERE id='$this->paymentId'") or die(mysql_error());
        mysql_query("UPDATE school_payments SET amount='$this->amount' WHERE id='$this->paymentId'") or die(mysql_error());
        mysql_query("UPDATE school_payments SET started='$this->started' WHERE id='$this->paymentId'") or die(mysql_error());
        mysql_query("UPDATE school_payments SET completed='$this->completed' WHERE id='$this->paymentId'") or die(mysql_error());
        mysql_query("UPDATE school_payments SET finaid='$this->finaid' WHERE id='$this->paymentId'") or die(mysql_error());
    }
    
    /**
     * Delete the payment row for this object
     **/
    function deletePayment(){
        $result = mysql_query("DELETE FROM school_payments WHERE id='$this->paymentId'") or die(mysql_error());
        return true;
    }
    
    /**
     * Get all the payments for a particular school
     **/
    public static function getSchoolPayments($schoolId){
        $result = mysql_query("SELECT id FROM school_payments WHERE schoolId='$schoolId'") or die(mysql_error());
        $payments = array();
        while($row = mysql_fetch_array($result)){
            array_push($payments, $row['id']);
        }
        return $payments;
    }
    
    /**
     * Create a new payment row
     **/
    public static function newPayment(){
        $result = mysql_query("INSERT INTO school_payments () VALUES()") or die(mysql_error());
        $payment = new payment(mysql_insert_id());
        $payment->completed = date("Y-m-d H:i:s");
        $payment->saveInfo();
        return $payment;
    }
}
