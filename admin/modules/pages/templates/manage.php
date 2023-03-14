<?
    global $user;

    $info = get_item( $_GET['i'], $database[0] );
?>


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
				<td class="left">Name:</td>
				<td class="right">
                	<? field_text( 'name', $info['name'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Description:</td>
				<td class="right">
                	<? field_textarea( 'description', $info['description'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Template File:</td>
				<td class="right">
                	<? field_select2( 'filename', $template_files, $info['filename'] ); ?>
                </td>
			</tr>
		</tbody>
	</table>

    &nbsp;

    <? $banner_dimensions = $info['banner_dimensions'] ? json_decode( $info['banner_dimensions'], true ) : null ?>

    <table class="form" <?= $user['level'] != 1 ? 'style="display:none"' : '' ?>>
        <thead>
            <tr>
                <td colspan="2" style="background-color:#21537b;">Developer Settings</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="left">Recommended Banner Dimensions:</td>
                <td class="right">
                    <? field_text( 'banner_dimensions[width]', ($banner_dimensions ? $banner_dimensions['width'] : ''), 'width:50px;' ); ?> <span class="black">px</span>
                    &nbsp;&nbsp;&times;&nbsp;&nbsp;
                    <? field_text( 'banner_dimensions[height]', ($banner_dimensions ? $banner_dimensions['height'] : ''), 'width:50px;' ); ?> <span class="black">px</span>
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

<?

	if( $_GET['act'] == 'edit' ){
        echo '<div class="grid">';
        echo '<div class="grid_box l w_50 p_r p_10">';
		ajax_section( 'left_blocks' );
        echo '</div>';

        echo '<div class="grid_box l w_50 p_l p_10">';
		ajax_section( 'right_blocks' );
        echo '</div>';
        echo '</div>';
	}
	
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




