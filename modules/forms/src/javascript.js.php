<script>


	var form_states = new Array();
	
	
	function form_verify( form_id ){
		
		var value;
		var name;
		var label;
		var status  = true;
		var found	= false;
		var reg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,15})+$/

        if ($('#recaptcha_box_'+form_id).length) {
            var recaptcha_widget_id = $('#recaptcha_box_'+form_id).index('.g-recaptcha');
            var recaptcha_state     = grecaptcha.getResponse(recaptcha_widget_id);

            if( !recaptcha_state ){
                alert( 'Please check the recaptcha box to submit the form' );
                status = false;
                return false;
            }
        }

		
		$( '#form_' + form_id + ' .validate_1' ).each( function(i){
			
			value = $( this ).val();
			label = $( this ).attr( 'data-label' );
			
			if( value == '' ){
				alert( 'You must enter a value for "' + label + '".' );
				$( this ).focus();
				status = false;
				return false;
			}
			
		});
		
		if( !status ){ return false; }
		
		$( '#form_' + form_id + ' .validate_2' ).each( function(i){
			
			value = $( this ).val();
			label = $( this ).attr( 'data-label' );
			
			if( value == '' ){
				alert( 'You must enter a value for "' + label + '".' );
				$( this ).focus();
				status = false;
				return false;
			} else if( !reg.test(value) ){
				alert( 'You must enter a valid e-mail address for "' + label + '".' );
				$( this ).focus();
				status = false;
				return false;
			}
			
		});
		
		if( !status ){ return false; }
		
		$( '#form_' + form_id + ' .validate_3' ).each( function(i){
			
			label = $( this ).attr( 'data-label' );
			
			if( !$(this).find('input').is(':checked') ){
				alert( 'You must choose an option for "' + label + '".' );
				status = false;
				return false;
			}
			
		});
		
		if( !status ){ return false; }
		
		return true;
		
	}


	function form_lead( form_id ){
		if( !form_states[form_id] ){
		
			var url 	= '<? mainURL(); ?>/modules/forms/process/capture.php';		
			var lead_id = $( '#form_' + form_id + ' #lead_id' ).val();
			var request;
		
			form_states[form_id] = true;
			
			if( !lead_id ){
				
				request = $.ajax({
					url:	url + '?t=create&f=' + form_id,
					type:	'get'
				});
				
				request.done( function(response, textStatus, jqXHR){
					console.log( response );
					$( '#form_' + form_id + ' #lead_id' ).val( response );
					form_states[form_id] = false;
				});
				
			} else {
				
				request = $.ajax({
					url:	url + '?t=update&f=' + form_id,
					type:	'post',
					data:	$( '#form_' + form_id ).serialize()
				});
				
				request.done( function(response, textStatus, jqXHR){
					form_states[form_id] = false;
				});
			
			}
		
		}
	}
	

	s( function(){
		$( '.form_module' ).find( 'input' ).focus( function(){ form_lead( $(this).attr('data-form-id') ); } );
		$( '.form_module' ).find( 'select' ).focus( function(){ form_lead( $(this).attr('data-form-id') ); } );
		$( '.form_module' ).find( 'textarea' ).focus( function(){ form_lead( $(this).attr('data-form-id') ); } );
		$( '.form_module' ).find( 'input' ).blur( function(){ form_lead( $(this).attr('data-form-id') ); } );
		$( '.form_module' ).find( 'select' ).blur( function(){ form_lead( $(this).attr('data-form-id') ); } );
		$( '.form_module' ).find( 'textarea' ).blur( function(){ form_lead( $(this).attr('data-form-id') ); } );
		$( '.form_module' ).find( 'input[type="checkbox"]' ).click( function(){ form_lead( $(this).attr('data-form-id') ); } );
		$( '.form_module' ).find( 'input[type="radio"]' ).click( function(){ form_lead( $(this).attr('data-form-id') ); } );
		$( '.form_module' ).find( 'select' ).change( function(){ form_lead( $(this).attr('data-form-id') ); } );
		$( '.form_module' ).find( 'input' ).keyup( function(){ form_lead( $(this).attr('data-form-id') ); } );
		$( '.form_module' ).find( 'textarea' ).keyup( function(){ form_lead( $(this).attr('data-form-id') ); } );
	});



</script>