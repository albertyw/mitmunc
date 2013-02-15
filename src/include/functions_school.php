<?php
/**
 * This class embodies the school mysql table
 **/
class school {
    const NUM_COUNTRY_PREFS = 11;
    /**
     * Read information from the school tables
     */
    function __construct($schoolId){
        $query = "SELECT * FROM school WHERE id='$schoolId'";
        $result = mysql_query($query) or die(mysql_error());
        $row = mysql_fetch_array($result);
        $this->schoolId = $schoolId;
        $this->schoolName = $row['schoolName'];
        $this->numStudents = $row['numStudents'];
        $this->numAdvisers = $row['numAdvisers'];
        $this->totalAttendees = $this->numStudents + $this->numAdvisers;
        $this->regTime = $row['regTime'];
        $this->address = array();
        $this->address['1'] = $row['address1'];
        $this->address['2'] = $row['address2'];
        $this->address['city'] = $row['city'];
        $this->address['state'] = $row['state'];
        $this->address['zip'] = $row['zip'];
        $this->address['countryId'] = $row['country'];
        $this->address['country'] = country::getCountryName($this->address['countryId']);
        $this->hearAboutUs = $row['hearAboutUs'];
        $this->finAid = $row['finaid'];
        $this->stayInHotel = $row['stayInHotel'];
        $this->countryId = array();
        $this->countryName = array();
        for($i = 1; $i<=school::NUM_COUNTRY_PREFS; $i++){
            $this->countryId[$i] = $row['country'.$i];
            $this->countryName[$i] = country::getCountryName($this->countryId[$i]);
        }
        $this->numSpecialPositions = $row['numSpecialPositions'];
        $this->countryConfirm = $row['countryConfirm'];
        $this->finaidQuestion = array();
        for($i = 1; $i<=5; $i++){
            $this->finaidQuestion[$i] = $row['finaidQuestion'.$i];
        }
        $this->userIds = user::getSchoolUsers($this->schoolId);
        $this->getPayments();
        $this->getAttendees();
        $this->getStatus();
    }
    
