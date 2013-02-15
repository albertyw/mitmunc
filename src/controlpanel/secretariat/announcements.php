<?php 
$title = "MITMUNC - Control Panel - MITMUNC Announcements";
require("/var/www/mitmunc/template/header.php"); ?>
<script type="text/javascript">
$(function(){
    
});
function addAnnouncement(){
    // Find last announcement id
    var id = 1;
    while($("#announcement"+id).length == 1){
        id += 1;
    }
    var d = new Date();
    var month = (d.getMonth()+1).toString();
    if(month.length == 1) month = '0'+month;
    var day = d.getDate().toString();
    if(day.length == 1) day = '0'+day;
    var postDate = d.getFullYear()+'-'+month+'-'+day
    $("#announcements").append('<tr id="announcement'+id+'">\
        <td class="postDate">'+postDate+'</td>\
        <td class="announcement"></td>\
        <td></td>\
        <td><a href="javascript:;" onclick="javascript:deleteAnnouncement($(this).parent().parent().attr(\'id\'))">Delete</a></td>\
        </tr>');
    editAnnouncement("announcement"+id);
}
function editAnnouncement(id){
    var postDate = $("#"+id+">.postDate").html();
    var announcement = $("#"+id+">.announcement").html().replace(/"/g,'&quot;');
    $("#"+id).html('<td class="postDate"><input type="text" value="'+postDate+'"></td>\
        <td class="announcement"><input type="text" size="100" value="'+announcement+'"></td>\
        <td></td>\
        <td><a href="javascript:;" onclick="javascript:deleteAnnouncement($(this).parent().parent().attr(\'id\'))">Delete</a></td>\
    ');
    $(".postDate input").datepicker({ dateFormat: 'yy-mm-dd'});
}
function deleteAnnouncement(id){
    id = id.substring(12);
    $("#announcement"+id).remove();
    id++;
    while($("#announcement"+id).length == 1){
        $("#announcement"+id).attr('id',"announcement"+(id-1));
        id++;
    }
    submitAnnouncements();
}
function submitAnnouncements(){
    var id = 1;
    var postDate = Array(0);
    var announcements = Array(0);
    while($("#announcement"+id).length == 1){
        if($("#announcement"+id+">.postDate>input").length == 1){
            postDate.push($("#announcement"+id+">.postDate>input").val());
            announcements.push($("#announcement"+id+">.announcement>input").val());
        }else{
            postDate.push($("#announcement"+id+">.postDate").html());
            announcements.push($("#announcement"+id+">.announcement").html());
        }
        id += 1;
    }
    postDate = JSON.stringify(postDate);
    announcements = JSON.stringify(announcements);
    $.post(
        "/include/ajax/announcements",
        {
            postDate:postDate,
            announcements:announcements
        },
        function(data){
            window.location.reload();
        }
    );
}
</script>
<h1>Announcements</h1>
                
<?php
$SESSION->securityCheck(true, array('secretariat'));
?>

These announcements are displayed on the <a href="/">MITMUNC Home Page</a>.  

<?php
$result = mysql_query("SELECT id, postDate, announcement FROM announcements ORDER BY postDate DESC");
echo '<table id="announcements">';
while($row = mysql_fetch_array($result)){
    echo '<tr id="announcement'.$row['id'].'">';
    echo '<td class="postDate">'.$row['postDate'].'</td>';
    echo '<td class="announcement">'.$row['announcement'].'</td>';
    echo '<td><a href="javascript:;" onclick="javascript:editAnnouncement($(this).parent().parent().attr(\'id\'))">Edit</a></td>';
    echo '<td><a href="javascript:;" onclick="javascript:deleteAnnouncement($(this).parent().parent().attr(\'id\'))">Delete</a></td>';
    echo '</tr>';
}
echo '</table>';
echo '<input type="submit" onclick="javascript:addAnnouncement()" value="Add Announcements" />';
echo '<input type="submit" onclick="javascript:submitAnnouncements()" value="Save Announcements" />';
?>

<br />
<br />
<a href="/controlpanel/">Back To Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php");?>
