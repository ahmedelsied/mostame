<?=$this->get_message()?>
<section class="forget_pass-section text-center mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="forget_pass-text text-center">
                    <h1 class="h4 text-center">
                        <?=$this->__('main.forget_pass.type-mail')?>
                    </h1>
                    <form id="forget_pass_form" action="/main/forget_password/forget_pass" method="POST">
                        <?=$this->_token()?>
                        <div class="form-group">
                            <input class="form-control border-main-color" name="email" placeholder="<?=$this->__('main.forget_pass.email-placeholder')?>" type="text" required="required"/>
                        </div>
                        <br>
                        <button class="main-btn login-btn" type="submit">
                            <?=$this->__('main.forget_pass.send-code')?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