    /**
     * this function gets a little opaque, because of the tiered cost 
     * system and because schools sometimes don't pay school and delegate 
     * fees separately
     */
    function getPayments(){
        $earlyPayment = 0;
        $regularPayment = 0;
        $latePayment = 0;
        
        // Separate fee payments into early, regular, late deadlines
        $this->totalFinAid = 0;
        $payments = payment::getSchoolPayments($this->schoolId);
        for($i = 0; $i < sizeof($payments); $i++){
            $payment = new payment($payments[$i]);
            if($payment->finaid == '1') $this->totalFinAid += $payment->amount;
            if($payment->startedTimeStamp<=generalInfoReader('earlyRegDeadline')){
                $earlyPayment += intval($payment->amount);
            }elseif($payment->startedTimeStamp>generalInfoReader('earlyRegDeadline') && $payment->startedTimeStamp<=generalInfoReader('regularRegDeadline')){
                $regularPayment += intval($payment->amount);
            }elseif($payment->startedTimeStamp>generalInfoReader('regularRegDeadline')){
                $latePayment += intval($payment->amount);
            }
        }
        // Check when school fee was paid
        if($earlyPayment>=generalInfoReader('earlySchoolFee') || $this->numStudents <= 5){
            $this->delegateFee = generalInfoReader('earlyDelegateFee');
            if ($this->numStudents <=30) {
     	        $this->schoolFee = generalInfoReader('earlySchoolFee');
	    } else {
	        $this->schoolFee = generalInfoReader('earlyLargeSchoolFee');
	    }
        }elseif($earlyPayment+$regularPayment>=generalInfoReader('regularSchoolFee')){
            $this->delegateFee = generalInfoReader('regularDelegateFee');
            if ($this->numStudents <= 30) {   
	        $this->schoolFee = generalInfoReader('regularSchoolFee');
            } else {
	      	$this->schoolFee = generalInfoReader('regularLargeSchoolFee');
	    }

	}elseif($earlyPayment+$regularPayment+$latePayment>=generalInfoReader('lateSchoolFee')){
            $this->delegateFee = generalInfoReader('lateDelegateFee');
            if ($this->numStudents <= 30) {
	       $this->schoolFee = generalInfoReader('lateSchoolFee');
	    } else {
	    	    $this->schoolFee = generalInfoReader('lateLargeSchoolFee');
	    } 
       }else{  // School fee was not paid
            $curTime = time();
            if($curTime<=generalInfoReader('earlyRegDeadline')){
                $this->delegateFee = generalInfoReader('earlyDelegateFee');
                if ($this->numStudents <=30) {
       	          $this->schoolFee = generalInfoReader('earlySchoolFee');
         	} else {
	          $this->schoolFee = generalInfoReader('earlyLargeSchoolFee');
	        }
            }elseif($curTime>generalInfoReader('earlyRegDeadline') && $curTime<=generalInfoReader('regularRegDeadline')){
	        $this->delegateFee = generalInfoReader('regularDelegateFee');
                if ($this->numStudents <= 30) {   
	            $this->schoolFee = generalInfoReader('regularSchoolFee');
                } else {
	       	    $this->schoolFee = generalInfoReader('regularLargeSchoolFee');
	        }
            }elseif($curTime>generalInfoReader('regularRegDeadline')){
                $this->delegateFee = generalInfoReader('lateDelegateFee');
                if ($this->numStudents <= 30) {
	           $this->schoolFee = generalInfoReader('lateSchoolFee');
	        } else {
	    	   $this->schoolFee = generalInfoReader('lateLargeSchoolFee');
	        } 
            }
        }
	
        // Small delegations don't pay school fees
        if($this->numStudents <=5 && $this->numAdvisers){
            $this->schoolFee = 0;
        }
	
	//Chosun doesn't pay
	if($this->schoolName == "Chosuneducation" || $this->schoolName == "Worldview Education"){
	    $this->schoolFee = 0;
	    $this->delegateFee = 0;
	}

        // Calculating numbers
        $this->totalPaid = $earlyPayment + $regularPayment + $latePayment - $this->totalFinAid;
        $this->delegateFeeTotal = $this->numStudents*$this->delegateFee;
        $mealTicket = new mealTicket($this->schoolId);
        $this->mealTicketTotal = $mealTicket->totalCost;
        
        $this->schoolFeePaid = 0;
        $this->schoolFeeOwed = 0;
        $this->delegateFeePaid = 0;
        $this->delegateFeeOwed = 0;
        $this->mealTicketPaid = 0;
        $this->mealTicketOwed = 0;
        if($this->totalPaid < $this->schoolFee){
            // Haven't paid school fee
            $this->schoolFeePaid = $this->totalPaid;
            $this->schoolFeeOwed = $this->schoolFee - $this->totalPaid;
            $this->delegateFeeOwed = $this->delegateFeeTotal;
            $this->mealTicketOwed = $this->mealTicketTotal;
        }elseif($this->totalPaid + $this->totalFinAid < $this->schoolFee + $this->delegateFeeTotal){
            // Have paid school fee but not delegate fee
            $this->schoolFeePaid = $this->schoolFee;
            $this->delegateFeePaid = $this->totalPaid + $this->totalFinAid - $this->schoolFee;
            $this->delegateFeeOwed = $this->delegateFeeTotal - $this->delegateFeePaid;
            $this->mealTicketOwed = $this->mealTicketTotal;
        }else{
            // Have paid school and delegate fee
            $this->schoolFeePaid = $this->schoolFee;
            $this->delegateFeePaid = $this->delegateFeeTotal;
            $this->mealTicketPaid = min($this->mealTicketTotal, $this->totalPaid + $this->totalFinAid - $this->schoolFee - $this->delegateFeeTotal);
            $this->mealTicketOwed = $this->mealTicketTotal - $this->mealTicketPaid;
        }
        $this->totalFee = $this->schoolFee + $this->delegateFeeTotal + $this->mealTicketTotal;
        $this->totalOwed = $this->totalFee - $this->totalFinAid - $this->totalPaid;
        
	//Create formatted versions:
	$this->totalFeeFormatted = '$'.money_format('%.2n',$this->totalFee);
	$this->totalPaidFormatted = '$'.money_format('%.2n',$this->totalPaid);
	$this->totalOwedFormatted = '$'.money_format('%.2n',$this->totalOwed);


	$this->schoolFeeFormatted = '$'.money_format('%.2n',$this->schoolFee);
	$this->schoolFeePaidFormatted = '$'.money_format('%.2n',$this->schoolFeePaid);
	$this->schoolFeeOwedFormatted = '$'.money_format('%.2n',$this->schoolFeeOwed);
	
	$this->delegateFeeFormatted = '$'.money_format('%.2n',$this->delegateFee);
	$this->delegateFeeTotalFormatted = '$'.money_format('%.2n',$this->delegateFeeTotal);
	$this->delegateFeePaidFormatted = '$'.money_format('%.2n',$this->delegateFeePaid);
	$this->delegateFeeOwedFormatted = '$'.money_format('%.2n',$this->delegateFeeOwed);

	$this->totalFinAidFormatted = '$'.money_format('%.2n',$this->totalFinAid);


        // Calculate Payment Due Date
        if($this->delegateFee == generalInfoReader('earlyDelegateFee'))
            $this->schoolFeeDue = generalInfoReader('earlyRegDeadline');
        if($this->delegateFee == generalInfoReader('regularDelegateFee'))
            $this->schoolFeeDue = generalInfoReader('regularRegDeadline');
        if($this->delegateFee == generalInfoReader('lateDelegateFee'))
            $this->schoolFeeDue = generalInfoReader('lateRegDeadline');
        $this->totalPaymentDue = generalInfoReader('paymentDueDate');
	
    }
    
