<?php $this->get_message();?>
<section class="confirm_code-section special text-center">
    <div class="parent">
        <div class="col-md-12 text-center">
            <div class="forget_pass-text text-center">
                <h1 class="h4 text-center">
                    <?=$this->__('main.confirm_code.type-code')?>
                </h1>
                <form id="confirm_code_form" action="/user/active_account/active_account" method="POST">
                    <?=$this->_token();?>
                    <div class="form-group">
                        <input class="form-control border-main-color" name="code" placeholder="<?=$this->__('main.confirm_code.code-placeholder')?>" type="text" required="required"/>
                    </div>
                    <br>
                    <button class="btn main-btn login-btn" type="submit">
                        <?=$this->__('main.confirm_code.confirm-code')?>
                    </button>
                </form>
            </div>
            <form action="/user/active_account/resend_code" method="post">
                <?=$this->_token();?>
                <div class="resend">
                    <button type="submit" class="main-color"><?=$this->__("main.confirm_code.resend-code")?></button>
                </div>
            </form>
            <?php if(!empty($this->code_resend_time)) :?>
            <p style="margin-top: 15px;"><?=$this->__("main.confirm_code.interval_text");?><span id="code_interval"><?=$this->code_resend_time;?></span> <?=$this->__("main.confirm_code.second");?> </p>
            <?php endif;?>
        </div>
    </div>
</section>
