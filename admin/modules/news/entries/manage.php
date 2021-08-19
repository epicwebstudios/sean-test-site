<? $info = get_item( $_GET['i'], $database[0] ); ?>


<div class="ca title_box">

    <div class="l">
        <h1><? if( $_GET['act'] == 'add' ){ echo 'Add New'; } else { echo 'Editing'; } ?> <? echo $item_capital; ?></h1>
    </div>
    
    <div class="l">
		<input type="button" value="Return to all <? echo $item_plural_capital; ?>" onclick="window.location = '<? echo $base_url; ?>';">
    </div>
    
    <div class="r">
    </div>

</div>


<form 
	id="page_editor"
    method="post"
    enctype="multipart/form-data"
    action="<? echo $base_url; if( $_GET['act'] == 'edit' ){ echo '&act='.$_GET['act'].'&i='.$_GET['i']; } ?>"
>

    <? field_hidden( 'id', $info['id'] ); ?>
    
	<table class="form">
		<thead>
			<tr>
				<td colspan="2"><? echo $item_capital; ?> Information</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="left">Title:</td>
				<td class="right">
                	<? field_text( 'name', $info['name'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Permalink:</td>
				<td class="right">
                	<? field_permalink( 'permalink', $info['permalink'], 'name' ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Category:</td>
				<td class="right">
                	<? field_select2( 'category', $categories, $info['category'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Post Date:</td>
				<td class="right">
                	<? field_date( 'post_date', $info['date'] ); ?> at <? field_time( 'post_time', $info['date'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Status:</td>
				<td class="right">
                	<?
						$options = array( 1 => 'Published / Scheduled', 0 => 'Draft' );
                    	field_select2( 'status', $options, $info['status'] );
					?>
                </td>
			</tr>
		</tbody>
	</table>
    
    &nbsp;
    
	<table class="form">
		<thead>
			<tr>
				<td colspan="2"><? echo $item_capital; ?> Summary</td>
			</tr>
		</thead>
        <tbody>
			<tr>
				<td class="left">Summary:</td>
				<td class="right">
                	<? field_textarea( 'summary', $info['summary'], 'width: 100%;' ); ?>
                    <div>This is the summary shown on news listing pages. This should be a short teaser for the full entry.</div>
                </td>
			</tr>
    	</tbody>
	</table>
	
	&nbsp;
    
	<table class="form">
		<thead>
			<tr>
				<td colspan="2"><? echo $item_capital; ?> Content</td>
			</tr>
		</thead>
	</table>
    <div><? field_editor( 'entry', $info['entry'] ); ?></div>
	
	&nbsp;
    
	<table class="form">
		<thead>
			<tr>
				<td colspan="2">Social Media Sharing</td>
			</tr>
		</thead>
		<tbody>
			<tr class="category">
				<td colspan="2">
					These settings are used to specify specific information for the page when shared on Facebook. By default, the new entries title, summary, and default photo are used as sharing information.
				</td>
			</tr>
			<tr>
				<td class="left">Facebook Title:</td>
				<td class="right">
                	<? field_text( 'og_title', $info['og_title'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Facebook Description:</td>
				<td class="right">
                	<? field_textarea( 'og_description', $info['og_description'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Facebook Image:</td>
				<td class="right">
                	<? field_image( 'og_image', $info['og_image'], '/og_images/' ); ?>
                    <div>Facebook share images should be at least <b>600x315</b> in size. The recommended size is <b>1200x630</b>.</div>
                </td>
			</tr>
		</tbody>
	</table>
	
	&nbsp;
	
	<div>
		
        <input
        	type="submit"
            name="<? if( $_GET['act'] == 'edit' ){ echo 'edit'; } else { echo 'add'; } ?>_sub"
            value="Save <? echo $item_capital; ?>"
        >
        
	</div>
  
</form>

<? if( $_GET['act'] == 'edit' ){ ?>

	&nbsp;
	
	<link type="text/css" rel="stylesheet" href="<? mainURL(); ?>/admin/sources/css/dnd-uploader.css">
	<script type="text/javascript" src="<? mainURL(); ?>/admin/sources/js/dnd-uploader.min.js"></script>
	<script>
		
		$( document ).ready( function(){
		
			var settings = {
				url: 				'<? echo $ajax_url; ?>/upload.php?i=<? echo $info['id']; ?>',
				method: 			'POST',
				allowedTypes:		'jpg,png,gif,jpeg',
				fileName: 			'photo',
				multiple: 			true,
				onSuccess: 			function( files, data, xhr, filebox ){ ajax_listing( 'photos', <? echo $info['id']; ?> ); filebox.statusbar.remove(); },
				onError: 			function( files, status, error_message ){ alert( 'Upload Failed: ' + error_message ); }
			}
			
			$( '#multi_file' ).uploadFile( settings );
		
		});
		
	</script>
	
	<div class="file-uploader"> 
		<div id="multi_file">Select Photos to Upload</div>
		<div class="c"></div>
		<div id="status"></div>
	</div>
	
	<div class="file-list"></div>
	
	&nbsp;
    
    <? ajax_section( 'photos' ); ?>

<? } ?>

<?
	
	// AJAX Table/Records
	
	/*
	if( $_GET['act'] == 'edit' ){
		ajax_section( 'template' );
	}
	*/
	
?>

<?
	if( $_GET['act'] == 'add' ){
		browser_title( 'Add New '.$item_capital );
	} else {
		browser_title( 'Editing '.$item_capital );
	}
?>




