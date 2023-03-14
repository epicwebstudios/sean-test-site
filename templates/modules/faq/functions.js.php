<script>
	jQuery_defer( function(){
		$( '.faq_module .entry .question' ).click( function(){
			
			var parent = $( this ).parent();
			
			if( parent.hasClass('collapsed') ){
				parent.children( '.response' ).slideDown( 'fast' );
				parent.removeClass( 'collapsed' );
			} else {
				parent.children( '.response' ).slideUp( 'fast' );
				parent.addClass( 'collapsed' );
			}
		
		});
	});
</script>