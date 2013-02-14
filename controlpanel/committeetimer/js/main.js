/**
 * This file contains the bulk of the javascript that is needed to run the
 * committee timer
 **/
var committee = 0;
var countries = [];

// Stopwatch timers
var s = new Stopwatch(function(runtime) {
    var totalTime = calculateTotalTime('#speech_timer_minutes', '#speech_timer_seconds');
    var timeLeft = totalTime -    Math.round(runtime / 1000);
    var displayText = '';
    if(timeLeft < 0)
        displayText += '-';
    displayText += Math.floor(Math.abs(timeLeft) / 60) + ':';
    if((Math.abs(timeLeft) % 60) < 10)
        displayText += '0';
    displayText += Math.abs(timeLeft % 60);
    if(timeLeft < 0) {
        if(runtime % 1000 != 0) {
            // displayText = displayText + " !";
            $("#speech_timer_number").css("color", "#C22");
        } else {
            $("#speech_timer_number").css("color", "#222");
        }
    } else {
        $("#speech_timer_number").css("color", "");
    }
    $("#speech_timer_number").html(displayText);
});

var t = new Stopwatch(function(runtime) {
    var totalTime = calculateTotalTime('#caucus_timer_minutes', '#caucus_timer_seconds');
    var timeLeft = totalTime -    Math.round(runtime / 1000);
    var displayText = '';
    if(timeLeft < 0)
        displayText += '-';
    displayText += Math.floor(Math.abs(timeLeft) / 60) + ':';
    if((Math.abs(timeLeft) % 60) < 10)
        displayText += '0';
    displayText += Math.abs(timeLeft % 60);
    if(timeLeft < 0) {
        if(runtime % 1000 != 0) {
            // displayText = displayText + " !";
            $("#caucus_timer_number").css("color", "#C22");
        } else {
            $("#caucus_timer_number").css("color", "#222");
        }
    } else {
        $("#caucus_timer_number").css("color", "");
    }
    $("#caucus_timer_number").html(displayText);
    if(timeLeft == -60)
        alert('Caucus has ended!');
});

// Functions to run at loading
$(document).ready(function() {
    // Basic loading
    committee = $("#committeeId").val();
    doc_load_speakers_list();
    doc_load_settings();
    js_clock();

    // first stopwatch
    $("#speech_timer_start").bind("click", function() {
        s.startStop();
        checkStartPause(s, "#speech_timer_start");
    });
    $("#speech_timer_reset").bind("click", function() {
        timer_reset(s, "#speech_timer_start");
    });
    
    $(document).bind('keydown', 's', function() {
        if (!($("#speakers_list_input").is(":focus")) && !($("#announcements_textarea").is(":focus"))) {
            if ($("#speech_timer_start").is(":visible")) {
                s.startStop();
                checkStartPause(s, "#speech_timer_start");
            } else {
                timer_reset(s, "#speech_timer_start")
            }
        }
    });
    $(document).bind('keydown', 'r', function() {
        if (!($("#speakers_list_input").is(":focus")) && !($("#announcements_textarea").is(":focus"))) {
            timer_reset(s, "#speech_timer_start");
        }
    });
    $(document).bind('keyup', 'e', function() {
        if (!($("#speakers_list_input").is(":focus")) && !($("#announcements_textarea").is(":focus"))) {
            $("#speech_timer_edit_button").click();
        }
    });
    
    $("#speech_timer_minutes").keypress(function(e) {
        if(e.keyCode == 13) {
            speech_timer_number_save();
        }
    });
    $("#speech_timer_seconds").keypress(function(e) {
        if(e.keyCode == 13) {
            speech_timer_number_save();
        }
    });
    s.doDisplay();

    // second stopwatch
    $("#caucus_timer_start").bind("click", function() {
        t.startStop();
        checkStartPause(t, "#caucus_timer_start");
    });
    $("#caucus_timer_reset").bind("click", function() {
        timer_reset(t, "#caucus_timer_start");
    });

    $(document).bind('keydown', 'shift+s', function() {
        if (!($("#speakers_list_input").is(":focus")) && !($("#announcements_textarea").is(":focus"))) {
            if ($("#caucus_timer_start").is(":visible")) {
                t.startStop();
                checkStartPause(t, "#caucus_timer_start");
            } else {
                timer_reset(t, "#caucus_timer_start")
            }
        }
    });
    $(document).bind('keydown', 'shift+r', function() {
        if (!($("#speakers_list_input").is(":focus")) && !($("#announcements_textarea").is(":focus"))) {
            timer_reset(t, "#caucus_timer_start");
        }
    });
    $(document).bind('keyup', 'shift+e', function() {
        if (!($("#speakers_list_input").is(":focus")) && !($("#announcements_textarea").is(":focus"))) {
            $("#caucus_timer_edit_button").click();
        }
    });
    
    $("#caucus_timer_minutes").keypress(function(e) {
        if(e.keyCode == 13) {
            caucus_timer_number_save();
        }
    });
    $("#caucus_timer_seconds").keypress(function(e) {
        if(e.keyCode == 13) {
            caucus_timer_number_save();
        }
    });

    t.doDisplay();

    $.stylesheetInit();

    // This code loops through the stylesheets when you click the link with
    // an ID of "toggler" below.
    $('#toggler').bind('click', function(e) {
        $.stylesheetToggle();
        return false;
    });
    // When one of the styleswitch links is clicked then switch the stylesheet to
    // the one matching the value of that links rel attribute.
    $('.styleswitch').bind('click', function(e) {
        $.stylesheetSwitch(this.getAttribute('rel'));
        return false;
    });
});
function timer_reset(timer_object, button_id) {
    // Reset the timer
    timer_object.resetLap();
    checkStartPause(timer_object, button_id);
}

