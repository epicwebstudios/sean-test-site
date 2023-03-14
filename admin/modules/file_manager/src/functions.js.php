<script>
	
	
	var config = {};
	config['is_super']		= <? if( $user['level'] == 1 ){ echo 'true'; } else { echo 'false'; } ?>;
	config['manage_url']	= '<? echo MANAGE_URL; ?>';
	config['process_url']	= '<? echo PROCESS_URL; ?>';
	config['site_url']		= '<? mainURL(); ?>/uploads/';
	config['base_dir']		= '<? echo BASE_DIR; ?>/uploads/';
	config['current_dir']	= '<? echo BASE_DIR; ?>/uploads/';
	config['current_level']	= 0;
	config['from_base_dir']	= new Array();
	config['file_list']		= [];
	config['deep_search']	= false;
	config['allow_rename']	= <? if( ALLOW_RENAME ){ echo 'true'; } else { echo 'false'; } ?>;
	config['allow_delete']	= <? if( ALLOW_DELETE ){ echo 'true'; } else { echo 'false'; } ?>;
	config['sort_by']		= 'name';
	config['sort_dir']		= 'asc';
	
	
	function build_breadcrumb(){
		
		var output = '';
		
		if( config['deep_search'] ){
			
			output += 'Deep file search for "' + $( '#deep_search').val() + '"...';
			output += '&nbsp;&nbsp;';
			output += '<input type="button" value="Clear Search" onclick="return run_deep_search( true );">';
			 
		} else {
		
			output += '&nbsp;<a href="#" onclick="return enter_breadcrumb(0);"><span class="fas fa-home"></span></a>';

			for( var i=1; i<=config['current_level']; i++ ){
				output += '&nbsp;&nbsp;&raquo;&nbsp;&nbsp;';
				output += '<a href="#" onclick="return enter_breadcrumb('+i+');">';
					output += '<span class="fas fa-folder"></span>';
					output += config['from_base_dir'][(i-1)];
				output += '</a>';
			}
			
		}
		
		$( '.breadcrumb .l' ).html( output );
		
		return false;
		
	}
	
	
	function build_hierarchy(){

		var output = new Array();

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
		
		return false;

	}
	
	
	function capitalize( word ){
		if( typeof word !== 'string' ){
			return '';
		}
		return word.charAt( 0 ).toUpperCase() + word.slice( 1 );
	}
	

	function create_folder(){
		
		var directory 	= config['current_dir'];
		var file;
		
		var msg			= 'Please enter a name for this new folder:';
		
		if( file = prompt(msg) ){
			
			var post_data = {};
			post_data['method'] 	= 'create';
			post_data['directory']	= directory;
			post_data['file']		= file;

			var request = $.ajax({
				url: 	config['process_url'],
				type: 	'POST',
				data: 	post_data
			});

			request.done( function( response, code ){
				if( response == 'OK' ){
					get_directory();
				} else {
					alert( response );
				}
			});
		
		}
		
		return false;
		
	}
	
	
	function clear_file_list(){
		$( '.table tbody tr' ).each( function(){
			if( !$(this).hasClass('category') ){
				$( this ).remove();
			}
		});
		return false;
	}
	
	
	function delete_item( element ){
		
		var type 		= element.attr( 'data-file-type' );
		var directory 	= element.attr( 'data-file-path' );
		var file 		= element.attr( 'data-file-name' );
		
		var msg			= 'Are you sure you want to delete the ' + type + ' "' + file + '"?' + '\n' + 'This cannot be undone.';
		
		if( confirm(msg) ){
		
			var post_data = {};
			post_data['method'] 	= 'delete';
			post_data['directory']	= directory;
			post_data['file']		= file;
	
			var request = $.ajax({
				url: 	config['process_url'],
				type: 	'POST',
				data: 	post_data
			});

			request.done( function( response, code ){
				if( response == 'OK' ){
					get_directory();
				} else {
					alert( response );
				}
			});
			
		}
		
		return false;
		
	}
	
	
	function download_item( element ){
		var file_url 	= element.attr( 'data-file-url' );
		window.open( file_url );
		return false;
	}
	
	
	function enter_breadcrumb( level ){
		
		var dir = config['base_dir'];
		
		for( i=1; i<=level; i++ ){
			dir += config['from_base_dir'][(i-1)] + '/';
		}
		
		config['current_dir'] = dir;
		get_directory();
		
		return false;
		
	}
	
	
	function enter_directory( name ){
		if( typeof name != 'undefined' ){
			config['current_dir'] += name + '/';
			get_directory();
			return false;
		}
	}
	
	
	function get_directory(){
		
		clear_file_list();
		build_hierarchy();
		set_file_uploader();
		
		var output	= '';
		
		if( config['current_level'] > 0 ){
			output += '<tr>';

				output += '<td class="icon rel">';
					output += '<span class="fas fa-arrow-left"></span>';
					output += '<a href="#" onclick="return enter_breadcrumb(' + ( config['current_level'] - 1 ) + ');"></a>';
				output += '</td>';
			
				output += '<td colspan="100">';
					output += '<a href="#" onclick="return enter_breadcrumb(' + ( config['current_level'] - 1 ) + ');">';
						output += '<b>Back a Directory</b>';
					output += '</a>';
				output += '</td>';
			
			output += '</tr>';
		}
		
		var post_data = {};
		post_data['method'] 	= 'directory';
		post_data['directory']	= config['current_dir'];
		post_data['sort_by']	= config['sort_by'];
		post_data['sort_dir']	= config['sort_dir'];
	
		var request = $.ajax({
			url: 	config['process_url'],
			type: 	'POST',
			data: 	post_data
		});

		request.done( function( response, code ){
			
			var json 	= JSON.parse( response );
			
			$.each( json, function( key, value ){
				
				if( value['omit'] ){
					output += '<tr class="inactive">';
				} else {
					output += '<tr>';
				}
				
					output += '<td class="icon rel">';
				
						if( value['icon'] ){
							output += '<span';
								output += ' class="' + value['icon'] + '"';
								if( value['color'] ){
									output += ' style="color: ' + value['color'] + ';"';
								}
							output += '></span>';
						}
						
						if( value['file_type'] == 'folder' ){
							output += '<a href="#" onclick="return enter_directory(\'' + value['file_name'] + '\');"></a>';
						}
				
						if( value['thumb'] ){
							output += '<div style="background-image: url(\'' + value['thumb'] + '\');"></div>';
							output += '<a href="' + value['thumb'] + '" class="lightbox_img"></a>';
						}
				
					output += '</td>';
				
					output += '<td><b>';
						if( value['file_type'] == 'folder' ){
							output += '<a href="#" onclick="return enter_directory(\'' + value['file_name'] + '\');">';
								output += value['file_name'];
							output += '</a>';
						} else {
							output += value['file_name'];
						}
					output += '</b></td>';
				
					output += '<td>';
						if( value['file_url'] ){
							output += '<a href="#" class="copy_btn" data-clipboard-text="' + value['file_url'] + '" title="Copy to Clipboard"><span class="fas fa-copy"></span></a>';
							output += '&nbsp;&nbsp;';
							output += '<a href="' + value['file_url'] + '" target="_blank">' + value['file_url'] + '</a>';
						}
					output += '</td>';
				
					output += '<td class="tc_l_grey">' + value['modified'] + '</td>';
				
					output += '<td class="tr tc_l_grey">' + value['size'] + '</td>';
				
					var attr = '';
					attr += ' data-file-type="' + value['file_type'] + '"';
					attr += ' data-file-path="' + config['current_dir'] + '"';
					attr += ' data-file-name="' + value['file_name'] + '"';
					attr += ' data-file-url="' + value['file_url'] + '"';
				
					if( config['is_super'] ){
						output += '<td>';
							output += '<a href="' + config['manage_url'] + '?file=' + config['current_dir'] + value['file_name'] + '" class="lightbox_iframe" data-size="600x500">Settings</a>';
						output += '</td>';
					}
				
					output += '<td>';
						if( value['file_url'] ){
							output += '<a href="#" class="download_item" ' + attr + '>Download</a>';
						}
					output += '</td>';
				
					output += '<td>';
						if( config['allow_rename'] ){
							output += '<a href="#" class="rename_item" ' + attr + '>Rename</a>';
						}
					output += '</td>';
				
					output += '<td>';
						if( config['allow_delete'] ){
							output += '<a href="#" class="delete_item" ' + attr + '>Delete</a>';
						}
					output += '</td>';
				
				output += '</tr>';
			});
			
			$( '.table tbody' ).append( output );
			
		});
		
	}
	
	
	function rename_item( element ){
		
		var type 		= element.attr( 'data-file-type' );
		var directory 	= element.attr( 'data-file-path' );
		var file 		= element.attr( 'data-file-name' );
		var rename_to;
		
		var msg			= 'Please enter a new name for this ' + type + ':';
		
		if( rename_to = prompt(msg, file) ){
			if( rename_to != file ){
			
				var post_data = {};
				post_data['method'] 	= 'rename';
				post_data['directory']	= directory;
				post_data['file']		= file;
				post_data['rename_to']	= rename_to;

				var request = $.ajax({
					url: 	config['process_url'],
					type: 	'POST',
					data: 	post_data
				});

				request.done( function( response, code ){
					if( response == 'OK' ){
						get_directory();
					} else {
						alert( response );
					}
				});
		
			}
		}
		
		return false;
		
	}
	
	
	function run_deep_search( clear ){
		
		if( clear ){
			$( '#deep_search' ).val( '' );
			$( '#deep_search_clear' ).hide();
			run_deep_search();
			return false;
		}
		
		var search_term = $( '#deep_search' ).val();
		
		if( search_term != '' ){
			config['deep_search'] = true;
			$( '#deep_search_clear' ).show();
			$( '.breadcrumb .actions' ).hide();
		} else {
			config['deep_search'] = false;
			$( '#deep_search' ).val( '' );
			$( '#deep_search_clear' ).hide();
			$( '.breadcrumb .actions' ).show();
			get_directory();
			return false;
		}
		
		clear_file_list();
		build_hierarchy();
		
		var output	= '';
		
		if( (config['current_level'] > 0) && (!config['deep_search']) ){
			output += '<tr>';

				output += '<td class="icon rel">';
					output += '<span class="fas fa-arrow-left"></span>';
					output += '<a href="#" onclick="return enter_breadcrumb(' + ( config['current_level'] - 1 ) + ');"></a>';
				output += '</td>';
			
				output += '<td colspan="100">';
					output += '<a href="#" onclick="return enter_breadcrumb(' + ( config['current_level'] - 1 ) + ');">';
						output += '<b>Back a Directory</b>';
					output += '</a>';
				output += '</td>';
			
			output += '</tr>';
		}
		
		var post_data = {};
		post_data['method'] = 'search';
		post_data['term']	= search_term;
	
		var request = $.ajax({
			url: 	config['process_url'],
			type: 	'POST',
			data: 	post_data
		});

		request.done( function( response, code ){
			
			var json 	= JSON.parse( response );
			
			if( json.length > 0 ){
				$.each( json, function( key, value ){

					if( value['omit'] ){
						output += '<tr class="inactive">';
					} else {
						output += '<tr>';
					}

						output += '<td class="icon rel">';

							if( value['icon'] ){
								output += '<span';
									output += ' class="' + value['icon'] + '"';
									if( value['color'] ){
										output += ' style="color: ' + value['color'] + ';"';
									}
								output += '></span>';
							}

							if( value['file_type'] == 'folder' ){
								output += '<a href="#" onclick="return enter_directory(\'' + value['file_name'] + '\');"></a>';
							}

							if( value['thumb'] ){
								output += '<div style="background-image: url(\'' + value['thumb'] + '\');"></div>';
								output += '<a href="' + value['thumb'] + '" class="lightbox_img"></a>';
							}

						output += '</td>';

						output += '<td><b>';
							if( value['file_type'] == 'folder' ){
								output += '<a href="#" onclick="return enter_directory(\'' + value['file_name'] + '\');">';
									output += value['file_name'];
								output += '</a>';
							} else {
								output += value['file_name'];
							}
						output += '</b></td>';

						output += '<td>';
							if( value['file_url'] ){
								output += '<a href="#" class="copy_btn" data-clipboard-text="' + value['file_url'] + '" title="Copy to Clipboard"><span class="fas fa-copy"></span></a>';
								output += '&nbsp;&nbsp;';
								output += '<a href="' + value['file_url'] + '" target="_blank">' + value['file_url'] + '</a>';
							}
						output += '</td>';

						output += '<td>' + value['modified'] + '</td>';

						output += '<td class="tr">' + value['size'] + '</td>';

						var attr = '';
						attr += ' data-file-type="' + value['file_type'] + '"';
						attr += ' data-file-path="' + config['current_dir'] + '"';
						attr += ' data-file-name="' + value['file_name'] + '"';
						attr += ' data-file-url="' + value['file_url'] + '"';

						if( config['is_super'] ){
							output += '<td>';
								output += '<a href="' + config['manage_url'] + '?file=' + config['current_dir'] + value['file_name'] + '" class="lightbox_iframe" data-size="600x500">Settings</a>';
							output += '</td>';
						}

						output += '<td>';
							if( value['file_url'] ){
								output += '<a href="#" class="download_item" ' + attr + '>Download</a>';
							}
						output += '</td>';

						output += '<td>';
							output += '<a href="#" class="rename_item" ' + attr + '>Rename</a>';
						output += '</td>';

						output += '<td>';
							output += '<a href="#" class="delete_item" ' + attr + '>Delete</a>';
						output += '</td>';

					output += '</tr>';
				});
			} else {
				output += '<tr>';
					output += '<td colspan="100" align="center">';
					 	if( search_term.length > 2 ){
							output += 'There are no file results for "<b>' + search_term  + '</b>"...';
						} else {
							output += '<b>Your search term must be 3 or more characters</b>.';
						}
					output += '</td>';
				 output += '</tr>';
			}
			
			$( '.table tbody' ).append( output );
			
		});
		
	}
	
	
	function set_file_uploader(){

		$( '.ajax-upload-dragdrop' ).remove();

		var settings = {
			url: 				config['process_url'],
			method: 			'POST',
			fileName: 			'file',
			multiple: 			true,
			formData: 			{ 'method': 'upload', 'directory': config['current_dir'] },
			onSuccess: 			function( files, data, xhr, filebox ){ 
				if( data == 'OK'){ get_directory(); } else { alert(data); } filebox.statusbar.remove();
			},
			showFileCounter:	false,
			showQueueDiv:		'upload_queue'
		}

		$( '#multi_file' ).uploadFile( settings );

	}
	
	
	function set_sorts( sort_by ){
		
		if( config['sort_by'] == sort_by ){
			if( config['sort_dir'] == 'asc' ){
				config['sort_dir'] = 'desc';
			} else {
				config['sort_dir'] = 'asc';
			}
		} else {
			config['sort_dir'] = 'asc';
		}
		
		config['sort_by'] 	= sort_by;
		
		$( '.table tbody .category td span' )
			.removeClass( 'fal' )
			.removeClass( 'fa-sort-alpha-up' )
			.removeClass( 'fa-sort-alpha-down' );
		
		if( config['sort_dir'] == 'asc' ){
			$( '.table tbody .category td.' + config['sort_by'] + ' span' )
				.addClass( 'fal' )
				.addClass( 'fa-sort-alpha-down' );
		} else {
			$( '.table tbody .category td.' + config['sort_by'] + ' span' )
				.addClass( 'fal' )
				.addClass( 'fa-sort-alpha-up' );
		}
		
		
		
		get_directory();
		
		return false;
		
	}
	
	
	$( document ).ready( function(){
		
		new ClipboardJS( '.copy_btn' );
		
		get_directory();
		
		$( 'body' ).on( 'click', 'a.delete_item', function(e){
			e.preventDefault();
			return delete_item( $(this) );
		});
		
		$( 'body' ).on( 'click', 'a.rename_item', function(e){
			e.preventDefault();
			return rename_item( $(this) );
		});
		
		$( 'body' ).on( 'click', 'a.download_item', function(e){
			e.preventDefault();
			return download_item( $(this) );
		});
		
		$( 'body' ).on( 'click', 'a.copy_btn', function(e){
			e.preventDefault();
		});
		
	});


</script>