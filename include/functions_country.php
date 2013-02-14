<?php
/**
 * This class embodies the country table in the mysql database
 **/
class country {
    const NO_FILTERS = 0;
    const ASSIGNED_ONLY = 1;
    const UNASSIGNED_ONLY = 2;
    const IN_MATRIX = 3;
    const NOT_IN_MATRIX = 4;

    /** Constructor **/
    function __construct($countryId){
        $result = mysql_query("SELECT * FROM countries WHERE id='$countryId'") or die(mysql_error());
        $row = mysql_fetch_array($result);
        $this->countryId = $countryId;
        $this->countryName = $row['country'];
        $this->showInMatrix = $row['showInMatrix'];
    }
    
    /** Save the country information **/
    function saveInfo(){
        $countryName = mysql_real_escape_string($this->countryName);
        mysql_query("UPDATE countries SET country='$countryName' WHERE id='$this->countryId'") or die(mysql_error());
        mysql_query("UPDATE countries SET showInMatrix='$this->showInMatrix' WHERE id='$this->countryId'") or die(mysql_error());
    }
    
    /**
     * Delete the country from the database
     **/
    function deleteCountry(){
        mysql_query("DELETE FROM countries WHERE id='$this->countryId'") or die(mysql_error());
    }
    
    /**
     * Check whether the current country has already been assigned to a school
     **/
    function getCountryAssigned(){
        $result = mysql_query("SELECT id, countryConfirm FROM school WHERE 
            country1='$this->countryId' OR country2='$this->countryId' OR
            country3='$this->countryId' OR country4='$this->countryId' OR
            country5='$this->countryId' OR country6='$this->countryId' OR
            country7='$this->countryId' OR country8='$this->countryId' OR
            country9='$this->countryId' OR country10='$this->countryId'");
        $assignedSchoolIds = array();
        while($row = mysql_fetch_array($result)){
            if($row['countryConfirm'] == '1') array_push($assignedSchoolIds, $row['id']);
        }
        return $assignedSchoolIds;
    }
    
    /**
     * Get an array of all the countries
     **/
     public static function getAllCountries($filter = country::NO_FILTERS){
        $countries = array();
        if($filter == country::IN_MATRIX || $filter == country::NOT_IN_MATRIX){
            $showInMatrix = ($filter == country::IN_MATRIX) ? ('1') : ('0');
            $result = mysql_query("SELECT id, country FROM countries WHERE showInMatrix='$showInMatrix' ORDER BY country") or die(mysql_error());
        }else{
            $result = mysql_query("SELECT id, country FROM countries ORDER BY country") or die(mysql_error());
        }
        while($row = mysql_fetch_array($result)){
            if($filter == country::ASSIGNED_ONLY || $filter==country::UNASSIGNED_ONLY) {
              $assigned = ($filter == country::ASSIGNED_ONLY) ? (TRUE) : (FALSE);
              $country = new country($row['id']);
              if (($country->getCountryAssigned()>0) != $assigned) {
                continue;
              }
            }
            $countries[$row['id']] = $row['country'];
        }
        return $countries;
    }
    /**
     * Generate an html select list from all the countries.  Useful for frontend
     **/
    public static function getCountryOptions($optionsArray = array(), $defaultCountryId = 0, $countries = null ){
        $returnString = '<select';
        foreach($optionsArray as $key => $value){
            $returnString .= ' '.$key.'="'.$value.'"';
        }
        $returnString .= '>';
        if ($countries == null) {
          $countries = self::getAllCountries();
        }
        foreach($countries as $countryId => $countryName){
            if($countryId != $defaultCountryId){
                $returnString .= '<option value="'.$countryId.'">'.$countryName.'</option>';
            }else{
                $returnString .= '<option value="'.$countryId.'" selected>'.$countryName.'</option>';
            }
        }
        $returnString .= '</select>';
        return $returnString;
    }
    
    /**
     * This function loads the country names based off of the country list
     */
    public static function getCountryName($countryId){
        if(substr($countryId,0,7)=='special'){
            $specialCommittee = new specialCommitteePosition(substr($countryId, 7));
            return $specialCommittee->positionName;
        }else{
            $result = mysql_query("SELECT country FROM countries WHERE id='$countryId'") or die(mysql_error());
            $row = mysql_fetch_array($result);
            return $row['country'];
        }
    }
    
    /**
     * This function creates a new country
     **/
    public static function newCountry($countryName, $showInMatrix){
        $result = mysql_query("SELECT id FROM countries WHERE country='$countryName'") or die(mysql_error());
        $row = mysql_fetch_array($result);
        if($row['id'] != 0) return $row['id'];
        mysql_query("INSERT INTO countries (country, showInMatrix) 
            VALUES('$countryName', '$showInMatrix')") or die(mysql_error());
        return mysql_insert_id();
    }
}




