<?=$this->get_message()?>
<section class="contact_us-section special text-center mt-5">
  <div class="contact_us-text text-center">
    <h1 class="h2 text-center main-color"><b><?=$this->__('main.contact-us.contact-us-h')?></b></h1>
    <form id="contact_form" action="/user/contact_us/contact_us_process" method="POST">
      <?=$this->_token()?>
      <div class="form-group">
        <input class="border-main-color form-control" name="full_name" placeholder="<?=$this->__('main.contact-us.full-name')?>" type="text" required="required" value="<?=$this->get_session("full_name")?>"/>
      </div>
      <div class="form-group">
          <input class="border-main-color form-control" name="subject" placeholder="<?=$this->__('main.contact-us.subject')?>" type="text" required="required"/>
      </div>
      <div class="form-group">
          <input class="border-main-color form-control" name="email" placeholder="<?=$this->__('main.contact-us.email')?>" type="text" required="required" value="<?=$this->get_session("email")?>"/>
      </div>
      <div class="form-group">
        <textarea required="required"
          class="border-main-color form-control main-textarea"
          name="message"
          placeholder="<?=$this->__('main.contact-us.message')?>"
        ></textarea>
      </div>
      <button class="btn main-btn" type="submit"><?=$this->__('main.contact-us.submit-btn')?></button>
    </form>
  </div>
</section>
