

function back_directory(){
		
	var directory = config['base_dir'];
	
	if( config['current_level'] > 0 ){
		
		for( var i=0; i<(config['current_level']-1); i++ ){
			directory += config['from_base_dir'][i] + '/';
		}
		
		config['current_dir'] = directory;
		
	}
	
	build_hierarchy();
	get_directory();
	
	return false;
	
}


function build_breadcrumb(){
	
	var spacer	= '<span class="spacer">&raquo;</span>';
	var output 	= '';
	
	output += '<a href="#" onclick="return jump_directory(-1);">';
		output += '<span class="fas fa-home"></span>';
	output += '</a>';
	
	$.each( config['from_base_dir'], function( key, value ){
		output += spacer;
		output += '<a href="#" onclick="return jump_directory(' + key + ');">';
			output += '<span class="fas fa-folder"></span> ' +value;
		output += '</a>';
	});
	
	$( '#breadcrumb' ).html( output );
	
}


function build_hierarchy(){
	
	var output = new Array();
	
	var file_path 		= config['current_dir'];
	file_path 			= '..' + file_path.replace( config['root_dir'], '' );
	config['file_path'] = file_path;
	
	var path 	= config['current_dir'];
	path 		= path.replace( config['base_dir'], '' );
	path 		= path.split( '/' );
	
	for( var i=0; i<path.length; i++ ){
		if( path[i] ){
			output.push( path[i] );
		}
	}
	
	config['from_base_dir'] = output;
	config['current_level'] = output.length;
	
	build_breadcrumb();
	
}


function capitalize( word ){
	if( typeof word !== 'string' ){
		return '';
	}
	return word.charAt( 0 ).toUpperCase() + word.slice( 1 );
}


function clear_search(){
	$( '#search_term' ).val( '' );
	$( '#clear_search' ).hide();
	$( '.file_box' ).show();
	return false;
}


function close_window(){
	parent.tinymce.activeEditor.windowManager.close();
	return false;
}


function confirm_create_folder(){
	
	var content = '';
	content += '<form id="create_form">';
		content += '<p>Enter a name for a new folder:</p>';
		content += '<input type="text" id="folder_name" value="" placeholder="New Folder Name">';
		content += '<p class="tr buttons">';
			content += '<input type="submit" value="Create Folder">';
			content += '<a href="#" class="btn" onclick="return modal_option(\'close\');">Cancel</a>';
		content += '</p>';
	content += '</form>';
	
	modal_option( 'open' );
	modal_option( 'set', content );
	$( '#modal #content #folder_name' ).focus();
	
	return false;
	
}


function confirm_delete_file( file_name, file_type ){
	
	var content = '';
	content += '<p>Are you sure you want to delete this ' + file_type + '?</p>';
	content += '<p>This cannot be undone.</p>';
	content += '<p class="tr buttons">';
		content += '<a href="#" class="btn" onclick="return delete_file(\'' + file_name + '\');">Delete ' + capitalize( file_type ) + '</a>';
		content += '<a href="#" class="btn" onclick="return modal_option(\'close\');">Cancel</a>';
	content += '</p>';
	
	modal_option( 'open' );
	modal_option( 'set', content );
	
	return false;
	
}


function confirm_rename_file( file_name, file_type ){
	
	var content = '';
	content += '<form id="rename_form">';
		content += '<p>Enter a new name for this ' + file_type + ':</p>';
		content += '<input type="hidden" id="original_file" value="' + file_name + '">';
		content += '<p><input type="text" id="rename_file" value="' + file_name + '"</p>';
		content += '<p class="tr buttons">';
			content += '<input type="submit" value="Rename ' + capitalize( file_type ) + '">';
			content += '<a href="#" class="btn" onclick="return modal_option(\'close\');">Cancel</a>';
		content += '</p>';
	content += '</form>';
	
	modal_option( 'open' );
	modal_option( 'set', content );
	$( '#modal #content #rename_file' ).focus();
	
	return false;
	
}


function create_folder(){
	
	var folder_name = $( '#modal #content #folder_name' ).val();
	
	if( (typeof folder_name == 'undefined') || (folder_name == '') ){
		modal_option( 'close' );
		return false;
	}
	
	var post_data = {};
	post_data['method'] 	= 'create';
	post_data['directory']	= config['current_dir'];
	post_data['filename']	= folder_name;

	var endpoint_url = config['browser_url'] + 'process/';
	
	var request = $.ajax({
		url: 	endpoint_url,
		type: 	'POST',
		data: 	post_data
	});

	request.done( function( response, code ){
		if( response == 'OK' ){
			get_directory();
			modal_option( 'close' );
		} else if( response == 'ERROR' ){
			var content = '';
			content += '<p>This folder could not be created because a folder already exists with this name.</p>';
			content += '<p class="tr buttons">';
				content += '<a href="#" class="btn" onclick="return modal_option(\'close\');">Close</a>';
			content += '</p>';
			modal_option( 'set', content );
		}
	});
	
	return false;
	
}


