<?

	@security();
	
	
	// Database tables associated and used within this module.
	$database 			= array( 'admin_pages' );
	
	
	// Database column to be include in any action logs for a specific record.
	$log_item 			= 'name';
	
	
	// The name of this module, in both singular and plural form.
	$item 				= 'administrative page';
	$item_plural 		= 'administrative pages';
	
	
	// Database columns to search through.
	// - To disable the search function, leave this array empty.
	$search 			= array(  );
	
	
	// Columns to display in listing table
	// - 'title' = Title of the column in the table
	// - 'sort' = Column name of the database table to sort by. To disallow/disable sorting, use 'false', '0', or omit from record.
	// - 'width' = The specific width of the column in the listing table. For automatic sizing, use 'false', '0', or omit from record.
	$columns = array(
		array( 'title' => 'Page Name',	'sort' => false, 	'width' => 0 ),
		array( 'title' => 'Links To', 	'sort' => false, 	'width' => 0 ),
		array( 'title' => 'Status', 	'sort' => false, 	'width' => 125 ),
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




	