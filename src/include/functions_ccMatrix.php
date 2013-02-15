<?php
/**
 * This class embodies the committee table in the mysql database
 **/
class ccMatrix {
    /**
     * Constructor
     * The ccMatrix saves its information to matrix[committeeId][countryId]
    **/
    function __construct(){
        $this->matrix = array();
        $this->committees = array();
        $this->countries = array();
        // Add committees to matrix
        $result = mysql_query("SHOW COLUMNS FROM ccmatrix") or die(mysql_error());
        while($row = mysql_fetch_assoc($result)){
            if($row['Field'] != 'countryId'){
                $this->matrix[$row['Field']] = array();
                array_push($this->committees, $row['Field']);
            }
        }
        // Add countries to matrix
        $result = mysql_query("SELECT * FROM ccmatrix") or die(mysql_error());
        while($row = mysql_fetch_assoc($result)){
            foreach(array_keys($this->matrix) as $committeeId){
                $this->matrix[$committeeId][$row['countryId']] = $row[$committeeId];
            }
            array_push($this->countries, $row['countryId']);
        }

    }



     /**
      * Removes committees that don't have countries
      * This only affects $this->committees and $this->countries
      **/
     function removeEmpty(){
         // Remove committees with no countries
         foreach($this->committees as $id =>$committeeId){
             if(array_sum($this->matrix[$committeeId])==0){
                 unset($this->committees[$id]);
             }
         }
         // Remove countries with no committees
         foreach($this->countries as $countryId){
             $hasCommittee = false;
             foreach($this->committees as $committeeId){
                 if($this->matrix[$committeeId][$countryId] == 1){
                     $hasCommittee = true;
                 }
             }
             if(!$hasCommittee){
                 unset($this->countries[$countryId]);
             }
         }
     }
    
    /**
     * Add a new committee, defaults to having no selected countries
     **/
    function addCommittee($committeeId){
        // Check to make sure column doesn't already exist
        $result = mysql_query("SHOW COLUMNS FROM ccmatrix") or die(mysql_error());
        while($row = mysql_fetch_array($result)){
            if($committeeId == $row['Field']) return;
        }
        
        mysql_query("ALTER TABLE `ccmatrix` ADD `$committeeId` BOOLEAN NOT NULL") or die(mysql_error());
    }
    
    /**
     * Remove a committee from the matrix
     **/
    function removeCommittee($committeeId){
        // Check to make sure column does already exist
        $result = mysql_query("SHOW COLUMNS FROM ccmatrix") or die(mysql_error());
        while($row = mysql_fetch_array($result)){
            if($committeeId == $row['Field'])
                $result = mysql_query("ALTER TABLE ccmatrix DROP $committeeId") or die(mysql_error());
        }
    }
    
    /**
     * Add a new country, defaults to having no selected committees
     **/
    function addCountry($countryId){
        // Check to make sure row doesn't already exist
        $result = mysql_query("SELECT * FROM ccmatrix WHERE countryId='$countryId'") or die(mysql_error());
        if(mysql_num_rows($result)==0)
            mysql_query("INSERT INTO ccmatrix (countryId) VALUES('$countryId')") or die(mysql_error());
    }
    
    /**
     * Remove a country from the matrix
     **/
    function removeCountry($countryId){
        // Check to make sure row already exists
        $result = mysql_query("SELECT * FROM ccmatrix WHERE countryId='$countryId'") or die(mysql_error());
        if(mysql_num_rows($result)!=0)
            mysql_query("DELETE FROM ccmatrix WHERE countryId='$countryId'") or die(mysql_error());
    }
    
    
    /**
     * Remakes the ccmatrix table based off of the country and committees objects
     * This object will try to keep old data, if it exists
     **/
     function reloadMatrix(){
         $countries = country::getAllCountries(country::IN_MATRIX);
         $committees = committee::getAllCommitteeShortNames();
         
         // Add new  committees
         $committees2 = array();
         foreach($committees as $committeeId => $committeeShortName){
             array_push($committees2, $committeeId);
             $this->addCommittee($committeeId);
         }
         
         // Delete unused committees and add countryId
         $result = mysql_query("SHOW COLUMNS FROM ccmatrix") or die(mysql_error());
         $countryIdExists = false;
         while($row = mysql_fetch_array($result)){
             if($row['Field'] == 'countryId'){
                 $countryIdExists = true;
                 continue;
             }
             if(!in_array($row['Field'], $committees2))
                 $this->removeCommittee($row['Field']);
         }
         if(!$countryIdExists){
             mysql_query("ALTER TABLE ccmatrix ADD countryId INT NOT NULL") or die(mysql_error());
             mysql_query("CREATE UNIQUE INDEX countryId ON ccmatrix") or die(mysql_error());
         }
         
         
         // Add new countries
         foreach($countries as $countryId => $countryName){
             $this->addCountry($countryId);
         }
         
         // Delete unused countries
         $result = mysql_query("SELECT countryId FROM ccmatrix") or die(mysql_error());
         while($row = mysql_fetch_array($result)){
             if(!array_key_exists($row['countryId'], $countries))
                 $this->removeCountry($row['countryId']);
         }
         $newCcMatrix = new ccMatrix();
         $this->matrix = $newCcMatrix->matrix;
     }
     
     /**
      * Saves the data in this object to the database
      **/
     function saveInfo(){
         mysql_query("TRUNCATE TABLE ccmatrix") or die(mysql_error());
         $committeeIds = array_keys($this->matrix);
         $dbKeys = implode('`, `', $committeeIds);
         $dbKeys = '`'.$dbKeys.'`';
         $dbKeys = '`countryId`, '.$dbKeys;
         $countryIds = array_keys($this->matrix[$committeeIds[0]]);
         foreach(array_keys($this->matrix[$committeeIds[0]]) as $countryId){
             $query = 'INSERT INTO `ccmatrix`('.$dbKeys.') VALUES(\''.$countryId.'\', ';
             foreach($committeeIds as $committeeId){
                 $query .= "'".$this->matrix[$committeeId][$countryId]."', ";
             }
             $query = substr($query, 0, -2).')';
             mysql_query($query) or die(mysql_error());
         }
         mysql_query("ALTER TABLE ccmatrix ORDER BY countryId");
     }
     
     /**
      * Return the total number of spots in a country
      **/
     function countrySpots($countryId){
         $totalSpots = 0;
         foreach($this->committees as $committeeId){
             if(!isset($this->matrix[$committeeId][$countryId])) return 0;
             $totalSpots += $this->matrix[$committeeId][$countryId];
         }
         return $totalSpots;
     }
}




