<?

	if( ($_GET['i']) && ($_GET['c']) ){
		
		$info = mysql_fetch_assoc( mysql_query("SELECT * FROM `administrators` WHERE `id` = '".$_GET['i']."' LIMIT 1") );
		
		if( $info['login_reset'] == $_GET['c'] ){
			if( time() > $info['reset_valid_until'] ){
				$error = "<div>The requested reset could not be completed. The reset code has expired.</div>";
			}
		} else {
			$error = "<div>The requested reset could not be completed. The code does not match the reset code on file.</div>";
		}
		
?>

    <!DOCTYPE HTML>
    <html>
    
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <title>Reset Your Password (epicPlatform)</title>
        	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,700">
            <link type="text/css" rel="stylesheet" href="//css.ewsapi.com/reset/reset.min.css" />
            <link type="text/css" rel="stylesheet" href="sources/css/global.css" />
            <link type="text/css" rel="stylesheet" href="sources/css/stylesheet.css" />
            <link type="text/css" rel="stylesheet" href="sources/css/login.css" />
            <script src="//js.ewsapi.com/jquery/jquery-1.10.2.min.js"></script>
            <script>
            
                function check_form(){
                    
                    var pass_1 = $( '#password_1' ).val();
                    var pass_2 = $( '#password_2' ).val();
                    
                    if( pass_1 != pass_2 ){
                        alert( 'The passwords you entered do not match.' );
                        return false;
                    }
					
					return true;
                    
                }
                
            </script>
        </head>
    
        <body>
        
            <form method="post" action="<? echo $_SERVER['REQUEST_URI']; ?>"  onsubmit="return check_form();">
                <div class="login_box">
                    
                    <div class="logo">
                        <img src="images/ep-login-logo.png" />
                    </div>
                    
                    <? if( $error ){ ?>
                        
                        <div class="notify notify-error">
                            <div class="close"><span class="fa fa-close"></span></div>
                            <h4>Reset Error</h4>
                            <div><? echo $error; ?></div>
                        </div>
                    
                        <div class="tc row">
                            <b>Reset Your Account Password</b>
                        </div>
                        
                        <div class="tc row">
                        	<input type="button" value="Request New Reset Code" onclick="window.location='?a=reset';" />
                        </div>
                        
                    <? } else { ?>
                    
                        <div class="tc row">
                            <b>Reset Your Account Password</b>
                        </div>
                        
                        <div class="tc row">
                            Enter your username or e-mail address to reset your password or reactivate a locked account.
                        </div>
                        
                        <input type="hidden" name="uid" value="<? echo $_GET['i']; ?>" />
                        <input type="hidden" name="code" value="<? echo $_GET['c']; ?>" />
                        
                        <div class="row">
                            <input type="password" id="password_1" name="pass" placeholder="New Password" />
                        </div>
                        
                        <div class="row">
                            <input type="password" id="password_2" name="pass_confirm" placeholder="Confirm Password" />
                        </div>
                        
                        <? if( $info['status'] == '2' ){ ?>
                            <div class="tc row">
                                <b>Note:</b> Once a new password is set, your account will be unlocked.
                            </div>
                        <? } ?>
                        
                        <div class="tc row">
                            <input type="submit" name="reset_sub" value="Reset Account" />
                        </div>
                        
					<? } ?>
                    
                </div>
            </form>
        
        </body>
    
    </html>

<?
	} else if( $_GET['done'] == '1' ){
?>

    <!DOCTYPE HTML>
    <html>
    
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <title>Password Reset Successful (epicPlatform)</title>
            <link type="text/css" rel="stylesheet" href="//css.ewsapi.com/reset/reset.min.css" />
            <link type="text/css" rel="stylesheet" href="sources/css/global.css" />
            <link type="text/css" rel="stylesheet" href="sources/css/stylesheet.css" />
            <link type="text/css" rel="stylesheet" href="sources/css/login.css" />
        </head>
    
        <body>
        
            <form method="post" action="<? echo $_SERVER['REQUEST_URI']; ?>"  onsubmit="return check_form();">
                <div class="login_box">
                    
                    <div class="logo">
                        <img src="images/ep-login-logo.png" />
                    </div>
                    
                    <div class="notify notify-success">
                    	<h4>Password Reset Successful</h4>
                    	<div>Your account has been reset successfully!</div>
					</div>
                    
                    <div class="tc row">
                    	<input type="button" value="Return To Login" onClick="window.location='?';" />
                    </div>
                    
                </div>
            </form>
        
        </body>
    
    </html>

<?
	} else {
?>

    <!DOCTYPE HTML>
    <html>
    
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <title>Reset Your Password (epicPlatform)</title>
            <link type="text/css" rel="stylesheet" href="//css.ewsapi.com/reset/reset.min.css" />
            <link type="text/css" rel="stylesheet" href="sources/css/global.css" />
            <link type="text/css" rel="stylesheet" href="sources/css/stylesheet.css" />
            <link type="text/css" rel="stylesheet" href="sources/css/login.css" />
            <script src="//js.ewsapi.com/jquery/jquery-1.10.2.min.js"></script>
            <script>
            
                function check_form(){
                    
                    var pass_1 = $( '#password_1' ).val();
                    var pass_2 = $( '#password_2' ).val();
                    
                    if( pass_1 != pass_2 ){
                        alert( 'The passwords you entered do not match.' );
                        return false;
                    }
                    
                }
                
            </script>
        </head>
    
        <body>
        
            <form method="post" action="<? echo $_SERVER['REQUEST_URI']; ?>"  onsubmit="return check_form();">
                <div class="login_box">
                    
                    <div class="logo">
                        <img src="images/ep-login-logo.png" />
                    </div>
                    
                    <? if( $request_error ){ ?>
                        <div class="notify notify-error">
                            <div class="close"><span class="fa fa-close"></span></div>
                            <h4>Reset Error</h4>
                            <div><? echo $request_error; ?></div>
                        </div>
                    <? } ?>
                    
                    <? if( $request_success ){ ?>
                        <div class="notify notify-success">
                            <div class="close"><span class="fa fa-close"></span></div>
                            <h4>Reset Request Sent</h4>
                            <div><? echo $request_success; ?></div>
                        </div>
                    <? } ?>
                    
                    <div class="tc row">
                        <b>Reset Your Account Password</b>
                    </div>
                    
                    <div class="tc row">
                        Enter your username or e-mail address to reset your password or reactivate a locked account.
                    </div>
                    
                    <div class="row">
                        <input type="text" name="account" placeholder="Username or E-mail Address" />
                    </div>
                    
                    <div class="tc row">
                    	<input type="submit" name="request_sub" value="Request Password Reset" />
                    </div>
                    
                </div>
            </form>
        
        </body>
    
    </html>
    
<?
	}
?>
