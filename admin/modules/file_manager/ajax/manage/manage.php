<?

	global $user;

	$file_path 	= $_GET['file'];
	$file_name 	= explode( '/', $file_path );
	$file_name 	= end( $file_name );
	$file_url	= str_replace( BASE_DIR, returnURL(), $file_path );
	$file_size	= format_bytes( filesize( $file_path ) );
	$file_time	= date( 'n/j/Y, g:i A', filemtime( $file_path ) );

	$rQ = mysql_query( "SELECT * FROM `file_manager` WHERE `file_path` = '".$file_path."' LIMIT 1" );
	if( mysql_num_rows($rQ) > 0 ){
		$info 	= mysql_fetch_assoc( $rQ );
		$id 	= $info['id'];
	} else {
		$info 	= array();
		$id 	= '';
	}

	if( is_dir($file_path) ){
		$desc = 'folder';
	} else {
		$desc = 'file';
	}

?>

<? if( $user['level'] == 1 ){ ?>
	<script>window.parent.lb_close();</script>
<? } ?>

<form 
	id="page_editor"
    method="post"
    enctype="multipart/form-data"
    action="<? echo $base_url.'?file='.$_GET['file']; ?>"
>

    <? field_hidden( 'id', $id ); ?>
    <? field_hidden( 'file_path', $file_path ); ?>

    <table class="form">
        <thead>
            <tr>
                <td colspan="2">
                    <? echo ucwords( $desc ).' Details'; ?>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="left"><? echo ucwords( $desc ); ?> Name:</td>
                <td class="right black">
                    <div><b><? echo $file_name; ?></b></div>
                </td>
            </tr>
            <tr>
                <td class="left"><? echo ucwords( $desc ); ?> Server Path:</td>
                <td class="right black">
                    <div><? echo $file_path; ?></div>
                </td>
            </tr>
            <tr>
                <td class="left"><? echo ucwords( $desc ); ?> URL:</td>
                <td class="right black">
                    <div><a href="<? echo $file_url; ?>" target="_blank"><? echo $file_url; ?></a></div>
                </td>
            </tr>
            <tr>
                <td class="left"><? echo ucwords( $desc ); ?> Size:</td>
                <td class="right black">
                    <div><? echo $file_size; ?></div>
                </td>
            </tr>
            <tr>
                <td class="left"><? echo ucwords( $desc ); ?> Modified:</td>
                <td class="right black">
                    <div><? echo $file_time; ?></div>
                </td>
            </tr>
			<tr class="category">
				<td colspan="2">
					<? echo ucwords( $desc ); ?> Configuration &amp; Overrides
				</td>
			</tr>
            <tr>
                <td class="left">Custom Icon:</td>
                <td class="right">
                    <? field_text( 'icon', $info['icon'], 'width: 100%;' ); ?>
					<div>To change the icon displayed, enter the icon class names above.</div>
					<div>For class names, please refer to the <a href="https://fontawesome.com/icons?d=gallery" target="_blank">FontAwesome 5 icon codes</a>.</div>
                </td>
            </tr>
            <tr>
                <td class="left">Custom Icon Color:</td>
                <td class="right">
                    <? field_color( 'color', $info['color'] ); ?>
					<div>If you'd like to change the icon color, choose a new color above.</div>
                </td>
            </tr>
            <tr>
                <td class="left">Custom Thumbnail:</td>
                <td class="right">
                    <? field_text( 'thumbnail', $info['thumbnail'], 'width: 100%;' ); ?>
					<div>Please include the full URL to the desired image above.</div>
					<div>URL must include <b>http://</b> or <b>https://</b> to display correctly.</div>
                </td>
            </tr>
            <tr>
                <td class="left">File Browser Visibility:</td>
                <td class="right">
                    <?
						$options = array( 0 => 'Visible in File Browser', 1 => 'Hidden in File Browser' );
						field_select( 'omit', $options, $info['omit'] );
					?>
					<div>You can change the visibility of this <? echo $desc; ?> within the file browser with this setting.</div>
                </td>
            </tr>
            <tr>
                <td class="left">Search Engine Visibility:</td>
                <td class="right">
                    <?
						$options = array( 0 => 'Enabled', 1 => 'Disabled' );
						field_select( 'disallow_index', $options, $info['disallow_index'] );
					?>
					<div>If you'd like to hide this <? echo $desc; ?> from search engines you can set this to "<b>Disabled</b>"</div>
                </td>
            </tr>
        </tbody>
    </table>
    
    &nbsp;
    
    <div>
		
        <input
        	type="submit"
            name="edit_sub"
            value="Save Settings"
        >
        
        &nbsp;
        
        <input
            type="button"
            name="cancel"
            value="Cancel"
            onclick="window.parent.lb_close();"
        >
        
    </div>

</form>