function delete_file( file_name ){
	
	var post_data = {};
	post_data['method'] 	= 'delete';
	post_data['directory']	= config['current_dir'];
	post_data['filename']	= file_name;

	var endpoint_url = config['browser_url'] + 'process/';
	
	var request = $.ajax({
		url: 	endpoint_url,
		type: 	'POST',
		data: 	post_data
	});

	request.done( function( response, code ){
		if( response == 'OK' ){
			get_directory();
			modal_option( 'close' );
		} else if( response == 'ERROR' ){
			var content = '';
			content += '<p>This folder could not be deleted because it is not empty.</p>';
			content += '<p class="tr buttons">';
				content += '<a href="#" class="btn" onclick="return modal_option(\'close\');">Close</a>';
			content += '</p>';
			modal_option( 'set', content );
		}
	});
	
	return false;
	
}


function enter_directory( folder ){
	config['current_dir'] += folder + '/';
	build_hierarchy();
	get_directory();
	return false;
}


function get_directory(){
	
	modal_option( 'open' );
	
	var post_data = {};
	post_data['method'] 	= 'directory';
	post_data['directory']	= config['current_dir'];
	post_data['type']		= config['type'];

	var endpoint_url = config['browser_url'] + 'process/';
	
	var request = $.ajax({
		url: 	endpoint_url,
		type: 	'POST',
		data: 	post_data
	});

	request.done( function( response, code ){
		
		config['file_list'] = [];
		var json 	= JSON.parse( response );
		var output 	= '';
		var file_obj;
		var class_name;
		var icon;
		var thumb;
		var data_vars;
		
		output += '<div class="ca heading">';
			output += '<div class="label">Filename</div>';
			output += '<div class="actions">Actions</div>';
			output += '<div class="size">Size</div>';
			output += '<div class="modified">Modified</div>';
		output += '</div>';
		
		if( config['current_level'] > 0 ){
			output += '<div class="file_box back">';
				output += '<div class="rel inner">';
					output += '<div class="label">Back Directory</div>';
					output += '<div class="icon"><span class="fas fa-arrow-left"></span></div>';
				output += '</div>';
			output += '</div>';
		}
		
		$.each( json, function( key, value ){
			
			var lc_filename = value['file_name'];
			lc_filename = lc_filename.toLowerCase();
			
			file_obj = {
				index: key,
				content: lc_filename
			}
			
			config['file_list'].push( file_obj );
			
			icon 	= '';
			thumb 	= '';
			
			if( value['type'] == 'folder' ){
				class_name = 'folder';
			} else if( value['type'] == 'file' ){
				class_name = 'file';
			}

			if( value['icon'] ){	
				icon += '<div class="icon">';
					icon += '<span';
						icon += ' class="' + value['icon'] + '"';
						if( value['style'] ){
							icon += ' style="' + value['style'] + '"';
						}
					icon += '></span>';
				icon += '</div>';
			}

			if( value['thumb'] ){
				thumb = '<div class="thumb" style="background-image: url(\'' + value['thumb'] + '\');"></div>';
			}
			
			output += '<div';
				output += ' id="file_' + key + '"';
				output += ' class="rel file_box ' + class_name + '"';
				output += ' data-file-name="' + value['file_name'] + '"';
				output += ' title="' + value['file_name'] + '"';
			output += '>';
			
				output += '<div class="rel inner">';
					
					output += icon;
					output += thumb;
			
					output += '<div class="actions">';
			
						data_vars 	 = '';
						data_vars 	+= ' data-file-name="' + value['file_name'] + '"';
						data_vars 	+= ' data-file-type="' + class_name + '"';
						data_vars 	+= ' data-file-url="' + value['file_url'] + '"';
			
						if( value['type'] == 'file' ){
							output += '<a href="#" class="open" title="View / Download" ' + data_vars + '><span class="fas fa-eye"></span></a>';
							output += '<a href="#" class="link" title="Get Link URL" ' + data_vars + '><span class="fas fa-link"></span></a>';
						}
			
						if( config['allow_rename'] ){
							output += '<a href="#" class="rename" title="Rename"' + data_vars + '><span class="fas fa-pencil"></span></a>';
						}
			
						if( config['allow_delete'] ){
							output += '<a href="#" class="delete" title="Delete"' + data_vars + '><span class="fas fa-trash"></span></a>';
						}
					
					output += '</div>';
			
					output += '<div class="size">' + value['size'] + '</div>';
			
					output += '<div class="modified">' + value['modified'] + '</div>';
			
					output += '<div class="label">' + value['file_name'] + '</div>';
			
				output += '</div>';
			
			output += '</div>';
			
		});
		
		$( '#file_listing' ).html( output );
		clear_search();
		set_file_uploader();
		modal_option( 'close' );
		
	});
	
}


