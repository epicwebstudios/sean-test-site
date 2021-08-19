<?


	// HTML Form Field Rendering and Parsing Functions
	
	
	function field_id( $value ){
		
		$value = str_replace( '[', '_', $value );
		$value = str_replace( ']', '_', $value );
		
		while( strpos($value, '__') !== false ){
			$value = str_replace( '__', '_', $value );
		}
		
		if( substr($value, 0, 1) == '_' ){
			$value = substr( $value, 1 );
		}
		
		if( substr($value, -1) == '_' ){
			$value = substr( $value, 0, (strlen($value)-1) );
		}
		
		return $value;
			
	}
	
	
	function field_text( $name, $value = false, $style = false, $other = false ){
		
		$output = '';
		
		$output .= '<input';
			$output .= ' type="text"';
			$output .= ' name="'.$name.'"';
			$output .= ' id="'.field_id( $name ).'"';
			if( $style ){ $output .= ' style="'.$style.'"'; }
			if( $other ){ $output .= ' '.$other; }
			$output .= ' value="'.htmlentities( $value ).'"';
		$output .= '/>';
		
		echo $output;
		
	}
	
	
	function field_hidden( $name, $value = false ){
		
		$output = '';
		
		$output .= '<input';
			$output .= ' type="hidden"';
			$output .= ' name="'.$name.'"';
			$output .= ' id="'.field_id( $name ).'"';
			$output .= ' value="'.htmlentities( $value ).'"';
		$output .= '/>';
		
		echo $output;
		
	}
	
	
	function field_password( $name, $value = false, $style = false, $other = false ){
		
		$output = '';
		
		$output .= '<input';
			$output .= ' type="hidden"';
			$output .= ' name="c_'.$name.'"';
			$output .= ' id="c_'.field_id( $name ).'"';
			$output .= ' value="'.$value.'"';
		$output .= '/>';
		
		$output .= '<input';
			$output .= ' type="password"';
			$output .= ' name="'.$name.'"';
			$output .= ' id="'.field_id( $name ).'"';
			if( $style ){ $output .= ' style="'.$style.'"'; }
			if( $other ){ $output .= ' '.$other; }
		$output .= '/>';
		
		echo $output;
		
	}
	
	
	function field_select( $name, $options, $selected = false, $style = false, $other = false ){
		
		$output = '';
		
		$output .= '<select';
			$output .= ' name="'.$name.'"';
			$output .= ' id="'.field_id( $name ).'"';
			if( $style ){ $output .= ' style="'.$style.'"'; }
			if( $other ){ $output .= ' '.$other; }
		$output .= '>';
		
		if( is_array($options) ){
			foreach( $options as $key => $value ){
				
				$output .= '<option';
					$output .= ' value="'.htmlentities( $key ).'"';
					if( strval($key) == strval($selected) ){ $output .= ' selected'; }
				$output .= '>';
					$output .= $value;
				$output .= '</option>';
				
			}
		}
		
		$output .= '</select>';
		
		echo $output;
		
	}
	
	
	function field_select2( $name, $options, $selected = false, $style = false, $other = false ){
		
		field_select( $name, $options, $selected, $style, $other );
		
		echo '<script type="text/javascript">';
			echo "$( '#".field_id( $name )."' ).select2();";
        echo '</script>';
		
	}
	
	
	function field_textarea( $name, $value = false, $style = false, $other = false ){
		
		$output = '';
		
		$output .= '<textarea';
			$output .= ' name="'.$name.'"';
			$output .= ' id="'.field_id( $name ).'"';
			if( $style ){ $output .= ' style="'.$style.'"'; }
			if( $other ){ $output .= ' '.$other; }
		$output .= '>';
			$output .= $value;
		$output .= '</textarea>';
		
		echo $output;
		
	}
	
	
	function field_radio( $name, $options, $selected = false, $columns = 1, $other = false ){
	
		$output = '';
		
		if( $columns > 1 ){
			$limit = ceil( count($options) / $columns );
		} else {
			$limit = count( $options );
		}
		
		$total = 0;
		$count = 1;
				
		$output .= '<div class="l p_r" style="padding-top: 0;">';
			$output .= '<div class="p_r" style="padding-top: 0;">';
		
				if( is_array($options) ){
					foreach( $options as $key => $value ){
						
						$output .= '<div class="black">';
							$output .= '<label>';
								$output .= '<input';
									$output .= ' type="radio"';
									$output .= ' name="'.$name.'"';
									$output .= ' value="'.$key.'"';
									if( strval($key) == strval($selected) ){ $output .= ' checked="checked"'; }
									if( $other ){ $output .= ' '.$other; }
								$output .= '> ';
								$output .= $value;
							$output .= '</label>';
						$output .= '</div>';
						
						$total++;
						
						if( $count == $limit ){
								
								$output .= '</div>';
							$output .= '</div>';
							
							if( $total < count($options) ){
								$output .= '<div class="l p_r" style="padding-top: 0;">';
									$output .= '<div class="p_r" style="padding-top: 0;">';
							}
							
							$count = 1;
							
						} else {
							$count++;
						}
						
					}
				}
				
			$output .= '</div>';
		$output .= '</div>';
		
		echo $output;
	
	}
	
	
	function field_checkbox( $name, $options, $selected = false, $columns = 1, $other = false ){
	
		$output = '';
		
		if( !is_array($selected) ){
			$selected = explode( ',', $selected );
		}
		
		if( $columns > 1 ){
			$limit = ceil( count($options) / $columns );
		} else {
			$limit = count( $options );
		}
		
		$total = 0;
		$count = 1;
				
		$output .= '<div class="l p_r" style="padding-top: 0;">';
			$output .= '<div class="p_r" style="padding-top: 0;">';
		
				if( is_array($options) ){
					foreach( $options as $key => $value ){
						
						$output .= '<div class="black" style="padding-bottom: 5px;">';
							$output .= '<label>';
								$output .= '<input';
									$output .= ' type="checkbox"';
									$output .= ' name="'.$name.'[]"';
									$output .= ' value="'.$key.'"';
									if( in_array($key, $selected) === true ){ $output .= ' checked="checked"'; }
									if( $other ){ $output .= ' '.$other; }
								$output .= '> ';
								$output .= $value;
							$output .= '</label>';
						$output .= '</div>';
						
						$total++;
						
						if( $count == $limit ){
								
								$output .= '</div>';
							$output .= '</div>';
							
							if( $total < count($options) ){
								$output .= '<div class="l p_r" style="padding-top: 0;">';
									$output .= '<div class="p_r" style="padding-top: 0;">';
							}
							
							$count = 1;
							
						} else {
							$count++;
						}
						
					}
				}
		
			$output .= '</div>';
		$output .= '</div>';
		
		echo $output;
	
	}
	
	
	function field_file( $name, $value = false, $upload_path = '/uploads/', $other = false ){
		
		$output = '';
		
		$output .= '<input';
			$output .= ' type="hidden"';
			$output .= ' name="c_'.$name.'"';
			$output .= ' id="c_'.field_id( $name ).'"';
			$output .= ' value="'.htmlentities( $value ).'"';
			$output .= ' data-initial="'.htmlentities( $value ).'"';
		$output .= '/>';
		
		$output .= '<div>';
			$output .= '<input';
				$output .= ' type="file"';
				$output .= ' name="'.$name.'"';
				$output .= ' id="'.field_id( $name ).'"';
				$output .= ' value="'.htmlentities( $value ).'"';
				if( $other ){ $output .= ' '.$other; }
			$output .= '/>';
		$output .= '</div>';
		
		if( $value ){
			
			if( substr($upload_path, 0, 1) != '/' ){ $upload_path = '/'.$upload_path; }
			if( substr($upload_path, -1) != '/' ){ $upload_path = $upload_path.'/'; }
			$file = returnURL().'/uploads'.$upload_path.$value;
			
			$output .= '<div';
				$output .= ' class="file_message"';
				$output .= ' id="file_message_'.field_id( $name ).'"';
			$output .= '>';
				
				$output .= '<div class="current">';
					
					$output .= '<span>';
						$output .= 'The current file uploaded is "';
							$output .= '<a';
								$output .= ' href="'.$file.'"';
								$output .= ' target="_blank"';
							$output .= '>';
								$output .= '<b>'.$value.'</b>';
							$output .= '</a>';
						$output .= '".';
					$output .= '</span>';
					
					$output .= 'Select a new file to overwrite the current file or ';
					$output .= '<a';
						$output .= ' href="#"';
						$output .= ' onclick="current_file_toggle( \''.field_id( $name ).'\' ); return false;"';
					$output .= '>';
						$output .= 'remove the current file';
					$output .= '</a>.';
				
				$output .= '</div>';
			
			
				$output .= '<div class="removed" style="display: none;">';
				
					$output .= 'The current file will be removed once you click "Save" or you can ';
					$output .= '<a';
						$output .= ' href="#"';
						$output .= ' onclick="current_file_toggle( \''.field_id( $name ).'\' ); return false;"';
					$output .= '>';
						$output .= 'undo removing the current file';
					$output .= '</a>.';
					
				$output .= '</div>';
			
			$output .= '</div>';
			
		}
		
		$output .= '<div class="c"></div>';
		
		echo $output;
		
	}
	
	
	function field_image( $name, $value = false, $upload_path = '', $position = 'left', $other = false ){
		
		$output = '';
		
		$output .= '<input';
			$output .= ' type="hidden"';
			$output .= ' name="c_'.$name.'"';
			$output .= ' id="c_'.field_id( $name ).'"';
			$output .= ' value="'.htmlentities( $value ).'"';
			$output .= ' data-initial="'.htmlentities( $value ).'"';
		$output .= '/>';
		
		if( $value ){
			
			if( substr($upload_path, 0, 1) == '/' ){ $upload_path = substr( $upload_path, 1 ); }
			if( substr($upload_path, -1) != '/' ){ $upload_path = $upload_path.'/'; }
			$thumbnail = img_url( $upload_path.$value, 100, 100 );
			$file = returnURL().'/uploads/'.$upload_path.$value;
			
			if( $position == 'top' ){
				$thumbnail = img_url( $upload_path.$value, 'auto', 100 );
				$output .= '<div>';
			}
			
				$output .= '<a';
					$output .= ' class="lightbox_img"';
					$output .= ' href="'.$file.'"';
				$output .= '>';
					$output .= '<img';
						$output .= ' src="'.$thumbnail.'"';
						$output .= ' class="thumb_'.$position.'"';
						$output .= ' id="thumb_'.field_id( $name ).'"';
					$output .= '/>';
				$output .= '</a>';
			
			if( $position == 'top' ){
				$output .= '</div>';
			}
			
		}
		
		$output .= '<div>';
			$output .= '<input';
				$output .= ' type="file"';
				$output .= ' name="'.$name.'"';
				$output .= ' id="'.field_id( $name ).'"';
				$output .= ' value="'.htmlentities( $value ).'"';
				if( $other ){ $output .= ' '.$other; }
			$output .= '/>';
		$output .= '</div>';
		
		if( $value ){
			$output .= '<div';
				$output .= ' class="file_message"';
				$output .= ' id="file_message_'.field_id( $name ).'"';
			$output .= '>';
				
				$output .= '<div class="current">';
				
					if( $position == 'left' ){
						$output .= 'The current image is shown to the left. ';
					} else {
						$output .= 'The current image is shown above. ';
					}
					
					$output .= 'Select a new file to overwrite the current image or ';
					$output .= '<a';
						$output .= ' href="#"';
						$output .= ' onclick="current_file_toggle( \''.field_id( $name ).'\' ); return false;"';
					$output .= '>';
						$output .= 'remove the current image';
					$output .= '</a>.';
				
				$output .= '</div>';
			
			
				$output .= '<div class="removed" style="display: none;">';
				
					$output .= 'The current image will be removed once you click "Save" or you can ';
					$output .= '<a';
						$output .= ' href="#"';
						$output .= ' onclick="current_file_toggle( \''.field_id( $name ).'\' ); return false;"';
					$output .= '>';
						$output .= 'undo removing the current image';
					$output .= '</a>.';
					
				$output .= '</div>';
			
			$output .= '</div>';
			
		}
		
		$output .= '<div class="c"></div>';
		
		echo $output;
		
	}
	
	
	function field_code( $name, $value = false, $style = false, $other = false ){
		
		$output = '';
		
		$output .= '<textarea';
			$output .= ' name="'.$name.'"';
			$output .= ' id="'.field_id( $name ).'"';
			$output .= ' class="code"';
			if( $style ){ $output .= ' style="'.$style.'"'; }
			if( $other ){ $output .= ' '.$other; }
		$output .= '>';
			$output .= $value;
		$output .= '</textarea>';
		
		echo $output;

        echo '<script>';
			echo ' CodeMirror.fromTextArea(document.getElementById("'.field_id( $name ).'"),{ ';
				echo ' lineNumbers: true, ';
				echo ' indentUnit: 4, ';
				echo ' mode: "javascript" ';
			echo ' }); ';
        echo '</script>';
		
	}
	
	
	function field_editor( $name, $value = false, $style = false, $other = false ){
		
		$output = '';
		
		$output .= '<textarea';
			$output .= ' name="'.$name.'"';
			$output .= ' id="'.field_id( $name ).'"';
			$output .= ' class="editor"';
			if( $style ){ $output .= ' style="'.$style.'"'; }
			if( $other ){ $output .= ' '.$other; }
		$output .= '>';
			$output .= $value;
		$output .= '</textarea>';
		
		echo $output;
		
	}
	
	
	function field_date( $name, $value = false, $other = false ){
		
		if( $value ){
			$value = date( 'm/d/Y', $value );
		} else {
			$value = false;
		}
		
		$output = '';
		
		$output .= '<input';
			$output .= ' type="text"';
			$output .= ' name="'.$name.'"';
			$output .= ' id="'.field_id( $name ).'"';
			$output .= ' style="width: 85px; text-align: center;"';
			$output .= ' autocomplete="off"';
			if( $other ){ $output .= ' '.$other; }
			$output .= ' value="'.htmlentities( $value ).'"';
		$output .= '/>';
		
		echo $output;
		
		echo '<script type="text/javascript">';
			echo '$(function() {';
				echo "$( '#".field_id( $name )."' ).datepicker();";
			echo '});';
		echo '</script>';
	
	}
	
	
	function field_time( $name, $value = false, $step = 15, $other = false ){
		
		if( $value ){
			$value = date( 'g:ia', $value );
		} else {
			$value = false;
		}
		
		$output = '';
		
		$output .= '<input';
			$output .= ' type="text"';
			$output .= ' name="'.$name.'"';
			$output .= ' id="'.field_id( $name ).'"';
			$output .= ' style="width: 70px; text-align: center;"';
			$output .= ' autocomplete="off"';
			if( $other ){ $output .= ' '.$other; }
			$output .= ' value="'.htmlentities( $value ).'"';
		$output .= '/>';
		
		echo $output;
	
		echo '<script type="text/javascript">';
			echo '$(function() {';
				echo "$( '#".field_id( $name )."' ).timepicker({ 'step': ".$step." });";
			echo '});';
		echo '</script>';
	
	}
	
	
	function field_color( $name, $value = false, $other = false ){
		
		$output = '';
		
		$output .= '<input';
			$output .= ' type="text"';
			$output .= ' name="'.$name.'"';
			$output .= ' id="'.field_id( $name ).'"';
			$output .= ' style="width: 95px;"';
			if( $other ){ $output .= ' '.$other; }
			$output .= ' autocomplete="off"';
			$output .= ' value="'.htmlentities( $value ).'"';
		$output .= '/>';
		
		echo $output;
	
		echo '<script type="text/javascript">';
			echo '$(function() {';
				echo "$.minicolors.defaults.letterCase = 'uppercase';";
				echo "$( '#".$name."' ).minicolors();";
			echo '});';
		echo '</script>';
	
	}
	
	
	function field_permalink( $name, $value = false, $linked_field = false ){
		
		$output = '';
		
		$output .= '<input';
			$output .= ' type="text"';
			$output .= ' style="font-family:monospace;"';
			$output .= ' name="'.$name.'"';
			$output .= ' id="'.field_id( $name ).'"';
			if( $style ){ $output .= ' style="'.$style.'"'; }
			if( $other ){ $output .= ' '.$other; }
			$output .= ' value="'.htmlentities( $value ).'"';
		$output .= '/>';
		
		if( ($linked_field) && ($value == '') ){
			if (!is_array($linked_field))
				$linked_field = array($linked_field);

			$linked_field_selectors = implode(',', array_map(
				function($linked_field) {
					return ('#'.$linked_field);
				}, $linked_field
			));

			$output .= '<script type="text/javascript"> ';
				$output .= "$( document ).ready( function(){ ";
					$output .= "$( '$linked_field_selectors' ).keyup( function(){ ";

						$output .= 'var string = "";';

						foreach ($linked_field as $field) {
							$output .= "var perm_$field = $(\"#$field\").val().toLowerCase();" ;
							$output .= "perm_$field = perm_$field.replace(/[^a-zA-Z0-9 ]+/g, ''); ";
							$output .= "perm_$field = perm_$field.replace(/ /g, '-'); ";
						}

						$i = 0;

						foreach ($linked_field as $field) {
							$output .= "if (perm_$field)";
								$output .= "string = string + '".($i < 1 ? '' : '-')."' + perm_$field; ";

							$i++;
						}

						$output .= "$('#".field_id( $name )."').val(string); ";
					$output .= "}); ";
				$output .= "}); ";
            $output .= "</script>";
		}
		
		echo $output;

	}
	
	
	function field_tags( $name, $value = false, $other = false ){
		
		$output = '';
		
		if( $value ){
			$value = explode( '||', $value );
			unset( $value[0], $value[count($value)] );
			$value = implode( ',', $value );
		}
		
		$output .= '<input';
			$output .= ' type="text"';
			$output .= ' name="'.$name.'"';
			$output .= ' id="'.field_id( $name ).'"';
			$output .= ' value="'.htmlentities( $value ).'"';
		$output .= '/>';
		
		echo $output;
	
		echo '<script type="text/javascript">';
			echo '$(function() {';
				echo "$( '#".field_id( $name )."' ).tagsInput({ width: 'auto' });";
			echo '});';
		echo '</script>';
		
	}


	function field_toggle( $name, $options, $value = '0', $onclick = false ){
	
		$output = '';
		
		if( $value == '1' ){
			$class = 'toggle_on';
		} else {
			$class = 'toggle_off';
		}
		
		if( $onclick ){
			$onclick = " field_toggle( '".field_id( $name )."' ); ".$onclick;
		} else {
			$onclick = " field_toggle( '".field_id( $name )."' ); ";
		}
		
		$output .= '<div';
			$output .= ' class="toggle_field '.$class.'"';
			$output .= ' id="toggle_field_'.field_id( $name ).'"';
			$output .= ' data-off-value="'.htmlentities( $options[0] ).'"';
			$output .= ' data-on-value="'.htmlentities( $options[1] ).'"';
		$output .= '>';
		
			$output .= '<input';
				$output .= ' type="hidden"';
				$output .= ' name="'.$name.'"';
				$output .= ' id="'.field_id( $name ).'"';
				$output .= ' value="'.htmlentities( $value ).'"';
			$output .= '>';
			
			$output .= '<div';
				$output .= ' class="ilb rel toggle"';
				$output .= ' onclick="'.$onclick.'"';
			$output .= '>';
				$output .= '<div class="abs inner"></div>';
			$output .= '</div>';
			
			$output .= '<div class="ilb label">'.$options[$value].'</div>';
		
		$output .= '</div>';
		
		echo $output;
		
	}
	
	
	function process_file( $name, $path = '' ){
		
		if( $path != '' ){
			if( substr($path, 0, 1) == '/' ){ $path = substr( $path, 1 ); }
			if( substr($path, -1) != '/' ){ $path .= '/'; }
		}
		
		$path_parts = explode( '/', $path );
		$path 		= BASE_DIR.'/uploads/'.$path;
		$cur_file 	= $_POST['c_'.$name];
		$new_file 	= basename( $_FILES[$name]['name'] );
		$result		= $cur_file;
		
		if( $new_file ) {
			
			$file 	= clean_filename( substr(time(), -6).'_'.$new_file );
			
			if( !is_dir($path) ){
				$route = BASE_DIR.'/uploads/';
				foreach( $path_parts as $part ){
					$route .= $part.'/';
					if( !is_dir($route) ){
						mkdir( $route );
						chmod( $route, 0755 );
					}
				}
			}
			
			if( move_uploaded_file($_FILES[$name]['tmp_name'], $path.$file) ){
				$result = $file;
			}
			
		}
		
		return $result;
	
	}
	
	
	function process_tags( $name ){
		
		$tags = $_POST[$name];
		$tags = explode( ',', $tags );
		$tags = implode( '||', $tags );
		
		if( $tags != '' ){
			$tags = '||'.$tags.'||';
		} else {
			$tags = '|'.$tags.'|';
		}
		
		return $tags;
		
	}
	
	
	function process_checkbox( $name ){
	
		$result = '';
		
		if( is_array($_POST[$name]) ){
			foreach( $_POST[$name] as $value ){
				if( $result != '' ){ $result .= ','; }
				$result .= $value;
			}
		}
		
		return $result;
		
	}
	
	
	function process_checkbox_tags( $name ){
		
		$tags = process_checkbox( $name );
		$tags = explode( ',', $tags );
		$tags = implode( '||', $tags );
		
		if( $tags != '' ){
			$tags = '||'.$tags.'||';
		} else {
			$tags = '|'.$tags.'|';
		}
		
		return $tags;
		
	}
	
	
	function process_password( $name ){
		
		if( $_POST[$name] != '' ){
			$value = $_POST[$name];
		} else {
			$value = $_POST['c_'.$name];
		}
		
		return $value;
		
	}
	
	
	function process_date_time( $date, $time ){
		return strtotime( $_POST[$date].', '.$_POST[$time] );
	}

