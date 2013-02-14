<?php
// See also resolutionClause class below
/**
 * This class embodies the resolution table in the database
 **/
class resolution {
    /** Constructor **/
    function __construct($resolutionId){
        // Read the resolution information from the database
        $result = mysql_query("SELECT * FROM resolution_list WHERE id='$resolutionId'") or die(mysql_error());
        $row = mysql_fetch_array($result);
        $this->resolutionId = $resolutionId;
        $this->committeeId = $row['committeeId'];
        $this->topicId = $row['topicId'];
        $this->resolutionNum = $row['resolutionNum'];
        $this->sponsors = $row['sponsors'];
        $this->signatories = $row['signatories'];
	$this->date = $row['date'];
        
        // Load the resolution clauses
        $preambulatoryId = $row['preambulatoryId'];
        $operativeId = $row['operativeId'];
        $this->preambulatory = resolutionClause::traverseClauses($preambulatoryId);
        $this->operative = resolutionClause::traverseClauses($operativeId);
    }
    
    /**
     * Save the current resolution state to the database
     **/
    function saveInfo(){
        // Save resolution information
        mysql_query("UPDATE resolution_list SET committeeId='$this->committeeId' WHERE id='$this->resolutionId'") or die(mysql_error());
        mysql_query("UPDATE resolution_list SET topicId='$this->topicId' WHERE id='$this->resolutionId'") or die(mysql_error());
        mysql_query("UPDATE resolution_list SET resolutionNum='$this->resolutionNum' WHERE id='$this->resolutionId'") or die(mysql_error());
        mysql_query("UPDATE resolution_list SET sponsors='$this->sponsors' WHERE id='$this->resolutionId'") or die(mysql_error());
        mysql_query("UPDATE resolution_list SET signatories='$this->signatories' WHERE id='$this->resolutionId'") or die(mysql_error());
        // Save clause information
        $preambulatoryId = 0;
        foreach($this->preambulatory as $clause){
            if($preambulatoryId==0) $preambulatoryId = $clause->clauseId;
            $clause->saveInfo();
        }
        mysql_query("UPDATE resolution_list SET preambulatoryId='$preambulatoryId' WHERE id='$this->resolutionId'") or die(mysql_error());
        
        $operativeId = 0;
        foreach($this->operative as $clause){
            if($operativeId==0) $operativeId = $clause->clauseId;
            $clause->saveInfo();
        }
        mysql_query("UPDATE resolution_list SET operativeId='$operativeId' WHERE id='$this->resolutionId'") or die(mysql_error());

	mysql_query("UPDATE resolution_list SET date='$this->date' WHERE id='$this->resolutionId'") or die(mysql_error()); 
    }
    
    /**
     * Delete this resolution and all clauses, then renumber other resolutions
     **/
    function delete(){
        // Renumber resolutions
        $resolutions = resolution::getResolutions($this->committeeId, $this->topicId);
        foreach($resolutions as $resolution){
            if($resolution->resolutionNum <= $this->resolutionNum)
                continue;
            $resolution->resolutionNum--;
            $resolution->saveInfo();
        }
        // Delete subclauses
        foreach($this->preambulatory as $clause){
            $clause->delete();
        }
        foreach($this->operative as $clause){
            $clause->delete();
        }
        // Delete resolution
        mysql_query("DELETE FROM resolution_list WHERE id='$this->resolutionId'") or die(mysql_error());
    }
    
    /**
     * Start a new resolution
     **/
    public static function newResolution(){
        $result = mysql_query("INSERT INTO resolution_list () VALUES()") or die(mysql_error());
        return new resolution(mysql_insert_id());
    }
    
    /**
     * Get a list of all resolutions for a topic and committee
     **/
    public static function getResolutions($committeeId, $topicId){
        $result = mysql_query("SELECT id FROM resolution_list WHERE committeeId='$committeeId' AND topicId='$topicId'") or die(mysql_error());
        $resolutionIds = array();
        while($row = mysql_fetch_array($result)){
            array_push($resolutionIds, $row['id']);
        }
        return $resolutionIds;
    }
    
    /**
     * Get a new resolution's number for a committee
     **/
    public static function getNewResolutionNum($committeeId){
        $result = mysql_query("SELECT id FROM resolution_list WHERE committeeId='$committeeId'") or die(mysql_error());
        $resolutionIds = array();
        while($row = mysql_fetch_array($result)){
            array_push($resolutionIds, $row['id']);
        }
        return sizeof($resolutionIds)+1;
    }
}





