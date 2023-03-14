<? require_once dirname( __FILE__ ).'/src/init.php'; ?>
<!doctype html>
<html>
	
	<head>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,700">
		<link rel="stylesheet" href="https://css.ewsapi.com/reset/reset.min.css">
		<link rel="stylesheet" href="https://css.ewsapi.com/global/global.v3.css">
		<link rel="stylesheet" href="https://css.ewsapi.com/icons/fa5/icons.min.css">
		<link rel="stylesheet" href="src/dnd-uploader.css?<? echo time(); ?>">
		<link rel="stylesheet" href="src/stylesheet.css?<? echo time(); ?>">
		<script src="//js.ewsapi.com/jquery/jquery-1.10.2.min.js"></script>
		<script src="src/functions.js?<? echo time(); ?>"></script>
		<script src="src/dnd-uploader.min.js?<? echo time(); ?>"></script>
		<script>
			var config = {};
			config['base_url']		= '<? echo BASE_URL; ?>';
			config['browser_url']	= '<? echo BROWSER_URL; ?>';
			config['type']			= '<? echo BROWSER_TYPE; ?>';
			config['callback'] 		= '<? echo CALLBACK; ?>';
			config['description'] 	= '<? echo DESCRIPTION; ?>';
			config['display_type'] 	= '<? echo DISPLAY_TYPE; ?>';
			config['root_dir']		= '<? echo ROOT_DIR; ?>';
			config['base_dir']		= '<? echo BASE_DIR; ?>';
			config['current_dir']	= '<? echo CURRENT_DIR; ?>';
			config['current_file']	= '<? echo CURRENT_FILE; ?>';
			config['current_level']	= 0;
			config['from_base_dir']	= new Array();
			config['allow_rename']	= <? echo string_bool( ALLOW_RENAME ); ?>;
			config['allow_delete']	= <? echo string_bool( ALLOW_DELETE ); ?>;
			config['file_list']		= [];
		</script>
	</head>

	<body>
		
		<header class="fix">
			
			<div id="toolbar" class="ca">
				
				<div class="l">
	
					<? if( ALLOW_FILE_UPLOAD ){ ?>
						<div class="ilb file-uploader"> 
							<div id="multi_file"><a class="btn" href="#" onclick="return false;">Upload Files</a></div>
						</div>
					<? } ?>
					
					<? if( ALLOW_FOLDER_CREATION ){ ?>
						<a class="btn" href="#" onclick="return confirm_create_folder();">Create Folder</a>
					<? } ?>
					
					<? if( ALLOW_FILE_UPLOAD || ALLOW_FOLDER_CREATION ){ ?>
						&nbsp;&nbsp;&nbsp;
					<? } ?>
					
					View as:
					
					<div class="ilb toggles">
						<?
							echo '<a';
								echo ' id="view_grid"';
								echo ' href="#"';
								echo ' onclick="return toggle_view(\'grid\');"';
								if( DISPLAY_TYPE == 'grid' ){
									echo ' class="active"';
								}
							echo '>Grid</a>';
						
							echo '<a';
								echo ' id="view_list"';
								echo ' href="#"';
								echo ' onclick="return toggle_view(\'list\');"';
								if( DISPLAY_TYPE == 'list' ){
									echo ' class="active"';
								}
							echo '>List</a>';
						
						?>
					</div>
					
					&nbsp;&nbsp;&nbsp;
					
					<a class="btn" href="#" onclick="return get_directory();">Refresh</a>
					
				</div>
				
				<div class="r">
					<a class="btn" href="#" id="clear_search" onclick="return clear_search();">Clear Search</a>
					<input type="text" id="search_term" placeholder="Search Directory...">
				</div>
				
			</div>
			
			<div id="breadcrumb"></div>
			
		</header>
		
		<div id="file_listing" class="<? echo DISPLAY_TYPE; ?>" class="ca"></div>
			
		<div id="upload_queue" class="fix"></div>
		
		<div id="modal" class="fix">
			<div id="loading" class="abs"><i class="fa fa-cog fa-spin fa-3x fa-fw"></i></div>
			<div id="content" class="abs"></div>
		</div>
		
	</body>
	
</html>
