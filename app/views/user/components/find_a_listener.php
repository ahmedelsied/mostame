<script>
    const find_listener = $("#find_listener");
    function find_a_listener(){
        var data = JSON.stringify({
            'target':'find_a_listener',
            'id': "<?=$this->get_session('id')?>"
        });
        return data;
    }

    find_listener.on("click",function(e){
        e.preventDefault();
        window.socket.send(find_a_listener())
    });

    function user_in_queue(){
        var backend_msg = "<div id='searching_listener' class='success-backend-message backend-message'><?=$this->__("backend_messages.messages.search_about_listener")?></div>";
        $('body').prepend(backend_msg);
        setTimeout(function(){
            $("#searching_listener").remove();
        }, 10000);
    }

    function not_available(){
        alert("This Action Not Available Now !\nIf You're Already Clicked Before You Just Have To Wait");
    }
</script>