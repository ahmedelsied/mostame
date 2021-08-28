// Init FB Script
(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) { return; }
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v10.0&appId=154753999925185&autoLogAppEvents=1";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

window.fbAsyncInit = function () {
    FB.init({
        appId: '154753999925185',
        cookie: true,
        xfbml: true,
        version: 'v10.0'
    });
}

// Google Login Function
var firstTime = true;
function onSignIn(googleUser) {
    if (firstTime) { firstTime = false; return; }
    if(location.href.split("/").indexOf("listener_signup") != -1) {
        var target = "listener_signup"
    }else{
        var target = location.href.split("/").indexOf("login") != -1 ? "login" : "signup";
    }
    var profile = googleUser.getBasicProfile(),
        name = profile.getName(),
        email = profile.getEmail();
    ajaxRequest("/main/"+target+"/"+target+"_with_google", "POST", { "name": name, "email": email, "hash_token": window.token }, "html", onAPISuccess, onAPIFailed);
}