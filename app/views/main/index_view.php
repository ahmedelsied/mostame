<section class="home-section text-center">
    <div class="container">
        <div class="custom_wrap">
                <div class="order">
                    <img src="<?=MAIN_IMGS?>index<?=DS?>undraw_friendship_mni7-600.svg"
                        sizes="(min-width:1200px) 600px,
                                (min-width:768px) 400px,
                                (max-width:768px) 150px
                                "
                        srcset="<?=MAIN_IMGS?>index<?=DS?>undraw_friendship_mni7-600.svg 600w,
                                <?=MAIN_IMGS?>index<?=DS?>undraw_friendship_mni7-400.svg 400w,
                                <?=MAIN_IMGS?>index<?=DS?>undraw_friendship_mni7-150.svg 150w
                                "
                        alt="friendship">
                </div>
                <div class="home-text main text-<?=$this->__("settings.align");?>-lg">
                    <h1 class="h2 main-color"><b><?=$this->main_text?></b></h1>
                    <p class="bio"><?=$this->__('main.index.bio')?></p>
                    <div class="action">
                        <a href="<?=DOMAIN?>/main/login" class="btn secondary-btn"><?=$this->__('main.index.find-listener')?></a>
                    </div>
                </div>
        </div>
    </div>
</section>