<?php
// See also specialCommitteePosition class below
/**
 * This class embodies the committee table in the mysql database
 **/
class committee {
    const NUM_TOPICS = 3;
    /** Constructor **/
    function __construct($committeeId){
        $result = mysql_query("SELECT * FROM committees WHERE id='$committeeId'") or die(mysql_error());
        $row = mysql_fetch_array($result);
        $this->committeeId = $committeeId;
        $this->committeeName = $row['name'];
        $this->shortName = $row['shortName'];
        $this->announcement = $row['announcement'];
        $this->email = $row['email'];
        $this->topic = array();
        $this->topicDescription = array();
        $this->topicBg = array();
        for($i=1; $i<=committee::NUM_TOPICS; $i++){
            $this->topic[$i] = $row['topic'.$i];
            $this->topicDescription[$i] = $row['topic'.$i.'Description'];
            $this->topicBg[$i] = $row['topic'.$i.'Bg'];
        }
        $this->getChairs();
        $this->getSpecialPositions();
    }
    
    /**
     * Get and save a list of chair ids
     * Note that some of the chairs may also be secretariat
     **/
    function getChairs(){
        $this->chairs = array();
        $result = mysql_query("SELECT id FROM users WHERE committeeId='$this->committeeId'") or die(mysql_error());
        while($row = mysql_fetch_array($result)){
            array_push($this->chairs, $row['id']);
        }
    }
    
