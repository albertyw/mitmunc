var errors = new Array(1,1,1,1,1,1,1);
var errorChecking = new Array();
$(function() {
    $("#address2").Watermark("Optional");
    $("#phoneNumber").Watermark("Optional");
    $("#hearAboutUs").Watermark("Optional");
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
    var usernameError = function() {return !$(arguments[0]).val().match(/^[a-z0-9]+$/i)}
    errorChecking[5] = new Array("#username", "#usernameError", usernameError, "A username must contain only letters and numbers");
    var usernameTakenError = function() {
        var usernameTaken;
        $.ajax({
            type:'POST',
            url:'/include/ajax/registrationUsername',
            data:{username:$(arguments[0]).val()},
            async:false,
            success: function(result){usernameTaken = result;}
        });
        return usernameTaken=='true';

    }
    errorChecking[6] = new Array("#username", "#usernameTakenError", usernameTakenError, "Your username has already been taken.  Please choose another username");
    
    addEventHandlers(errorChecking);
    $("#submitButton").attr('disabled', 'disabled');
});

function isInt(variable){ return parseFloat(variable) == parseInt(variable) && !isNaN(variable);}

function addEventHandlers(errorChecking) {
    for(var i=0; i<errorChecking.length; i++){
        $(errorChecking[i][0]).blur({index:i, errorChecking:errorChecking}, function(event){
                var i = event.data.index;
                var errorChecking = event.data.errorChecking;
                checkInput(errorChecking[i][0], errorChecking[i][1], errorChecking[i][2], errorChecking[i][3], i)
        });
    }
}

function runErrorChecking(errorChecking) {
    for(var i=0; i<errorChecking.length; i++){
        checkInput(errorChecking[i][0], errorChecking[i][1], errorChecking[i][2], errorChecking[i][3]);
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

function registrationSubmit(){
    runErrorChecking(errorChecking);
    if($("#submitButton").attr('disabled')!=null) return;
    $.post(
		"/include/ajax/registration",
		{
            schoolName: $("#schoolName").val(),
            numStudents: $("#numStudents").val(),
            numAdvisers: $("#numAdvisers").val(),
            contactName: $("#contactName").val(),
            email: $("#email").val(),
            address1: $("#address1").val(),
            address2: $("#address2").val(),
            city: $("#city").val(),
            state: $("#state").val(),
            zip: $("#zip").val(),
            countryId: $("#countryId").val(),
            phoneNumber: $("#phoneNumber").val(),
            username: $("#username").val(),
            hearAboutUs: $("#hearAboutUs").val(),
            finAid: $("input[@name='finAid']:checked").val()
		},
		function(txt){
		        if(txt != "") {
		          text = txt;
		        } else {
		          text = '<b>Your registration has been submitted and an email has been sent to your provided address with login information to the website.  Thank you.</b><br /><br />';
		        }
            $("#regform").html(text);
		}
	)
}
