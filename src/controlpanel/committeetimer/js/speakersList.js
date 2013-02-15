/**
 * This file contains javascript relating to the speakers list
**/

var committee = 0;
var countries = [];

function doc_load_speakers_list(){
    // functions to be run on document load
    load_countries();
    $("#speakers_list_input").autocomplete(countries);
    timer_log();
    $('#speakers_list_input').keyup(function(e) {
        if(e.keyCode == 13) {
            timer_log_new();
        }
    });
}


function load_countries(){
    // This function does an ajax request that loads the list of all available 
    // countries
    $.ajax({
      url: 'https://www.mitmunc.org/controlpanel/committeetimer/ajax/get_countries',
      async: false,
      success: function(data) {
        countries = jQuery.parseJSON(data);
      }
    });
}

function timer_log(){
    // Display the Speakers List
    $.post(
        'https://www.mitmunc.org/controlpanel/committeetimer/ajax/timer_log',
        {
            committee:committee
        },
        function(data){
            $('#speakers_list').html(data);
        }
    );
}

function timer_log_new(){
    // Add speaker to Speakers List and Refresh
    country = $("#speakers_list_input").val();
    
    $.post(
        'https://www.mitmunc.org/controlpanel/committeetimer/ajax/timer_log_new',
        {
            country:country,
            committee:committee
        },
        function(data) {
              $('#speakers_list').html(data);
        }
    );

    $("#speakers_list_input").val('');
}

function timer_log_delete(timer_log_id){
    // Delete Speaker from Speakers List and Refresh
    $.post(
        'https://www.mitmunc.org/controlpanel/committeetimer/ajax/timer_log_delete',
        {
            timer_log_id:timer_log_id
        },
        function(data){
            timer_log();
        });
}

