<?
	
	
	// Get the information on record for the specified user.
	function getUser( $id ){
		$query	= mysql_query( "SELECT * FROM `administrators` WHERE `id` = '".$id."' LIMIT 1" );
		$info	= mysql_fetch_assoc( $query );
		return $info;
	}
	

	// Checks to see if the current saved cookies are valid login credentials.
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


	// This function is essentially a dummy function to make sure resource pages are not being called outside of the admin panel.
	function security(){
		if( !isLoggedIn() ){
			redirect( 'index.php' );
		}
	}


	// Generates reset account code, as well as sets validity date of reset code.
	function generate_reset_code( $id ){
		
		$reset = time();
		$reset = md5( $reset );
		$reset = substr( $reset, 0, 7 );
		
		$timeout = ( time() + (86400 * 7) );
		
		mysql_query( "UPDATE `administrators` SET `login_reset` = '".$reset."', `reset_valid_until` = '".$timeout."' WHERE `id` = '".$id."' LIMIT 1" );
		
	}
	
	
	// Generates reset e-mail to be sent to the administrator's email address
	function generate_reset_email( $id ){
		
		$settings = siteSettings();
		
		$info = mysql_fetch_assoc( mysql_query("SELECT `email`, `id`, `login_reset`, `reset_valid_until` FROM `administrators` WHERE `id` = '".$id."' LIMIT 1") );
		
		$m_subject = 'Password Reset For '.$settings['name'].' Requested';
		
		$m_msg  = '';
		$m_msg .= 'You have requested to reset your password on '.$settings['name'].' (on '.$settings['url'].'/admin)' . "\n";
		$m_msg .= "\n";
		$m_msg .= 'To complete the reset process, please proceed to the following URL:' . "\n";
		$m_msg .= "\n";
		$m_msg .= returnURL().'/admin/?a=reset&i='.$info['id'].'&c='.$info['login_reset'] . "\n";
		$m_msg .= "\n";
		$m_msg .= 'Once you have opened this URL, simply enter your new desired password.' . "\n";
		$m_msg .= "\n";
		$m_msg .= 'The above link is only valid until '.date( 'F jS, Y \\a\\t g:i A', $info['reset_valid_until'] ).'. After this time, you must regenerate a new password reset request.' . "\n";
		$m_msg .= "\n";
		$m_msg .= 'If you have not requested a password reset, you can simply ignore this message. No access has been given to your account, and your account has not been changed in any way.' . "\n";
		$m_msg .= "\n";
		$m_msg .= 'Thank you!' . "\n";
		$m_msg .= "\n";
		$m_msg .= '---' . "\n";
		$m_msg .= 'This e-mail is automatically generated. Any responses to this e-mail account are not monitored or retrieved.';
		
		$m_from = $settings['email'];
		
		mail( $info['email'], $m_subject, $m_msg, 'From:'.$m_from, '-f'.$m_from );
		
	}
	
	
	// Generates reset e-mail to be sent to the administrator's email address
	function generate_locked_email($id){
		
		$settings = siteSettings();
		
		$info = mysql_fetch_assoc( mysql_query("SELECT `email`, `id`, `login_reset`, `reset_valid_until` FROM `administrators` WHERE `id` = '".$id."' LIMIT 1") );
		
		$m_subject = 'Account Locked For '.$settings['name'];
		
		$m_msg  = '';
		$m_msg .= 'Your administrative account on '.$settings['name'].' (on '.$settings['url'].'/admin) has been locked out due to too many invalid login attempts.' . "\n";
		$m_msg .= "\n";
		$m_msg .= 'In order to active your account, you must complete the reset process. To complete this process, please proceed to the following URL:' . "\n";
		$m_msg .= "\n";
		$m_msg .= returnURL().'/admin/?a=reset&i='.$info['id'].'&c='.$info['login_reset'] . "\n";
		$m_msg .= "\n";
		$m_msg .= 'Once you have opened this URL, simply enter your new desired password. This will reset your password and unlock your account.' . "\n";
		$m_msg .= "\n";
		$m_msg .= 'The above link is only valid until '.date( 'F jS, Y \\a\\t g:i A', $info['reset_valid_until'] ).'. After this time, you must regenerate a new reset request.' . "\n";
		$m_msg .= "\n";
		$m_msg .= 'Please note that no access has been given to your account, and your account has been locked as a safety precaution.' . "\n";
		$m_msg .= "\n";
		$m_msg .= 'Thank you!' . "\n";
		$m_msg .= "\n";
		$m_msg .= '---' . "\n";
		$m_msg .= 'This e-mail is automatically generated. Any responses to this e-mail account are not monitored or retrieved.';
		
		$m_from = $settings['email'];
		
		mail( $info['email'], $m_subject, $m_msg, 'From:'.$m_from, '-f'.$m_from );
		
	}
	
	
	// This function checks to make sure the user has access to this page, if not, they are redirected to the homepage.
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


	if( isset( $_GET['a'] ) && ( $_GET['a'] == 'logout') ){
		setcookie( 'admin_user', '', (time()-1000), '/' );
		setcookie( 'admin_pass', '', (time()-1000), '/' );		
		redirect( 'index.php' );
	}


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
						
						$timeout = 0;
						
						if( $remember == 1 ){
							$timeout = ( time() + (86400 * 180) );
						}
						
						setcookie( 'admin_user', $info['id'], $timeout, "/");
						setcookie( 'admin_pass', $info['password'], $timeout, "/");
						mysql_query( "UPDATE `administrators` SET `login_attempts` = '0', `login_reset` = '' WHERE `id` = '".$info['id']."' LIMIT 1" );
						$success = 1;
						redirect( $_SERVER['REQUEST_URI'] );
						
					} else {
						
						$attempts = ( $info['login_attempts'] + 1 );
						
						if( ($max_login_attempts != '0') && ($attempts >= $max_login_attempts) ){
							mysql_query( "UPDATE `administrators` SET `login_attempts` = '".$attempts."', `status` = '2' WHERE `id` = '".$info['id']."' LIMIT 1" );
							$error = '<div>Maximum login attempts have been reached for this account. Please check your e-mail for details to reactive you account.</div>';
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
						$error = '<div>This account has been locked due to too many invalid login attempts.</div>' . '<div>Please click here to <a href=\"?a=reset\">reset your account</a>.</div>';
					}
					
				}
				
			} else {
				$error = '<div>The username you entered is invalid.</div>';
			}
			
		} else {
			$error = '<div>You must enter a username and password.</div>';
		}

	}
	
	
	// Process Reset Request
	if(isset($_POST['request_sub'])){
		
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
	
	
	// Process Reset Submission
	if(isset($_POST['reset_sub'])){
	
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


