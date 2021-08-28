<?php $this->get_message();?>
<section class="signup-section text-center mt-5">
  <div class="container">
    <div class="row">
      <?php if($this->__('settings.align') == "right") :?>
      <div class="col-md-6">
        <img
          class="has_dark signup-img"
          src="<?=MAIN_IMGS?>user-signup<?=DS?>undraw_Forms_re_pkrt.svg"
          alt="signup"
        />
      </div>
      <?php endif; ?>
      <div
        class="col-md-4 custom-form-parent <?=$this->__('settings.align') == "right" ? 'col-md-offset-2' : '' ?> text-<?=$this->__('settings.align')?>">
        <div class="signup-text text-center">
          <h1 class="h2 text-center main-color"><b><?=$this->__('main.user-signup.signup-h')?></b></h1>
          <div class="signup-options-parent">
              <div class="signup-options">
                  <a id="fb-login-button" class="fb-login-button"  data-size="medium" data-button-type="login_with" data-layout="rounded" data-auto-logout-link="false" data-use-continue-as="true" href="#">
                    <i class="fab fa-facebook-f fa-2x"></i>
                  </a>
                  <div class="g-signin2" data-onsuccess="onSignIn"></div>
              </div>
              <p><?=$this->__('main.user-signup.signup-options')?></p>
          </div>
          <form id="contact_form" action="/main/signup/signup_process" method="POST">
            <?=$this->_token();?>
            <div class="form-group">
              <input class="border-main-color form-control" name="full_name" placeholder="<?=$this->__('main.user-signup.signup-full-name')?>" type="text" required="required"/>
            </div>
            <div class="form-group">
                <input class="border-main-color form-control" name="email" placeholder="<?=$this->__('main.user-signup.signup-email')?>" type="text" required="required"/>
            </div>
            <div class="form-group">
                <input class="border-main-color form-control" name="pass" placeholder="<?=$this->__('main.user-signup.signup-pass')?>" type="password" required="required"/>
            </div>
            <div class="form-group">
                <input class="border-main-color form-control" name="cnfrm-pass" placeholder="<?=$this->__('main.user-signup.signup-cnfrm-pass')?>" type="password" required="required"/>
            </div>
            <div class="form-group" style="position:relative">
                <input class="border-main-color form-control" id="birthdate" name="birthdate" placeholder="<?=$this->__('main.user-signup.signup-birth-date')?>" type="date" required="required"/>
                <label style="<?=$this->__('settings.align')?>: 4%;text-align: <?=$this->__('settings.align')?>;" id="birthdate-label"><?=$this->__('main.user-signup.signup-birth-date')?></label>
            </div>
            <div class="form-group" style="position:relative">
                <input class="border-main-color form-control" id="city" name="city" placeholder="<?=$this->__('main.user-signup.signup-city')?>" type="text" required="required"/>
            </div>
            <div class="form-group">
                <select style="padding-top: 0px;" required="required" class="border-main-color form-control" name="gender" id="gender">
                    <option value="" selected disabled="disabled"><?=$this->__('main.user-signup.signup-gender')?></option>
                    <option value="<?=MALE?>"><?=$this->__('main.user-signup.signup-male')?></option>
                    <option value="<?=FEMALE?>"><?=$this->__('main.user-signup.signup-female')?></option>
                    <option value="<?=OTHER?>"><?=$this->__('main.user-signup.signup-other')?></option>
                </select>
            </div>
            <label class="agree-terms" for="terms"><?=$this->__('main.user-signup.agree')?> <a target="_blank" class="main-color" href="/main/terms"><?=$this->__('main.user-signup.terms')?></a></label>
            <input type="checkbox" id="terms" required="required"/>
            <br>
            <button class="main-btn" type="submit"><?=$this->__('main.user-signup.signup-btn')?></button>
          </form>
        </div>
      </div>
      <?php if($this->__('settings.align') == "left") :?>
      <div class="col-md-6 col-md-offset-2">
        <img
          class="signup-img has_dark"
          src="<?=MAIN_IMGS?>user-signup<?=DS?>undraw_Forms_re_pkrt.svg"
          alt="air support"
        />
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>
<script>
  window.token = "<?=$this->get_session('hash_token')?>";
</script>
<script src="<?=MAIN_JS?>api.js"></script>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script src="<?=MAIN_JS?>handle_api.js"></script>