    /**
     * This function loads the mitmunc user that is in charge of the 
     * school's information
     */
    function getUsers(){
        $this->users = array();
        foreach($this->userIds as $userId){
            array_push($this->users, new user($userId));
        }
    }
    
    /**
     * This function loads the school's adviser and delegate list
     */
    function getAttendees(){
        $this->attendees = array();
        $i = 0;
        $schoolTable = 'school_'.$this->schoolId;
        $query = "SELECT id, name AS attendeeName, logintype, email, phone, hotel, room, 
            committee AS committeeId, country AS countryId 
            FROM $schoolTable";
        $result = mysql_query($query) or die(mysql_error());
        while($row = mysql_fetch_array($result)){
            $this->attendees[$i] = array();
            $this->attendees[$i]['id'] = $row['id'];
            $this->attendees[$i]['name'] = $row['attendeeName'];
            $this->attendees[$i]['logintype'] = $row['logintype'];
            $this->attendees[$i]['committeeId'] = $row['committeeId'];
            $this->attendees[$i]['countryId'] = $row['countryId'];
            $this->attendees[$i]['email'] = $row['email'];
            $this->attendees[$i]['phone'] = $row['phone'];
            $this->attendees[$i]['hotel'] = $row['hotel'];
            $this->attendees[$i]['room'] = $row['room'];
            $i++;
        }
        // Populate empty rows if attendees table isn't filled
        for($i; $i<$this->totalAttendees; $i++){
            $this->attendees[$i] = array();
            $this->attendees[$i]['id'] = 0;
            $this->attendees[$i]['name'] = 0;
            $this->attendees[$i]['logintype'] = 0;
            $this->attendees[$i]['committeeId'] = 0;
            $this->attendees[$i]['countryId'] = 0;
            $this->attendees[$i]['email'] = 0;
            $this->attendees[$i]['phone'] = 0;
            $this->attendees[$i]['hotel'] = 0;
            $this->attendees[$i]['room'] = 0;
        }
    }
    
