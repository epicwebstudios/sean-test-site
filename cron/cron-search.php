<?
    ini_set('display_errors',1);
    $path = explode( '/cron', dirname(__FILE__) );
    define( "BASE_DIR", $path[0] );
	require "../sources/init/connect.php";
    require "../sources/init/global.php";
    require "../sources/php/functions.php";
	require "../sources/php/search-cron.class.php";
	
	$cron = new SearchCron();