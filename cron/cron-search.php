<?

    ini_set('display_errors',1);

    $path = explode( '/cron', dirname(__FILE__) );
    define( 'CORE_DIR', $path[0].'/core' );

	require_once CORE_DIR.'/core.php';
    require_once BASE_DIR.'/sources/php/functions.php';

	$cron = new SearchCron();

    line('Search successfully built!');