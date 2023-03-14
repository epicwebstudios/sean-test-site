<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <? if( defined('IS_AJAX') ){ echo 'class="ajax"'; } ?>>

	<head>
    
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
        <title>Administration (epicPlatform)</title>
        <link rel="shortcut icon" type="image/x-icon" href="<? mainURL(); ?>/admin/images/favicon.ico">
		
		<link rel="stylesheet" href="<? mainURL(); ?>/core/css/sf-pro-text.css" />
		<link rel="stylesheet" href="<? mainURL(); ?>/core/css/sf-pro-display.css" />
        <link rel="stylesheet" href="<? mainURL(); ?>/core/css/fa4.min.css" />
        <link rel="stylesheet" href="<? mainURL(); ?>/admin/sources/css/reset.min.css" />
        <link rel="stylesheet" href="<? mainURL(); ?>/admin/sources/css/global.css" />
        <link rel="stylesheet" href="<? mainURL(); ?>/admin/sources/css/timepicker.css" />
        <link rel="stylesheet" href="<? mainURL(); ?>/admin/sources/css/minicolors.css" />
        <link rel="stylesheet" href="<? mainURL(); ?>/admin/sources/css/tags.css" />
        <link rel="stylesheet" href="<? mainURL(); ?>/admin/sources/css/select2.min.css" />
		<link rel="stylesheet" href="<? mainURL(); ?>/admin/sources/css/jquery-ui.1.11.4.min.css" />
        <link rel="stylesheet" href="<? mainURL(); ?>/admin/sources/css/codemirror.min.css">
		<link rel="stylesheet" href="<? mainURL(); ?>/admin/sources/css/stylesheet.css" />
		
		<? if( $_COOKIE['ews_dark_mode'] == '1' ){ ?>
			<link rel="stylesheet" href="<? mainURL(); ?>/admin/sources/css/dark-mode.css" />
		<? } ?>
		
		<script type="text/javascript" src="<? mainURL(); ?>/core/js/jquery.latest.min.js"></script>
		<script type="text/javascript" src="<? mainURL(); ?>/core/js/lightbox.min.js"></script>
        <script type="text/javascript" src="<? mainURL(); ?>/admin/sources/js/select2.min.js"></script>
		<script type="text/javascript" src="<? mainURL(); ?>/admin/sources/js/jquery-ui.1.11.4.min.js"></script>
        <script type="text/javascript" src="<? mainURL(); ?>/admin/sources/js/timepicker.js"></script>
        <script type="text/javascript" src="<? mainURL(); ?>/admin/sources/js/minicolors.js"></script>
        <script type="text/javascript" src="<? mainURL(); ?>/admin/sources/js/tags.js"></script>
        <script type="text/javascript" src="<? mainURL(); ?>/admin/sources/js/codemirror.min.js"></script>
		<script type="text/javascript" src="<? mainURL(); ?>/admin/sources/js/functions.js"></script>
        
		<meta name="viewport" content="width=1050, user-scalable=yes" />
        
	</head>

	<body class="main">