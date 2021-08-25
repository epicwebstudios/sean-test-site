<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
    
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
        <title>Administration (epicPlatform)</title>
        <link rel="shortcut icon" type="image/x-icon" href="<? mainURL(); ?>/admin/images/favicon.ico">
		
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,700">
        <link rel="stylesheet" type="text/css" href="//css.ewsapi.com/icons/icons.min.css" />
        <link rel="stylesheet" type="text/css" href="sources/css/reset.min.css" />
        <link rel="stylesheet" type="text/css" href="sources/css/global.css" />
        <link rel="stylesheet" type="text/css" href="sources/css/timepicker.css" />
        <link rel="stylesheet" type="text/css" href="sources/css/minicolors.css" />
        <link rel="stylesheet" type="text/css" href="sources/css/tags.css" />
        <link rel="stylesheet" type="text/css" href="sources/css/select2.min.css" />
		<link rel="stylesheet" type="text/css" href="sources/css/jquery-ui.1.11.4.min.css" />
        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.37.0/codemirror.min.css">
		<link rel="stylesheet" type="text/css" href="sources/css/stylesheet.css" />
		
		<script type="text/javascript" src="//js.ewsapi.com/jquery/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="//js.ewsapi.com/lightbox/lightbox.min.js"></script>
        <script type="text/javascript" src="sources/js/select2.min.js"></script>
		<script type="text/javascript" src="sources/js/jquery-ui.1.11.4.min.js"></script>
        <script type="text/javascript" src="sources/js/timepicker.js"></script>
        <script type="text/javascript" src="sources/js/minicolors.js"></script>
        <script type="text/javascript" src="sources/js/tags.js"></script>
        <script type="text/javascript" src="sources/js/codemirror.min.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.37.0/codemirror.min.js"></script>
		<script type="text/javascript" src="sources/js/functions.js"></script>
        
		<meta name="viewport" content="width=1050, user-scalable=yes" />
        
	</head>

	<body class="main">
    
    
    	<!-- Header -->
    	<div class="header">
        	
            <div class="ca top">
        
                <div class="l logo">
                    <img src="images/ep-logo.png" />
                </div>
                
                <div class="r tr">
                	
                    <div class="website">
                    	<a href="<? echo $settings['url']; ?>" target="_blank">
                    		<span class="fa fa-home"></span><? echo $settings['name']; ?>
                        </a>
                    </div>
                    
                    <div class="version">
                    	Currently running on epicPlatform <? echo EP_VERSION; ?>
                    </div>
                    
                </div>
            
            </div>
            
            <div class="ca bottom">
            
            	<div class="l">
                	<? require_once BASE_DIR.'/admin/sources/php/menu.php'; ?>
                </div>
                
                <div class="r user">
                	<a href="?a=41">Logged in as <b><? echo $user['first']." ".$user['last']; ?></b></a> (<a href="?a=logout">Logout</a>)
                </div>
            
            </div>
        
        </div>
        
        
        <!-- Content -->
        <div class="content">
        	<? get_page( $_GET['a'] ); ?> 
        </div>
        
	
	</body>

</html>