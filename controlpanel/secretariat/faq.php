<?php 
$title = "MITMUNC - Control Panel - MITMUNC FAQ";
require("/var/www/mitmunc/template/header.php"); ?>
<script type="text/javascript">
$(function(){
    
});
function addFaq(){
    // Find last faq id
    var id = 1;
    while($("#faq"+id).length == 1){
        id += 1;
    }
    $("#faq").append('<tr id="faq'+id+'">\
        <td class="section"></td>\
        <td class="question"></td>\
        <td class="answer"></td>\
        <td></td>\
        <td><a href="javascript:;" onclick="javascript:deleteFaq($(this).parent().parent().attr(\'id\'))">Delete</a></td>\
        </tr>');
    editFaq("faq"+id);
}
function editFaq(id){
    var section = $("#"+id+">.section").html();
    var question = $("#"+id+">.question").html();
    var answer = $("#"+id+">.answer").html().replace(/"/g,'&quot;');
    $("#"+id).html('<td class="section"><input type="text" value="'+section+'"></td>\
        <td class="question"><input type="text" value="'+question+'" size="50"></td>\
        <td class="answer"><textarea cols="50" rows="3">'+answer+'</textarea></td>\
        <td></td>\
        <td><a href="javascript:;" onclick="javascript:deleteFaq($(this).parent().parent().attr(\'id\'))">Delete</a></td>\
    ');
}
function deleteFaq(id){
    id = id.substring(3);
    $("#faq"+id).remove();
    id++;
    while($("#faq"+id).length == 1){
        $("#faq"+id).attr('id',"faq"+(id-1));
        id++;
    }
    submitFaq();
}
function submitFaq(){
    var id = 1;
    var section = Array(0);
    var question = Array(0);
    var answer = Array(0);
    while($("#faq"+id).length == 1){
        if($("#faq"+id+">.section>input").length == 1){
            section.push($("#faq"+id+">.section>input").val());
            question.push($("#faq"+id+">.question>input").val());
            answer.push($("#faq"+id+">.answer>textarea").val());
        }else{
            section.push($("#faq"+id+">.section").html());
            question.push($("#faq"+id+">.question").html());
            answer.push($("#faq"+id+">.answer").html());
        }
        id += 1;
    }
    section = JSON.stringify(section);
    question = JSON.stringify(question);
    answer = JSON.stringify(answer);
    $.post(
        "/include/ajax/faq",
        {
            section:section,
            question:question,
            answer:answer
        },
        function(data){
            if(data==''){
                window.location.reload();
            }else{
                alert(data);
            }
        }
    );
}
</script>
<h1>FAQ</h1>
                
<?php
$SESSION->securityCheck(true, array('secretariat'));
?>

These FAQ are displayed on the <a href="/faq">FAQ Page</a>.  

<?php
$result = mysql_query("SELECT * FROM faq") or die(mysql_error());
echo '<table id="faq" class="bordered padded">';
echo '<tr><th>Section</th><th>Question</th><th>Answer</th></tr>';
while($row = mysql_fetch_array($result)){
    echo '<tr id="faq'.$row['id'].'">';
    echo '<td class="section">'.$row['section'].'</td>';
    echo '<td class="question">'.$row['question'].'</td>';
    echo '<td class="answer">'.$row['answer'].'</td>';
    echo '<td><a href="javascript:;" onclick="javascript:editFaq($(this).parent().parent().attr(\'id\'))">Edit</a></td>';
    echo '<td><a href="javascript:;" onclick="javascript:deleteFaq($(this).parent().parent().attr(\'id\'))">Delete</a></td>';
    echo '</tr>';
}
echo '</table>';
echo '<input type="submit" onclick="javascript:addFaq()" value="Add FAQ" />';
echo '<input type="submit" onclick="javascript:submitFaq()" value="Save FAQ" />';
?>

<br />
<br />
<a href="/controlpanel/">Back To Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php");?>
