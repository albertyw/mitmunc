<?php
require("/var/www/mitmunc/template/header_very_basic.php");

$SESSION->securityCheck(true, array('secretariat', 'chair'));

$resolutionId = sanitizeValue($_POST['resolutionId']);
$resolution = new resolution($resolutionId);
if($_POST['action']=='SAVE'){
    $resolution->date = sanitizeValue($_POST['date']);

    $topicId = sanitizeValue($_POST['topicId']);
    $resolution->topicId = $topicId;
    
    // Delete old clauses
    foreach($resolution->preambulatory as $clause){
        $clause->delete();
    }
    foreach($resolution->operative as $clause){
        $clause->delete();
    }
    $preambulatory = json_decode($_POST['preambulatory'], true);
    $operative = json_decode($_POST['operative'], true);
    //echo $_POST['preambulatory'];
    
    $resolution->sponsors = sanitizeValue($_POST['sponsors']);
    $resolution->signatories = sanitizeValue($_POST['signatories']);
    $resolution->preambulatory = parseClauses($preambulatory);
    $resolution->operative = parseClauses($operative);
    
    $resolution->saveInfo();
}elseif($_POST['action']=='PRINT'){
    
}elseif($_POST['action']=='DELETE'){
    $resolution->delete();
}

/**
 * Read the returned text and parse them into a resolution?
 **/
function parseClauses($jsonClauses){
    $clauses = array();
    for($i=0; $i<sizeof($jsonClauses); $i++){
        $jsonClause = $jsonClauses[$i];
        $clause = resolutionClause::newClause();
        $clause->text = mysql_real_escape_string($jsonClause['text']);
        if($i!=0){
            $clauses[$i-1]->nextId = $clause->clauseId;
        }
        if($jsonClause['subClause'] != '0'){
            $clause->subClause = parseClauses($jsonClause['subClause']);
        }
        $clauses[$i] = $clause;
    }
    return $clauses;
}
