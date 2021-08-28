<?php $this->get_message();?>
<section class="forget_pass-section text-center mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="forget_pass-text text-center">
                    <h1 class="h4 text-center">
                        <?=$this->__('main.confirm_code.type-code')?>
                    </h1>
                    <form id="forget_pass_form" action="" method="POST">
                        <?=$this->_token();?>
                        <div class="form-group">
                            <input class="form-control border-main-color" name="full_name" placeholder="<?=$this->__('main.confirm_code.code-placeholder')?>" type="text" required="required"/>
                        </div>
                        <div class="resend">
                            <a href="/main/signup/resend_code" class="main-color"><?=$this->__("main.confirm_code.resend-code")?></a>
                        </div>
                        <br>
                        <button class="main-btn login-btn" type="submit">
                            <?=$this->__('main.confirm_code.confirm-code')?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