function jump_directory( level ){
	
	var directory = config['base_dir'];
	
	for( var i=0; i<=level; i++ ){
		directory += config['from_base_dir'][i] + '/';
	}
	
	config['current_dir'] = directory;
	
	build_hierarchy();
	get_directory();
	
	return false;
	
}


function modal_option( type, content ){
	
	if( type == 'open' ){
		$( '#modal' ).fadeIn( 'fast' );
	}
	
	if( type == 'close' ){
		$( '#modal' ).fadeOut( 'fast', function(){
			$( '#modal #content' ).hide();
		});
	}
	
	if( type == 'set' ){
		$( '#modal #content' ).html( content ).fadeIn( 'fast' );
	}
	
	if( type == 'clear' ){
		$( '#modal #content' ).fadeOut( 'fast', function(){ $(this).html( '' ); });
	}
	
	return false;
	
}


function open_file( file_url ){
	window.open( file_url );
	return false;
}


function rename_file( file_name ){
	
	var file_name	= $( '#modal #content #original_file' ).val();
	var rename_to 	= $( '#modal #content #rename_file' ).val();
	
	if( (typeof rename_to == 'undefined') || (rename_to == '') ){
		modal_option( 'close' );
		return false;
	}
	
	var post_data = {};
	post_data['method'] 	= 'rename';
	post_data['directory']	= config['current_dir'];
	post_data['filename']	= file_name;
	post_data['rename_to']	= rename_to;

	var endpoint_url = config['browser_url'] + 'process/';
	
	var request = $.ajax({
		url: 	endpoint_url,
		type: 	'POST',
		data: 	post_data
	});

	request.done( function( response, code ){
		if( response == 'OK' ){
			get_directory();
			modal_option( 'close' );
		} else if( response == 'ERROR' ){
			var content = '';
			content += '<p>This item could not be renamed because an item already exists with this name.</p>';
			content += '<p class="tr buttons">';
				content += '<a href="#" class="btn" onclick="return modal_option(\'close\');">Close</a>';
			content += '</p>';
			modal_option( 'set', content );
		}
	});
	
	return false;
	
}


function run_search(){
		
	var search_term = $( '#search_term' ).val();
	search_term = search_term.toLowerCase();

	if( search_term != '' ){
		$( '#clear_search' ).show();
		var results = search_files( search_term );
		$( '.file_box' ).hide();
		$.each( results, function( key, value ){
			$( '.file_box#file_' + value.index ).show();
		});
	} else {
		$( '#clear_search' ).hide();
		$( '.file_box' ).show();
	}
	
	return false;
	
}


function search_files( text ){
	
	text = text.split( ' ' );
	var items = config['file_list'];
	
	return items.filter( function(item){
		return text.every( function(el){
			return item.content.indexOf( el ) > -1;
		});
	});
	
}


function set_file( file_name ){
	
	var file_element = parent.document.getElementById( config['callback'] );
	var desc_element = parent.document.getElementById( config['description'] );
	
	file_element.value = config['file_path'] + file_name;
	
	if( config['type'] == 'image' ){
		if( (desc_element.value == '') || (desc_element.value == config['current_file']) ){
			desc_element.value = file_name;
		}
	}
	
	if( 'createEvent' in document ){
    	var event = document.createEvent( 'HTMLEvents' );
    	event.initEvent( 'change', false, true );
    	file_element.dispatchEvent( event );
	} else {
    	file_element.fireEvent( 'onchange' );
	}
	
	close_window();
	return false;
	
}


