var errors = new Array(0,0,0,0,0);
var errorChecking = new Array();
$(function() {
    $("#address2").Watermark("Optional");
    $("#phoneNumber").Watermark("Optional");
    var schoolNameError = function() {return $(arguments[0]).val() == ''}
    errorChecking[0] = new Array("#schoolName", "#schoolNameError", schoolNameError, "We require the name of your school or organization");
    var numStudentsError = function() {return !isInt($(arguments[0]).val())}
    errorChecking[1] = new Array("#numStudents", "#numStudentsError", numStudentsError, "Number of students should be a number");
    var tooManyStudentsError = function() {return isInt($(arguments[0]).val()) && parseInt($(arguments[0]).val())>30}
    errorChecking[2] = new Array("#numStudents", "#tooManyStudentsError", tooManyStudentsError, "We limit delegation sizes to 30 students");
    var numAdvisersError = function() {return !isInt($(arguments[0]).val())}
    errorChecking[3] = new Array("#numAdvisers", "#numAdvisersError", numAdvisersError, "Number of advisers should be a number");
    var emailError = function() {return !$(arguments[0]).val().match(/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])(([a-z0-9-])*([a-z0-9]))+(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i)}
    errorChecking[4] = new Array("#email", "#emailError", emailError, "Your email address is improperly formatted");
});

function isInt(variable){ return parseFloat(variable) == parseInt(variable) && !isNaN(variable);}

function addEventHandlers(errorChecking) {
    for(var i=0; i<errorChecking.length; i++){
        $(errorChecking[i][0]).change({index:i, errorChecking:errorChecking}, function(event){
                var i = event.data.index;
                var errorChecking = event.data.errorChecking;
                checkInput(errorChecking[i][0], errorChecking[i][1], errorChecking[i][2], errorChecking[i][3], i)
        });
        $(errorChecking[i][0]).keyup({index:i, errorChecking:errorChecking}, function(event){
                var i = event.data.index;
                var errorChecking = event.data.errorChecking;
                checkInput(errorChecking[i][0], errorChecking[i][1], errorChecking[i][2], errorChecking[i][3], i)
        });
    }
}

function runErrorChecking(errorChecking) {
    for(var i=0; i<errorChecking.length; i++){
        checkInput(errorChecking[i][0], errorChecking[i][1], errorChecking[i][2], errorChecking[i][3], i);
    }
}

function checkInput(input_selector, error_selector, check_function, error_text, i){
    $(input_selector).css("background-color", "#FFF");
    $(error_selector).html("");
    if(check_function(input_selector)) {
        $(input_selector).css("background-color", "#FCC");
        $(error_selector).html(error_text);
        errors[i] = 1;
    }else{
        errors[i] = 0;
    }
    checkRegisterButton();
}

function checkRegisterButton(){
    for(var i=0; i<errors.length; i++){
        if(errors[i] == 1){
            $("#submitButton").attr('disabled', 'disabled');
            return;
        }
    }
    $("#submitButton").removeAttr('disabled');
}