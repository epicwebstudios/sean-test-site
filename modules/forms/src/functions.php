<?
	function form_render( $form_id ){
	
		$output = '';
		
		if( is_array($_POST['form_messages'][$form_id]) ){
			$message = $_POST['form_messages'][$form_id];
			$output .= '<div class="notify notify-'.$message['class'].'">';
				$output .= '<h4>'.$message['title'].'</h4>';
				$output .= '<div>'.$message['message'].'</div>';
			$output .= '</div>';
		}
	
		$form = mysql_fetch_assoc( mysql_query( "SELECT * FROM `m_forms` WHERE `id` = '".$form_id."' LIMIT 1" ) );

		if ($form['recaptcha'])
			require_once __DIR__.'/recaptcha.html';
		
		if( ($form['id']) && ($form['status'] == '1') ){
			
			$output .= '<script>';
				$output .= 'form_states['.$form['id'].'] = false;';
			$output .= '</script>';
			
			$output .= '<div class="ca form_module">';
				$output .= '<form method="post" enctype="multipart/form-data" onsubmit="return form_verify('.$form['id'].');" id="form_'.$form['id'].'">';
				
					$output .= '<input type="hidden" name="form_id" value="'.$form['id'].'">';
					$output .= '<input type="hidden" name="on_page" id="on_page" value="'.returnURL().'/'.$_GET['act'].'">';
					
					$output .= '<input';
						$output .= ' type="hidden"';
						$output .= ' name="lead_id"';
						$output .= ' id="lead_id"';
						$output .= ' value="';
							if( ($_POST['form_id'] == $form['id']) && ($_POST['lead_id']) ){ $output .= $_POST['lead_id']; }
						$output .= '"';
					$output .= '>';
				
					$rQ = mysql_query( "SELECT * FROM `m_form_fields` WHERE `form` = '".$form['id']."' ORDER BY `order` ASC" );
					while( $r = mysql_fetch_assoc($rQ) ){
						
						$id				= $r['id'];
						$label 			= $r['label'];
						$type			= $r['type'];
						$placeholder 	= $r['placeholder'];
						$values 		= $r['values'];
						$notes			= $r['notes'];
						$width  		= $r['width'];
						$height 		= $r['height'];
						$alignment 		= $r['alignment'];
						$columns 		= $r['columns'];
						$validation 	= $r['validation'];
						$class			= '';
						
						if( $validation > 0 ){
							$class		= 'validate_'.$validation;
						}
						
						$output .= '<div class="l w_'.$width.'">';

						    if( $type != '8' ){
                                $output .= '<div class="p_a">';
                            }

								if( $_GET['form_labeless'] != '1' ){
									if( $type != '7' && $type != '8'){
										$output .= '<div class="label">';
											$output .= $label;
											if( $validation > 0 ){
												$output .= ' <i class="required">*</i>';
											}
										$output .= '</div>';
									}
								}
								
								$output .= '<div class="ca field">';
					
									// 1: Text
									if( $type == '1' ){
										
										$output .= '<input';
											$output .= ' type="text"';
											$output .= ' id="field_'.$id.'"';
											$output .= ' name="field_'.$id.'"';
											$output .= ' data-label="'.htmlentities( $label ).'"';
											$output .= ' data-form-id="'.$form['id'].'"';
											$output .= ' placeholder="'.$placeholder.'"';
											$output .= ' value="'.$_POST['field_'.$id].'"';
											$output .= ' class="'.$class.'"';
										$output .= '>';
										
									}
									
									// 2: Textarea
									if( $type == '2' ){
										
										$output .= '<textarea';
											$output .= ' id="field_'.$id.'"';
											$output .= ' name="field_'.$id.'"';
											$output .= ' data-label="'.htmlentities( $label ).'"';
											$output .= ' data-form-id="'.$form['id'].'"';
											$output .= ' placeholder="'.$placeholder.'"';
											$output .= ' class="'.$class.'"';
										$output .= '>';
											$output .= $_POST['field_'.$id];
										$output .= '</textarea>';
									
									}
									
									// 3: Select
									if( $type == '3' ){
									
										$values = str_replace( "\r\n", "\n", $values );
										$values = explode( "\n", $values );
										
										$output .= '<select';
											$output .= ' id="field_'.$id.'"';
											$output .= ' name="field_'.$id.'"';
											$output .= ' data-label="'.htmlentities( $label ).'"';
											$output .= ' data-form-id="'.$form['id'].'"';
											$output .= ' class="'.$class.'"';
										$output .= '>';
											
											foreach( $values as $option ){
												
												$output .= '<option';
													$output .= ' value="'.$option.'"';
													if( $option == $_POST['field_'.$id] ){
														$output .= ' selected';
													}
												$output .= '>';
													$output .= $option;
												$output .= '</option>';
												
											}
											
										$output .= '</select>';
									
									}
									
									// 4: Checkboxes
									if( $type == '4' ){
									
										$values = str_replace( "\r\n", "\n", $values );
										$values = explode( "\n", $values );
										
										$i = 1;
										
										$output .= '<div';
											$output .= ' data-label="'.htmlentities( $label ).'"';
											if( $validation == '3' ){
												$output .= ' class="validate_3"';
											}
										$output .= '>';
										
											if( $alignment == '3' ){
												
												$column_values = array();
												$c = 1;
												
												foreach( $values as $value ){
													$column_values[$c][] = $value;
													if( $c < $columns ){ $c++; } else { $c = 1; }
												}
												
												foreach( $column_values as $column ){
													
													$output .= '<div class="l column">';
										
														foreach( $column as $option ){
															
															$output .= '<div class="option">';
															
																$output .= '<label>';
														
																	$output .= '<input';
																		$output .= ' type="checkbox"';
																		$output .= ' id="field_'.$id.'_'.$i.'"';
																		$output .= ' name="field_'.$id.'[]"';
																		$output .= ' data-label="'.htmlentities( $label ).'"';
																		$output .= ' data-form-id="'.$form['id'].'"';
																		$output .= ' value="'.$option.'"';
																		if( $option == $_POST['field_'.$id] ){
																			$output .= ' selected';
																		}
																	$output .= '>';
																	
																	$output .= ' '.$option;
																	
																$output .= '</label>';
																
																$i++;
															
															$output .= '</div>';
														
														}
													
													$output .= '</div>';
													
												}
												
											} else {
										
												foreach( $values as $option ){
												
													if( $alignment == '1' ){
														$output .= '<div>';
													} else if( $alignment == '2' ){
														$output .= '<div class="ilb p_r">';
													}
													
														$output .= '<label>';
												
															$output .= '<input';
																$output .= ' type="checkbox"';
																$output .= ' id="field_'.$id.'_'.$i.'"';
																$output .= ' name="field_'.$id.'[]"';
																$output .= ' data-label="'.htmlentities( $label ).'"';
																$output .= ' data-form-id="'.$form['id'].'"';
																$output .= ' value="'.$option.'"';
																if( $option == $_POST['field_'.$id] ){
																	$output .= ' selected';
																}
															$output .= '>';
															
															$output .= ' '.$option;
															
														$output .= '</label>';
													
													$output .= '</div>';
													
													$i++;
												
												}
											
											}
										
										$output .= '</div>';
									
									}
									
									// 5: Radio Buttons
									if( $type == '5' ){
									
										$values = str_replace( "\r\n", "\n", $values );
										$values = explode( "\n", $values );
										
										$i = 1;
										
										$output .= '<div';
											$output .= ' data-label="'.htmlentities( $label ).'"';
											if( $validation == '3' ){
												$output .= ' class="validate_3"';
											}
										$output .= '>';
										
											if( $alignment == '3' ){
												
												$column_values = array();
												$c = 1;
												
												foreach( $values as $value ){
													$column_values[$c][] = $value;
													if( $c < $columns ){ $c++; } else { $c = 1; }
												}
												
												foreach( $column_values as $column ){
													
													$output .= '<div class="l column">';
										
														foreach( $column as $option ){
															
															$output .= '<div class="option">';
															
																$output .= '<label>';
														
																	$output .= '<input';
																		$output .= ' type="radio"';
																		$output .= ' id="field_'.$id.'_'.$i.'"';
																		$output .= ' name="field_'.$id.'"';
																		$output .= ' data-label="'.htmlentities( $label ).'"';
																		$output .= ' data-form-id="'.$form['id'].'"';
																		$output .= ' value="'.$option.'"';
																		if( $option == $_POST['field_'.$id] ){
																			$output .= ' selected';
																		}
																	$output .= '>';
																	
																	$output .= ' '.$option;
																	
																$output .= '</label>';
																
																$i++;
															
															$output .= '</div>';
														
														}
													
													$output .= '</div>';
													
												}
												
											} else {
										
												foreach( $values as $option ){
												
													if( $alignment == '1' ){
														$output .= '<div>';
													} else if( $alignment == '2' ){
														$output .= '<div class="ilb p_r">';
													}
													
														$output .= '<label>';
												
															$output .= '<input';
																$output .= ' type="radio"';
																$output .= ' id="field_'.$id.'_'.$i.'"';
																$output .= ' name="field_'.$id.'"';
																$output .= ' data-label="'.htmlentities( $label ).'"';
																$output .= ' data-form-id="'.$form['id'].'"';
																$output .= ' value="'.$option.'"';
																if( $option == $_POST['field_'.$id] ){
																	$output .= ' selected';
																}
															$output .= '>';
															
															$output .= ' '.$option;
															
														$output .= '</label>';
													
													$output .= '</div>';
													
													$i++;
												
												}
											
											}
										
										$output .= '</div>';
																		
									}
									
									// 6: File
									if( $type == '6' ){
										
										$output .= '<input';
											$output .= ' type="file"';
											$output .= ' id="field_'.$id.'"';
											$output .= ' name="field_'.$id.'"';
											$output .= ' data-label="'.htmlentities( $label ).'"';
											$output .= ' data-form-id="'.$form['id'].'"';
											$output .= ' value="'.$_POST['field_'.$id].'"';
											$output .= ' class="'.$class.'"';
										$output .= '>';
									
									}
									
									// 7: Label / Category
									if( $type == '7' ){
									
										$output .= '<h2>';
											$output .= $label;
										$output .= '</h2>';
									
									}

									if( $type == '8' ){

									    $output .= "<div class='c'></div>";

                                    }
								
								$output .= '</div>';
								
								if( $notes ){
									$output .= '<div class="notes">';
										$output .= nl2br( $notes );
									$output .= '</div>';
								}

                        if( $type != '8' ){
                            $output .= '</div>'; //end div p_a
                        }

						$output .= '</div>'; //end div w_*width
					
					}
					
					$output .= '<div class="c"></div>';

					if( $form['recaptcha'] )
                        $output .= '<div id="recaptcha_box_'.$form_id.'" class="g-recaptcha" data-sitekey="'.$form['recaptcha_site_key'].'"></div>';

					
					$output .= '<div class="p_a submit">';
										
						$output .= '<input';
							$output .= ' type="submit"';
							$output .= ' name="form_module_sub"';
							$output .= ' value="'.$form['button_text'].'"';
						$output .= '>';
										
					$output .= '</div>';
				
				$output .= '</form>';
			$output .= '</div>';
			
			echo $output;

		}
	
	}