$(function(){
    // Search For Listener
    window.socket = new window.WebSocket("ws://localhost:8080/?page="+window.current_page+"&id="+window.user_id+"&permission="+window.permission+"&type=user&hash_token="+window._token);
    window.socket.onopen = function(){
        console.log("Socket Connection Is Open !");
    };
});