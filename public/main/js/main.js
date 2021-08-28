$(function(){
    if(localStorage.getItem("dark_mode") != null){
        $('#mode').css('left','50%');
    }
    setTimeout(() => {
        $('.backend-message').remove();
    }, 3000);
    var overlay = $('.overlay'),
        fadeTimeOut = 300,
        displaySettings = $('.display-setting-parent');
    // Public In Main Pages
    $('#display-setting').on('click',function(e){
        e.preventDefault();
        overlay.fadeIn(fadeTimeOut);
        displaySettings.fadeIn(fadeTimeOut);
    });
    if(localStorage.getItem("dark_mode") == 0){
        $("#mode-parent .last-ac").addClass("live");
        $("#mode-parent span.active-action").css('left',"0%");
    }else{
        $("#mode-parent .last-ac").prev().addClass("live");
    }
    // Display Settings
    $('.setting-child span').on('click',function(){
        // Display Settings Animation
        $(this).siblings('.action').toggleClass('live');
        $(this).toggleClass('live');
        if($(this).siblings('.active-action').css('left') == '0px'){
            $(this).siblings('.active-action').animate({
                left:50+'%'
            });
        }else{
            $(this).siblings('.active-action').animate({
                left:0+'%'
            });
        }
        // Fire Action Logic
        eval($(this).parent().data('action') + '()');
    });
    function changeLang(){
        var nextLang = getCookie("lang") == "ar" ? "en" : "ar";
        setCookie("lang",nextLang,100)
        setTimeout(function(){
            window.location.reload(1);
        }, 300);
    }
    function changeTheme(){
        if(localStorage.getItem("dark_mode") == 1){
            $('#dark_mode').remove();
            localStorage.setItem("dark_mode",0);
        }else{
            var darkStyle= '<link id="dark_mode" href="\\main\\css\\dark-main.css" rel="stylesheet"/>';
            $('head').append(darkStyle);
            localStorage.setItem("dark_mode", 1);
        }
    }
    overlay.on('click',function(){
        $(this).fadeOut(fadeTimeOut);
        var action = $(this).data('action');
        eval(action + '()');
    });
    // Signup Page
    $('#birthdate').on('change',function(){
        $('#birthdate-label').hide();
    });
    
    function hideDisplaySettings(){
        displaySettings.fadeOut(fadeTimeOut);
    }
});