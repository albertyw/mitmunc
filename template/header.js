
$(function() {
    changeNavBarFocus(1, loggedin);
    $("#navbar1").mouseenter(function(){
        changeNavBarFocus(1, loggedin);
    });
    $("#navbar2").mouseenter(function(){
        changeNavBarFocus(2, loggedin);
    });
    $("#navbar3").mouseenter(function(){
        changeNavBarFocus(3, loggedin);
    });
    $("#navbar4").mouseenter(function(){
        changeNavBarFocus(4, loggedin);
    });
    $("#navbar5").mouseenter(function(){
        changeNavBarFocus(5, loggedin);
    });
    $("#navbar6").mouseenter(function(){
        changeNavBarFocus(6, loggedin);
    });
    preloadimages();
});
function changeNavBarFocus(focusLoc, loggedin){
    resetNavBar(loggedin);
    switch (focusLoc) {
      case 1: navbar1(); break;
      case 2: navbar2(); break;
      case 3: navbar3(); break;
      case 4: navbar4(); break;
      case 5: navbar5(); break;
      case 6: navbar6(); break;
    }
}
function navbar1() {
 $("#header2_home").css('display', 'block');
}
function navbar2(){
    $('#navbar2').attr('src','/images/header/navbar2_h.gif');
    $("#header2logo").css('background-image','url(/images/header/selection2.gif)');
    $("#header2_link2").css('display', 'block');
}
function navbar3(){
    $('#navbar3').attr('src','/images/header/navbar3_h.gif');
    $("#header2logo").css('background-image','url(/images/header/selection3.gif)');
    $("#header2_link3").css('display', 'block');
}
function navbar4(){
    $('#navbar4').attr('src','/images/header/navbar4_h.gif');
    $("#header2logo").css('background-image','url(/images/header/selection4.gif)');
    $("#header2_link4").css('display', 'block');

}
function navbar5(){
    if(loggedin){
        $('#navbar5').attr('src','/images/header/navbar5_h_loggedin.gif');
        $("#header2logo").css('background-image','url(/images/header/selection5_loggedin.gif)');
    }else{
        $('#navbar5').attr('src','/images/header/navbar5_h.gif');
        $("#header2logo").css('background-image','url(/images/header/selection5.gif)');
    }
    $("#header2_link5").css('display', 'block');
}
function navbar6(){
    if(loggedin){
        $('#navbar6').attr('src','/images/header/navbar6_h_loggedin.gif');
    }else{
        $('#navbar6').attr('src','/images/header/navbar6_h.gif');
        $("#header2logo").css('background-image','url(/images/header/selection6.gif)');
    }
    $("#header2_link6").css('display', 'block');
}

function resetNavBar(loggedin){
    $('#navbar2').attr('src','/images/header/navbar2.gif');
    $('#navbar3').attr('src','/images/header/navbar3.gif');
    $('#navbar4').attr('src','/images/header/navbar4.gif');
    if(loggedin){
        $('#navbar5').attr('src','/images/header/navbar5_loggedin.gif');
        $('#navbar6').attr('src','/images/header/navbar6_loggedin.gif');
    }else{
        $('#navbar5').attr('src','/images/header/navbar5.gif');
        $('#navbar6').attr('src','/images/header/navbar6.gif');
    }
    $("#header2logo").css('background-image','url(/images/header/selection1.gif)');
    $(".menu_item").css('display', 'none');
    
}

function preloadimages(){
    $("#preloadimage").html('<img src="/images/header/navbar2_h.gif">');
    $("#preloadimage").html('<img src="/images/header/navbar3_h.gif">');
    $("#preloadimage").html('<img src="/images/header/navbar4_h.gif">');
    $("#preloadimage").html('<img src="/images/header/navbar4_h_loggedin.gif">');
    $("#preloadimage").html('<img src="/images/header/navbar5_h.gif">');
    $("#preloadimage").html('<img src="/images/header/navbar5_h_loggedin.gif">');
    $("#preloadimage").html('<img src="/images/header/navbar6_h.gif">');
    $("#preloadimage").html('<img src="/images/header/navbar6_h_loggedin.gif">');
    $("#preloadimage").html('<img src="/images/header/selection1.gif">');
    $("#preloadimage").html('<img src="/images/header/selection2.gif">');
    $("#preloadimage").html('<img src="/images/header/selection3.gif">');
    $("#preloadimage").html('<img src="/images/header/selection4.gif">');
    $("#preloadimage").html('<img src="/images/header/selection5.gif">');
    $("#preloadimage").html('<img src="/images/header/selection5_loggedin.gif">');
    $("#preloadimage").html('<img src="/images/header/selection6.gif">');
}
