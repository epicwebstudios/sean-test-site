jQuery_plugin_defer('ews_slider', function() {
    $('.testimonial_module.feed.slider[data-id="<?= $category_id ?>"]').ews_slider({
	    mode:'slider',
        delay:4000,
        arrows:true,
        loop:true,
	    slidesToShow:1,
        slidesToScroll:1,
	    auto:true,
    });
});