<?=$this->get_message();?>
<?php if(!$this->is_listener()):?>
    <div id="fixed-overlay"></div>
    <div id="listener_closed_chat" class="popup_form">
        <h2 class="main-color"><?=$this->__("user.chat_component.listener_close_chat")?></h2>
        <p><?=$this->__("user.chat_component.listener_closed_chat_p")?></p>
        <a class="btn main-btn" href="/user/index">Ok</a>
    </div>
<?php endif;?>
<div id="report_chat_form" class="popup_form">
    <h3 class="main-color"><?=$this->__("user.chat_component.report_reason")?></h3>
    <form method="POST" action="/user/problem/new_problem">
        <?=$this->_token();?>
        <input type="hidden" name="conversation_id" value="<?=$this->messages[0]['conversation_id']?>"/>
        <textarea name="report_msg" placeholder="<?=$this->__("user.chat_component.report_reason")?>" class="border-main-color form-control main-textarea" required="required"></textarea>
        <button name="Open Problem" class="btn main-btn"><?=$this->__("user.chat_component.report_btn")?></button>
    </form>
</div>
<div id="close_chat_form" class="popup_form">
    <h3 class="main-color"><?=$this->__("user.chat_component.are_u_sure")?></h3>
    <form method="POST" action="/user/index/close_chat">
        <?php if(!$this->is_listener):?>
            <p><?=$this->end_of_chat_text?></p>
            <h6 class="main-color"><?=$this->__("user.chat_component.join_to_listener")?></h6>
            <p><?=$this->__("user.chat_component.rate_listener")?></p>
            <ul id="rate_listener" class="main-color list-unstyled">
                <li data-value="1">
                    <i class="far fa-star"></i>
                </li>
                <li data-value="2">
                    <i class="far fa-star"></i>
                </li>
                <li data-value="3">
                    <i class="far fa-star"></i>
                </li>
                <li data-value="4">
                    <i class="far fa-star"></i>
                </li>
                <li data-value="5">
                    <i class="far fa-star"></i>
                </li>
            </ul>
            <input id="listener_rate_inpt" type="hidden" value="1" name="rating"/>
        <?php endif;?>
            <?=$this->_token();?>
        <button title="Close Chat" type="submit" class="btn btn-danger need_confirm"><?=$this->__("user.chat_component.close_chat")?></button>
        <button title="Cancel" id="cancel_close_chat" type="button" class="btn main-btn"><?=$this->__("user.chat_component.cancel_close")?></button>
    </form>
</div>
<div class="chat_content_parent">
    <div class="top-info">
        <div class="main-color fa-mysize pull-<?=$this->__("settings.reverse-align")?>">
            <span class="rating">
            <?php if(!$this->is_listener):?>
                <?php $this->get_rating() ?>
            <?php endif; ?>
            </span>
            <div class="chat_action_parent">
                <i class="fas fa-ellipsis-v" id="caht_action"></i>
                <ul class="list-unstyled" id="chat_actions" style="<?=$this->__("settings.reverse-align")?>:0">
                    <li class="chat_action" id="report_chat"><?=$this->__("user.chat_component.report_chat")?></li>
                    <li class="chat_action" id="close_chat"><?=$this->__("user.chat_component.close_chat")?></li>
                </ul>
            </div>
        </div>
        <div class="h4 text-<?=$this->__("settings.align")?> main-color">
            <span>User</span>
        </div>
    </div>
        <?php if(!empty($this->messages)):?>
        <div id="load_more_msgs" class="load_more_msgs">
            <p class="lead"><?=$this->__("user.chat_component.load_more")?></p>
        </div>
        <div class="chat_content">
        <?php foreach($this->messages as $msg): ?>
            <?php if($this->is_message_mine($msg)) : ?>
            <div class="pull-<?=$this->__("settings.align")." me"?>" style="padding-<?=$this->__("settings.align")?>:8vw;">
                <span class="avatar img-circle"><?=$this->my_avatar?></span>
                <p class="msg-content lead" style="padding-<?=$this->__("settings.align")?>:20px;border-top-<?=$this->__("settings.align")?>-radius:0">
                    <?=nl2br($msg["message_content"])?>
                </p>
            </div>
            <?php else:?>
            <div class="pull-<?=$this->__("settings.reverse-align")?> other-side" style="padding-<?=$this->__("settings.reverse-align")?>:8vw;">
                <span class="avatar img-circle"><?=$this->other_side_avatar?></span>
                <p class="msg-content lead" style="border-top-<?=$this->__("settings.reverse-align")?>-radius:0">
                    <?=nl2br($msg["message_content"])?>
                </p>
            </div>
            <?php endif;?>
        <?php endforeach;?>
        </div>
        <?php else:?>
        <div class="chat_content">
            <div class="text-center no_messages">
                <p class="lead">There Is No Messages Yet</p>
            </div>
        </div>
        <?php endif;?>
    <form id="message_sender" action="">
        <div class="form-group">
            <textarea class="border-main-color form-control" name="msg" id="msg-inpt" placeholder="<?=$this->__("user.chat_component.send-ms-ph")?>" required="required"  oninvalid='this.setCustomValidity('<?=$this->__("user.chat_component.type_your_msg")?>')' style="border-<?=$this->__("settings.reverse-align")?>: none;"></textarea>
            <div>
                <button title="Send Message" class="border-main-color tranparent-btn" style="<?=$this->__("settings.reverse-align")?>:0;border-<?=$this->__("settings.align")?>: none;">
                    <i class="fas fa-paper-plane fa-2x main-color"></i>
                </button>
            </div>
        </div>
    </form>
</div>
<?php $this->fire_component("chat");?>