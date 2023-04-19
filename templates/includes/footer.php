<footer class="footer">
    <div class="wrapper">
        <div class="w_50">
            <div id="search_div">
                <form action="https://www.google.com/search" method="get" target="_blank">
                    <input type="text" placeholder="Search..." name="q">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <div class="logo">
                <a href="<?= returnURL(0); ?>"><img src="<?= returnURL(). '/uploads/layout/'. $settings['logo_footer']; ?>"/></a>
            </div>    
            <span class="copy"> <? year(); ?> &copy; Sean M. Temple</span><?= $settings['name']; ?>
            
        </div>
        <div class="w_50 footer_nav">
            <div class="w_33" id="footer_nav1">
                <h5>Navigation</h5>
                <? vertical_menu( 2 ); ?>
            </div>
            <div class="w_33">
                <h5 id="gallery_header">Galleries</h5>
                <? vertical_menu( 3 ); ?>
            </div>
            <div class="w_33">
                <h5>Business Location</h5>
                <?= location_address(); ?><br>
                <?= location_address_2(); ?><br>
                <?= location_city(); ?>, <?= location_state(); ?> <?= location_zip(); ?><br>
            </div>
        </div>
    </div>
</footer>