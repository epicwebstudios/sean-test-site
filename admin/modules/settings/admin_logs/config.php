<?

	@security();
	
	
	// Database tables associated and used within this module.
	$database 			= array( 'admin_action_logs', 'administrators' );
	
	
	// Database column to be include in any action logs for a specific record.
	$log_item 			= 'name';
	
	
	// The name of this module, in both singular and plural form.
	$item 				= 'administrator action log';
	$item_plural 		= 'administrator action logs';
	
	
	// Database columns to search through.
	// - To disable the search function, leave this array empty.
	$search 			= array( 'id', 'action', 'page' );
	
	
	// Columns to display in listing table
	// - 'title' = Title of the column in the table
	// - 'sort' = Column name of the database table to sort by. To disallow/disable sorting, use 'false', '0', or omit from record.
	// - 'width' = The specific width of the column in the listing table. For automatic sizing, use 'false', '0', or omit from record.
	$columns = array(
		array( 'title' => 'Administrator', 	'sort' => false, 	'width' => 300 ),
		array( 'title' => 'Action Taken', 	'sort' => 'action', 'width' => 0 ),
		array( 'title' => 'Date', 			'sort' => 'date', 	'width' => 150 )
	);
	
	
	// Default ordering for listing table.
	// - If $allow_order is enabled, this will be overridden.
	$order 				= '`date` DESC';
	
	
	// The number of records to display on each page.
	$page_limit 		= 25;
	
	
	// Specify the $_GET filters to look for in URL for pagination controls.
	$filter_list 		= array( 'sb', 'd', 's', 'p', 'debug', 'f_a' );
	

	// Configuration for permissions and plugins.
	$allow_add 			= false;
	$allow_edit 		= false;
	$allow_delete 		= false;
	$allow_order 		= false;
	$allow_duplicate	= false;
	$include_editor		= false;

?>




	