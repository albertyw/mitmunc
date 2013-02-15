var errors = new Array(1,1,1);
var errorChecking = new Array();
$(function() {
    $("#phoneNumber").Watermark("Optional");
    $("#hearAboutUs").Watermark("Optional");
    var emailError = function() {return !$(arguments[0]).val().match(/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])(([a-z0-9-])*([a-z0-9]))+(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i)}
    errorChecking[0] = new Array("#email", "#emailError", emailError, "Your email address is improperly formatted");
    var usernameError = function() {return !$(arguments[0]).val().match(/^[a-z0-9]+$/i)}
    errorChecking[1] = new Array("#username", "#usernameError", usernameError, "A username must contain only letters and numbers");
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
    errorChecking[2] = new Array("#username", "#usernameTakenError", usernameTakenError, "Your username has already been taken.  Please choose another username");
    
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

function timerRegistrationCheck(){
    runErrorChecking(errorChecking);
    if($("#submitButton").attr('disabled')!=null) return;
    //Send it off to registration check
    $.post(
		"/include/ajax/registrationTimer",
		{
            contactName: $("#contactName").val(),
            email: $("#email").val(),
            phoneNumber: $("#phoneNumber").val(),
            username: $("#username").val(),
            hearAboutUs: $("#hearAboutUs").val()
		},
		function(txt){ //argument#3 - process the return text
		    $("#regform").html('<b>Your registration has been submitted and an email has been sent to your provided address with login information to the website.  Thank you.</b><br /><br />');
		}
	)
}
