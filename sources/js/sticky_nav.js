function sticky_nav(elem_header) {
    // settings
    const elem_header_top 			= $(elem_header).offset().top;
    const wrapper_element 			= 'nav-wrapper';				// wrap element in header of same size
    const use_placeholder			= true;							// put placeholder behind sticky nav
    const elem_header_to_get_bg		= elem_header+' .header-bottom' // element to get bg color
    const nav_transition			= 0;							// timeout to set when calculating nav height (nav transition)
    let element_height 				= $(elem_header).outerHeight();

    let elem_header_height = $(elem_header).outerHeight();

    // wrap nav
    $(elem_header).wrap('<div class="' + wrapper_element + '" style="height:' + elem_header_height + 'px;"></div>');

    // add styles
    $('<style type="text/css">'+elem_header+'{position:relative;width:100%;z-index:9999;}</style>').appendTo($('head'));
    $('<style type="text/css">'+elem_header+'.sticky{position:fixed;top:0;width:100%;z-index:9999;}</style>').appendTo($('head'));

    if (use_placeholder) {
        sticky_nav_resize_placeholder(elem_header, wrapper_element, element_height);

        // set placeholder color so it blends in
        $('.'+wrapper_element).css('background-color', $(elem_header_to_get_bg).css('background-color'));

        // on window resize
        $(window).resize(function() {
            setTimeout(function() {
                element_height = $(elem_header).outerHeight();

                sticky_nav_resize_placeholder(elem_header, wrapper_element, element_height);

            }, nav_transition);
        });
    }

    // activate on load
    sticky_nav_activate(elem_header, elem_header_top);

    // on scroll
    $(window).scroll(function() {
        sticky_nav_activate(elem_header, elem_header_top);
        sticky_nav_resize_placeholder(elem_header, wrapper_element, element_height);
    });
}

// resize placeholder
function sticky_nav_resize_placeholder(elem_header, wrapper_element, elem_height_orig) {

    // if scrolling, get height of header element and set wrapper height
    if ($(elem_header).hasClass('sticky'))
        $('.' + wrapper_element).css('height', $(elem_header).outerHeight() + 'px');
    // else if back at top, set wrapper height at original height (this is for navigation bars that change height on scroll)
    else
        $('.' + wrapper_element).css('height', elem_height_orig + 'px');

}

// toggle sticky
function sticky_nav_activate(elem_header, elem_header_top) {
    let window_top = $(window).scrollTop();
    let element_top = $(elem_header).position().top;

    if (window_top > elem_header_top && window_top > 0)
        $(elem_header).addClass('sticky');
    else
        $(elem_header).removeClass('sticky');
}