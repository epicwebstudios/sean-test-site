<script>

	var additional_state 	= true;
	var site_title 			= '<? echo addcslashes( $settings['title'], "'" ); ?>';
	
	
	function update_title(){
			
		$( '.title_desc' ).html( '' );
		$( '.title_error' ).html( '' );
		
		var title	= $( '#title' ).val();
		var error	= '';
		var output	= site_title;
		
		if( title != '' ){
			output = title + ' - ' + site_title;
		}
		
		if( output.length > 60 ){
			error += '<div>Your title is over 60 characters. Normal SEO practices suggest a page title of <b>60 characters or less</b>.</div>';
			error += '<div>You are currently at <b>' + output.length + ' characters</b>.</div>';
		}
		
		$( '.title_desc' ).html( output );
		$( '.title_error' ).html( error );
			
	}
	
	
	function update_desc(){
			
		$( '.description_error' ).html( '' );
		
		var description	= $( '#description' ).val();
		var error	= '';
		
		if( description.length > 158 ){
			error += '<div>Your description is over 158 characters. Normal SEO practices suggest a description of <b>158 characters or less</b>.</div>';
			error += '<div>You are currently at <b>' + description.length + ' characters</b>.</div>';
		}
		
		$( '.description_error' ).html( error );
			
	}


	function submit_page( form, target, location ){
		
		$( '#page_editor' ).attr( 'target', target );
		$( '#page_editor' ).attr( 'action', location );
		$( '#page_editor' ).submit();
		
		
		$( '#page_editor' ).attr( 'target', '_self' );
		
		<? if( $_GET['act'] == 'add' ){ ?>
			$( '#page_editor' ).attr( 'action', '?a=<? echo $_GET['a']; ?>' );
		<? } else { ?>
			$( '#page_editor' ).attr( 'action', '?a=<? echo $_GET['a']; ?>&act=edit&i=<? echo $_GET['i']; ?>' );
		<? } ?>
		
		return false;
		
	}
	
	
	function swap_password(){
		$( '.password' ).hide();
		var value = $( '#protect' ).val();
		if( value == '1' ){
			$( '.password' ).show();
		}
	}
	
	
	function toggle_additional(){
		if( additional_state ){
			$( '#additional_settings .state' ).html( '(Click here to expand)' );
			$( '#additional_settings tbody' ).hide();
			additional_state = false;
		} else {
			$( '#additional_settings .state' ).html( '' );
			$( '#additional_settings tbody' ).show();
			additional_state = true;
		}
	}
	
	
	$( document ).ready( function(){
	
		update_title();
		update_desc();
		swap_password();
		toggle_additional();
		
		$( '#additional_settings thead td' ).click( function(){
			toggle_additional();
		});
			
	});


</script>