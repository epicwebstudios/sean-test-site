<?
	
	$info = get_item( $_GET['i'], $database[0] );
	require_once dirname( __FILE__ ).'/functions.js.php';

	if($_GET['act'] == "add"){
		$info['content'] 	= '<div class="section"><div class="wrapper"><h1>Page Title</h1><p>The content of the page goes here.</p></div></div>';
		$info['template'] 	= 2;
	}

	$banner_image_rec = array(
        'Homepage'  => '1920x###',
        'Subpage'   => '1920x###',
    );
?>


<div class="ca title_box">

    <div class="l">
        <h1><? if( $_GET['act'] == 'add' ){ echo 'Add New'; } else { echo 'Editing'; } ?> <? echo $item_capital; ?></h1>
    </div>
    
    <div class="l">
		<input type="button" value="Return to all <? echo $item_plural_capital; ?>" onclick="window.location = '<? echo $base_url; ?>';">
    </div>
    
    <div class="r">
		<? if( $_GET['act'] == 'edit' ){ ?>
        	<input type="button" value="View Page" onClick="window.open('<? echo returnURL().'/'.$info['link']; ?>');">
        <? } ?>
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
				<td colspan="2">Page Information</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="left">Page Name:</td>
				<td class="right">
                	<? field_text( 'name', $info['name'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Page URL:</td>
				<td class="right">
					<span class="black"><b><? mainURL(1); ?></b></span><? field_text( 'link', $info['link'], "margin-top: -3px; width: 200px;" ); ?>
                    <? /* <input type="text" name="link" value="<? echo $info['link']; ?>" style="margin-top: -3px; width: 200px;"/> */ ?>
					<div>This corresponds to the link where the page is accessed.</div>
				</td>
			</tr>
			<tr>
				<td class="left">Browser Title Bar:</td>
				<td class="right">
                	
					<? field_text( 'title', $info['title'], '', 'onkeyup="update_title();"' ); ?>
					
                    <div>
                    	The title bar of the browser will read <b>"<span class="title_desc"></span>"</b> for this page.
                    </div>
                    
					<div class="title_error" style="color: #C00;"></div>
                    
				</td>
			</tr>
			<tr>
				<td class="left">Page Template:</td>
				<td class="right">
                	<? field_select2( 'template', $page_templates, $info['template'] ); ?>
				</td>
			</tr>
		</tbody>
	</table>

    &nbsp;

    <table class="form template-setting template-setting-1  template-setting-2">
        <thead>
            <tr>
                <td colspan="2">Banner Information</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="left">Use Banner:</td>
                <td class="right">
                    <? field_select( 'banner', array(0 => 'No', 1 => 'Yes',), $info['banner'] ); ?>
                </td>
            </tr>
        </tbody>
        <tbody class="banner-setting banner-setting-1">
            <tr>
                <td class="left">Media Type:</td>
                <td class="right">
                    <? field_select( 'banner_type', array(2 => 'None', 0 => 'Image', 1 => 'Video'), $info['banner_type'] ); ?>
                </td>
            </tr>
            <tr class="banner-type-setting banner-type-setting-0 banner-type-setting-1">
                <td class="left">Use Overlay:</td>
                <td class="right">
                    <? field_select( 'banner_overlay', array(1 => 'Yes', 0 => 'No',), $info['banner_overlay'] ); ?>
                </td>
            </tr>
            <tr class="banner-type-setting banner-type-setting-0">
                <td class="left">Banner Image:</td>
                <td class="right">
                    <? field_image( 'banner_image', $info['banner_image'], '/layout/banner/' ); ?>
                    <table>
                        <tr><td colspan="2"><b>Recommended Dimensions</b></td></tr>
                        <? foreach ($banner_image_rec as $key => $dim) : ?>
                            <tr><td><?= $key ?>:</td><td><?= $dim ?></td></tr>
                        <? endforeach; ?>
                    </table>
                </td>
            </tr>
            <tr class="banner-type-setting banner-type-setting-1">
                <td colspan="9999">
                    <table>
                        <tr>
                            <td class="left">Video Type:</td>
                            <td class="right">
                                <? field_select( 'banner_video_type', array(1 => 'Upload', 2 => 'YouTube URL',), $info['banner_video_type'] ); ?>
                            </td>
                        </tr>
                        <tr class="banner-video-type-setting banner-video-type-setting-1">
                            <td class="left">Video File:</td>
                            <td class="right">
                                <? field_file( 'banner_video_file', $info['banner_video_file'], '/layout/banner/' ); ?>
                                <div>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th colspan="9999">Recommended Video Specs</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>File Type:</td>
                                                <td>.mp4</td>
                                            </tr>
                                            <tr>
                                                <td>Size:</td>
                                                <td>< 15 MB</td>
                                            </tr>
                                            <tr>
                                                <td>Length:</td>
                                                <td>< 15 seconds</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr class="banner-video-type-setting banner-video-type-setting-2">
                            <td class="left">Video URL:</td>
                            <td class="right">
                                <? field_text( 'banner_video_url', $info['banner_video_url'] ); ?>
                                <div>e.g. https://www.youtube.com/watch?v=LXb3EKWsInQ</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="left">Video Thumbnail:</td>
                            <td class="right">
                                <? field_image( 'banner_video_thumbnail', $info['banner_video_thumbnail'], '/layout/banner/' ); ?>
                                <table>
                                    <tr><td colspan="2"><b>Recommended Dimensions</b></td></tr>
                                    <? foreach ($banner_image_rec as $key => $dim) : ?>
                                        <tr><td><?= $key ?>:</td><td><?= $dim ?></td></tr>
                                    <? endforeach; ?>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="left">Title:</td>
                <td class="right">
                    <? field_text( 'banner_title', $info['banner_title'] ); ?>
                </td>
            </tr>
            <tr>
                <td class="left">Supertitle:</td>
                <td class="right">
                    <? field_text( 'banner_supertitle', $info['banner_supertitle'] ); ?>
                    <div>Text above banner title</div>
                </td>
            </tr>
            <tr>
                <td class="left">Subtitle/Text:</td>
                <td class="right">
                    <? field_textarea( 'banner_subtitle', $info['banner_subtitle'] ); ?>
                    <div>Text below banner title</div>
                </td>
            </tr>
            <tr>
                <td class="left">Use Button(s):</td>
                <td class="right">
                    <?
                        $options = array( 0 => 'Do Not Use Button(s)', 1 => 'Use Button(s)' );
                        field_select2( 'banner_button', $options, $info['banner_button'] );
                    ?>
                </td>
            </tr>
            <tr class="button-setting button-setting-1">
                <td colspan="9999" style="padding:15px;">
                    <div style="margin-top:-2em;">
                        <?
                            if ($_GET['act'] == 'edit')
                                ajax_section('banner_buttons');
                            else
                                echo 'Please save the page before adding buttons.';
                        ?>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
		
	&nbsp;
	
    <? field_editor( 'content', $info['content'] ); ?>
	
	&nbsp;
    
	<table class="form">
		<thead>
			<tr>
				<td colspan="2">Page Description and Security Settings</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="left">Page Description:</td>
				<td class="right">
                	<? field_textarea( 'description', $info['description'], '', 'onkeyup="update_desc();"' ); ?>
					<div class="description_error" style="color: #C00;"></div>
				</td>
			</tr>
			<tr>
				<td class="left">Page Status:</td>
				<td class="right">
                	<? field_select2( 'status', $statuses, $info['status'] ); ?>
				</td>
			</tr>
			<tr>
				<td class="left">Allow SEO Indexing:</td>
				<td class="right">
                	<?
						$options = array( 0 => 'Yes', 1 => 'No' );
						field_select2( 'spider', $options, $info['spider'] );
					?>
					<div>If this setting is set to "Yes," the system will allow this page to be indexed by search engines.</div>
				</td>
			</tr>
			<tr>
				<td class="left">Password Protection:</td>
				<td class="right">
                	<?
						$options = array( 0 => 'No (Public)', 1 => 'Yes (Only accessible with password)' );
						field_select2( 'protect', $options, $info['protect'], '', 'onchange="swap_password();"' );
					?>
				</td>
			</tr>
			<tr class="password">
				<td class="left">Page Password:</td>
				<td class="right">
                	<?
						field_hidden( 'c_password', $info['password'] );
						field_hidden( 'ce_password', $info['e_password'] );
						field_text( 'password' );
					?>
					<? if($info['password']){ ?>
						<div>The page password is currently set to <b><? echo $info['password']; ?></b>. To change the password, please enter a new password above.</div>
					<? } ?>
				</td>
			</tr>
			<tr>
				<td class="left">Canonical URL:</td>
				<td class="right">
                	<? field_text( 'canonical', $info['canonical'] ); ?>
					<div>If this page duplicates the content of another page or website, enter the original URL here. Otherwise, leave blank.</div>
                </td>
			</tr>
		</tbody>
	</table>
	
	&nbsp;
    
	<table class="form" id="additional_settings">
		<thead>
			<tr>
				<td colspan="2" style="cursor: pointer;">Additional Page Settings and Configuration <span class="state"></span></td>
			</tr>
		</thead>
		<tbody>
			<tr class="category">
				<td colspan="2">
					These settings are used to specify specific information for the page when shared on Facebook. By default, the pages title, description, and site logo are used as sharing information.
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
			<tr class="category">
				<td colspan="2">
					You can use the following settings to add in custom scripts and snippets to this page individually. (Note: These are used in addition to the custom tags added into the "Site Settings" section)
				</td>
			</tr>
			<tr>
				<td class="left">&lt;head&gt; Tags:</td>
				<td class="right">
                	<? field_code( 'head', $info['head'] ); ?>
                    <div>
                    	The above code is loaded just prior to the closing <b>&lt;/head&gt;</b> tag. 
                        This section can be used for including custom scripts from 3rd party websites and services.
                    </div>
                </td>
            </tr>
			<tr>
				<td class="left">Opening &lt;body&gt; Tags:</td>
				<td class="right">
                	<? field_code( 'body_open', $info['body_open'] ); ?>
                    <div>
                    	The above code is loaded just after to the opening <b>&lt;body&gt;</b> tag. 
                        This section can be used for including custom scripts from 3rd party websites and services.
                    </div>
                </td>
            </tr>
			<tr>
				<td class="left">Closing &lt;body&gt; Tags:</td>
				<td class="right">
                	<? field_code( 'body_close', $info['body_close'] ); ?>
                    <div>
                    	The above code is loaded just prior to the closing <b>&lt;/body&gt;</b> tag. 
                        This section can be used for including custom scripts from 3rd party websites and services.
                    </div>
                </td>
            </tr>
		</tbody>
	</table>
	
	<input type="hidden" name="preview" value="1" />
	
	&nbsp;
	
	<div>
		
        <input
        	type="submit"
            name="<? if($_GET['act'] == "edit"){ echo "edit"; } else { echo "add"; } ?>_sub"
            value="Save <? echo $item_capital; ?>"
        />
		
        &nbsp;&nbsp;
		
        <input
        	type="submit"
            name="preview_sub"
            value="Preview Page"
            onclick="return submit_page( this.form, '_blank', '<? mainURL(1); ?>preview' );"
         />
	
    </div>
  
</form>

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

<script>
    $(function() {
        bind_toggle('#template', 'template-setting');
        bind_toggle('#banner', 'banner-setting');
        bind_toggle('#banner_type', 'banner-type-setting');
        bind_toggle('#banner_video_type', 'banner-video-type-setting');
        bind_toggle('#banner_button', 'button-setting');
    });
</script>