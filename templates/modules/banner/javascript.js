window.onload = function() {

    function resize_banner_video() {
        const $banner       = $('.banner');
        const $banner_video = $('.banner .banner-video');

        let container_height   = $banner.height();
        let container_width    = $banner.width();

        let window_ratio    = container_width / container_height;
        let ratio           = 16 / 9;

        let height, width;

        // if window ratio > target ratio
        if (window_ratio > ratio) {
            width   = container_width;
            height  = width * ratio;
        } else {
            height  = container_height;
            width   = height * ratio;
        }

        $banner_video.css('height', height+'px');
        $banner_video.css('width', width+'px');
    }

    jQuery_defer(function() {

        $(document).ready(function() {
            resize_banner_video();
        });

        $(window).resize(function() {
            resize_banner_video();
        });
    });

}