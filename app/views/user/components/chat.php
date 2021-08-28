<?php
    
    $fh = fopen(STORAGE_PATH . 'forbidden_words.txt','r');
    $words = "";
    while ($line = fgets($fh)) {
        $words .= $line;
    }
    fclose($fh);
?>
<script>
    const message_sender = $("#message_sender");
    const chat_content = $('.chat_content');
    var message_content = null,
        avatar = null,
        textarea = message_sender.find("textarea"),
        msg_inpt = $("#msg-inpt");
    function send_message(){
        var data = JSON.stringify({
            'target':'send_message',
            'message_content':message_content,
            'conversation_id': "<?=$this->conversation_id?>",
            'sender_id': "<?=$this->get_session('id')?>"
        });
        return data;
    }
    msg_inpt.on("keypress",function(e){
        if (e.key == 'Enter' && !e.shiftKey) {
            e.preventDefault();
            message_sender.submit();
        }
    });
    <?php if($this->is_listener):?>
    $("#close_chat_form").on("submit",function(e){
        var data = JSON.stringify({
            'target':'send_closing_message',
            'conversation_id': "<?=$this->conversation_id?>",
            'sender_id': "<?=$this->get_session('id')?>"
        });
        window.socket.send(data);
    })
    <?php endif; ?>
    function listener_closed_chat(){
        $("#fixed-overlay").show();
        $("#listener_closed_chat").show();
    }
    message_sender.on("submit",function(e){
        e.preventDefault();
        msg_inpt.focus();
        message_content = textarea.val();
        if(check_content(message_content)){
            alert("<?=$this->__("user.chat_component.bad_words")?>")
            return;
        }
        if(message_content.length == 0){
            alert("Please Write A Message !");
            return;
        }
        window.socket.send(send_message());
    });
    function check_content(message_content){
        var bad_words = "<?=trim($words)?>";
        bad_words = bad_words.split(",");
        for(var i=0;i<bad_words.length;i++){
            if(message_content.includes(bad_words[i])){
                return true;
            }
        }
        return false;
    }
    function message_sent(){
        check_if_its_first();
        set_avatar('.me');
        var html = '<div class="pull-<?=$this->__("settings.align")?> me" style="padding-<?=$this->__("settings.align")?>:8vw;">';
            html += '<span class="avatar img-circle">'+avatar+'</span>';
            html += '<p class="msg-content lead" style="padding-<?=$this->__("settings.align")?>:20px;border-top-<?=$this->__("settings.align")?>-radius:0">';
            html += nl2br(message_content)+'</p></div>';
        chat_content.append(html);
        textarea.val("");
        textarea.focus();
        scroll_to_bottom();
    }

    function new_message(data){
        check_if_its_first();
        set_avatar('.other-side');
        var html = '<div class="pull-<?=$this->__("settings.reverse-align")?> other-side" style="padding-<?=$this->__("settings.reverse-align")?>:8vw;">';
            html += '<span class="avatar img-circle">'+avatar+'</span>';
            html += '<p class="msg-content lead" style="border-top-<?=$this->__("settings.reverse-align")?>-radius:0">';
            html += nl2br(data.data[0])+'</p></div>';
        chat_content.append(html);
        scroll_to_bottom();
    }
    function not_authorized_to_send(){
        alert("You're not auherized to send message in this chat !");
    }

    function set_avatar(target){
        if($(target).length > 0){
            avatar = $('.chat_content '+target+' .avatar').eq(0).text();
        }else{
            avatar = generateRandomCharchters(1);
        }
    }
    function scroll_to_bottom(){
        var n = $(document).height();
        $('html, body').scrollTop(n);
    }
    
    function check_if_its_first(){
        var no_msg = $('.no_messages');
        if(no_msg.length > 0){
            no_msg.remove();
        }
    }
</script>
<!-- Load more messages -->
<!-- Need Refactor -->
<script>
    let load_more = $("#load_more_msgs"),
        offset = <?=SERVER_LIMIT?>;
    load_more.on("click",function(){
        data = {
            offset : offset,
            hash_token : "<?=$this->get_token()?>"
        }
        ajaxRequest("/user/index/load_more_messages","POST",data,"html",success_loading,failed_loading);
        offset+=<?=SERVER_LIMIT?>;
    });
    function success_loading(data){
        data = JSON.parse(data);
        if(data.length <= 0){
            load_more.remove();
            return;
        }
        for(i=0;i<data.length;i++){
            if(data[i]["sender_id"] == "<?=$this->get_session("id")?>"){
                var html = '<div class="pull-<?=$this->__("settings.align")?> me" style="padding-<?=$this->__("settings.align")?>:8vw;">';
                    html += '<span class="avatar img-circle"><?=$this->my_avatar?></span>';
                    html += '<p class="msg-content lead" style="border-top-<?=$this->__("settings.align")?>-radius:0">';
                    html += data[i]['message_content'];
                    html += '</p></div>';
            }else{
                var html = '<div class="pull-<?=$this->__("settings.reverse-align")?> other-side" style="padding-<?=$this->__("settings.reverse-align")?>:8vw;">';
                    html += '<span class="avatar img-circle"><?=$this->other_side_avatar?></span>';
                    html += '<p class="msg-content lead" style="border-top-<?=$this->__("settings.reverse-align")?>-radius:0">';
                    html += data[i]['message_content'];
                    html += '</p></div>';
            }
            chat_content.prepend(html);
        }
    }
    function failed_loading (){
        alert("failed");
    }
</script>