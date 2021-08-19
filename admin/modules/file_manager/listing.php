<? require dirname( __FILE__ ).'/settings.php'; ?>
<link rel="stylesheet" href="https://css.ewsapi.com/icons/fa5/icons.min.css">
<link rel="stylesheet" href="<? mainURL(); ?>/admin/files/src/dnd-uploader.css?<? echo time(); ?>">
<script src="<? mainURL(); ?>/admin/files/src/dnd-uploader.min.js"></script>
<script src="<? echo $dir_url; ?>/src/clipboard.min.js"></script>
<? require dirname( __FILE__ ).'/src/functions.js.php'; ?>
<? require dirname( __FILE__ ).'/src/styles.css.php'; ?>

<div class="ca title_box">

    <div class="l">
    	<h1><? echo $item_plural_capital; ?></h1>
    </div>
    
    <div class="l">
		<? if( $allow_add ){ ?>
            <input type="button" value="Add <? echo $item_capital; ?>" onclick="window.location = '<? echo $base_url.'&act=add'; ?>'; return false;">
        <? } ?>
    </div>
    
    <div class="r">
		<input type="button" id="deep_search_clear" onclick="return run_deep_search( true );" value="Clear Search">
		&nbsp;&nbsp;
		<input type="text" id="deep_search" onkeyup="return run_deep_search();" placeholder="Deep File Search">
    </div>

</div>

<table class="table">
	<thead>
		<tr>
			<td colspan="200" class="ca breadcrumb">
				
				<div class="l"></div>
				
				<div class="r actions">
					<? if( ALLOW_FILE_UPLOAD ) { ?>
						<div class="ilb file-uploader"> 
							<div id="multi_file"><input type="button" onclick="return create_folder();" value="Upload Files"></div>
						</div>
					<? } ?>
					<? if( ALLOW_FOLDER_CREATION ) { ?>
						&nbsp;
						<input type="button" onclick="return create_folder();" value="Create Folder">
					<? } ?>
					&nbsp;
					<input type="button" onclick="return get_directory();" value="Refresh">
				</div>
				
            </td>
		</tr>
	</thead>
	<tbody>
		<tr class="category">
			
			<td style="width: 40px;">&nbsp;</td>
			
			<td style="min-width: 269px;" class="name">
				<a href="#" onclick="return set_sorts('name');">File / Folder Name</a> <span class="fal fa-sort-alpha-down"></span>
			</td>
			
			<td style="min-width: 269px;">URL</td>
			
			<td style="width: 150px;" class="modified">
				<a href="#" onclick="return set_sorts('modified');">Modified</a> <span></span>
			</td>
			
			<td style="width: 100px;" class="tr size">
				<a href="#" onclick="return set_sorts('size');">Size</a> <span></span>
			</td>
			
			<? if( $user['level'] == '1' ){ ?>
				<td style="width: 40px;">Settings</td>
			<? } ?>
			
			<td style="width: 40px;">Download</td>
			<td style="width: 40px;">Rename</td>
			<td style="width: 40px;">Delete</td>
			
		</tr>
	</tbody>
</table>

<div id="upload_queue" class="fix"></div>

<? browser_title( ''.$item_plural_capital ); ?>