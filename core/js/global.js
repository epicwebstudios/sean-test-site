function add_to_admin_bar( button_text, link ){
	
	var output = '';
	
	output += '<a href="' + link + '" target="_blank" class="button">';
		output += button_text;
	output += '</a>';
	
	$( '#admin_bar .admin-bar-items' ).append( output );
	
	return;
	
}