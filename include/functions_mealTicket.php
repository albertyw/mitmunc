<?php
/**
 * This class embodies the meal_ticket table in the mysql database
 **/
class mealTicket {
    const numMeals = 7;
    
    /** Constructor **/
    function __construct($schoolId){
        $result = mysql_query("SELECT *FROM meal_tickets WHERE schoolId='$schoolId'") or die(mysql_error());
        $row = mysql_fetch_array($result);
        $this->schoolId = $schoolId;
        $this->meal = array();
        $this->mealDescription = array();
        $this->mealCost = array();
        $this->totalCost = 0;
        for($i=1; $i<=mealTicket::numMeals; $i++){
            $meal = 'meal'.$i;
            $this->meal[$i] = $row[$meal];
            $this->mealDescription[$i] = generalInfoReader($meal);
            $this->mealCost[$i] = generalInfoReader($meal.'price');
            $this->totalCost += $this->mealCost[$i] * $this->meal[$i];
        }
        $this->mealNotes = $row['mealNotes'];
    }
    
    /**
     * Save the information in the table to the database
     * mealDescription is not saved because it is part of the generalInfo table
     **/
    function saveInfo(){
        for($i=1; $i<=mealTicket::numMeals; $i++){
            $result = mysql_query("UPDATE meal_tickets SET meal$i='".$this->meal[$i]."' WHERE schoolId='$this->schoolId'") or die(mysql_error());
        }
        $result = mysql_query("UPDATE meal_tickets SET mealNotes='$this->mealNotes' WHERE schoolId='$this->schoolId'") or die(mysql_error());
    }
    
    
    /**
     * Add a new row in the table for a new school
     **/
    public static function newMealTicket($schoolId){
        mysql_query("INSERT INTO meal_tickets (schoolId) VALUES('$schoolId')") or die(mysql_error());
    }
    
    /**
     * Get a list of IDs that are for meals that are not disabled
     **/
    public static function mealIDs(){
        $mealIds = array();
        for($i=1; $i<=mealTicket::numMeals; $i++){
            if(generalInfoReader('meal'.$i)!='disabled') array_push($mealIds, $i);
        }
        return $mealIds;
    }
    
    /**
     * Get the description of a meal given the ID
     **/
     public static function mealDescription($id){
         return generalInfoReader('meal'.$id);
     }
}




