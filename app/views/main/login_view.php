<style>
    .login-section .form-group i{
        <?=$this->__('settings.align')?>:33.7%;
    }
    @media(max-width:992px){
        .login-section .form-group i{
            <?=$this->__('settings.align')?>:8px;
        }
        .login-section .forget-pass{
            width:63%;
        }
    }
</style>
<?=$this->get_message();?>
<section class="login-section text-center mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-md-<?=$this->__('settings.align')?>">
                <div class="login-text text-center">
                    <h1 class="h2 text-center main-color"><b><?=$this->__('main.login.login')?></b></h1>
                    <form id="login_form" action="/main/login/login_process" method="POST">
                        <?=$this->_token();?>
                        <div class="form-group">
                            <label class="login-fields text-<?=$this->__('settings.align')?>"><?=$this->__('main.login.email')?></label>
                            <i class="fa fa-user main-color"></i>
                            <input style="padding-<?=$this->__('settings.align')?>: 30px;" class="form-control border-main-color" name="email" placeholder="<?=$this->__('main.login.email-placeholder')?>" type="text" required="required"/>
                        </div>
                        <div class="form-group">
                            <label class="login-fields text-<?=$this->__('settings.align')?>"><?=$this->__('main.login.password')?></label>
                            <i class="fa fa-lock main-color"></i>
                            <input style="padding-<?=$this->__('settings.align')?>: 30px;" class="form-control border-main-color" name="pass" placeholder="<?=$this->__('main.login.password-placeholder')?>" type="password" required="required"/>
                        </div>
                        <p class="forget-pass text-<?=$this->__('settings.align')?>">
                            <a class="main-color" href="/main/forget_password"><?=$this->__('main.login.forget-pass')?></a>
                        </p>
                        <br>
                        <div class="text-center">
                            <button class="main-btn login-btn" type="submit"><?=$this->__('main.login.login-btn')?></button>
                        </div>
                    </form>
                    <div class="login-options-parent">
                        <p><?=$this->__('main.login.login-options')?></p>
                        <div class="signup-options-parent">
                            <div class="signup-options">
                                <a style="padding-top:4px" id="fb-login-button" class="fb-login-button hidden"  data-size="medium" data-button-type="login_with" data-layout="rounded" data-auto-logout-link="false" data-use-continue-as="true" href="#"><i class="fab fa-facebook-f fa-2x"></i></a>
                                <div class="g-signin2" data-onsuccess="onSignIn"></div>
                            </div>
                        </div>
                    </div>
                    <?=$this->__("main.login.not_registered")?>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
  window.token = "<?=$this->get_token()?>";
</script>
<script src="<?=MAIN_JS?>api.js"></script>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script src="<?=MAIN_JS?>handle_api.js"></script>