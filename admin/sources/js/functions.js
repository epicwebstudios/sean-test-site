function delete_item( id ){
	if( confirm('Are you sure you would like to delete this item?') ){
		window.location = base_url + '&act=delete&i=' + id;
	} else {
		return false;
	}
}


function order_item( id, order ){
	window.location = base_url + '&act=order&i=' + id + '&o=' + order;
}


$( document ).ready( function(){ 
	
	// Add tabbing ability inside of code textareas
	$( 'textarea.code' ).keydown( function(e){
		if( e.keyCode === 9 ){
			
			var start = this.selectionStart;
			var end = this.selectionEnd;
			var $this = $(this);
			var value = $this.val();
	
			$this.val( value.substring(0, start)
						+ "\t"
						+ value.substring(end) );
	
			this.selectionStart = this.selectionEnd = start + 1;
	
			e.preventDefault();
		}
	});
	
});


function current_file_toggle( id ){
	
	var c 	= $( '#c_' + id );
	var img = $( '#thumb_' + id );
	var msg = $( '#file_message_' + id );
	
	if( c.val() == '' ){
		c.val( c.attr( 'data-initial' ) );
		img.css( 'display', '' );
		msg.children( '.current' ).css( 'display', '' );
		msg.children( '.removed' ).css( 'display', 'none' );
	} else {
		c.val( '' );
		img.css( 'display', 'none' );
		msg.children( '.current' ).css( 'display', 'none' );
		msg.children( '.removed' ).css( 'display', '' );
	}
	
	return false;
	
}


function field_toggle( id ){
	
	var field 	= $( '#' + id );
	var element = $( '#toggle_field_' + id );
	var label	= $( '#toggle_field_' + id + ' .label' );
	
	element.removeClass( 'toggle_on' ).removeClass( 'toggle_off' );
	
	if( field.val() == '1' ){
		element.addClass( 'toggle_off' );
		label.html( element.attr('data-off-value') );
		field.val( 0 );
	} else {
		element.addClass( 'toggle_on' );
		label.html( element.attr('data-on-value') );
		field.val( 1 );
	}
	
}


function ajax_listing( section, id ){
	
	$( '#' + section + ' .loading' ).show();
	
	var request = $.ajax({
		url: ajax_url + '/' + section + '/module.php?i=' + id,
		type: 'get'
	});
	
	request.done( function( response, textStatus, jqXHR ){
		$( '#' + section + ' .listing' ).html( response );
		$( '#' + section + ' .loading' ).hide();
	});
	
}


function ajax_process( section, id, attributes, message ){
	
	if( message ){
		if( !confirm( message ) ){ return false; }
	}

	$( '#' + section + ' .loading' ).show();
	
	var request = $.ajax({
		url: ajax_url + '/' + section + '/module.php?i=' + id + attributes,
		type: 'get'
	});
	
	request.done( function( response, textStatus, jqXHR ){
		ajax_listing( section, id );
	});
	
}


function ajax_autosize( size ){
	lb_iframe_size( size );
}

function bind_toggle(elem, toggle_class) {
	$(elem).bind('change.bind_namespace', function() {
		const val = $(elem).val();

		$('.'+toggle_class).hide();
		$('.'+toggle_class+'-'+val).show();
	}).trigger('change.bind_namespace');
}

function toggle_dark_mode(){
	
	var toggle 	= $( '.dark_mode_toggle' );
	var url		= toggle.data( 'url' );
	
	if( toggle.hasClass('on') ){
		toggle.removeClass( 'on' ).addClass( 'off' ).addClass( 'loading' );
		window.location = url + '&set_dark_mode=0';
	} else {
		toggle.removeClass( 'off' ).addClass( 'on' ).addClass( 'loading' );
		window.location = url + '&set_dark_mode=1';
	}
	
	return false;
	
}

$( document ).ready( function(){
	$( 'body' ).on( 'click', '.dark_mode_toggle', function(e){
		toggle_dark_mode();
		return false;
	});
});