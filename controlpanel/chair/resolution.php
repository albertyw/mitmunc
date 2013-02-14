<?php
$title = "MITMUNC - Control Panel - Resolution";
require("/var/www/mitmunc/template/header.php"); ?>
<script type="text/javascript">
var preambulatoryClause = '<li>\
        <textarea type="text" rows="2" cols="80"></textarea>\
        <a href="javascript:void(0)" onclick="javascript:deleteClause($(this).parent())"><img src="/images/cancel.png" /></a> \
        </li>';
var operativeClause = '<li>\
        <textarea type="text" rows="2" cols="80"></textarea>\
        <a href="javascript:void(0)" onclick="javascript:createSubClause($(this).parent())"><img src="/images/subclause.png" /></a> \
        <a href="javascript:void(0)" onclick="javascript:deleteClause($(this).parent())"><img src="/images/cancel.png" /></a> \
        </li>';
/**
 * Start off by binding existing textareas to event handlers
 **/
$(function(){
    for(i=0; i<$("#preambulatory > li").length; i++){
        var clause = $($("#preambulatory > li")[i]);
        bindTextArea(clause);
    }
    for(i=0; i<$("#operative > li").length; i++){
        var clause = $($("#operative > li")[i]);
        bindTextArea(clause);
    }
});

/**
 * Bind a text area so that newlines create new clauses.  
 **/
function bindTextArea(clause){
    var textarea = clause.find('textarea');
    textarea.keyup(function(event) {
        if(event.which != 13) return;
        var previousClause = $(event.target);
        var previousClauseText = previousClause.val();
        for(var i=0; i<previousClauseText.length; i++){
            if(previousClauseText.charAt(i)!="\n") continue;
            previousClauseText = previousClauseText.substring(0, i)+previousClauseText.substring(i+1,previousClauseText.length);
            i--;
        }
        previousClause.val(previousClauseText);
        createNewClause(previousClause);
    });
}

/**
 * Create a new clause at the same level after the <li>...</li> previousClause
 **/
function createNewClause(previousClause){
    previousClause = previousClause.parent();
    if(previousClause.parents('#preambulatory').length==1){
        previousClause.after(preambulatoryClause);
    }else{
        previousClause.after(operativeClause);
    }
    bindTextArea(previousClause.next());
    previousClause.next().children('textarea').focus();
}

/**
 * Create an empty subclause for the <li>...</li> parentClause
 **/
function createSubClause(parentClause){
    if(parentClause.find('ol').length==0){
        parentClause.append('<ol></ol>');
    }
    var parentSubList = $(parentClause.find('ol')).first();
    parentSubList.append(operativeClause);
    bindTextArea(parentSubList.children().first());
}

/**
 * Delete the subclause
 **/
function deleteClause(clause){
    clause.detach();
}

/**
 * Traverse the clauses in the <ol>...</ol> clauseList and return an object of the text
 **/
function traverseClauses(clauseList){
    var clauses = new Array();
    for(var i=0; i<clauseList.children().length; i++){
        var clause = $(clauseList.children()[i]);
        clauses[i] = new Object();
        clauses[i].text = clause.children('textarea').val();
        if(clause.children('ol').length==1){
            var subClause = traverseClauses(clause.children('ol'));
            clauses[i].subClause = subClause;
        }else{
            clauses[i].subClause = 0;
        }
    }
    return clauses;
}

/**
 * Save the topic, preambulatory, and operative clauses
 **/
function saveResolution(refresh){
    // Create the object for clauses
    var date = $("#date").val();
    var sponsors = $("#sponsors").val();
    var signatories = $("#signatories").val();
    var preambulatory = traverseClauses($("#preambulatory"));
    var operative = traverseClauses($("#operative"));
    preambulatory = JSON.stringify(preambulatory);
    operative = JSON.stringify(operative);
    var asdf = true;
    var ajaxReturn = $.ajax({
        type: "POST",
        async: false,
        url: '/include/ajax/resolution',
        data: {
            action:'SAVE',
	    date:date,
            resolutionId:$("#resolutionId").val(),
            topicId:$("#topicId").val(),
            sponsors:sponsors,
            signatories:signatories,
            preambulatory:preambulatory,
            operative:operative
        }
    });
    if(ajaxReturn.responseText==''){
        if(refresh==true){
            window.location.reload();
        }
    }else{
        alert(ajaxReturn.responseText);
    }
}

