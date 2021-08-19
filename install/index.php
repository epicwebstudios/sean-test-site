<!DOCTYPE html>
<html lang="en">
	
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,700">
        <link rel="stylesheet" type="text/css" href="//css.ewsapi.com/icons/icons.min.css">
        <link type="text/css" rel="stylesheet" href="//css.ewsapi.com/reset/reset.min.css" />
        <link type="text/css" rel="stylesheet" href="//css.ewsapi.com/global/global.v2.css" />
        <link type="text/css" rel="stylesheet" href="//platform.epicwebstudios.com/shared/stylesheet.css" />
        <script src="//js.ewsapi.com/jquery/jquery-1.10.2.min.js"></script>
        <script>	
			$( document ).ready( function(){
				$( '#installation_form' ).submit( function(e){
					
					e.preventDefault();
					
					$( '#installation_form input[type="submit"]' ).prop( 'disabled', true );
					
					$( '.installer_box .messages' ).html( '' );
					
					var step_id 	= $( this ).attr( 'data-step-id' );
					var output 		= '';
					var form_data	= $( this ).serialize();
					var response;
					
					$.ajax({
						type: 		'POST',
						url: 		'step-' + step_id +'.php',
						data:		form_data,
						success: 	function( data ){
						
							response = jQuery.parseJSON( data );
						  
							if( response.success ){
								$( '#installation_form' ).attr( 'data-step-id', response.next_step );
								$( '.installer_box .progress .meter' ).animate({ 'width': response.progress + '%' });
								$( '.installer_box .details' ).html( response.html );
							} else {
								
								$( '#installation_form input[type="submit"]' ).prop( 'disabled', false );
								
								output += '<div class="tl notify notify-error">';
									output += '<div>' + response.message + '</div>';
								output += '</div>';
								
								$( '.installer_box .messages' ).html( output );
								
							}
						
						}
					});
					
				});
			});
		</script>
	</head>

	<body>

		<form method="post" id="installation_form" data-step-id="0">
            <div class="installer_box">
                <div class="rel contain">
                
                    <div class="abs progress"><div class="rel inner"><div class="abs meter"></div></div></div>
                
                    <div class="logo">
                        <img src="//platform.epicwebstudios.com/shared/ep-login-logo.png" />
                    </div>
                    
                    <div class="messages"></div>
                    
                    <div class="tc details">
                        
                        <h3>epicPlatform Installer</h3>
                        
                        <p>
                            This installer will guide you through the installation process.
                        </p>
                        
                        <p>
                        	<input type="submit" value="Begin Installation">
                        </p>
                        
                    </div>
                
                </div>
            </div>
        </form>
        
    </body>

</html>