<?

	@security();
	global $user;
	
	
	// Database tables associated and used within this module.
	$database 			= array( 'file_manager' );
	
	
	// Database column to be include in any action logs for a specific record.
	$log_item 			= 'name';
	
	
	// The name of this module, in both singular and plural form.
	$item 				= 'file manager';
	$item_plural 		= 'file manager';
	
	
	// Database columns to search through.
	// - To disable the search function, leave this array empty.
	$search 			= array( 'id' );
	
	
	// Columns to display in listing table
	// - 'title' = Title of the column in the table
	// - 'sort' = Column name of the database table to sort by. To disallow/disable sorting, use 'false', '0', or omit from record.
	// - 'width' = The specific width of the column in the listing table. For automatic sizing, use 'false', '0', or omit from record.
	$columns = array(
		array( 'title' => '', 						'sort' => false, 	'width' => 40 ),
		array( 'title' => 'File / Folder Name', 	'sort' => false, 	'width' => 0 ),
		array( 'title' => 'URL', 					'sort' => false, 	'width' => 0 ),
		array( 'title' => 'Modified', 				'sort' => false, 	'width' => 150 ),
		array( 'title' => 'Size', 					'sort' => false, 	'width' => 100 ),
		array( 'title' => 'Settings', 				'sort' => false, 	'width' => 40 ),
		array( 'title' => 'Download', 				'sort' => false, 	'width' => 40 ),
		array( 'title' => 'Rename', 				'sort' => false, 	'width' => 40 ),
		array( 'title' => 'Delete', 				'sort' => false, 	'width' => 40 ),
	);

	if( $user['level'] != '1' ){
		unset( $columns[5] );
	}
	
	
	// Default ordering for listing table.
	// - If $allow_order is enabled, this will be overridden.
	$order 				= '`id` DESC';
	
	
	// The number of records to display on each page.
	$page_limit 		= 25;
	
	
	// Specify the $_GET filters to look for in URL for pagination controls.
	$filter_list 		= array( 'sb', 'd', 's', 'p', 'debug' );
	

	// Configuration for permissions and plugins.
	$allow_add 			= false;
	$allow_edit 		= false;
	$allow_delete 		= false;
	$allow_order 		= false;
	$allow_duplicate	= false;
	$include_editor		= false;

