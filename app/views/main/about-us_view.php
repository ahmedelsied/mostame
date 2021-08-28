<style>
    @media (min-width:992px) {
        .order{
            width: 50%;
        }
    }
</style>
<section class="about_us-section text-center mt-5">
    <div class="container">
        <div class="custom_wrap">
            <div class="order">
                <img class="has_dark" src="<?=MAIN_IMGS?>about-us<?=DS?>undraw_about_me_wa29.svg" alt="about-us">
            </div>
            <div class="text-<?=$this->__('settings.align')?>" style="padding-right:40px">
                <div class="about_us-text">
                    <h1 class="h2 main-color"><b><?=$this->__('main.about-us.about_us-text')?></b></h1>
                    <p class="about_us-desc"><?=$this->about_us_text?></p>
                </div>
            </div>
        </div>
    </div>
</section>