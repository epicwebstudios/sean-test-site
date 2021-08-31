function add_to_admin_bar( button_text, link ){
	
	var output = '';
	
	output += '<a href="' + link + '" target="_blank" class="button">';
		output += button_text;
	output += '</a>';
	
	$( '#admin_bar' ).append( output );
	
	return;
	
}


function size_footer(){
	var height = $( '.footer' ).outerHeight();
	$( '.site_container' ).css( 'padding-bottom', height );
}


function toggle_mobile_menu(){
	if( $( '.menu_module.mobile' ).css( 'display' ) == 'block' ){
		$( 'body' ).css( 'overflow', 'auto' );
		$( '.menu_module.mobile' ).fadeOut( 'fast' );
	} else {
		$( 'body' ).css( 'overflow', 'hidden' );
		$( '.menu_module.mobile' ).fadeIn( 'fast' );
	}
}


$(document).ready( function(){
	
	size_footer();
	
	$( '.menu_module.mobile .item a' ).click( function(e){

        if($(this).hasClass('level_0')){
            $(this).parent().addClass('active');
        }

        if ($(this).parents('.active').length !== 0) {
            $('.level_0').removeClass('active');
            $(this).parents('.level_0').addClass('active');
        }

        $('.level_0:not(.active) .dropdown').hide();

		if( $(this).hasClass('has_children') ){
			e.preventDefault();
			var level = ( parseInt( $(this).attr('data-level') ) + 1 );
			var child = $( this ).parent().find( '.dropdown.level_' + level );
			if( child.css('display') == 'block' ){ child.hide(); } else { child.show(); }
		}
	});
	
	$( '.menu_module.mobile .close' ).click( function(){
		toggle_mobile_menu();
	});
	
	$( '.toggle_mobile_menu' ).click( function(){
		toggle_mobile_menu();
	});
	
});


$(window).resize( function(){
	size_footer();
});


setTimeout( function(){ size_footer(); }, 100 );