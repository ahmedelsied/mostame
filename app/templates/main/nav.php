		<!--Start Navbar-->	
		<nav class="navbar navbar-default" role="navigation">
		    <div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#ournavbar" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand hvr-pulse-shrink" href="<?=DOMAIN?>"><img src="<?=IMGS?>logo.png" alt="Logo"></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="ournavbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li <?=$this->active_page == 'home' ? 'class="active"' : "" ?>><a href="/main/index"><?=$this->__('main.nav.home')?></a></li>
                        <li <?=$this->active_page == 'about_us' ? 'class="active"' : "" ?>><a href="/main/about_us"><?=$this->__('main.nav.about_us')?></a></li>
                        <li <?=$this->active_page == 'contact_us' ? 'class="active"' : "" ?>><a href="/main/contact_us"><?=$this->__('main.nav.contact_us')?></a></li>
                        <li <?=$this->active_page == 'login' ? 'class="active"' : "" ?>><a href="/main/login"><?=$this->__('main.nav.login')?></a></li>
                        <li <?=$this->active_page == 'signup' ? 'class="active"' : "" ?>><a href="/main/signup"><?=$this->__('main.nav.signup')?></a></li>
                        <li <?=$this->active_page == 'listener_signup' ? 'class="active"' : "" ?>><a class="btn main-btn be-listener" href="/main/listener_signup"><?=$this->__('main.nav.be_a_listner')?></a></li>
                        <li>
                            <a id="display-setting" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 44 44">
                                    <g id="Icon_feather-settings" data-name="Icon feather-settings" transform="translate(0.5 0.5)">
                                        <path id="Path_331" data-name="Path 331" d="M22.5,18A4.5,4.5,0,1,1,18,13.5,4.5,4.5,0,0,1,22.5,18Z" transform="translate(3.5 3.5)" fill="none" stroke="#4c61d5" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
                                        <path id="Path_332" data-name="Path 332" d="M34.955,26.955a3,3,0,0,0,.6,3.309l.109.109a3.638,3.638,0,1,1-5.145,5.145l-.109-.109a3.024,3.024,0,0,0-5.127,2.145v.309a3.636,3.636,0,1,1-7.273,0V37.7a3,3,0,0,0-1.964-2.745,3,3,0,0,0-3.309.6l-.109.109a3.638,3.638,0,1,1-5.145-5.145l.109-.109a3.024,3.024,0,0,0-2.145-5.127H5.136a3.636,3.636,0,1,1,0-7.273H5.3a3,3,0,0,0,2.745-1.964,3,3,0,0,0-.6-3.309l-.109-.109a3.638,3.638,0,1,1,5.145-5.145l.109.109a3,3,0,0,0,3.309.6h.145a3,3,0,0,0,1.818-2.745V5.136a3.636,3.636,0,1,1,7.273,0V5.3a3.024,3.024,0,0,0,5.127,2.145l.109-.109a3.638,3.638,0,1,1,5.145,5.145l-.109.109a3,3,0,0,0-.6,3.309v.145a3,3,0,0,0,2.745,1.818h.309a3.636,3.636,0,1,1,0,7.273H37.7a3,3,0,0,0-2.745,1.818Z" fill="none" stroke="#4c61d5" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
                                    </g>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
		</nav>
		<!--End Navbar-->
		<!--Start Display Settings-->
        <div class="overlay" data-action="hideDisplaySettings"></div>
        <div class="display-setting-parent" style="direction: ltr;">
            <h2 class="main-color"><b>Display Settings</b></h2>
            <div class="text-left">
                <div class="mode-parent">
                    <h5><b>Mode</b></h5>
                    <div class="setting-child" id="mode-parent" data-action="changeTheme">
                        <span class="active-action" id="mode"></span>
                        <span class="action">
                            <i class="far fa-moon fa-mysize"></i>
                        </span>
                        <span class="action last-ac">
                            <svg id="Icon_feather-sun" data-name="Icon feather-sun" xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 36 36">
                                <path id="Path_322" data-name="Path 322" d="M25.5,18A7.5,7.5,0,1,1,18,10.5,7.5,7.5,0,0,1,25.5,18Z" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/>
                                <path id="Path_323" data-name="Path 323" d="M18,1.5v3" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/>
                                <path id="Path_324" data-name="Path 324" d="M18,31.5v3" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/>
                                <path id="Path_325" data-name="Path 325" d="M6.33,6.33,8.46,8.46" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/>
                                <path id="Path_326" data-name="Path 326" d="M27.54,27.54l2.13,2.13" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/>
                                <path id="Path_327" data-name="Path 327" d="M1.5,18h3" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/>
                                <path id="Path_328" data-name="Path 328" d="M31.5,18h3" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/>
                                <path id="Path_329" data-name="Path 329" d="M6.33,29.67l2.13-2.13" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/>
                                <path id="Path_330" data-name="Path 330" d="M27.54,8.46l2.13-2.13" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/>
                            </svg>
                        </span>
                    </div>
                </div>
                <br>
                <div class="language-parent">
                    <h5><b>Language</b></h5>
                    <div class="setting-child" id="langs" data-action="changeLang" data-lang="">
                        <span class="active-action" <?=$this->__('settings.align') == 'right' ? 'style="left:50%"' : "no"?>></span>
                        <span class="action <?=$this->__('settings.align') == 'right' ? 'live' : ''?>"><b>AR</b></span>
                        <span class="action last-ac <?=$this->__('settings.align') == 'left' ? 'live' : ''?>"><b>EN</b></span>
                    </div>
                </div>
            </div>
        </div>
		<!--End Display Settings-->