function set_file_uploader(){
	
	$( '.ajax-upload-dragdrop' ).remove();

	var settings = {
		url: 				config['browser_url'] + 'process/',
		method: 			'POST',
		fileName: 			'file',
		multiple: 			true,
		formData: 			{ 'method': 'upload', 'directory': config['current_dir'] },
		onSuccess: 			function( files, data, xhr, filebox ){ if( data == 'OK'){ get_directory(); } else { alert(data); } filebox.statusbar.remove(); },
		showFileCounter:	false,
		showQueueDiv:		'upload_queue'
	}

	$( '#multi_file' ).uploadFile( settings );
	
}


function show_link_url( file_url ){
	
	var content = '';
	content += '<p>You can use the following URL to link directly to this file:</p>';
	content += '<p><input type="text" value="' + file_url + '" onclick="this.select();"></p>';
	content += '<p class="tr buttons">';
		content += '<a href="#" class="btn" onclick="return modal_option(\'close\');">Close</a>';
	content += '</p>';
	
	modal_option( 'open' );
	modal_option( 'set', content );
	$( '#modal #content #folder_name' ).focus();
	
	return false;
	
}


function toggle_view( list_type ){
	
	$( '#file_listing' ).removeClass( 'grid' ).removeClass( 'list' );
	$( '#view_grid' ).removeClass( 'active' );
	$( '#view_list' ).removeClass( 'active' );
	$( '#file_listing' ).addClass( list_type );
	$( '#view_' + list_type ).addClass( 'active' );
	
	var display_type = '';
	
	if( list_type == 'grid' ){
		display_type = 'inline-block';
	} else {
		display_type = 'block';
	}
	
	$.each( $('.file_box'), function(){
		if( $(this).css('display') != 'none' ){
			$( this ).css( 'display', display_type );
		}
	});
	
	config['display_type'] = list_type;
	
	var post_data = {};
	post_data['method'] 	= 'view';
	post_data['list_type']	= list_type;

	var endpoint_url = config['browser_url'] + 'process/';
	
	var request = $.ajax({
		url: 	endpoint_url,
		type: 	'POST',
		data: 	post_data
	});
	
}

		
$( document ).ready( function(){

	build_hierarchy();
	get_directory();

	$( 'body' ).on( 'click', '.file_box.back', function(e){
		return back_directory();
	});

	$( 'body' ).on( 'click', '.file_box.folder', function(e){
		var file_name = $( this ).attr( 'data-file-name' );
		return enter_directory( file_name );
	});

	$( 'body' ).on( 'click', '.file_box.file', function(e){
		var file_name = $( this ).attr( 'data-file-name' );
		return set_file( file_name );
	});

	$( 'body' ).on( 'click', '.file_box .actions a.delete', function(e){
		e.stopPropagation;
		e.preventDefault;
		var file_name = $( this ).attr( 'data-file-name' );
		var file_type = $( this ).attr( 'data-file-type' );
		return confirm_delete_file( file_name, file_type );
	});

	$( 'body' ).on( 'click', '.file_box .actions a.rename', function(e){
		e.stopPropagation;
		e.preventDefault;
		var file_name = $( this ).attr( 'data-file-name' );
		var file_type = $( this ).attr( 'data-file-type' );
		return confirm_rename_file( file_name, file_type );
	});

	$( 'body' ).on( 'submit', '#rename_form', function(e){
		e.stopPropagation;
		e.preventDefault;
		return rename_file();
	});

	$( 'body' ).on( 'submit', '#create_form', function(e){
		e.stopPropagation;
		e.preventDefault;
		return create_folder();
	});

	$( 'body' ).on( 'click', '.file_box .actions a.open', function(e){
		e.stopPropagation;
		e.preventDefault;
		var file_url = $( this ).attr( 'data-file-url' );
		return open_file( file_url );
	});

	$( 'body' ).on( 'click', '.file_box .actions a.link', function(e){
		e.stopPropagation;
		e.preventDefault;
		var file_type = $( this ).attr( 'data-file-type' );
		var file_url = $( this ).attr( 'data-file-url' );
		return show_link_url( file_url, file_type );
	});

	$( 'body' ).on( 'keyup', 'header #toolbar #search_term', function(e){
		e.stopPropagation;
		e.preventDefault;
		return run_search();
	});
	
	$( '#upload_queue' ).bind( 'DOMSubtreeModified', function(){
		setTimeout( function(){
			var h = $( '#upload_queue' ).outerHeight();
			if( $('#file_listing').hasClass('grid') ){ h = ( h + 5 ); }
			$( '#file_listing' ).css( 'padding-bottom', h );
		}, 10 );
	});

});