function checkStartPause(timer, button_id) {
    // This function switches the caucus and speech timer buttons between start
    // and pause
    if(timer.timer == null) {
        $(button_id).find(".playbg").css("background-image", "url(img/play.png)");
    }
    if(timer.timer != null) {
        $(button_id).find(".playbg").css("background-image", "url(img/pause.png)");
    }
}

function formatTimeInput(minuteText, secondText) {
    // This function is run when the timer is started or stopped
    // This forces a change to the input to make it compatible
    minutes = $(minuteText).val();
    seconds = $(secondText).val();
    if(minutes.replace(/[^0-9]/g, '') != minutes || minutes == '')
        minutes = 0;
    if(seconds.replace(/[^0-9]/g, '') != seconds || seconds == '')
        seconds = 0;
    minutes = parseInt(minutes);
    seconds = parseInt(seconds);
    if(seconds > 60) {
        minutes += Math.floor(seconds / 60);
        seconds = seconds % 60;
    }
    $(minuteText).val(minutes);
    $(secondText).val(seconds);
}

function calculateTotalTime(minutesId, secondsId) {
    var totalTime = $(minutesId).val() * 60 + parseInt($(secondsId).val());
    if(isNaN(totalTime))
        totalTime = 0;
    return totalTime;
}

function js_clock() {
    // Run the clock
    var clock_time = new Date();
    var clock_hours = clock_time.getHours();
    var clock_minutes = clock_time.getMinutes();
    var clock_suffix = "AM";
    if(clock_hours > 11) {
        clock_suffix = "PM";
        clock_hours = clock_hours - 12;
    }
    if(clock_hours == 0) {
        clock_hours = 12;
    }
    if(clock_minutes < 10) {
        clock_minutes = "0" + clock_minutes;
    }
    var clock_div = document.getElementById('js_clock');
    clock_div.innerHTML = clock_hours + ":" + clock_minutes + " " + clock_suffix;
    setTimeout("js_clock()", 1000);
}

function speech_timer_number_edit() {
    // Edit the speech_timer setting
    timer_reset(s, "#speech_timer_start");
    $("#speech_timer_edit_button").hide();
    $("#speech_timer_number").hide();
    $("#speech_timer_start").hide();
    $("#speech_timer_reset").hide();
    $("#speech_timer_save_button").show();
    $("#speech_timer_number_edit").css('display', 'inline-block');
    $("#speech_timer_minutes").focus();
}

function speech_timer_number_save() {
    formatTimeInput("#speech_timer_minutes", "#speech_timer_seconds");
    timer_reset(s, "#speech_timer_start");
    $("#speech_timer_edit_button").show();
    $("#speech_timer_number").show();
    $("#speech_timer_start").show();
    $("#speech_timer_reset").show();
    $("#speech_timer_save_button").hide();
    $("#speech_timer_number_edit").hide();
    save_settings();
}

function caucus_timer_number_edit() {
    // Edit the caucus_timer setting
    timer_reset(t, "#caucus_timer_start");
    $("#caucus_timer_edit_button").hide();
    $("#caucus_timer_number").hide();
    $("#caucus_timer_start").hide();
    $("#caucus_timer_reset").hide();
    $("#caucus_timer_save_button").show();
    $("#caucus_timer_number_edit").css('display', 'inline-block');
    $("#caucus_timer_minutes").focus();
}

function caucus_timer_number_save() {
    formatTimeInput("#caucus_timer_minutes", "#caucus_timer_seconds");
    timer_reset(t, "#caucus_timer_start");
    $("#caucus_timer_edit_button").show();
    $("#caucus_timer_number").show();
    $("#caucus_timer_start").show();
    $("#caucus_timer_reset").show();
    $("#caucus_timer_save_button").hide();
    $("#caucus_timer_number_edit").hide();
    save_settings();
}