function pdfResolution(){
    saveResolution(false);
    var url = 'pdfresolution?resolutionId='+$("#resolutionId").val();
    window.location=url;
    
}
function deleteResolution(){
    var asdf = confirm("Are you sure you want to delete this resolution?");
    if(!asdf) return;
    $.post(
        '/include/ajax/resolution',
        {
            action:'DELETE',
            resolutionId:$("#resolutionId").val()
        },
        function(data){
            if(data==''){
                window.location='/controlpanel/chair/resolutionlist';
            }else{
                alert(data);
            }
        }
    );
}
</script>

<h1>Committee Resolutions</h1>
<p>Below is a resolution created for this committee. Use "ENTER" to create a 
new clause and the buttons to create subclauses or to delete clauses.</p>
<?php
$SESSION->securityCheck(true, array('secretariat', 'chair'));
$committee = new committee($SESSION->committeeId);
echo 'Your committee: '.committee::getCommitteeShortName($committee->committeeId).'<br /><br />';

$_POST = sanitizeArray($_POST);
$resolutionId = $_GET['resolutionId'];
if($resolutionId=='NEW'){
    $resolution = resolution::newResolution();
    // Populate with default values
    $resolution->committeeId = $committee->committeeId;
    $resolution->topicId = 1;
    $resolution->resolutionNum = resolution::getNewResolutionNum($resolution->committeeId);
    $preambulatory = resolutionClause::newClause();
    $operative = resolutionClause::newClause();
    array_push($resolution->preambulatory, $preambulatory);
    array_push($resolution->operative, $operative);
    $resolution->saveInfo();
    echo '<script type="text/javascript">';
    echo 'window.location="resolution?resolutionId='.$resolution->resolutionId.'";';
    echo '</script>';
    require("/var/www/mitmunc/template/footer.php");
    die();
}else{
    $resolution = new resolution($resolutionId);
}
echo '<input type="hidden" id="resolutionId" value="'.$resolution->resolutionId.'">';
echo 'Topic ';
echo '<select id="topicId">';
foreach($committee->topic as $id => $topic){
    echo '<option value="'.$id.'" ';
    if($id==$resolution->topicId) echo 'selected';
    echo '>Topic #'.$id.' - '.$topic.'</option>';
}
echo '</select><br />';
echo 'Resolution #'.$resolution->resolutionNum.'<br />';
echo '<br />';
echo 'Date (yyyy-mm-dd): <br />';
$date = $resolution->date;
if ($date == "0000-00-00"){
   $date = date("Y-m-d");
}
echo '<input type="text" id="date" value = "' . $date . '"/>';
echo '<br />';


echo '<h2>Sponsors</h2>';
echo '<textarea id="sponsors" rows="2" cols="80">'.$resolution->sponsors.'</textarea><br />';

echo '<h2>Signatories</h2>';
echo '<textarea id="signatories" rows="2" cols="80">'.$resolution->signatories.'</textarea><br />';
echo '<br />';

echo '<h2>Preambulatory Clauses</h2>';
echo '<ol id="preambulatory">';
foreach($resolution->preambulatory as $clause){
    echo '<li>';
    echo $clause->getForm(false);
    echo '</li>';
}
echo '</ol>';

echo '<h2>Operative Clauses</h2>';
echo '<ol id="operative">';
foreach($resolution->operative as $clause){
    echo '<li>';
    echo $clause->getForm(true);
    echo '</li>';
}
echo '</ol>';

?>
<input type="submit" onclick="javascript:saveResolution(true)" value="Save Changes"><br />
<input type="submit" onclick="javascript:pdfResolution()" value="Get Resolution PDF"><br />
<br />
<input type="submit" onclick="javascript:deleteResolution()" value="Delete Resolution"><br />
<br />
<a href="/controlpanel/">Back to Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
