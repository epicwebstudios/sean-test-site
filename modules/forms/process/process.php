<?

	$settings = siteSettings();


	$_POST['form_messages'] = array();
	
	
	if( isset($_POST['form_module_sub']) ){


		
		$form_id 	= preg_replace( "/[^0-9]/", '', $_POST['form_id'] ); 
		$form 		= mysql_fetch_assoc( mysql_query( "SELECT * FROM `m_forms` WHERE `id` = '".$form_id."' LIMIT 1" ) );


		if( $form['recaptcha'] ){
            $recaptch_response      = $_POST['g-recaptcha-response'];
            $recaptcha_url          = "https://www.google.com/recaptcha/api/siteverify";

            $data = array(
                'secret' => $form['recaptcha_secret_key'],
                'response' => $recaptch_response
            );

            $options = array(
                'http' => array (
                    'method' => 'POST',
                    'content' => http_build_query($data)
                )
            );

            $context  = stream_context_create($options);
            $verify = file_get_contents($recaptcha_url, false, $context);
            $captcha_success=json_decode($verify);

            if( !$captcha_success->success ){
                header( 'Location: '.$_POST['on_page'] );
                die();
            }
        }


		
		if( ($form['id']) && ($form['status'] == '1') ){
		
			$fields 		= array();
			$error			= false;
			$error_fields 	= '';
		
			$rQ = mysql_query( "SELECT * FROM `m_form_fields` WHERE `form` = '".$form['id']."' ORDER BY `order` ASC" );
			while( $r = mysql_fetch_assoc($rQ) ){
				
				$id			= $r['id'];
				$type		= $r['type'];
				$label 		= $r['label'];
				$validation = $r['validation'];
				$value 		= $_POST['field_'.$id];
				
				if( 
					( $type == '1' ) ||
					( $type == '2' ) ||
					( $type == '3' )
				){
					
					// Text, Textarea, Select
					
					if( $validation == '1' ){
					
						if( $value == '' ){
							$error = true;
							$error_fields .= '<div>You must enter a value for "<b>'.$label.'</b>".</div>';
						} else {
							$fields[] = array( 'label' => $label, 'value' => $value );
						}
					
					} else if( $validation == '2' ){
					
						if( $value == '' ){
							$error = true;
							$error_fields .= '<div>You must enter a value for "<b>'.$label.'</b>".</div>';
						} else if( !filter_var($value, FILTER_VALIDATE_EMAIL) ){
							$error = true;
							$error_fields .= '<div>You must enter a valid e-mail address for "<b>'.$label.'</b>".</div>';
						} else {
							$fields[] = array( 'label' => $label, 'value' => $value );
						}
					
					} else {
						$fields[] = array( 'label' => $label, 'value' => $value );
					}
					
				} else if(
					( $type == '4' ) ||
					( $type == '5' )
				){
					
					// Checkbox, Radio
					
					if( $validation == '3' ){
						
						if( $type == '4' ){
						
							if( count($value) <= 0 ){
								$error = true;
								$error_fields .= '<div>You must choose an option for "<b>'.$label.'</b>".</div>';
							} else {
								$fields[] = array( 'label' => $label, 'value' => implode( ', ', $value ) );
							}
						
						} else if( $type == '5' ){
						
							if( $value == '' ){
								$error = true;
								$error_fields .= '<div>You must choose an option for "<b>'.$label.'</b>".</div>';
							} else {
								$fields[] = array( 'label' => $label, 'value' => $value );
							}
							
						}
						
					} else {
						if( $type == '4' ){
							$fields[] = array( 'label' => $label, 'value' => implode( ', ', $value ) );
						} else {
							$fields[] = array( 'label' => $label, 'value' => $value );
						}
					}
					
				} else if(
					( $type == '6' )
				){
					
					// File
					
					$path = BASE_DIR.'/uploads/forms/';
					
					if( !is_dir($path) ){
						mkdir( $path );
					}
					
					$value = basename( $_FILES['field_'.$id]['name'] );
					$filename = clean_filename( substr(time(), -6)."_".$value );
					
					if( $validation == '1' ){
						
						if( $value == '' ){
							$error = true;
							$error_fields .= '<div>You must choose a file to upload for "<b>'.$label.'</b>".</div>';
						} else {
							if( $filename ) {
								$target = $path.$filename; 
								if( move_uploaded_file( $_FILES['field_'.$id]['tmp_name'], $target ) ){
									$fields[] = array( 'label' => $label, 'value' => returnURL().'/uploads/forms/'.$filename );
								}
							}
						}
						
					} else {
						
						if( $filename ) {
							$target = $path.$filename;
							if( move_uploaded_file( $_FILES['field_'.$id]['tmp_name'], $target ) ){
								$fields[] = array( 'label' => $label, 'value' => returnURL().'/uploads/forms/'.$filename );
							}
						}
						
					}
					
				}
			
			}
			
			
			if( $error ){
				$_POST['form_messages'][$form['id']] = array(
					'class' 	=> 'error',
					'title' 	=> 'Submission Error',
					'message' 	=> '<div>You must correct the following issues:</div>'.$error_fields,
				);
			} else {
				
				
				$_POST['form_messages'][$form['id']] = array(
					'class' 	=> 'success',
					'title' 	=> 'Submission Successful',
					'message' 	=> '<div>Your information has been submitted successfully.</div>',
				);
				
				
				$values = array(
					'form' 		=> $form['id'],
					'log_value' => $_POST['field_'.$form['log_field']],
					'fields' 	=> $fields,
					'ip' 		=> $_SERVER['REMOTE_ADDR'],
					'browser' 	=> $_SERVER['HTTP_USER_AGENT'],
					'date'		=> time(),
					'on_page' 	=> $_POST['on_page'],
				);
				
				
				$emails = $form['email_to'];
				if( $emails != '' ){
					
					$m_to 		= $emails;
					$m_from 	= $settings['email'];
					
					$m_subject 	= '"'.$form['name'].'" submission on '.$settings['name'];
					
					$m_msg		= '';
					$m_msg		.= 'The following has been submitted through the "'.$form['name'].'" on '.$settings['name'].':' . "\n";
					$m_msg		.= '---' . "\n" . "\n";
					
					foreach( $values['fields'] as $field ){
						if( $field['value'] != '' ){
							$m_msg .= $field['label'].': '.$field['value'] . "\n" . "\n";
						}
					}
					
					$m_msg		.= 'Submitted On: '.$values['on_page'] . "\n";
					if( $values['referral'] ){
						$m_msg		.= 'Referring URL: '.$values['referral'] . "\n";
					}
					$m_msg		.= 'User IP Address: '.$values['ip'] . "\n" . "\n";
					
					$m_msg		.= '---' . "\n";
					$m_msg		.= 'This e-mail was automatically generated. Please do not respond directly to this message.';
					
					mail( $m_to, $m_subject, $m_msg, 'From:'.$m_from );
					
					$values['emailed_to'] 		= $m_to;
					$values['email_contents'] 	= $m_msg;
					
				}
				
				
				$set = query_build_set( $values );
				mysql_query( "INSERT INTO `m_form_results` ".$set );
				$submission_id = mysql_insert_id();
				
				
				if( $_POST['lead_id'] ){
					mysql_query( "UPDATE `m_form_leads` SET `submission_id` = '".$submission_id."' WHERE `id` = '".$_POST['lead_id']."' LIMIT 1" );
				}
				
				
				if( $form['thank_you'] != '0' ){
					header( 'Location: '.get_page_url($form['thank_you']) );
					die();
				}
				
				
			}
		
		}
	
	}
	
	
	
