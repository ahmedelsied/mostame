<!DOCTYPE html>
<html <?=$this->__('settings.html_setting')?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-control" content="public">
    <meta name="google-signin-client_id" content="977596710483-f8ktiqhp1otrjgrjgb5jp8o3uk76hrkv.apps.googleusercontent.com">
    <noscript><meta http-equiv="refresh" content="0; URL=/error_js"></noscript>
    <title><?=$this->__('settings.title')?></title>
    <link href="<?=IMGS?>logo_icon.png" rel="shortcut icon"/>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet"> -->
    <link href="<?=PUBLIC_CSS?>bootstrap.min.css" rel="stylesheet"/>
    <link href="<?=PUBLIC_CSS?>fontawesome.min.css" rel="stylesheet"/>
    <link href="<?=PUBLIC_CSS?>public.css" rel="stylesheet"/>
    <link href="<?=MAIN_CSS?>main.css" rel="stylesheet"/>
    <script>
        if(localStorage.getItem("dark_mode") == '1'){
            var headID = document.getElementsByTagName('head')[0];
            var link = document.createElement('link');
            link.type = 'text/css';
            link.rel = 'stylesheet';
            link.id = 'dark_mode';
            headID.appendChild(link);
            link.href = '\\main\\css\\dark-main.css';
        }
    </script>
    <script src="<?=PUBLIC_JS?>jquery-3.3.1.min.js"></script>
</head>
<body>