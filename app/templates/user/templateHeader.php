<!DOCTYPE html>
<html <?=$this->__('settings.html_setting')?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-control" content="public">
    <noscript><meta http-equiv="refresh" content="0; URL=/error_js"></noscript>
    <title><?=$this->__('settings.title')?></title>
    <link href="<?=IMGS?>logo_icon.png" rel="shortcut icon"/>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet"> -->
    <link href="<?=PUBLIC_CSS?>bootstrap.min.css" rel="stylesheet"/>
    <link href="<?=PUBLIC_CSS?>fontawesome.min.css" rel="stylesheet"/>
    <link href="<?=PUBLIC_CSS?>public.css" rel="stylesheet"/>
    <link href="<?=USER_CSS?>user.css" rel="stylesheet"/>
    <script src="<?=PUBLIC_JS?>jquery-3.3.1.min.js"></script>
    <script src="<?=PUBLIC_JS?>functions.js"></script>
    <script src="<?=PUBLIC_JS?>bootstrap.min.js"></script>
    <script>
        if(localStorage.getItem("dark_mode") == '1'){
            var file = localStorage.getItem("file");
            var headID = document.getElementsByTagName('head')[0];
            var link = document.createElement('link');
            link.type = 'text/css';
            link.rel = 'stylesheet';
            link.id = 'dark_mode';
            headID.appendChild(link);
            link.href = '\\user\\css\\dark-user.css';
        }
    </script>
    <style>
        @media(min-width:768px){
            .chat.content{
                margin-<?=$this->__("settings.align")?>:225px;
            }
            section.special{
                margin-<?=$this->__("settings.align")?>:225px;
            }
        }
    </style>
    <?php $this->fire_component("set_socket_parameters");?>
    <script id="socket" src="<?=USER_JS?>websocket.js"></script>
    <script>
        $(function(){
            window.socket.onmessage = function(data){
            var data = JSON.parse(data.data),
                callBack = data['action'];
                data["has_arg"] ? eval(callBack + "(data)") : eval(callBack + "()");
            }

            function chat_started(){
                window.location.href = "/user/index";
            }
        });
        
    </script>
</head>
<body>