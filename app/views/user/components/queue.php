<script>
    var queue = $('.all_queue'),
        load_more_queue = $("#load_more_queue");
    function new_user(data){
        var user_data = data.user_data,
            new_user = "<div  data-id="+user_data[0]+" class='queue text-<?=$this->__("settings.align")?>'>";
            new_user += "<span class='avatar'>"+generateRandomCharchters(1)+"</span>";
            new_user += "<span class='name main-color'><?=$this->__("user.queue.unknown")?></span>";
            new_user += "<button class='chat btn main-btn pull-<?=$this->__("settings.reverse-align")?>'><?=$this->__("user.queue.chat-action")?></button>";
            new_user += "</div>";
            $(".empty").remove();
            if(load_more_queue.length > 0) load_more_queue.before(new_user);
            else queue.append(new_user);
    }

    function start_chat(target_user_id){
        var data = JSON.stringify({
            'target':'start_chat',
            'target_user_id': target_user_id,
            'id': "<?=$this->get_session('id')?>",
        });
        return data;
    }

    function already_in_chat(){
        alert("Somthing Is Wrong !\nPlease Reload The Page.");
    }

    function remove_user_from_queue(data){
        var id = data.user_data;
        $(".queue[data-id="+id+"]").remove();
    }

    // Init Start Chat
    $('body').on("click",".chat",function(){
        var data = $(this).parent().data("id");
        window.socket.send(start_chat(data))
    });

    // Load More User In Queue
    var offset = <?=SERVER_LIMIT?>,
        limit = <?=SERVER_LIMIT?>;
    load_more_queue.on("click",function(){
        let data = {
            offset : offset,
            limit : limit,
            hash_token : "<?=$this->get_token()?>"
        };
        
        ajaxRequest("/user/queue/load_more_users","POST",data,"html",success_loading,failed_loading);
    });
    
    function render_new_queue(data){
        for(i=0;i<data.length;i++){
            var html = '<div data-id="'+data[i]['id']+'" class="queue text-<?=$this->__("settings.align")?>">';
                html += '<span class="avatar"><?=chr(rand(65,90));?></span>';
                html += '<span class="name main-color"><?=$this->__("user.queue.unknown")?></span>';
                html += '<button class="chat btn main-btn pull-<?=$this->__("settings.reverse-align")?>"><?=$this->__("user.queue.chat-action")?></button></div>';
                if(load_more_queue.length > 0) load_more_queue.before(html);
                else queue.prepend(html);
        }
    }

    function success_loading(data){
        data = JSON.parse(data)['data'];
        if(data.length == 0){
            alert("There is no more");
            load_more_queue.remove();
        }else{
            render_new_queue(data);
            offset+= <?=SERVER_LIMIT?>;
        }
    }

    function failed_loading(){
        alert("failed");
    }
</script>