    /**
     * Get and save a list of special positions
     **/
    function getSpecialPositions(){
        $this->specialPositions = array();
        $result = mysql_query("SELECT id 
            FROM special_committee_positions 
            WHERE committeeId='$this->committeeId'") or die(mysql_error());
        while($row = mysql_fetch_array($result)){
            array_push($this->specialPositions, $row['id']);
        }
    }
    
    /**
     * Save the information in the table to the database
     **/
    function saveInfo(){
        $result = mysql_query("UPDATE committees SET name='$this->committeeName' WHERE id='$this->committeeId'") or die(mysql_error());
        $result = mysql_query("UPDATE committees SET shortName='$this->shortName' WHERE id='$this->committeeId'") or die(mysql_error());
        $result = mysql_query("UPDATE committees SET announcement='$this->announcement' WHERE id='$this->committeeId'") or die(mysql_error());
        $result = mysql_query("UPDATE committees SET email='$this->email' WHERE id='$this->committeeId'") or die(mysql_error());
        for($i=1; $i<=committee::NUM_TOPICS; $i++){
            $result = mysql_query("UPDATE committees SET topic".$i."='".$this->topic[$i]."' WHERE id='$this->committeeId'") or die(mysql_error());
            $result = mysql_query("UPDATE committees SET topic".$i."Description='".$this->topicDescription[$i]."' WHERE id='$this->committeeId'") or die(mysql_error());
            $result = mysql_query("UPDATE committees SET topic".$i."Bg='".$this->topicBg[$i]."' WHERE id='$this->committeeId'") or die(mysql_error());
        }
    }
    
    function deleteCommittee(){
        $result = mysql_query("DELETE FROM committees WHERE id='$this->committeeId'") or die(mysql_error());
    }
    
    public static function newCommittee(){
        $result = mysql_query("SELECT id FROM committees WHERE name=''") or die(mysql_error());
        $row = mysql_fetch_array($result);
        if($row['id']!=0) return $row['id'];
        mysql_query("INSERT INTO committees () VALUES()") or die(mysql_error());
        return mysql_insert_id();
    }
    
    
    /**
     * This function loads the committee names based off of the committee list
     */
    public static function getCommitteeName($committeeId){
        $committee = new committee($committeeId);
        return $committee->committeeName;
    }
    
    /**
     * this function gets the committee abbreviation from a committee ID
     **/
    public static function getCommitteeShortName($committeeId){
        $committee = new committee($committeeId);
        return $committee->shortName;
    }
    
    /**
     * Get an array of all the committees and their names
     **/
    public static function getAllCommitteeNames(){
        $committees = array();
        $result = mysql_query("SELECT id, name FROM committees ORDER BY name") or die(mysql_error());
        while($row = mysql_fetch_array($result)){
            $committees[$row['id']] = $row['name'];
        }
        return $committees;
    }
    
    /**
     * Get an array of all the committees and their shortNames
     **/
    public static function getAllCommitteeShortNames(){
        $committees = array();
        $result = mysql_query("SELECT id, shortName FROM committees ORDER by shortName") or die(mysql_error());
        while($row = mysql_fetch_array($result)){
            $committees[$row['id']] = $row['shortName'];
        }
        return $committees;
    }
    
    
    /**
     * Generate an html select list from all the committees.  Useful for frontend
     **/
     public static function getCommitteeOptions($optionsArray = array(), $defaultCommitteeId = 0, 
         $values = 'getAllCommitteeShortNames'){
        $returnString = '<select';
        foreach($optionsArray as $key => $value){
            $returnString .= ' '.$key.'="'.$value.'"';
        }
        $returnString .= '>';
        if($values == 'getAllCommitteeShortNames'){
            $values = self::getAllCommitteeShortNames();
        }
        foreach($values as $committeeId=>$committeeShortName){
            if($committeeId != $defaultCommitteeId){
                $returnString .= '<option value="'.$committeeId.'">'.$committeeShortName.'</option>';
            }else{
                $returnString .= '<option value="'.$committeeId.'" selected>'.$committeeShortName.'</option>';
            }
        }
        $returnString .= '</select>';
        return $returnString;
    }
}

/**
 * This class represents the specialcommitteeposition table
 **/
class specialCommitteePosition {
    function __construct($positionId){
        // Read Positions
        $result = mysql_query("SELECT id, positionName, committeeId
            FROM special_committee_positions 
            WHERE id='$positionId'") or die(mysql_error());
        $row = mysql_fetch_array($result);
        $this->positionId = $positionId;
        $this->positionName = $row['positionName'];
        $this->committeeId = $row['committeeId'];
        
        // Read Applications
        $this->schoolApplications = array();
        $this->assignedSchoolId = 0;
        $result = mysql_query("SELECT id, schoolId FROM special_committee_applications WHERE positionId='$positionId'") or die(mysql_error());
        while($row = mysql_fetch_array($result)){
            $this->schoolApplications[$row['id']] = $row['schoolId'];
            if(school::getCountryConfirm($row['schoolId'])=='1'){
                $this->assignedSchoolId = $row['schoolId'];
            }
        }
    }
    
    /**
     * Save the information for the position
     **/
    function saveInfo(){
        mysql_query("UPDATE special_committee_positions SET positionName='$this->positionName' WHERE id='$this->positionId'") or die(mysql_error());
        mysql_query("UPDATE special_committee_positions SET committeeId='$this->committeeId' WHERE id='$this->positionId'") or die(mysql_error());
    }
    
    /**
     * Delete the position
     **/
    function deletePosition(){
        mysql_query("DELETE FROM special_committee_positions WHERE id='$this->positionId'") or die(mysql_error());
    }
    
    /**
     * Generate a new special committee position
     **/
    public static function newPosition(){
        $result = mysql_query("INSERT INTO special_committee_positions () VALUES()") or die(mysql_error());
        $position = new specialCommitteePosition(mysql_insert_id());
        return $position;
    }
    
    /**
     * Get all the special committee applications for a school
     **/
    public static function getAllSchoolApplications($schoolId){
        $positions = array();
        $result = mysql_query("SELECT id, positionId FROM special_committee_applications WHERE schoolId='$schoolId'") or die(mysql_error());
        while($row = mysql_fetch_array($result)){
            $positions[$row['id']] = $row['positionId'];
        }
        return $positions;
    }
    
    /**
     * Generate a new special committee application
     **/
    public static function newApplication($schoolId, $positionId){
        $result = mysql_query("INSERT INTO special_committee_applications
            (schoolId, positionId)
            VALUES('$schoolId', '$positionId')") or die(mysql_error());
        return mysql_insert_id();
    }
    
    /**
     * Delete application
     **/
    public static function deleteApplication($applicationId){
        $result = mysql_query("DELETE FROM special_committee_applications WHERE id='$applicationId'") or die(mysql_error());
    }
}





