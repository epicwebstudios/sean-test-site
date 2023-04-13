<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>

<table class="title_box">
	<tr>
		<td class="left"><h1><? if($_GET['act'] == "add"){ echo "Add New"; } else { echo "Editing"; } ?> <? echo $item_capital; ?></h1></td>
		<td class="right"><input type="button" value="Return To All <? echo $item_plural_capital; ?>" onClick="window.location='?a=<? echo $_GET['a']; ?>';"></td>
	</tr>
</table>

<?
	$query = mysql_query("SELECT * FROM `".$database[0]."` WHERE `id` = '".$_GET['i']."' LIMIT 1");
	$info = mysql_fetch_array($query);
	
	if($_GET['act'] == "add"){
		$info['description'] = '<h1 class="tc">Video Title</h1><p style="text-align: center;">Description of video goes here.</p>';
	}
	
?>   

<form id="page_editor" method="post" enctype="multipart/form-data" action="?a=<? echo $_GET['a']; ?><? if($_GET['act'] == "edit"){ ?>&act=<? echo $_GET['act']; } ?><? if($_GET['i']){ ?>&i=<? echo $_GET['i']; } ?>" >
	<input type="hidden" name="id" value="<? echo $info['id']; ?>" />
    
	<table class="form">
		<thead>
			<tr>
				<td colspan="2">Video Information</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="left">Video Category:</td>
				<td class="right">
					<select name="vid_cat">
						<?
							$query_cat = mysql_query("SELECT * FROM `m_videos_categories` WHERE `status` = 1");
							$vc_count = 1;
							while($p = mysql_fetch_assoc($query_cat)) {
								echo '<option value="'.$vc_count.'" '.(($info['vid_cat'] == $vc_count)?'selected="selected"':"").'>'.$p['name'].'</option>';;
								$vc_count++;
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="left">Name:</td>
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
                <td class="left">Banner Title:</td>
                <td class="right">
					<? field_text( 'banner_title', $info['banner_title'] ); ?>
                </td>
            </tr>
            <tr>
                <td class="left">Banner Subtitle:</td>
                <td class="right">
					<? field_text( 'banner_subtitle', $info['banner_subtitle'] ); ?>
                </td>
            </tr>
			<tr>
				<td class="left">Video Type:</td>
				<td class="right">
					<select name="video_type" id="video_type">
						<option value="1" <? if($info['video_type'] == "1"){ echo "selected"; } ?>>Native Video</option>
						<option value="0" <? if($info['video_type'] == "0"){ echo "selected"; } ?>>Youtube Video</option>
					</select>
				</td>
			</tr>
			<tr id="native_info">
				<td class="left">Upload Video:</td>
				<td class="right">
                	<? field_file('video_upload', $info['video_upload'], '/videos/' ); ?>
                    <div>Upload your Native Videos here. Recommends keeping videos under <b>100mb</b>.</div>
                </td>
			</tr>
			<tr id="youtube_info">
				<td class="left">YouTube Embed:</td>
				<td class="right">
					<? field_textarea( 'youtube_link', $info['youtube_link'], 'width: 25%;' ); ?>
					<div>Make sure to add <b>full embed</b> of Youtube video, not just the URL</div>
				</td>
			</tr>
			<tr>
				<td class="left">Status:</td>
				<td class="right">
					<select name="status">
						<option value="1" <? if($info['status'] == "1"){ echo "selected"; } ?>>Active / Enabled</option>
						<option value="0" <? if($info['status'] == "0"){ echo "selected"; } ?>>Inactive / Disabled</option>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
	
	&nbsp;
    
	<table class="form">
		<thead>
			<tr>
				<td colspan="2">Video Description</td>
			</tr>
		</thead>
	</table>
	<textarea class="editor" name="description" style="width: 100%; height: 500px;"><? echo $info['description']; ?></textarea>
		
	&nbsp;
	
	<div><input type="submit" name="<? if($_GET['act'] == "edit"){ echo "edit"; } else { echo "add"; } ?>_sub" value="Save <? echo $item_capital; ?>"></div>
  
</form>

<script>
		$( document ).ready(function() {
			var vt = $('#video_type').val();
				if (vt == "1") {
					$('#youtube_info').hide();
					$('#native_info').show();
				} else {
					$('#youtube_info').show();
					$('#native_info').hide();
				}
		});

		jQuery_defer(function() {
			$('#video_type').change(function() {
				var data = $(this).val();
					if (data == "1") {
						$('#youtube_info').hide();
						$('#native_info').show();
					} else {
						$('#youtube_info').show();
						$('#native_info').hide();
					}
			});
		});
</script>