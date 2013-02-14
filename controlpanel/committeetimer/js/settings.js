/**
 * These scripts have to do with saving and loading old settings/data for 
 * committee timers and announcements
**/
var globalAnnouncementSaveTimeout;
function doc_load_settings(){
    //functions to be run on document load
    get_settings();
    $("#announcements_textarea").keyup(function(){
        clearTimeout(globalAnnouncementSaveTimeout);
        globalAnnouncementSaveTimeout = setTimeout(save_settings, 2000);
    });
    
}

function get_settings(){
    // Get and apply old settings
    var committeeId = committee;
    
    $.post(
        'ajax/get_settings',
        {
            committeeId:committeeId
        },
        function(data){
            data = jQuery.parseJSON(data);
            $("#speech_timer_minutes").val(0);
            $("#speech_timer_seconds").val(data.speech);
            formatTimeInput("#speech_timer_minutes", "#speech_timer_seconds");
            timer_reset(s, "#speech_timer_start")
            $("#caucus_timer_minutes").val(0);
            $("#caucus_timer_seconds").val(data.caucus);
            formatTimeInput("#caucus_timer_minutes", "#caucus_timer_seconds");
            timer_reset(t, "#caucus_timer_start");
            $("#announcements_textarea").val(data.announcements);
        }
    );
}

function save_settings(){
    // Save settings
    var committeeId = committee;
    var speechTime = calculateTotalTime('#speech_timer_minutes', '#speech_timer_seconds');
    var caucusTime = calculateTotalTime('#caucus_timer_minutes', '#caucus_timer_seconds');
    var announcements = $("#announcements_textarea").val();
    $.post(
        'ajax/save_settings',
        {
            committeeId:committeeId,
            speechTime:speechTime,
            caucusTime:caucusTime,
            announcements:announcements
        },
        function(data) {
          
        }
    );
}
