<div id="reply_to_problem_box">
    <h3 class="main-color"><?=$this->__("user.problems.write_a_msg")?></h3>
    <form action="/user/problem/reply" method="POST">
        <?=$this->_token();?>
        <input type="hidden" name="prob_id" value="<?=$this->problem_content[0]['problem_id']?>"/>
        <textarea type="text" name="prob_msg" class="border-main-color form-control main-textarea" placeholder="<?=$this->__("user.problems.write_a_msg")?>" required="required"></textarea>
        <button class="btn main-btn"><?=$this->__("user.problems.reply")?></button>
    </form>
</div>
<section class="chat content text-center">
    <div class="close_prob_parent text-<?=$this->__("settings.align")?>">
        <form action="/user/problem/close_problem" method="POST" style="display:inline">
            <?=$this->_token();?>
            <input type="hidden" name="prob_id" value="<?=$this->problem_content[0]['problem_id']?>"/>
            <button class="btn btn-danger"><?=$this->__("user.problems.close_problem")?></button>
        </form>
        <button class="btn main-btn reply_to_problem"><?=$this->__("user.problems.reply")?></button>
    </div>
    <div class="all_problems text-<?=$this->__("settings.align")?>">
        <?php foreach($this->problem_content as $msg): ?>
        <?php if($this->is_from_admin($msg['msg_from'])): ?>
        <div class="problem_parent active-chat">
            <div class="info">
                <span class="name">Admin</span>
            </div>
            <p class="last_message">
                <?=$msg['message_content']?>
            </p>
        </div>
        <?php else:?>
        <div class="problem_parent">
            <div class="info">
                <span class="name">Me</span>
            </div>
            <p class="last_message">
                <?=$msg['message_content']?>
            </p>
        </div>
        <?php endif;?>
        <?php endforeach;?>
    </div>
</section>