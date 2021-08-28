<?=$this->get_message()?>
<section class="signup-section special text-center mt-5" style="margin-top: 10vw;">
  <div class="signup-text text-center">
    <h1 class="h2 text-center main-color" style="margin-bottom:20px"><b><?=$this->__('user.profile.profile-h')?></b></h1>
    <form id="contact_form" action="/user/profile/update" method="POST">
      <?=$this->_token()?>
      <div class="form-group">
        <input class="border-main-color form-control" name="full_name" placeholder="<?=$this->__('user.profile.name')?>" type="text" required="required" value="<?=$this->get_session("full_name")?>"/>
      </div>
      <div class="form-group">
          <input class="border-main-color form-control" name="email" placeholder="<?=$this->__('user.profile.email')?>" type="text" required="required" value="<?=$this->get_session("email")?>"/>
      </div>
      <div class="form-group">
          <input class="border-main-color form-control" name="pass" placeholder="<?=$this->__('user.profile.pass')?>" type="password"/>
      </div>
      <div class="form-group">
          <input class="border-main-color form-control" name="cnfrm-pass" placeholder="<?=$this->__('user.profile.cnfrm-pass')?>" type="password"/>
      </div>
      <div class="form-group" style="position:relative">
          <input class="border-main-color form-control" id="birthdate" name="birthdate" type="date" required="required" value="<?=$this->get_session("birthdate")?>"/>
          <label id="birthdate-label" style="text-align: <?=$this->__('settings.align')?>;<?=$this->__('user.profile.birthdate-pos')?>padding-<?=$this->__('settings.align')?>: 10px;"><?=$this->__('user.profile.birthdate')?></label>
      </div>
      <div class="form-group">
          <input class="border-main-color form-control" name="city" placeholder="<?=$this->__('user.profile.city')?>" type="text" required="required" value="<?=$this->get_session("city")?>"/>
      </div>
      <div class="form-group">
          <select style="padding-top: 0px;" required="required" class="border-main-color form-control" name="gender" id="gender">
              <option value="" selected disabled="disabled"><?=$this->__('user.profile.gender')?></option>
              <option value=<?=MALE?> <?=$this->get_session("gender") == MALE ? "selected" : "" ?> ><?=$this->__('user.profile.male')?></option>
              <option value=<?=FEMALE?> <?=$this->get_session("gender") == FEMALE ? "selected" : "" ?>><?=$this->__('user.profile.female')?></option>
              <option value=<?=OTHER?> <?=$this->get_session("gender") == OTHER ? "selected" : "" ?>><?=$this->__('user.profile.other')?></option>
          </select>
      </div>
      <button class="main-btn" type="submit" style="padding:10px"><?=$this->__('user.profile.save')?></button>
    </form>
  </div>
</section>
