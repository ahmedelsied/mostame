$(function(){
    if(localStorage.getItem("dark_mode") != null){
        $('#mode').css('left','50%');
    }
    setTimeout(function(){
        $(".backend-message").remove();
    },5000);
    var code_interval = setInterval(function(){
        if($("#code_interval").text() > 0) {
            $("#code_interval").text($("#code_interval").text() - 1)
        }else{
            $("#code_interval").parent().remove();
            clearInterval(code_interval);
        }
    },1000);
    var overlay = $('.overlay'),
        fadeTimeOut = 300,
        displaySettings = $('.display-setting-parent'),
        reply_problem_box =$("#reply_to_problem_box"),
        caht_action = $("#caht_action"),
        report_chat_form = $("#report_chat_form"),
        close_chat_form = $("#close_chat_form");
    // Public In Main Pages
    $('#display-setting').on('click',function(e){
        e.preventDefault();
        overlay.fadeIn(fadeTimeOut);
        displaySettings.fadeIn(fadeTimeOut);
    });
    
    $(".reply_to_problem").on('click',function(){
        reply_problem_box.fadeIn();
        overlay.show();
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
        var file = $(this).parent().data('file'); 
        eval($(this).parent().data('action') + '("'+file+'")');
    });
    function changeLang(){
        var nextLang = getCookie("lang") == "ar" ? "en" : "ar";
        setCookie("lang",nextLang,100)
        setTimeout(function(){
            window.location.reload(1);
        }, 300);
    }
    function changeTheme(file){
        if(localStorage.getItem("dark_mode") == 1){
            $('#dark_mode').remove();
            localStorage.setItem("dark_mode",0);
        }else{
            var darkStyle= '<link id="dark_mode" href="\\user\\css\\dark-user.css" rel="stylesheet"/>';
            $('head').append(darkStyle);
            localStorage.setItem("dark_mode", 1);
        }
    }
    overlay.on('click',function(){
        $(this).fadeOut(fadeTimeOut);
        hideDisplaySettings();
        hide_reply_box();
        hide_report_chat();
        hide_close_chat();
    });
    $("#report_chat").on("click",function(){
        report_chat_form.show();
        overlay.show();
    });
    $("#close_chat").on("click",function(){
        close_chat_form.show();
        overlay.show();
    });
    caht_action.on("click",function(){
        $("#chat_actions").toggle();
    });
    $(".chat_action").on("click",function(){
        $(this).parent().hide();
    });
    $("#cancel_close_chat").on("click",function(){
        hide_close_chat();
        overlay.fadeOut(fadeTimeOut);
    });
    $("#rate_listener li").on("mouseenter",function(){
        var curr = $(this).data("value");
        $('#rate_listener li[data-value]').filter(function () {
            return $(this).data('value') <= curr;
        }).children("i").addClass("fas");
        $('#rate_listener li[data-value]').filter(function () {
            return $(this).data('value') > curr;
        }).children("i").removeClass("fas");
    });
    $("#rate_listener li i").on("click",function(){
        var rate = $(this).parent("li").data("value");
        $("#listener_rate_inpt").val(rate);
    });
    function hideDisplaySettings(){
        displaySettings.fadeOut(fadeTimeOut);
    }
    function hide_report_chat(){
        report_chat_form.fadeOut(fadeTimeOut);
    }
    function hide_close_chat(){
        close_chat_form.fadeOut(fadeTimeOut);
    }
    function hide_reply_box(){
        reply_problem_box.fadeOut(fadeTimeOut);
    }

});