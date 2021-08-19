<?

	@security();
	
	
	// Database tables associated and used within this module.
	$database 			= array( 'm_news_entries', 'm_news_categories' );
	
	
	// Database column to be include in any action logs for a specific record.
	$log_item 			= 'name';
	
	
	// The name of this module, in both singular and plural form.
	$item 				= 'news entry';
	$item_plural 		= 'news entries';
	
	
	// Database columns to search through.
	// - To disable the search function, leave this array empty.
	$search 			= array( 'id', 'name', 'summary', 'entry' );
	
	
	// Columns to display in listing table
	// - 'title' = Title of the column in the table
	// - 'sort' = Column name of the database table to sort by. To disallow/disable sorting, use 'false', '0', or omit from record.
	// - 'width' = The specific width of the column in the listing table. For automatic sizing, use 'false', '0', or omit from record.
	$columns = array(
		array( 'title' => 'Title', 		'sort' => 'name', 		'width' => 0 ),
		array( 'title' => 'Category', 	'sort' => 'category', 	'width' => 300 ),
		array( 'title' => 'Post Date', 	'sort' => 'date', 		'width' => 150 ),
		array( 'title' => 'Status', 	'sort' => 'status', 	'width' => 125 )
	);
	
	
	// Default ordering for listing table.
	// - If $allow_order is enabled, this will be overridden.
	$order 				= '`date` DESC';
	
	
	// The number of records to display on each page.
	$page_limit 		= 25;
	
	
	// Specify the $_GET filters to look for in URL for pagination controls.
	$filter_list 		= array( 'sb', 'd', 's', 'p', 'debug' );
	

	// Configuration for permissions and plugins.
	$allow_add 			= true;
	$allow_edit 		= true;
	$allow_delete 		= true;
	$allow_order 		= false;
	$allow_duplicate	= false;
	$include_editor		= true;

?>




	