    /**
     * Generates a human-readable status message about the current school
     **/
    function getStatus(){
        $this->status = 'Unknown';
        if($this->finAid == 1 && $this->totalOwed != 0){
            if($this->finaidQuestion[1] == ''){
                $this->status = 'Waiting for finaid application';
                return;
            }else{
                $this->status = 'Waiting for finaid decision';
                return;
            }
        }
        if($this->schoolFeeOwed != 0){
            $this->status = 'Waiting for school fee payment';
            return;
        }
        if($this->countryId[1] == 0){
            $this->status = 'Waiting for country preferences';
            return;
        }
        if($this->countryId[1] != 0 && $this->countryConfirm != 1){
            $this->status = 'Waiting for country assignments';
            return;
        }
        if($this->delegateFeeOwed != 0){
            $this->status = 'Waiting for delegate fee payment';
            return;
        }
        if(sizeof($this->attendees) == 0){
            $this->status = 'Waiting for attendee info';
            return;
        }
        if($this->totalOwed < 0){
            $this->status = 'Need Refund';
            return;
        }
        if(sizeof($this->attendees) == $this->totalAttendees && $this->totalOwed == 0){
            $this->status = 'Ready';
            return;
        }
    }
    
    /**
     * Save the information in this object to the database
     * Because of the complexity of the financial table, this function does not
     * save changes to that table.  Manual SQL queries are required
     **/
    function saveInfo(){
        // Save values to school table
        $schoolName = mysql_real_escape_string($this->schoolName);
        mysql_query("UPDATE school SET schoolName='$schoolName' WHERE id='$this->schoolId'") or die(mysql_error());
        mysql_query("UPDATE school SET numStudents='$this->numStudents' WHERE id='$this->schoolId'") or die(mysql_error());
        mysql_query("UPDATE school SET numAdvisers='$this->numAdvisers' WHERE id='$this->schoolId'") or die(mysql_error());
        mysql_query("UPDATE school SET regTime='$this->regTime' WHERE id='$this->schoolId'") or die(mysql_error());
        $address1 = mysql_real_escape_string($this->address['1']);
        mysql_query("UPDATE school SET address1='$address1' WHERE id='$this->schoolId'") or die(mysql_error());
        $address2 = mysql_real_escape_string($this->address['2']);
        mysql_query("UPDATE school SET address2='$address2' WHERE id='$this->schoolId'") or die(mysql_error());
        $city = mysql_real_escape_string($this->address['city']);
        mysql_query("UPDATE school SET city='$city' WHERE id='$this->schoolId'") or die(mysql_error());
        $state = mysql_real_escape_string($this->address['state']);
        mysql_query("UPDATE school SET state='$state' WHERE id='$this->schoolId'") or die(mysql_error());
        $zip = mysql_real_escape_string($this->address['zip']);
        mysql_query("UPDATE school SET zip='$zip' WHERE id='$this->schoolId'") or die(mysql_error());
        mysql_query("UPDATE school SET country='".$this->address['countryId']."' WHERE id='$this->schoolId'") or die(mysql_error());
        mysql_query("UPDATE school SET hearAboutUs='$this->hearAboutUs' WHERE id='$this->schoolId'") or die(mysql_error());
        mysql_query("UPDATE school SET finaid='$this->finAid' WHERE id='$this->schoolId'") or die(mysql_error());
        mysql_query("UPDATE school SET stayInHotel='$this->stayInHotel' WHERE id='$this->schoolId'") or die(mysql_error());
        mysql_query("UPDATE school SET countryConfirm='$this->countryConfirm' WHERE id='$this->schoolId'") or die(mysql_error());
        mysql_query("UPDATE school SET numSpecialPositions='$this->numSpecialPositions' WHERE id='$this->schoolId'") or die(mysql_error());
        for($i = 1; $i<=10; $i++){
            mysql_query("UPDATE school SET country$i='".$this->countryId[$i]."' WHERE id='$this->schoolId'") or die(mysql_error());
        }
        for($i = 1; $i<=5; $i++){
            $finaidQuestion = mysql_real_escape_string($this->finaidQuestion[$i]);
            mysql_query("UPDATE school SET finaidQuestion$i='".$finaidQuestion."' WHERE id='$this->schoolId'") or die(mysql_error());
        }
        
        // Save values to attendees table
        mysql_query("TRUNCATE TABLE school_$this->schoolId") or die(mysql_error());
        for($i = 0; $i < sizeof($this->attendees); $i++){
            $name = $this->attendees[$i]['name'];
            $email = $this->attendees[$i]['email'];
            $phone = $this->attendees[$i]['phone'];
            $room = $this->attendees[$i]['room'];
            mysql_query("INSERT INTO school_$this->schoolId
                (id, name, logintype, committee, country, email, phone, hotel, room) 
                VALUES('".$this->attendees[$i]['id']."', '".$name."', '".$this->attendees[$i]['logintype']."', 
                '".$this->attendees[$i]['committeeId']."', '".$this->attendees[$i]['countryId']."', '".$email."', 
                '".$phone."', '".$this->attendees[$i]['hotel']."', '".$room."')") or die(mysql_error());
        }
    }
    
    function deleteSchool(){
       // Delete the entry in the school table
       mysql_query("DELETE FROM school WHERE id='$this->schoolId'") or die(mysql_error());
       
       // Delete the delegate positions table
       mysql_query("DROP TABLE school_$this->schoolId") or die(mysql_error());
    }
    
    /**
     * Get a list of all school IDs
     **/
    public static function getAllSchoolIds(){
        $schoolIds = array();
        $result = mysql_query("SELECT id FROM school") or die(mysql_error());
        while($row = mysql_fetch_array($result)){
            array_push($schoolIds, $row['id']);
        }
        return $schoolIds;
    }
    
    /**
     * Create a dropdown selection list for schools
     **/
    public static function getSchoolOptions($optionsArray = array(), $defaultSchoolId = 0, $allowEmpty = false){
        $returnString = '<select';
        foreach($optionsArray as $key => $value){
            $returnString .= ' '.$key.'="'.$value.'"';
        }
        $returnString .= '>';
        if($allowEmpty){
            $returnString .= '<option value="0">NONE</option>';
        }
        $result = mysql_query("SELECT id, schoolName FROM school");
        while($row = mysql_fetch_array($result)){
            $schoolId = $row['id'];
            $schoolName = $row['schoolName'];
            if($schoolId != $defaultSchoolId){
                $returnString .= '<option value="'.$schoolId.'">'.$schoolName.'</option>';
            }else{
                $returnString .= '<option value="'.$schoolId.'" selected>'.$schoolName.'</option>';
            }
        }
        $returnString .= '</select>';
        return $returnString;
    }
    
    
    /**
     * Get the school name given an id
     * This is the preferred way of getting a name, since instantiating a school is computationally expensive
     **/
    public static function getSchoolName($schoolId){
        $result = mysql_query("SELECT schoolName FROM school WHERE id='$schoolId'") or die(mysql_error());
        $row = mysql_fetch_array($result);
        return $row['schoolName'];
    }
    
    /**
     * Check whether the school has confirmed country assignments or not
     **/
    public static function getCountryConfirm($schoolId){
        $result = mysql_query("SELECT countryConfirm FROM school WHERE id='$schoolId'") or die(mysql_error());
        $row = mysql_fetch_array($result);
        return $row['countryConfirm'];
    }
    
    /**
     * Create a new school
     **/
    public static function newSchool(){
        $result = mysql_query("SELECT id FROM school WHERE schoolName=''") or die(mysql_error());
        $row = mysql_fetch_array($result);
        if($row['id'] != 0){
            $id = $row['id'];
        }else{
            $result = mysql_query("INSERT INTO school () VALUES()") or die(mysql_error());
            $id = mysql_insert_id();
        }
        mysql_query("CREATE TABLE IF NOT EXISTS school_$id (
                  id int(11) NOT NULL AUTO_INCREMENT,
                  name varchar(50) NOT NULL,
                  logintype varchar(11) NOT NULL,
                  committee int(11) NOT NULL,
                  country varchar(50) NOT NULL,
                  email varchar(50) NOT NULL,
                  phone varchar(50) NOT NULL,
                  hotel tinyint(1) NOT NULL,
                  room varchar(50) NOT NULL,
                  PRIMARY KEY (id)
                ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;") or die(mysql_error());
        mealTicket::newMealTicket($id);
        $school = new school($id);
        return $school;
    }
}


