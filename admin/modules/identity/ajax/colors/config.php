<?

	@security();
	
	
	// Database tables associated and used within this module.
	$database 			= array( 'm_identity_colors' );
	
	
	// Database column to be include in any action logs for a specific record.
	$log_item 			= 'name';
	
	
	// The parent column name of this sub-table.
	$parent_column 		= 'package';
	
	
	// The name of this module, in both singular and plural form.
	$item 				= 'color';
	$item_plural 		= 'colors';
	
	
	// Columns to display in listing table
	// - 'title' = Title of the column in the table
	// - 'sort' = Column name of the database table to sort by. To disallow/disable sorting, use 'false', '0', or omit from record.
	// - 'width' = The specific width of the column in the listing table. For automatic sizing, use 'false', '0', or omit from record.
	$columns = array(
		array( 'title' => 'Name',			'sort' => false,	'width' => 200 ),
		array( 'title' => 'Description',	'sort' => false,	'width' => 0 ),
		array( 'title' => 'Color',			'sort' => false,	'width' => 75 ),
		array( 'title' => 'Hex Code',		'sort' => false,	'width' => 85 ),
		array( 'title' => 'RGB Values',		'sort' => false,	'width' => 110 ),
		array( 'title' => 'CMYK Values',	'sort' => false,	'width' => 225 ),
	);
	
	
	// Default ordering for listing table.
	// - If $allow_order is enabled, this will be overridden.
	$order 				= '`id` DESC';
	
	
	// Specify the $_GET filters to look for in URL for pagination controls.
	$filter_list 		= array( 'sb', 'd', 's', 'p', 'debug' );
	
	
	// Specify columns you want to be omitted from being converted to htmlentities() on edit pages.
	// Most values can be converted without issue, however JSON values should be omitted as parsing issues can occur.
	$omit_entities		= array();
	

	// Configuration for permissions and plugins.
	$allow_add 			= true;
	$allow_edit 		= true;
	$allow_delete 		= true;
	$allow_order 		= true;

?>
