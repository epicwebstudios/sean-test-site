jQuery_plugin_defer('ews_slider', function() {
    $('.gallery_module.gallery.slider[data-id="<?= $gallery_id ?>"]').ews_slider({
        mode:'slider',
        delay:4000,
        arrows:true,
        loop:true,
        slidesToShow:3,
	    slidesToScroll:3,
        dots:true,
        responsive:{
	        825:{
		        slidesToShow:2,
		        slidesToScroll:2,
	        },
	        550:{
		        slidesToShow:1,
		        slidesToScroll:1,
	        },
        },
    });
});