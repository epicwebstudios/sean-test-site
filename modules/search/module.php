<?
    require BASE_DIR."/sources/php/search.class.php";

	if( isset($_POST['search']) ){
	
		$keyword 	= mysql_escape_string( $_POST['search'] );
		$search 	= new Search( $keyword );
		$search->do_search();
	
	}


