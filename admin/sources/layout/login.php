<!DOCTYPE HTML>
<html>

	<head>
    	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Please Login (epicPlatform)</title>
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,700">
        <link type="text/css" rel="stylesheet" href="//css.ewsapi.com/reset/reset.min.css" />
        <link type="text/css" rel="stylesheet" href="sources/css/global.css" />
        <link type="text/css" rel="stylesheet" href="sources/css/stylesheet.css" />
        <link type="text/css" rel="stylesheet" href="sources/css/login.css" />
    </head>

    <body>
    
    	<form method="post" action="<? echo $_SERVER['REQUEST_URI']; ?>">
            <div class="login_box">
                
                <div class="logo">
                    <img src="images/ep-login-logo.png" />
                </div>
                
                <? if( $error ){ ?>
                    <div class="notify notify-error">
                        <div class="close"><span class="fa fa-close"></span></div>
                        <h4>Login Error</h4>
                        <div><? echo $error; ?></div>
                    </div>
                <? } ?>
                
                <div class="row">
                	<input type="text" name="username" placeholder="Username" />
                </div>
                
                <div class="row">
                	<input type="password" name="password" placeholder="Password" />
                </div>
                
                <div class="ca row">
                	
                    <div class="l">
                    	<label><input type="checkbox" name="remember" value="1"> Remember Me</label>
                    </div>
                    
                    <div class="r">
                    	<a href="?a=reset"><b>Forgot Your Password?</b></a>
                    </div>
                    
                </div>
                
                <div class="tc row">
                	<input type="submit" name="login_sub" value="Login" />
                </div>
                
            </div>
        </form>
    
    </body>

</html>