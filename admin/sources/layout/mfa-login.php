<!DOCTYPE HTML>
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Enter Verification Code (epicPlatform)</title>
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,700">
		<link type="text/css" rel="stylesheet" href="//css.ewsapi.com/reset/reset.min.css" />
		<link type="text/css" rel="stylesheet" href="sources/css/global.css" />
		<link type="text/css" rel="stylesheet" href="sources/css/stylesheet.css" />
		<link type="text/css" rel="stylesheet" href="sources/css/login.css" />
		<script src="//js.ewsapi.com/jquery/jquery-1.10.2.min.js"></script>
		<script>

			function check_form(){

				var code = $( '#code' ).val();

				if( code == '' ){
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

				<div class="tc row">
					<b>Login Verification</b>
				</div>

				<? if( $error ){ ?>
					<div class="notify notify-error">
						<div class="close"><span class="fa fa-close"></span></div>
						<h4>Verification Error</h4>
						<div><? echo $error; ?></div>
					</div>
				<? } else { ?>
					<div class="notify notify-warning">
						<div class="close"><span class="fa fa-close"></span></div>
						<div>Please check your e-mail for your login verification code.</div>
					</div>
				<? } ?>
				
				<? if( !$mfa_fail ){ ?>

					<input type="hidden" name="mfa_u" value="<? echo $_POST['mfa_u']; ?>" />
					<input type="hidden" name="mfa_p" value="<? echo $_POST['mfa_p']; ?>" />

					<div class="row">
						<input
							type="text"
							id="code"
							name="mfa_code"
							placeholder="••••••"
							style="font-size: 2em; padding: 0.5em 1em; text-align: center; letter-spacing: .5em;"
						/>
					</div>

					<div class="tc row">
						<input type="submit" name="mfa_login_sub" value="Login" />
					</div>
				
				<? } else { ?>
                    
                    <div class="tc row">
                    	<input type="button" value="Return To Login" onClick="window.location='?';" />
                    </div>
				
				<? } ?>

			</div>
		</form>

	</body>

</html>
