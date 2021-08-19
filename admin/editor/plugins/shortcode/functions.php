<?
	function generate_js_tags(){
		$query = mysql_query("SELECT `id`, `type`, `tag` FROM `shortcodes` WHERE `status` = 1 ORDER BY `name` ASC");
		while($shortcode = mysql_fetch_array($query)){
			echo "types[".$shortcode['id']."] = new Array();";
			if($shortcode['type'] == "1"){
				echo "types[".$shortcode['id']."]['start'] = '{".$shortcode['tag']."}';";
				echo "types[".$shortcode['id']."]['close'] = '{/".$shortcode['tag']."}';";
				echo "types[".$shortcode['id']."]['dynamic'] = true;";
			} else {
				echo "types[".$shortcode['id']."]['start'] = '{".$shortcode['tag']."}';";
				echo "types[".$shortcode['id']."]['close'] = '';";
				echo "types[".$shortcode['id']."]['dynamic'] = false;";
			}
			echo " ";
		}
	}
	
	function generate_module_options(){
		$query = mysql_query("SELECT `id`, `name` FROM `shortcodes` WHERE `status` = 1 ORDER BY `name` ASC");
		while($shortcode = mysql_fetch_array($query)){
			echo '<option value="'.$shortcode['id'].'">'.htmlentities($shortcode['name']).'</option>';
		}
	}