/**
 * This class embodies a single clause in a resolution
 **/
class resolutionClause {
    /** Constructor **/
    function __construct($clauseId){
        $result = mysql_query("SELECT * FROM resolution WHERE id='$clauseId'") or die(mysql_error());
        $row = mysql_fetch_array($result);
        $this->clauseId = $row['id'];
        $this->text = $row['text'];
        $this->nextId = $row['nextId'];
        $this->subClause = $this->traverseClauses($row['subId']);
    }
    
    /**
     * Find the phrase and the rest of the text (useful for italicizing/bolding)
     **/
    function splitPhrase(){
        $split = array();
        if(strpos($this->text, ' ')!= false){
            $split[0] = substr($this->text, 0, strpos($this->text, ' '));
            $split[1] = substr($this->text, strpos($this->text, ' '));
        }else{
            $split[0] = $this->text;
            $split[1] = "";
        }
        return $split;
    }
    
    /**
     * Create a form for inputting data into this clause
     **/
    function getForm($subClause){
        $return = '';
        $return .= '<textarea type="text" rows="2" cols="80">';
        $return .= $this->text;
        $return .= '</textarea> ';
        if($subClause)
            $return .= '<a href="javascript:void(0)" onclick="javascript:createSubClause($(this).parent())"><img src="/images/subclause.png" /></a> ';
        $return .= '<a href="javascript:void(0)" onclick="javascript:deleteClause($(this).parent())"><img src="/images/cancel.png" /></a>';
        if($this->subClause != array()){
            $return .= '<ol>';
            foreach($this->subClause as $clause){
                $return .= '<li>';
                $return .= $clause->getForm($subClause);
                $return .= '</li>';
            }
            $return .= '</ol>';
        }
        return $return;
    }
    /**
     Get Resolution operative clause
     **/
    function getOperativeClause($clauseDepth){
        $return = '';
        $return .= '\\'.$clauseDepth.' ';
        $splitPhrase = $this->splitPhrase();
        if($clauseDepth == 1){
            $return .= '\\underline{'.trim(sanitizeLatex($splitPhrase[0])).'} ';
            $return .= trim(sanitizeLatex($splitPhrase[1]));
        }else{
            $return .= trim(sanitizeLatex($this->text));
        }
        foreach($this->subClause as $clause){
            $return .= "\n";
            $return .= $clause->getOperativeClause($clauseDepth+1);
        }
        return $return;
    }
    
    /**
     * Save this clause and all subclauses
     **/
    function saveInfo(){
        mysql_query("UPDATE resolution SET text='$this->text' WHERE id='$this->clauseId'") or die(mysql_error());
        mysql_query("UPDATE resolution SET nextId='$this->nextId' WHERE id='$this->clauseId'") or die(mysql_error());
        if($this->subClause==array()){
            mysql_query("UPDATE resolution SET subId='0' WHERE id='$this->clauseId'") or die(mysql_error());
        }else{
            $subId=$this->subClause[0]->clauseId;
            mysql_query("UPDATE resolution SET subId='$subId' WHERE id='$this->clauseId'") or die(mysql_error());
            foreach($this->subClause as $subClause){
                $subClause->saveInfo();
            }
        }
    }
    
    /**
     * Delete this clause and all subclauses
     **/
    function delete(){
        // Delete subclauses
        foreach($this->subClause as $clause){
            $clause->delete();
        }
        
        mysql_query("DELETE FROM resolution WHERE id='$this->clauseId'") or die(mysql_error());
    }
    
    /**
     * Create a new empty clause
     **/
    public static function newClause(){
        $result = mysql_query("INSERT INTO resolution () VALUES()") or die(mysql_error());
        $newClause = new resolutionClause(mysql_insert_id());
        return $newClause;
    }
    
    /**
     * Return an array of clauses at the same level with the same parent clause
     **/
    public static function traverseClauses($clauseId){
        $clauses = array();
        while($clauseId != 0){
            $clause = new resolutionClause($clauseId);
            array_push($clauses, $clause);
            $clauseId = $clause->nextId;
        }
        return $clauses;
    }
}




