//Function To Search In User Interface
function search(input,table){
    $(input).on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(table).filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
}

// Is Empty
function isEmpty(value){
    return value == '' ? true : false
}

// Generate Random Letter From A To Z
function generateRandomCharchters(n) {
  return Array(n)
    .fill(null)
    .map(() => Math.random()*100%25 + 'A'.charCodeAt(0))
    .map(a => String.fromCharCode(a))
    .join('')
}


function nl2br (str, is_xhtml) {
  if (typeof str === 'undefined' || str === null) {
      return '';
  }
  var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
  return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}


$(function(){
  $("body").on("click submit",".need_confirm",function(e){
    var cnfrm = confirm("Are You Sure ?");
    if(!cnfrm){
        e.preventDefault();
    }
  });
});
// Handle Ajax Request
function ajaxRequest(url,requestMethod,inptData,dataType,successFunc,errorFunc){
    $.ajax({
        url:url,
        type:requestMethod,
        data:inptData,
        dataType:dataType,
        success:function(data){
            if(typeof(successFunc) == 'function'){
                successFunc(data);
            }
        },
        error:function(data){
            if(typeof(errorFunc) == 'function'){
                errorFunc(data);
            }
        }
    });
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }

// Remove Post Data Afer Send
if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}