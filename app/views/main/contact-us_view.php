<?=$this->get_message();?>
<style>
  @media (min-width:992px) {
    .contact_us_parent{
      width:50%;
      padding-right: 40px
    }
    .contact_us-section .contact_us-img{
      margin-top:50px;
    }
  }
</style>
<section class="contact_us-section text-center mt-5">
  <div class="container">
    <div class="custom_wrap">
      <div class="order">
        <img
          class="contact_us-img"
          src="<?=MAIN_IMGS?>contact-us<?=DS?>undraw_contact_us_15o2.svg"
          alt="contact_us"
        />
      </div>
      <div class="text-md-<?=$this->__('settings.align')?> contact_us_parent">
        <div class="contact_us-text text-center">
          <h1 class="h2 text-center main-color"><b><?=$this->__('main.contact-us.contact-us-h')?></b></h1>
          <form id="contact_form" action="/main/contact_us/contact_us_process" method="POST">
            <?=$this->_token();?>
            <div class="form-group">
              <input class="border-main-color form-control" name="full_name" placeholder="<?=$this->__('main.contact-us.full-name')?>" type="text" required="required"/>
            </div>
            <div class="form-group">
                <input class="border-main-color form-control" name="subject" placeholder="<?=$this->__('main.contact-us.subject')?>" type="text" required="required"/>
            </div>
            <div class="form-group">
                <input class="border-main-color form-control" name="email" placeholder="<?=$this->__('main.contact-us.email')?>" type="text" required="required"/>
            </div>
            <div class="form-group">
              <textarea required="required"
                class="border-main-color form-control main-textarea"
                name="message"
                placeholder="<?=$this->__('main.contact-us.message')?>"
              ></textarea>
            </div>
            <button class="main-btn" type="submit"><?=$this->__('main.contact-us.submit-btn')?></button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
