<?

	@security();
	
	
	// Database tables associated and used within this module.
	$database 			= array( 'm_locations' );
	
	
	// Database column to be include in any action logs for a specific record.
	$log_item 			= 'name';
	
	
	// The name of this module, in both singular and plural form.
	$item 				= 'location';
	$item_plural 		= 'locations';
	
	
	// Database columns to search through.
	// - To disable the search function, leave this array empty.
	$search 			= array( 'id', 'name', 'address', 'address_2', 'city', 'state', 'zip', 'phone', 'fax', 'tollfree' );
	
	
	// Columns to display in listing table
	// - 'title' = Title of the column in the table
	// - 'sort' = Column name of the database table to sort by. To disallow/disable sorting, use 'false', '0', or omit from record.
	// - 'width' = The specific width of the column in the listing table. For automatic sizing, use 'false', '0', or omit from record.
	$columns = array(
		array( 'title' => 'Name', 			'sort' => 'name', 		'width' => 0 ),
		array( 'title' => 'Address', 		'sort' => 'address',	'width' => 0 ),
		array( 'title' => 'City', 			'sort' => 'city', 		'width' => 0 ),
		array( 'title' => 'State', 			'sort' => 'state', 		'width' => 0 ),
		array( 'title' => 'Zip Code', 		'sort' => 'zip', 		'width' => 75 ),
		array( 'title' => 'Phone Number', 	'sort' => 'phone', 		'width' => 150 ),
		array( 'title' => 'Status', 		'sort' => 'status', 	'width' => 135 )
	);
	
	
	// Default ordering for listing table.
	// - If $allow_order is enabled, this will be overridden.
	$order 				= '`id` DESC';
	
	
	// The number of records to display on each page.
	$page_limit 		= 25;
	
	
	// Specify the $_GET filters to look for in URL for pagination controls.
	$filter_list 		= array( 'sb', 'd', 's', 'p', 'debug' );
	

	// Configuration for permissions and plugins.
	$allow_add 			= true;
	$allow_edit 		= true;
	$allow_delete 		= true;
	$allow_order 		= true;
	$allow_duplicate	= false;
	$include_editor		= false;

?>




	