<!DOCTYPE HTML>
<html>

	<head>
    	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>We're Sorry...</title>
		<link type="text/css" rel="stylesheet" href="//css.ewsapi.com/reset/reset.min.css" />
		<link type="text/css" rel="stylesheet" href="//css.ewsapi.com/global/global.v2.css" />
		<style>
			body { background-color: #FAFAFA; }
			body, html { position: relative; height: 100%; width: 100%; padding: 0; margin: 0; }
			.notify { position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); }
		</style>
	</head>

	<body>
				
        <div class="notify notify-error">
        	<h4>We're Sorry...</h4>
            <div>Your IP address (<? echo $_SERVER['REMOTE_ADDR']; ?>) has been blocked from this website.</div>
            <div>Please contact your network administrator for assistance.</div>
        </div>

	</body>

</html>