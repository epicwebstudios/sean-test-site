<?


	class FormField {
		
		private $attributes;
		private $columns;
		private $format;
		private $ids;
		private $name;
		private $options;
		private $path;
		private $position;
		private $reference;
		private $selected;
		private $type;
		
		
		public function __construct( $type = false, $name = false ){
			$this->ids = array();
			$this->start( $type, $name );
		}
		
		
		public function attribute( $key, $value, $append = false ){
			
			if( !$this->attributes[$key] ){
				$this->attributes[$key] = '';
			}
			
			if( $this->attributes[$key] == '' ){
				$append = false;
			}
			
			if( $append ){
				$this->attributes[$key] .= ' '.$value;	
			} else {
				$this->attributes[$key] = $value;
			}
			
			return $this;
			
		}
		
		
		public function columns( $value ){
			$this->columns = $value;
			return $this;
		}
		
		
		public function format( $value ){
			$this->format = $value;
			return $this;
		}
		
		
		private function id( $value ){
			
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
			
			$i = 0;
			
			while( true ){

				$test = $value;
				if( $i > 0 ){ $test .= $i; }
				
				if( !in_array($test, $this->ids) ){
					$value = $test;
					$this->ids[] = $value;
					return $value;
				}
				
				$i++;
				
			}
			
		}
		
		
		public function name( $value ){
			$this->name = strtolower( $value );
			return $this;
		}
		
		
		public function options( $array ){
			$this->options = $array;
			return $this;
		}
		
		
		public function path( $path ){
			$path = str_replace( BASE_DIR, '', $path );
			if( substr($path,0,1) != '/' ){ $path = '/'.$path; }
			if( substr($path,-1) != '/' ){ $path .= '/'; }
			$this->path = $path;
			return $this;
		}
		
		
		public function position( $value ){
			$this->position = $value;
			return $this;
		}
		
		
		public function reference( $id ){
			$this->reference = $id;
			return $this;
		}
		
		
		public function render( $return = false ){
			
			if( $this->name ){
				$this->attribute( 'name', $this->name );
				$this->attribute( 'id', $this->id( $this->name ) );
			}
			
			switch( $this->type ){
					
				case 'code':
					return $this->render_code( $return );
					
				case 'color':
					return $this->render_color( $return );
					
				case 'checkbox':
				case 'checkboxes':
					return $this->render_checkboxes( $return );
					
				case 'date':
					return $this->render_date( $return );
					
				case 'editor':
					return $this->render_editor( $return );
				
				case 'email':
				case 'hidden':
				case 'number':
				case 'password':
				case 'text':
					$this->attribute( 'type', $this->type );
					return $this->render_text( $return );
					
				case 'file':
					return $this->render_file( $return );
					
				case 'image':
					return $this->render_image( $return );
					
				case 'permalink':
				case 'slug':
					return $this->render_permalink( $return );
					
				case 'radio':
				case 'radios':
					return $this->render_radios( $return );
					
				case 'select':
					return $this->render_select( $return );
					
				case 'select2':
					return $this->render_select2( $return );
					
				case 'tags':
					return $this->render_tags( $return );
					
				case 'textarea':
					return $this->render_textarea( $return );
					
				case 'time':
					return $this->render_time( $return );
				
			}
			
			return;
						
		}
		
		
		public function start( $type = false, $name = false ){
			
			$this->attributes 	= array();
			$this->columns		= false;
			$this->format		= false;
			$this->name			= false;
			$this->options		= false;
			$this->path			= '/uploads/';
			$this->position		= false;
			$this->reference	= false;
			$this->selected		= false;
			$this->type 		= false;
			
			if( $type ){
				$this->type( $type );
			}
			
			if( $name ){
				$this->name( $name );
			}
			
			return $this;

		}
		
		
		public function selected( $value ){
			$this->selected = $value;
			return $this;
		}
		
		
		public function type( $type ){
			$this->type = $type;
			return $this;
		}
		
		
		// Rendering
		
		
		private function render_code( $return = false ){
			
			$this->attribute( 'class', 'code', true );
			
			$output = $this->render_textarea( true );
			
			$output .= '<script>';
				$output .= ' CodeMirror.fromTextArea(document.getElementById("'.$this->attributes['id'].'"),{ ';
					$output .= ' lineNumbers: true, ';
					$output .= ' indentUnit: 4, ';
					$output .= ' mode: "'.$mode.'" ';
				$output .= ' }); ';
			$output .= '</script>';
			
			if( $return ){
				return $output;
			}
			
			echo $output;
			return;
			
		}
		
		
		private function render_color( $return = false ){
			
			$this->attribute( 'type', 'text' );
			$this->attribute( 'class', 'colorpicker', true );
			$this->attribute( 'autocomplete', 'off' );
			
			$output = $this->render_text( true );
		
			$output .= '<script>';
				$output .= '$( document ).ready( function(){';
					$output .= "$.minicolors.defaults.letterCase = 'uppercase';";
					$output .= "$( '#".$this->attributes['id']."' ).minicolors();";
				$output .= '});';
			$output .= '</script>';
			
			if( $return ){
				return $output;
			}
			
			echo $output;
			return;
			
		}
		
		
		private function render_checkboxes( $return = false ){
			
			$output = '';
			
			if( !$this->columns ){
				$this->columns = 1;
			}
			
			if( !is_array($this->selected) ){
				$this->selected = array( $this->selected );
			}
			
			$cols = array();
			$c = 1;
			
			foreach( $this->options as $k => $v ){
				
				$single = '';
				
				$single .= '<label>';
					$single .= '<input';
						$single .= ' type="checkbox"';
						$single .= ' name="'.$this->name.'[]"';
						$single .= ' value="'.$k.'"';
						
						if( in_array($k,$this->selected) ){
							$single .= ' checked="checked"';
						}
				
						foreach( $this->attributes as $aK => $aV ){
							if( ($aK != 'name') && ($aK != 'id') && ($aK != 'value') && ($aK != 'type') && ($aK != 'checked') ){
								$single .= ' '.$aK.'="'.htmlentities( $aV ).'"';
							}
						}
				
					$single .= '> '.$v;
				$single .= '</label>';
				
				$cols[$c][] = $single;
				
				if( $c == $this->columns ){
					$c = 1;
				} else {
					$c++;
				}
				
			}
			
			$output .= '<div class="checkboxes">';
				foreach( $cols as $k => $v ){
					$output .= '<div class="column">';
						$output .= implode( '', $v );
					$output .= '</div>';
				}
			$output .= '</div>';
			
			if( $return ){
				return $output;
			}
			
			echo $output;
			return;
			
		}
		
		
		private function render_date( $return = false ){
			
			$this->attribute( 'type', 'text' );
			$this->attribute( 'class', 'datepicker', true );
			$this->attribute( 'autocomplete', 'off' );
			
			if( $this->attributes['value'] ){
				if( 
					( $this->attributes['value'] != '' ) && 
					( $this->attributes['value'] != '0' ) && 
					( strpos($this->attributes['value'], '/') === false ) && 
					( strpos($this->attributes['value'], '-') === false )
				){
					$this->attribute( 'value', date('m/d/Y', $this->attributes['value']) );
				}
			}
			
 			if( $this->attributes['value'] == '0' ){
				$this->attribute( 'value', '' );
			}
			
			$output = $this->render_text( true );
		
			$output .= '<script>';
				$output .= '$( document ).ready( function(){';
					$output .= "$( '#".$this->attributes['id']."' ).datepicker();";
					if( $this->format ){
						$output .= "$( '#".$this->attributes['id']."' ).datepicker( 'option', 'dateFormat', '".$this->format."' );";
					} else {
						$output .= "$( '#".$this->attributes['id']."' ).datepicker( 'option', 'dateFormat', 'm/d/yy' );";
					}
				$output .= '});';
			$output .= '</script>';
			
			if( $return ){
				return $output;
			}
			
			echo $output;
			return;
			
		}
		
		
		private function render_editor( $return = false ){
			
			$this->attribute( 'class', 'editor', true );
			
			$output = $this->render_textarea( true );
			
			if( $return ){
				return $output;
			}
			
			echo $output;
			return;
			
		}
		
		
		private function render_file( $return = false ){
			
			$this->attribute( 'type', 'file' );
			$this->attribute( 'data-initial', $this->attributes['value'] );
			
			$output = '';
			
			$output .= '<div>'.$this->render_text( true ).'</div>';
			
			$output .= '<input';
				$output .= ' type="hidden"';
				$output .= ' name="c_'.$this->attributes['name'].'"';
				$output .= ' id="c_'.$this->attributes['id'].'"';
				$output .= ' value="'.htmlentities( $this->attributes['value'] ).'"';
				$output .= ' data-initial="'.htmlentities( $this->attributes['value'] ).'"';
			$output .= '/>';
			
			if( $this->attributes['value'] ){
				
				$file_name 	= $this->attributes['value'];
				$file_path	= BASE_DIR.$this->path.$file_name;
				$file_url	= returnURL().$this->path.$file_name;
			
				$output .= '<div';
					$output .= ' class="file_message"';
					$output .= ' id="file_message_'.$this->attributes['id'].'"';
				$output .= '>';

					$output .= '<div class="current">';

						$output .= '<span>';
							$output .= 'The current file uploaded is "';
								$output .= '<a';
									$output .= ' href="'.$file_url.'"';
									$output .= ' target="_blank"';
								$output .= '>';
									$output .= '<b>'.$file_name.'</b>';
								$output .= '</a>';
							$output .= '".';
						$output .= '</span>';

						$output .= 'Select a new file to overwrite the current file or ';
						$output .= '<a href="#" class="current_file_toggle" data-id="'.$this->attributes['id'].'">';
							$output .= 'remove the current file';
						$output .= '</a>.';

					$output .= '</div>';

					$output .= '<div class="removed" style="display: none;">';
						$output .= 'The current file will be removed once you click "Save" or you can ';
						$output .= '<a href="#" class="current_file_toggle" data-id="'.$this->attributes['id'].'">';
							$output .= 'undo removing the current file';
						$output .= '</a>.';
					$output .= '</div>';

				$output .= '</div>';

				$output .= '<script>';
					$output .= '$( document ).ready( function(){';
						$output .= " $( 'body' ).on( 'click', 'a.current_file_toggle', function(e){ ";
							$output .= " e.preventDefault(); ";
							$output .= " current_file_toggle( $(this).data('id') ); ";
							$output .= " return false; ";
						$output .= " }); ";
					$output .= '});';
				$output .= '</script>';
				
			}
			
			if( $return ){
				return $output;
			}
			
			echo $output;
			return;
			
		}
		
		
		private function render_image( $return = false ){
			
			if( !$this->position ){
				$this->position = 'left';
			}
			
			$this->attribute( 'type', 'file' );
			$this->attribute( 'data-initial', $this->attributes['value'] );
			
			$output = '';
			
			$output .= '<input';
				$output .= ' type="hidden"';
				$output .= ' name="c_'.$this->attributes['name'].'"';
				$output .= ' id="c_'.$this->attributes['id'].'"';
				$output .= ' value="'.htmlentities( $this->attributes['value'] ).'"';
				$output .= ' data-initial="'.htmlentities( $this->attributes['value'] ).'"';
			$output .= '/>';
			
			if( $this->attributes['value'] ){ 
				
				$file_name 	= $this->attributes['value'];
				$file_path	= BASE_DIR.$this->path.$file_name;
				$file_url	= returnURL().$this->path.$file_name;
				
				if( $this->position == 'top' ){
					$output .= '<div>';
				}
			
				$output .= '<a';
					$output .= ' class="lightbox_img"';
					$output .= ' href="'.$file_url.'"';
				$output .= '>';
					$output .= '<img';
						$output .= ' src="'.$file_url.'"';
						$output .= ' class="thumb_'.$this->position.'"';
						$output .= ' id="thumb_'.$this->attributes['id'].'"';
					$output .= '/>';
				$output .= '</a>';
				
				if( $this->position == 'top' ){
					$output .= '</div>';
				}
				
			}
			
			$output .= '<div>'.$this->render_text( true ).'</div>';
			
			if( $this->attributes['value'] ){
			
				$output .= '<div';
					$output .= ' class="file_message"';
					$output .= ' id="file_message_'.$this->attributes['id'].'"';
				$output .= '>';

					$output .= '<div class="current">';

						$output .= '<span>';
							$output .= 'The current file uploaded is "';
								$output .= '<a';
									$output .= ' href="'.$file_url.'"';
									$output .= ' target="_blank"';
								$output .= '>';
									$output .= '<b>'.$file_name.'</b>';
								$output .= '</a>';
							$output .= '".';
						$output .= '</span>';

						$output .= 'Select a new file to overwrite the current file or ';
						$output .= '<a href="#" class="current_file_toggle" data-id="'.$this->attributes['id'].'">';
							$output .= 'remove the current file';
						$output .= '</a>.';

					$output .= '</div>';

					$output .= '<div class="removed" style="display: none;">';
						$output .= 'The current file will be removed once you click "Save" or you can ';
						$output .= '<a href="#" class="current_file_toggle" data-id="'.$this->attributes['id'].'">';
							$output .= 'undo removing the current file';
						$output .= '</a>.';
					$output .= '</div>';

				$output .= '</div>';

				$output .= '<script>';
					$output .= '$( document ).ready( function(){';
						$output .= " $( 'body' ).on( 'click', 'a.current_file_toggle', function(e){ ";
							$output .= " e.preventDefault(); ";
							$output .= " current_file_toggle( $(this).data('id') ); ";
							$output .= " return false; ";
						$output .= " }); ";
					$output .= '});';
				$output .= '</script>';
				
			}
			
			if( $return ){
				return $output;
			}
			
			echo $output;
			return;
			
		}
		
		
		private function render_permalink( $return = false ){
			
			$this->attribute( 'type', 'text' );
			
			if( !$this->attributes['value'] ){
				$this->attribute( 'value', '' );
			}
			
			$this->attribute( 'data-initial', $this->attributes['value'] );
			
			$output = $this->render_text( true );
		
			if( $this->reference ){
				$output .= '<script>';
					$output .= '$( document ).ready( function(){';
						$output .= " $( '#".$this->reference."' ).keyup( function(){ ";
							$output .= " var base = $( this ).val(); ";
							$output .= " var initial = $( '#".$this->attributes['id']."' ).data( 'initial' ); ";
							$output .= " if( initial == '' ){ ";
								$output .= " var slug = base; ";
								$output .= " slug = slug.toLowerCase(); ";
								$output .= " slug = slug.replace(/[^a-zA-Z0-9 ]+/g, ''); ";
								$output .= " slug = slug.trim(); ";
								$output .= " slug = slug.replace(/ /g, '-'); ";
								$output .= " while( slug.indexOf('--') > 0 ){ ";
									$output .= " slug = slug.replace('--', '-'); ";
								$output .= " } ";
								$output .= " $( '#".$this->attributes['id']."' ).val( slug ); ";
							$output .= " } ";
						$output .= ' }); ';
					$output .= '});';
				$output .= '</script>';
			}
			
			if( $return ){
				return $output;
			}
			
			echo $output;
			return;
			
		}
		
		
		private function render_radios( $return = false ){
			
			$output = '';
			
			if( !$this->columns ){
				$this->columns = 1;
			}
			
			$cols = array();
			$c = 1;
			
			foreach( $this->options as $k => $v ){
				
				$single = '';
				
				$single .= '<label>';
					$single .= '<input';
						$single .= ' type="radio"';
						$single .= ' name="'.$this->name.'"';
						$single .= ' value="'.$k.'"';
						
						if( strval($k) == strval($this->selected) ){
							$single .= ' checked="checked"';
						}
				
						foreach( $this->attributes as $aK => $aV ){
							if( ($aK != 'name') && ($aK != 'id') && ($aK != 'value') && ($aK != 'type') && ($aK != 'checked') ){
								$single .= ' '.$aK.'="'.htmlentities( $aV ).'"';
							}
						}
				
					$single .= '> '.$v;
				$single .= '</label>';
				
				$cols[$c][] = $single;
				
				if( $c == $this->columns ){
					$c = 1;
				} else {
					$c++;
				}
				
			}
			
			$output .= '<div class="checkboxes">';
				foreach( $cols as $k => $v ){
					$output .= '<div class="column">';
						$output .= implode( '', $v );
					$output .= '</div>';
				}
			$output .= '</div>';
			
			if( $return ){
				return $output;
			}
			
			echo $output;
			return;
			
		}
		
		
		private function render_select( $return = false ){
			
			$output = '';
			
			$output .= '<select';
				foreach( $this->attributes as $k => $v ){
					if( $k != 'value' ){
						$output .= ' '.$k.'="'.htmlentities( $v ).'"';
					}
				}
			$output .= '>';
			
				if( is_array($this->options) ){
					foreach( $this->options as $k => $v ){
						
						$output .= '<option';
							$output .= ' value="'.$k.'"';
							if( $k == $this->selected ){
								$output .= ' selected';
							}
						$output .= '>';
							$output .= $v;
						$output .= '</option>';
						
					}
				}
			
			$output .= '</select>';
			
			if( $return ){
				return $output;
			}
			
			echo $output;
			return;
			
		}
		
		
		private function render_select2( $return = false ){
			
			$this->attribute( 'class', 'select2', true );
			
			$output = $this->render_select( true );
			
			$output .= '<script>';
				$output .= '$( document ).ready( function(){';
					$output .= "$( '#".$this->attributes['id']."' ).select2();";
				$output .= '});';
			$output .= '</script>';
			
			if( $return ){
				return $output;
			}
			
			echo $output;
			return;
			
		}
		
		
		private function render_tags( $return = false ){
			
			$this->attribute( 'type', 'text' );
			$this->attribute( 'class', 'tags', true );
			$this->attribute( 'autocomplete', 'off' );
			
			if( $this->attributes['value'] ){
				
				$value = $this->attributes['value'];
				$value = explode( '||', $value );
				
				foreach( $value as $k => $v ){
					if( $v == '' ){
						unset( $value[$k] );
					}
				}
				
				$this->attribute( 'value', implode(',', $value) );
				
			}
			
			$output = $this->render_text( true );
		
			$output .= '<script>';
				$output .= '$( document ).ready( function(){';
					$output .= "$( '#".$this->attributes['id']."' ).tagsInput({ width: 'auto' });";
				$output .= '});';
			$output .= '</script>';
			
			if( $return ){
				return $output;
			}
			
			echo $output;
			return;
			
			
		}
		
		
		private function render_text( $return = false ){
			
			$output = '';
			
			$output .= '<input';
				foreach( $this->attributes as $k => $v ){
					$output .= ' '.$k.'="'.htmlentities( $v ).'"';
				}
			$output .= '>';
			
			
			if( $return ){
				return $output;
			}
			
			echo $output;
			return;
			
		}
		
		
		private function render_textarea( $return = false ){
			
			$output = '';
			
			$output .= '<textarea';
				foreach( $this->attributes as $k => $v ){
					if( $k != 'value' ){
						$output .= ' '.$k.'="'.htmlentities( $v ).'"';
					}
				}
			$output .= '>';
			
				if( $this->attributes['value'] ){
					$output .= $this->attributes['value'];
				}
			
			$output .= '</textarea>';
			
			
			if( $return ){
				return $output;
			}
			
			echo $output;
			return;
			
		}
		
		
		private function render_time( $return = false ){
			
			$this->attribute( 'type', 'text' );
			$this->attribute( 'class', 'timepicker', true );
			$this->attribute( 'autocomplete', 'off' );
			
			if( $this->attributes['value'] ){
				if( 
					( $this->attributes['value'] != '' ) && 
					( $this->attributes['value'] != '0' ) && 
					( strpos($this->attributes['value'], ':') === false )
				){
					$this->attribute( 'value', date('g:ia', $this->attributes['value']) );
				}
			}
			
 			if( $this->attributes['value'] == '0' ){
				$this->attribute( 'value', '' );
			}
			
			$output = $this->render_text( true );
		
			$output .= '<script>';
				$output .= '$( document ).ready( function(){';
					if( $this->format ){
						$output .= "$( '#".$this->attributes['id']."' ).timepicker({ 'step': ".$this->format." });";
					} else {
						$output .= "$( '#".$this->attributes['id']."' ).timepicker({ 'step': 15 });";
					}
				$output .= '});';
			$output .= '</script>';
			
			if( $return ){
				return $output;
			}
			
			echo $output;
			return;
			
		}
		
		
	}

