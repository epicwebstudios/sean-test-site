<?
	$info = get_item( 1, $database[0] );
	$info['email_settings'] = json_decode( $info['email_settings'], true );
	if( !is_array($info['email_settings']) ){
		$info['email_settings'] = array();
	}
?>

<div class="ca title_box">

    <div class="l">
		<h1>Editing <? echo $item_capital; ?></h1>
    </div>
    
    <div class="r">
    </div>

</div>


<script>

	function swap_offline(){
		$( '.offline' ).hide();
		var id = $( '#offline' ).val();
		if( id == '1' ){
			$( '.offline' ).show();
		}
	}
	
	$( document ).ready( function(){
		swap_offline();
	});

</script>


<form 
	id="page_editor"
    method="post"
    enctype="multipart/form-data"
    action="<? echo $base_url; ?>"
>  
	
    <? field_hidden( 'id', $info['id'] ); ?>
    
	<table class="form">
		<thead>
			<tr>
				<td colspan="2">General Site Settings</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="left">Website URL:</td>
				<td class="right">
                	<? field_text( 'url', $info['url'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Website Name:</td>
				<td class="right">
                	<? field_text( 'name', $info['name'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Timezone:</td>
				<td class="right">
                	<? field_select( 'timezone', get_timezones(), $info['timezone'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Site Status:</td>
				<td class="right">
                	<?
						$options = array( 0 => 'Online', 1 => 'Offline / Maintenance Mode' );
                    	field_select2( 'offline', $options, $info['offline'], '', 'onchange="swap_offline();"' );
					?>
                </td>
			</tr>
			<tr class="offline">
				<td class="left">Offline Message:</td>
				<td class="right">
                	<? field_textarea( 'offline_msg', $info['offline_msg'] ); ?>
                </td>
			</tr>
		</tbody>
	</table>
    
    &nbsp;
    
    <script>
		
		function update_desc(){
				
			$( '.description_error' ).html( '' );
			
			var description	= $( '#description' ).val();
			var error	= '';
			
			if( description.length > 158 ){
				error += '<div>Your description is over 158 characters. Normal SEO practices suggest a description of <b>158 characters or less</b>.</div>';
				error += '<div>You are currently at <b>' + description.length + ' characters</b>.</div>';
			}
			
			$( '.description_error' ).html( error );
				
		}
		
		$( document ).ready( function(){
			update_desc();
		});
	
	</script>
    
	<table class="form">
		<thead>
			<tr>
				<td colspan="2">Default Site SEO Settings</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="left">Browser Title:</td>
				<td class="right">
                	<? field_text( 'title', $info['title'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Meta Description:</td>
				<td class="right">
                	<? field_textarea( 'description', $info['description'], '', 'onkeyup="update_desc();"' ); ?>
					<div class="description_error" style="color: #C00;"></div>
                </td>
			</tr>
			<tr>
				<td class="left">Allow Indexing:</td>
				<td class="right">
                	<?
						$options = array( 1 => 'Enabled', 0 => 'Disabled' );
                    	field_select2( 'allow_index', $options, $info['allow_index'] );
					?>
					<div>If enabled, Google (and other search engines) will be allowed to index the website.</div>
                </td>
			</tr>
            <tr class="setting-index setting-index-0">
                <td class="left">Allowed User Agents:</td>
                <td class="right">
                    <? field_select2_multiple( 'user_agents', $info['user_agents'], $info['user_agents'], false, false, ',', array('tags' => true,) ); ?>
                    <div>User agents to disable noindex for while indexing is disabled.</div>
                </td>
            </tr>
			<tr>
				<td class="left">Theme Color:</td>
				<td class="right">
                	<? field_color( 'theme_color', $info['theme_color'] ); ?>
                    <div>This color is used for iOS and Android devices to specify the "theme color" of the website.</div>
                </td>
			</tr>
			<tr>
				<td class="left">FavIcon:</td>
				<td class="right">
					<?
						$favicon = '';
						if( $info['favicon'] ){ $favicon = 'favicon-64x64.png?v='.$info['favicon']; }
                    	field_image( 'favicon', $favicon, '/ico/' );
					?>
					<div>FavIcon files should be a <b>square PNG image at least 256x256</b> in size.</div>
				</td>
			</tr>
			<tr>
				<td class="left">SEO Image:</td>
				<td class="right">
                	<? field_image( 'image', $info['image'], '/og_images/' ); ?>
                    <div>This is the default image that is pulled for the page by any Facebook sharing and APIs.</div>
                </td>
			</tr>
		</tbody>
	</table>
    
    &nbsp;
	
	<script>
	
		function toggle_smtp(){
			var id = $( '#email_settings_smtp' ).val();
			$( '.smtp' ).hide();
			$( '.smtp_' + id ).show();
			console.log( id );
		}
		
		$( document ).ready( function(){
			toggle_smtp();
		});
	
	</script>
    
	<table class="form">
		<thead>
			<tr>
				<td colspan="2">Mail Settings</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="left">"From" Name:</td>
				<td class="right">
                	<? field_text( 'email_settings[name]', $info['email_settings']['name'] ); ?>
					<div>If blank, the site name will be used.</div>
                </td>
			</tr>
			<tr>
				<td class="left">"From" E-mail Address:</td>
				<td class="right">
                	<? field_text( 'email_settings[email]', $info['email_settings']['email'] ); ?>
					<div>Default "From" e-mail address using any system mailer scripts.</div>
                </td>
			</tr>
			<tr>
				<td class="left">Use Authentication:</td>
				<td class="right">
                	<?
						$options = array( '0' => 'No', '1' => 'Yes' );
						field_select2( 'email_settings[smtp]', $options, $info['email_settings']['smtp'], '', 'onchange="toggle_smtp();"' );
					?>
                </td>
			</tr>
			<tr class="smtp smtp_1">
				<td class="left">SMTP Host:</td>
				<td class="right">
                	<? field_text( 'email_settings[host]', $info['email_settings']['host'] ); ?>
                </td>
			</tr>
			<tr class="smtp smtp_1">
				<td class="left">SMTP Port:</td>
				<td class="right">
                	<? field_text( 'email_settings[port]', $info['email_settings']['port'], 'width: 50px; text-align: center;' ); ?>
                </td>
			</tr>
			<tr class="smtp smtp_1">
				<td class="left">Encryption Type:</td>
				<td class="right">
                	<?
						$options = array( 'tls' => 'TLS', 'ssl' => 'SSL' );
						field_select2( 'email_settings[encryption]', $options, $info['email_settings']['encryption'] );
					?>
                </td>
			</tr>
			<tr class="smtp smtp_1">
				<td class="left">SMTP Username:</td>
				<td class="right">
                	<? field_text( 'email_settings[username]', $info['email_settings']['username'] ); ?>
                </td>
			</tr>
			<tr class="smtp smtp_1">
				<td class="left">SMTP Password:</td>
				<td class="right">
                	<? field_text( 'email_settings[password]', $info['email_settings']['password'] ); ?>
                </td>
			</tr>
		</tbody>
	</table>
	
	&nbsp;
    
	<table class="form">
		<thead>
			<tr>
				<td colspan="2">Page Settings</td>
			</tr>
		</thead>
		<tbody>
            <tr>
                <td class="left">Header Logo:</td>
                <td class="right">
                    <? field_image( 'logo_header', $info['logo_header'], '/layout/' ); ?>
                </td>
            </tr>
            <tr>
                <td class="left">Footer Logo:</td>
                <td class="right">
                    <? field_image( 'logo_footer', $info['logo_footer'], '/layout/' ); ?>
                </td>
            </tr>
            <tr>
                <td class="left">Default Banner Image:</td>
                <td class="right">
                    <? field_image( 'banner_image', $info['banner_image'], '/layout/banner/' ); ?>
                    <?= render_banner_dimensions(); ?>
                </td>
            </tr>
            <tr>
                <td class="left">Banner Lazy Loading:</td>
                <td class="right">
                    <? field_select( 'banner_lazy', array(0 => 'Disabled', 1 => 'Enabled'), $info['banner_lazy'] ); ?>
                </td>
            </tr>
            <tr>
                <td class="left">Sticky Header:</td>
                <td class="right">
                    <? field_select( 'sticky_header', array(0 => 'Disabled', 1 => 'Enabled'), $info['sticky_header'] ); ?>
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
	&nbsp;

	<table class="form">
		<thead>
			<tr>
				<td colspan="2">Header and Footer Buttons</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="left">Header Button Text:</td>
				<td class="right">
					<? field_text( 'header_button_txt', $info['header_button_txt']); ?>
					<div>
						Displays text within the Header button
					</div>
				</td>
			</tr>
			<tr>
				<td class="left">Header Button URL:</td>
				<td class="right">
					<? field_text( 'header_button_url', $info['header_button_url']); ?>
					<div>
						Where the Header button links
					</div>
				</td>
			</tr>
			<tr>
				<td class="left">Become a Member Text:</td>
				<td class="right">
					<? field_text( 'bam_button_txt', $info['bam_button_txt']); ?>
					<div>
						Displays text within Become a Member
					</div>
				</td>
			</tr>
			<tr>
				<td class="left">Become a Member URL:</td>
				<td class="right">
					<? field_text( 'bam_button_url', $info['bam_button_url']); ?>
					<div>
						Where Become a Member links
					</div>
				</td>
			</tr>
			<tr>
				<td class="left">Footer Button Text:</td>
				<td class="right">
					<? field_text( 'footer_button_txt', $info['footer_button_txt']); ?>
					<div>
						Displays Footer text within the button
					</div>
				</td>
			</tr>
			<tr>
				<td class="left">Footer Button URL:</td>
				<td class="right">
					<? field_text( 'footer_button_url', $info['footer_button_url']); ?>
					<div>
						Where the Footer button links
					</div>
				</td>
			</tr>
		</tbody>
	</table>

	&nbsp;
    
	<? $file_browser = json_decode( $info['file_browser'], true ); ?>
	<table class="form">
		<thead>
			<tr>
				<td colspan="2">File Browser Settings</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="left">Default Display:</td>
				<td class="right">
                	<?
						$options = array( 'grid' => 'Grid View', 'list' => 'List View' );
						field_select2( 'file_browser[display_type]', $options, $file_browser['display_type'] );
					?>
                </td>
            </tr>
			<tr>
				<td class="left">Valid Image File Types:</td>
				<td class="right">
                	<? field_text( 'file_browser[image_types]', $file_browser['image_types'], 'width: 100%;' ); ?>
					<div>This controls which type of files are shown when someone accesses the file browser via the "<b>Insert/edit image</b>" section.</div>
                </td>
            </tr>
			<tr>
				<td class="left">Valid Media File Types:</td>
				<td class="right">
                	<? field_text( 'file_browser[media_types]', $file_browser['media_types'], 'width: 100%;' ); ?>
					<div>This controls which type of files are shown when someone accesses the file browser via the "<b>Insert/edit video</b>" section.</div>
                </td>
            </tr>
			<tr>
				<td class="left">Valid Link File Types:</td>
				<td class="right">
                	<? field_text( 'file_browser[file_types]', $file_browser['file_types'], 'width: 100%;' ); ?>
					<div>This controls which type of files are shown when someone accesses the file browser via the "<b>Insert/edit link</b>" section.</div>
					<div>The "<b>Insert/edit link</b>" automatically assumes all types listed in "<b>image</b>" and "<b>media</b>" above, in addition to these types.</div>
                </td>
            </tr>
			<tr>
				<td class="left">Allow Folder Creation:</td>
				<td class="right">
                	<?
						$options = array( 1 => 'Yes', 0 => 'No' );
						field_select2( 'file_browser[allow_folder_creation]', $options, $file_browser['allow_folder_creation'] );
					?>
                </td>
            </tr>
			<tr>
				<td class="left">Allow File Upload:</td>
				<td class="right">
                	<?
						$options = array( 1 => 'Yes', 0 => 'No' );
						field_select2( 'file_browser[allow_file_upload]', $options, $file_browser['allow_file_upload'] );
					?>
                </td>
            </tr>
			<tr>
				<td class="left">Allow File Renaming:</td>
				<td class="right">
                	<?
						$options = array( 1 => 'Yes', 0 => 'No' );
						field_select2( 'file_browser[allow_rename]', $options, $file_browser['allow_rename'] );
					?>
                </td>
            </tr>
			<tr>
				<td class="left">Allow File Deletion:</td>
				<td class="right">
                	<?
						$options = array( 1 => 'Yes', 0 => 'No' );
						field_select2( 'file_browser[allow_delete]', $options, $file_browser['allow_delete'] );
					?>
                </td>
            </tr>
			<tr>
				<td class="left">Allow File Overwriting:</td>
				<td class="right">
                	<?
						$options = array( 1 => 'Yes', 0 => 'No' );
						field_select2( 'file_browser[allow_overwrite]', $options, $file_browser['allow_overwrite'] );
					?>
					<div>If disabled, when files with the same file name are uploaded, the file will append an iterative number at the end of the file name.</div>
                	<div>Example: If "<b>photo.jpg</b>" already exists, when re-uploaded, the new file will be named "<b>photo-1.jpg</b>".</div>
				</td>
            </tr>
        </tbody>
    </table>
	
	&nbsp;
    
	<table class="form">
		<thead>
			<tr>
				<td colspan="2">PageSpeed Settings</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="left">Auto-Minify CSS</td>
				<td class="right">
                	<?
						$options = array( 1 => 'Yes', 0 => 'No' );
                    	field_select2( 'ps_minify_css', $options, $info['ps_minify_css'] );
					?>
                    <div>
                    	If set to yes, the system will pull in all CSS files, minify them, and insert the content inside of a &lt;style&gt; in the &lt;head&gt; section.
                    </div>
                </td>
            </tr>
		</tbody>
	</table>
            
	&nbsp;
    
    <? $viewport = json_decode( $info['viewport'], true ); ?>
	<table class="form">
		<thead>
			<tr>
				<td colspan="2">Viewport (Mobile Rendering) Settings</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="left">Viewport Width:</td>
				<td class="right">
                	<? field_text( 'viewport[width]', $viewport['width'], 'width: 90px;' ); ?>
                    <div>If blank, this defaults to "<b>device-width</b>".</div>
                </td>
			</tr>
			<tr>
				<td class="left">Viewport Height:</td>
				<td class="right">
                	<? field_text( 'viewport[height]', $viewport['height'], 'width: 90px;' ); ?>
                    <div>If blank, this defaults to "<b>device-height</b>".</div>
                </td>
			</tr>
			<tr>
				<td class="left">Initial Scale:</td>
				<td class="right">
                	<? field_text( 'viewport[initial_scale]', $viewport['initial_scale'], 'width: 40px;' ); ?>
                    <div>If blank, this defaults to "<b>1.0</b>" (or 100% zoom)</div>
                </td>
			</tr>
			<tr>
				<td class="left">Min. Scale (Zoom Out):</td>
				<td class="right">
                	<? field_text( 'viewport[min_scale]', $viewport['min_scale'], 'width: 40px;' ); ?>
                    <div>The smallest zoom level (ex: "<b>0.25</b>" or 25%)</div>
                </td>
			</tr>
			<tr>
				<td class="left">Max. Scale (Zoom In):</td>
				<td class="right">
                	<? field_text( 'viewport[max_scale]', $viewport['max_scale'], 'width: 40px;' ); ?>
                    <div>The largest zoom level (ex: "<b>2.0</b>" or 25%)</div>
                </td>
			</tr>
			<tr>
				<td class="left">Scalable:</td>
				<td class="right">
                	<?
						$options = array( 'yes' => 'Yes', 'no' => 'No' );
                    	field_select2( 'viewport[scalable]', $options, $viewport['scalable'] );
					?>
                </td>
			</tr>
        </tbody>
    </table>
    
    &nbsp;
    
	<table class="form">
		<thead>
			<tr>
				<td colspan="2">Administrator Settings</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="left">Max. Login Attempts:</td>
				<td class="right">
                	<? field_text( 'max_login_attempts', $info['max_login_attempts'], 'width: 30px;' ); ?>
                    <div>This limits the number of invalid administrative login attempts for an individual user. If set to "<b>0</b>", unlimited login attempts are allowed.</div>
                </td>
			</tr>
        </tbody>
    </table>
    
    &nbsp;
	
	<div>
		
        <input
        	type="submit"
            name="edit_sub"
            value="Save <? echo $item_capital; ?>"
        >
        
	</div>
      
</form>

<? browser_title( 'Editing '.$item_capital ); ?>

<script>
    bind_toggle('#allow_index', 'setting-index');
</script>