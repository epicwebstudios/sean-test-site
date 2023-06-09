<?	


	/**
	 * Get administrative user details.
	 *
	 * @param int $id User ID.
	 *
	 * @return array User details.
	 */
	
	function getUser( $id ){
		$query	= mysql_query( "SELECT * FROM `administrators` WHERE `id` = '".$id."' LIMIT 1" );
		$info	= mysql_fetch_assoc( $query );
		return $info;
	}	


	/**
	 * Checks whether or not an administrative user is logged in.
	 *
	 * @return boolean Result of login verification.
	 */
	
	function isLoggedIn(){
		$query = mysql_query( "SELECT * FROM `administrators` WHERE `id` = '".$_COOKIE['admin_user']."' AND `password` = '".$_COOKIE['admin_pass']."' AND `status` = '1' LIMIT 1" );
		if( mysql_num_rows($query) > 0 ){
			return true;
		} else {
			setcookie( 'admin_user', '', (time()-1000), '/' );
			setcookie( 'admin_pass', '', (time()-1000), '/' );	
			return false;
		}
	}	


	/**
	 * Security enforcement.
	 *
	 * Essentially a dummy function to make sure resource pages are not being 
	 * called outside of the admin panel.
	 *
	 * @return void
	 */

	function security(){
		if( !isLoggedIn() ){
			redirect( 'index.php' );
		}
	}	


	/**
	 * Generate administrative user reset / action code.
	 *
	 * Generates and saves reset code to a user's account.
	 *
	 * @param int $id User ID.
	 *
	 * @return void
	 */

	function generate_reset_code( $id ){
		
		$reset = time();
		$reset = md5( $reset );
		$reset = substr( $reset, 0, 7 );
		
		$timeout = ( time() + (86400 * 7) );
		
		mysql_query( "UPDATE `administrators` SET `login_reset` = '".$reset."', `reset_valid_until` = '".$timeout."' WHERE `id` = '".$id."' LIMIT 1" );
		
	}	


	/**
	 * Generate administrative user password reset email notification.
	 *
	 * @param int $id User ID.
	 *
	 * @return void
	 */

	function generate_reset_email( $id ){
		
		$settings = siteSettings();
		
		$stmt  = "";
		$stmt .= " SELECT `id`, `email`, `first`, `last`, `login_reset`, `reset_valid_until` ";
		$stmt .= " FROM `administrators` ";
		$stmt .= " WHERE `id` = '".$id."' ";
		$stmt .= " LIMIT 1 ";
		
		$info = mysql_fetch_assoc( mysql_query( $stmt ) );
		
		$message  = '';
		$message .= '<div>You have requested to reset your password on <b>'.$settings['name'].'</b> ('.$settings['url'].'/admin)</div>';
		$message .= '<div>&nbsp;</div>';
		$message .= '<div>To complete the password reset process, please proceed to the following URL:</div>';
		$message .= '<div>&nbsp;</div>';
		$message .= '<div>';
			$message .= '<a href="'.returnURL().'/admin/?a=reset&i='.$info['id'].'&c='.$info['login_reset'].'" target="_blank">';
				$message .= returnURL().'/admin/?a=reset&i='.$info['id'].'&c='.$info['login_reset'];
			$message .= '</a>';
		$message .= '</div>';
		$message .= '<div>&nbsp;</div>';
		$message .= '<div>Once you have opened this URL, simply enter your new desired password</div>';
		$message .= '<div>&nbsp;</div>';
		$message .= '<div>This password reset request is only valid until <b>'.date( 'F jS, Y, g:i A', $info['reset_valid_until'] ).'</b>. After that time, you will need to generate a new password reset request.</div>';
		$message .= '<div>&nbsp;</div>';
		$message .= '<div>If you have not requested a password reset, you can simply ignore this message. No access has been given to your account, and your account has not been changed in any way.</div>';
		$message .= '<div>&nbsp;</div>';
		$message .= '<div>Thank you!</div>';
		$message .= '<div>&nbsp;</div>';
		$message .= '<div>---</div>';
		$message .= '<div>&nbsp;</div>';
		$message .= '<div>This e-mail is automatically generated, all replies will be discarded.</div>';
		
		$mailer = new Mailer();
		
		$mailer
			->to( $info['email'], $info['first'].' '.$info['last'] )
			->subject( 'Password Reset For '.$settings['name'].' Requested' )
			->message( $message );
		
		$send = $mailer->send();
		
		if( $send['result'] ){
			return true;
		}
		
		return false;
		
	}	


	/**
	 * Generate administrative user locked account email notification.
	 *
	 * @param int $id User ID.
	 *
	 * @return void
	 */
	
	function generate_locked_email($id){
		
		$settings = siteSettings();
		
		$stmt  = "";
		$stmt .= " SELECT `id`, `email`, `first`, `last`, `login_reset`, `reset_valid_until` ";
		$stmt .= " FROM `administrators` ";
		$stmt .= " WHERE `id` = '".$id."' ";
		$stmt .= " LIMIT 1 ";
		
		$info = mysql_fetch_assoc( mysql_query( $stmt ) );
		
		$message  = '';
		$message .= '<div>Your administrative account on <b>'.$settings['name'].'</b> ('.$settings['url'].'/admin) has been locked out due to too many invalid login attempts.</div>';
		$message .= '<div>&nbsp;</div>';
		$message .= '<div>In order to re-activate your account, you must complete a password reset. To complete this process, please proceed to the following URL:</div>';
		$message .= '<div>&nbsp;</div>';
		$message .= '<div>';
			$message .= '<a href="'.returnURL().'/admin/?a=reset&i='.$info['id'].'&c='.$info['login_reset'].'" target="_blank">';
				$message .= returnURL().'/admin/?a=reset&i='.$info['id'].'&c='.$info['login_reset'];
			$message .= '</a>';
		$message .= '</div>';
		$message .= '<div>&nbsp;</div>';
		$message .= '<div>Once you have opened this URL, simply enter your new desired password. This will reset your password and unlock your account.</div>';
		$message .= '<div>&nbsp;</div>';
		$message .= '<div>This password reset request is only valid until <b>'.date( 'F jS, Y, g:i A', $info['reset_valid_until'] ).'</b>. After that time, you will need to generate a new password reset request.</div>';
		$message .= '<div>&nbsp;</div>';
		$message .= '<div>Please note that no access has been given to your account, and your account has been locked as a safety precaution.</div>';
		$message .= '<div>&nbsp;</div>';
		$message .= '<div>Thank you!</div>';
		$message .= '<div>&nbsp;</div>';
		$message .= '<div>---</div>';
		$message .= '<div>&nbsp;</div>';
		$message .= '<div>This e-mail is automatically generated, all replies will be discarded.</div>';
		
		$mailer = new Mailer();
		
		$mailer
			->to( $info['email'], $info['first'].' '.$info['last'] )
			->subject( 'Account Locked On '.$settings['name'] )
			->message( $message );
		
		$send = $mailer->send();
		
		if( $send['result'] ){
			return true;
		}
		
		return false;
		
	}	


	/**
	 * Generate administrative user MFA/2FA email notification.
	 *
	 * @param int $id User ID.
	 *
	 * @return void
	 */
	
	function generate_mfa_email( $id ){
		
		$settings = siteSettings();
		
		$stmt  = "";
		$stmt .= " SELECT `id`, `email`, `first`, `last`, `login_reset`, `reset_valid_until` ";
		$stmt .= " FROM `administrators` ";
		$stmt .= " WHERE `id` = '".$id."' ";
		$stmt .= " LIMIT 1 ";
		
		$info = mysql_fetch_assoc( mysql_query( $stmt ) );
		
		$message  = '';
		$message .= '<div>Please enter the following verification code to access your account:</div>';
		$message .= '<div>&nbsp;</div>';
		$message .= '<div style="font-size: 20px;"><b>'.$info['login_reset'].'</b></div>';
		$message .= '<div>&nbsp;</div>';
		$message .= '<div>This verification code will expire in 5 minutes.</div>';
		$message .= '<div>&nbsp;</div>';
		$message .= '<div>The request for this access originated from IP address: '.IP_ADDRESS.'.</div>';
		$message .= '<div>&nbsp;</div>';
		$message .= '<div>If you did not request this code, please reset your password now to ensure your account remains secure.</div>';
		$message .= '<div>&nbsp;</div>';
		$message .= '<div>Thank you!</div>';
		$message .= '<div>&nbsp;</div>';
		$message .= '<div>---</div>';
		$message .= '<div>&nbsp;</div>';
		$message .= '<div>This e-mail is automatically generated, all replies will be discarded.</div>';
		
		$mailer = new Mailer();
		
		$mailer
			->to( $info['email'], $info['first'].' '.$info['last'] )
			->subject( $settings['name'].' Login Verification Code' )
			->message( $message );
		
		$send = $mailer->send();
		
		if( $send['result'] ){
			return true;
		}
		
		return false;
		
	}	


	/**
	 * Check whether administrative user has permission to view a specific page.
	 *
	 * @param int $user User ID.
	 * @param int $page Page ID.
	 *
	 * @return boolean Result of check.
	 */

	function hasPermission( $user, $page ){
		
		$user = getUser( $user );
		
		if( $user['level'] == 1 ){
			return true;
		} else {
			if( $page == 1 ){
				return true;
			} else {
				$query = mysql_query( "SELECT `id` FROM `admin_permissions` WHERE `level` = '".$user['level']."' AND `page` = '".$page."' LIMIT 1" );
				if( mysql_num_rows($query) > 0 ){
					return true;
				} else {
					return false;
				}
			}
		}
		
	}


	/**
	 * Process administrative logout request.
	 */

	if( isset( $_GET['a'] ) && ( $_GET['a'] == 'logout') ){
		setcookie( 'admin_user', '', (time()-1000), '/' );
		setcookie( 'admin_pass', '', (time()-1000), '/' );		
		redirect( 'index.php' );
	}


	/**
	 * Process Two-Factor / MFA administrative login request.
	 */

	$mfa_login 	= false;
	$mfa_fail	= false;

	if( isset($_POST['mfa_login_sub']) ){
	
		$mfa_login = true;
		
		$user_id 	= $_POST['mfa_u'];
		$password 	= $_POST['mfa_p'];
		$code 		= $_POST['mfa_code'];
		
		if( ($user_id != '') && ($password != '') ){
			
			$info = mysql_fetch_assoc( mysql_query( "SELECT * FROM `administrators` WHERE `id` = '".$user_id."' AND `password` = '".$password."' LIMIT 1" ) );
			
			if( $info['id'] ){
				if( $info['status'] == '1' ){
					if( $info['login_reset'] == $code ){
						if( time() <= $info['reset_valid_until'] ){
						
							$timeout = 0;

							if( $remember == 1 ){
								$timeout = ( time() + (86400 * 180) );
							}

							setcookie( 'admin_user', $info['id'], $timeout, "/");
							setcookie( 'admin_pass', $info['password'], $timeout, "/");
							
							$values = array(
								'login_attempts' 	=> 0,
								'login_reset'		=> '',
								'reset_valid_until'	=> 0,
							);
							
							mysql_query( "UPDATE `administrators` ".query_build_set($values)." WHERE `id` = '".$info['id']."' LIMIT 1" );
							
							$success = 1;
							
							redirect( $_SERVER['REQUEST_URI'] );
							
							
						} else {
							$error = '<div>The verification code you entered has expired. Please login again.</div>';
							$mfa_fail = true;
						}
					} else {
						$error = '<div>The verification code you entered is incorrect.</div>';
					}
				} else {
					$error = '<div>Your account is disabled or locked. Please try again later.</div>';
					$mfa_fail = true;
				}
			} else {
				$error = '<div>Your verification attempt failed due to incorrect information.</div>';
				$mfa_fail = true;
			}
			
		} else {
			$error = '<div>Your verification attempt failed due to missing information.</div>';
			$mfa_fail = true;
		}
	
	}


	/**
	 * Process administrative login request.
	 */

	if( isset($_POST['login_sub']) ){
		
		$max_login_attempts = siteSettings( '`max_login_attempts`' );
		$max_login_attempts = $max_login_attempts['max_login_attempts'];
		
		$username = $_POST['username'];
		$password =	$_POST['password'];
		$remember = $_POST['remember'];
		
		if( ($username != '') && ($password != '') ){
		
			$username = strtolower( $username );
			$password = md5( $password );
			
			$query = mysql_query("SELECT * FROM `administrators` WHERE `username` = '".$username."' LIMIT 1");
			if( mysql_num_rows($query) > 0 ){
				
				$info = mysql_fetch_assoc($query);
				
				if( $info['status'] == '1' ){
					if( $info['password'] == $password ){
						
						if( $info['force_mfa'] == '1' ){
							
							$_POST['mfa_u'] = $info['id'];
							$_POST['mfa_p'] = $info['password'];
							
							$values = array(
								'login_reset' 		=> mt_rand( 100000, 999999 ),
								'reset_valid_until' => (time()+(60 *5)),
							);
							
							mysql_query( "UPDATE `administrators` ".query_build_set($values)." WHERE `id` = '".$info['id']."' LIMIT 1" );
							generate_mfa_email( $info['id'] );
							
							$mfa_login = true;
							
						} else {
						
							$timeout = 0;

							if( $remember == 1 ){
								$timeout = ( time() + (86400 * 180) );
							}

							setcookie( 'admin_user', $info['id'], $timeout, "/");
							setcookie( 'admin_pass', $info['password'], $timeout, "/");
							
							$values = array(
								'login_attempts' 	=> 0,
								'login_reset'		=> '',
								'reset_valid_until'	=> 0,
							);
							
							mysql_query( "UPDATE `administrators` ".query_build_set($values)." WHERE `id` = '".$info['id']."' LIMIT 1" );
							
							$success = 1;
							
							redirect( $_SERVER['REQUEST_URI'] );
							
						}
						
					} else {
						
						$attempts = ( $info['login_attempts'] + 1 );
						
						if( ($max_login_attempts != '0') && ($attempts >= $max_login_attempts) ){
							mysql_query( "UPDATE `administrators` SET `login_attempts` = '".$attempts."', `status` = '2' WHERE `id` = '".$info['id']."' LIMIT 1" );
							$error = '<div>Maximum login attempts have been reached for this account. Please check your e-mail for details to re-activate you account.</div>';
							generate_reset_code( $info['id'] );
							generate_locked_email( $info['id'] );
						} else {
							mysql_query( "UPDATE `administrators` SET `login_attempts` = '".$attempts."' WHERE `id` = '".$info['id']."' LIMIT 1" );
							$error = '<div>The password you entered is invalid.</div>';
						}
						
					}
				} else {
					
					if( $info['status'] == '0' ){
						$error = '<div>The account you are trying access is currently disabled.</div>' . '<div>Please try again later.</div>';
					} else if( $info['status'] == '2' ){
						$error = '<div>This account has been locked due to too many invalid login attempts.</div>' . '<div>Please click here to <a href="?a=reset">reset your account</a>.</div>';
					}
					
				}
				
			} else {
				$error = '<div>The username you entered is invalid.</div>';
			}
			
		} else {
			$error = '<div>You must enter a username and password.</div>';
		}

	}


	/**
	 * Process administrative password reset request.
	 */

	if( isset($_POST['request_sub']) ){
		
		$account = $_POST['account'];
		
		$query = mysql_query( "SELECT * FROM `administrators` WHERE `email` = '".$account."' OR `username` = '".$account."' LIMIT 1" );
		if( mysql_num_rows($query) > 0 ){
			$info = mysql_fetch_assoc( $query );
			generate_reset_code($info['id']);
			generate_reset_email($info['id']);
			$request_success = "<div>Please follow the instructions sent to your e-mail to complete your password reset.</div>";
		} else {
			$request_error = "<div>The username or e-mail you entered is invalid. Please try again.</div>";
		}
		
	}


	/**
	 * Process administrative password reset submission.
	 */

	if( isset($_POST['reset_sub']) ){
	
		$uid = $_POST['uid'];
		$code = $_POST['code'];
		$pass = $_POST['pass'];
		$pass_confirm = $_POST['pass_confirm'];
		
		$info = mysql_fetch_assoc( mysql_query("SELECT * FROM `administrators` WHERE `id` = '".$uid."' LIMIT 1") );
		
		if($pass == $pass_confirm){
			if($code == $info['login_reset']){
				if(time() < $info['reset_valid_until']){
					mysql_query("UPDATE `administrators` SET `password` = '".md5($pass)."', `login_reset` = '', `status` = '1', `reset_valid_until` = '0' WHERE `id` = '".$uid."' LIMIT 1");
					redirect("?a=reset&done=1");
				}
			}
		}
	
	}


