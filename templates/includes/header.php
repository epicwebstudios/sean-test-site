<? admin_bar(); ?>
<? notification_popups(); ?>
<? notification_banners(); ?>
<header class="header" id="header">
    <div class="wrapper">
        <div class="logo">
            <a href="<?= returnURL(0); ?>"><img src="<?= returnURL(). '/uploads/layout/'. $settings['logo_header']; ?>"/></a>
        </div>       
        <? horizontal_menu( 1 ); ?>
        <div class="toggle_mobile_menu"><span class="fa fa-bars"></span></div>
    </div>
</header>