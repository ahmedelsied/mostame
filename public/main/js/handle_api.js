    // Init FB API
    function testAPI() {                      // Testing Graph API after login.  See statusChangeCallback() for when this call is made.
        if(location.href.split("/").indexOf("listener_signup") != -1) {
            var target = "listener_signup"
        }else{
            var target = location.href.split("/").indexOf("login") != -1 ? "login" : "signup";
        }
        query = target == "login" ? "name,email" : "name,email,birthday,hometown,gender";
        FB.api('/me?fields='+query, function(response) {
            response.hash_token = window.token;
            ajaxRequest("/main/"+target+"/"+target+"_with_facebook","POST",response,"html",onAPISuccess,onAPIFailed);
        });
    }
    $("#fb-login-button").on('click',function(e){
        e.preventDefault();
        FB.login(function(response) {
            if(response['status'] != "connected"){
                alert("Something Is Wrong !");
                return;
            }
            testAPI();
        }, {scope: 'public_profile,email'});
    });
    function onAPISuccess(response){
        if(/danger/i.test(response)) {
          $('body').prepend(response);
          setTimeout(() => {
            $('.backend-message').remove();
          }, 3000);
          return;
        }
        location.reload();
    }
    function onAPIFailed(response){
      alert("Something Is Wrong");
    }