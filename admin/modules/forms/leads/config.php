<?

	@security();
	
	
	// Database tables associated and used within this module.
	$database 			= array( 'm_form_leads', 'm_forms' );
	
	
	// Database column to be include in any action logs for a specific record.
	$log_item 			= 'log_value';
	
	
	// The name of this module, in both singular and plural form.
	$item 				= 'form lead capture';
	$item_plural 		= 'form lead captures';
	
	
	// Database columns to search through.
	// - To disable the search function, leave this array empty.
	$search 			= array( 'id', 'fields', 'browser', 'ip' );
	
	
	// Columns to display in listing table
	// - 'title' = Title of the column in the table
	// - 'sort' = Column name of the database table to sort by. To disallow/disable sorting, use 'false', '0', or omit from record.
	// - 'width' = The specific width of the column in the listing table. For automatic sizing, use 'false', '0', or omit from record.
	$columns = array(
		array( 'title' => 'ID', 			'sort' => 'id', 		'width' => 50 ),
		array( 'title' => 'Form', 			'sort' => 'form', 		'width' => 250 ),
		array( 'title' => 'IP Address', 	'sort' => 'ip', 		'width' => 175 ),
		array( 'title' => 'Browser', 		'sort' => 'browser', 	'width' => 0 ),
		array( 'title' => 'Date', 			'sort' => 'date', 		'width' => 175 ),
	);
	
	
	// Default ordering for listing table.
	// - If $allow_order is enabled, this will be overridden.
	$order 				= '`id` DESC';
	
	
	// The number of records to display on each page.
	$page_limit 		= 25;
	
	
	// Specify the $_GET filters to look for in URL for pagination controls.
	$filter_list 		= array( 'sb', 'd', 's', 'p', 'debug', 'f_f' );
	

	// Configuration for permissions and plugins.
	$allow_add 			= false;
	$allow_edit 		= true;
	$allow_delete 		= true;
	$allow_order 		= false;
	$allow_duplicate	= false;
	$include_editor		= false;

?>




	