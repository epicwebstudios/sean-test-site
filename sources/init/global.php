<?


	// Define Constants
	define( 'CMS_URL', returnURL() );
	$pageInfo = explode( '/', isset($_GET['act']) );
	
	
	// Remove installation files and folder if they still exist post installation.
	if( is_dir(BASE_DIR.'/install') && !file_exists(BASE_DIR.'/DEVMACHINE') ){
		
		$path 	= BASE_DIR.'/install/';
		$files 	= scandir( $path );
		
		foreach( $files as $file ){
			$this_file = $path.$file;
			if(
				( $this_file != '.' ) &&
				( $this_file != '..' ) &&
				( !is_dir($this_file) )
			){
				unlink( $this_file );
			}
		}
		
		rmdir( $path );
		
	}
	
	
	// This function returns the site settings.
	function siteSettings( $var = "*" ){
		$query 	= mysql_query( "SELECT ".$var." FROM `settings` WHERE `id` = '1'" );
		$info 	= mysql_fetch_assoc( $query );
		return $info;
	}
	
	
	// This function returns the system information.
	function systemInfo( $var = "*" ){
		$query 	= mysql_query( "SELECT ".$var." FROM `system` WHERE `id` = '1'" );
		$info 	= mysql_fetch_assoc( $query );
		return $info;
	}
	
	
	// This function gets the system set cache refresh timestamp.
	function cache_refresh(){
		$system = systemInfo( '`cache_refresh`' );
		return $system['cache_refresh'];
	}
	
	
	// This function echoes out the current year to screen.
	function year( $return = false ){
		$year = date( 'Y' );
		if( $return ){ return $year; }
		echo $year;
	}
	
	
	// This function returns the passed string wrapped in DIV tags.
	function line( $string, $element = 'div', $return = false ){
		$output = '<'.$element.'>'.$string.'</'.$element.'>';
		if( $return ){ return $output; }
		echo $output;
	}
	
	
	// This function passes the parameter string through a JavaScript Alert box.
	function alert( $message ){
		echo "<script>alert('".$message."');</script>";
	}
	
	
	// This function redirects the browser to the passed URL
	function redirect( $url ){
		echo "<script>window.location='".$url."';</script>";
	}
	
	
	// This function uses the JavaScript window.location redirection to URL passed as a parameter, delays by parameter.
	function delay( $url, $seconds = 5 ){
		$seconds = ( $seconds * 1000 );
		echo "<script>settimeout('window.location=".$url.";', ".$seconds.")</script>";
	}
	
	
	// This function sets the title of the page of which its called with the title passed.
	function setTitle( $title ){
		echo "<script>document.title='".$title."';</script>";
	}
	
	
	// Echos (displays) the site URL set in the "Site Settings"
	function mainURL( $type = false ){
		
		$settings = siteSettings();
		$url = $settings['url'];
		
		if( $type ){
			if( $settings['cleanURLs'] == 1 ){
				$url = $settings['url'].'/';
			} else {
				$url = $settings['url'].'/?act=';
			}
		}
		
		echo $url;
		
	}
	
	
	// Returns the site URL set in the "Site Settings"
	function returnURL( $type = false ){
		
		$settings = siteSettings( "`url`, `cleanURLs` " );
		$url = $settings['url'];
		
		if( $type ){
			if( $settings['cleanURLs'] == 1 ){
				$url = $settings['url'].'/';
			} else {
				$url = $settings['url'].'/?act=';
			}
		}
		
		return $url;
		
	}
	
	
	// Gets the information for the page called.
	// Note: this has been rewritten on 9/1/2011 to accommodiate incremental checking of page on rollback of a not found.
	function getPage( $page = 'home', $custom_fields = "*"){
	
		if($page == ''){
			$page = 'home';
		}
	
		$pageInfo = explode( '/', $page );
			
		$count = (count($pageInfo))-1;
		
		for( $i=$count; $i>=0; $i-- ){
			if( !$info ){
				
				$link = '';
				
				for( $c=0; $c<=$i; $c++ ){
					$link .= '/'.$pageInfo[$c];
				}
				
				$link = substr( $link, 1 );
				
				$query = mysql_query( "SELECT  ".$custom_fields." FROM `pages` WHERE `link` = '".$link."' LIMIT 1" );
				
				if( mysql_num_rows($query) > 0 ){
					$info = mysql_fetch_assoc( $query );
					if(
						( $info['status'] == 2 ) || 
						( ($info['module'] != 0) && (!checkModule($info['module'])) )
					){
						$info = false;
					}
				} else {
					$info = false;
				}
				
			}
		}
		
		if( $info['canonical'] == '' ){
			$uri = $_GET['act'];
			$uri = str_replace( '"', '', $uri );
			$uri = str_replace( "'", '', $uri );
			$uri = html_entity_decode( $uri );
			$uri = explode( '>', $uri );
			$uri = $uri[0];
			$uri = explode( '<', $uri );
			$uri = $uri[0];
			$uri = strip_tags( $uri );
			$info['canonical'] = returnURL().'/'.$uri;
		}
		
		if( $info ){
			return $info;
		} else {
			http_response_code( 404 );
			$query = mysql_query( "SELECT ".$custom_fields." FROM `pages` WHERE `link` = 'error' LIMIT 1" );
			$info = mysql_fetch_assoc( $query );
			return $info;
		}
	
	}
	
	
	// This function takes the saved content of the page and parses it for output in the browser.
	function parsePage( $content ){
		
  		$content = stripslashes( $content );
		
		$content = str_replace( '"../uploads', '"'.returnURL().'/uploads', $content );
		$content = str_replace( '"../', '"'.returnURL(1), $content );
		
		$content = parseShortcodes( $content );
		
		$content = str_replace( '#?php', '<?', $content );
		$content = str_replace( '#?', '<?', $content );
		$content = str_replace( '?#', '?>', $content );
		
		eval( ' ?>'.$content.'<? ' );
		
	}

	//function returns the parsed html stripped data/string
    function returnParsedPage($content){

        $content = stripslashes($content);

        // Replace relative linking to uploads and pages to work with the main template.
        $content = str_replace("\"../uploads", "\"".returnURL()."/uploads", $content);
        $content = str_replace("\"../", "\"".returnURL(1), $content);

        $content = parseShortcodes($content);

        // Parse PHP content...
        $content = str_replace("#?php", "<?", $content);
        $content = str_replace("#?", "<?", $content);
        $content = str_replace("?#", "?>", $content);
        // Write content to screen.
        ob_start();
        eval(" ?>".$content."<? ");
        $returned_value = ob_get_contents();
        ob_end_clean();
        return strip_tags($returned_value);
    }
	
	
	// This function replaces all shortcode snippets with their replacement content and clears all extraneous unused shortcode snippets.
	function parseShortcodes( $content ){
		
		$query = mysql_query("SELECT `tag`, `type`, `replace`, `b_replace`, `e_replace` FROM `shortcodes` WHERE `status` = '1' ORDER BY `id` ASC");
		while( $code = mysql_fetch_assoc($query) ){
			if( $code['type'] == '1' ){
				$content = str_replace( '{'.$code['tag'].'}', $code['b_replace'], $content );
				$content = str_replace( '{/'.$code['tag'].'}', $code['e_replace'], $content );
			} else {
				$content = str_replace( '{'.$code['tag'].'}', $code['replace'], $content );
			}
		}
		
		preg_match_all( "/\{(.*?)}(.*?)\{\/(.*?)\}/", $content, $output );
		foreach( $output[0] as $instance ){
			$content = str_replace( $instance, '', $content );
		}
		
		preg_match_all("/\{(.*?)\}/", $content, $output);
		foreach( $output[0] as $instance ){
			$content = str_replace( $instance, '', $content );
		}
		
		return $content;
	
	}
	
	
	// Gets the information for the page block called.
	function checkBlocks( $page, $position ){ 
		
		$count = 0;
		$query = mysql_query( "SELECT * FROM `page_template_blocks` WHERE `template` = '".$page."' AND `location` = '".$position."'" );
		if( mysql_num_rows($query) > 0 ){
			
			while( $block = mysql_fetch_assoc($query) ){
				if( getPageBlock($block['block']) ){
					$count++;
				}
			}
			
		}
		
		if( $count > 0 ){
			return true;
		} else {
			return false;
		}
		
	}
	
	
	// This function retreives a specific block by ID and returns it's content
	function getPageBlock( $id ){
		
		$query = mysql_query( "SELECT `content` FROM `page_blocks` WHERE `id` = '".$id."' LIMIT 1" );
		
		if( mysql_num_rows($query) > 0 ){
			$info = mysql_fetch_assoc( $query );
			return $info['content'];
		} else {
			return false;
		}
		
	}
	
	
	// This function retrieves the blocks for the specific page, and displays them in the saved order.
	function getBlocks( $page, $position ){
		
		$query = mysql_query("SELECT * FROM `page_template_blocks` WHERE `template` = '".$page."' AND `location` = '".$position."' ORDER BY `order` ASC");
		
		while( $info = mysql_fetch_array($query) ){
			
			$block = mysql_fetch_assoc( mysql_query( "SELECT `content` FROM `page_blocks` WHERE `id` = '".$info['block']."' LIMIT 1" ) );
			
			if(
				( $block['status'] == 2 ) ||
				( ($block['module'] != 0) && (!checkModule($block['module'])) )
			){
				// Do nothing.
			} else {
				parsePage( $block['content'] );
			}
		}
		
	}
	
	
	// This function takes the passed UNIX timestamp and echos it in a "user-friendly" fashion, depending on the type passed.
	function displayDate( $date, $type = 1 ){
		
		if( $type == 1 ){
			
			$output = date( 'l, F j, Y \\a\\t g:i A', $date );
		
		} else if( $type == 2 ){
		
			$output 	= '';
			$current 	= time();
			$difference = ( $current - $date );
			$days 		= floor( $difference / 86400 );
			$hours 		= floor( ( $difference - ( $days * 86400 ) ) / 3600 );
			$minutes 	= floor( ( $difference - ( ( $days * 86400 ) + ( $hours  *3600 ) ) ) / 60 );
			
			if( $days > 0 ){
				if( $output != '' ){ $output .= ', '; }
				$output .= $days.'d';
			}
			
			if($hours > 0){
				if( $output != '' ){ $output .= ', '; }
				$output .= $hours.'h';
			}
			
			if($minutes > 0){ 
				if( $output != '' ){ $output .= ', '; }
				$output .= $minutes.'m';
			} else {
				if( ($days <= 0) && ($hours <= 0) ){
					$output .= 'A few moments';
				} else {
					if( $output != '' ){ $output .= ', '; }
					$output .= $minutes.'m';
				}
			}
			
			$output .= ' ago. ('.date( 'n/j/Y \\a\\t g:i A', $date ).')';
			
		} else if($type == 3){
			$output = date( 'l, F j, Y', $date );
		} else if($type == 4){
			$output = date( 'F j, Y \\a\\t g:i A', $date );
		} else if($type == 5){
			$output = date( 'n/j/Y \\a\\t g:i A', $date );
		} else if($type == 6){
			$output = date( 'n/j/Y', $date );
		}
		
		echo $output;
		
	}
	
	
	// This function will display pagination controls for the page it is on.
	function pagination( $database, $current = 0, $limit ){
		
		if( $current ){
			$start 			= ( ( $current - 1 ) * $limit );
			$current_page 	= $current;
			$record_start 	= ( ( ( $_GET['p'] - 1 ) * $limit ) + 1 );
		} else {
			$start 			= 0;
			$current_page 	= 1;
			$record_start 	= 1;
		}
			
		$count_query = mysql_query( "SELECT `id` FROM `".$database."`" );
		$item_count = mysql_num_rows( $count_query );
				
		$pages = ceil( $item_count / $limit );
				
		if( $pages <= 0 ){
			$pages = 1;
		}
				
		if( $current_page < $pages ){
			$next_page = ( $current_page + 1 );
		}
				
		if( $current_page > 1 ){
			$prev_page = ( $current_page - 1 );
		}
		
		return $record_start;
				
	}
	
	
	// This function will check the current page, and reset the title based upon which page the user is currently on.
	function getTitle( $page, $title ){
		
		if($page['link'] == "news"){
			$pageInfo = explode("/", $_GET['act']);
			if(($pageInfo[1]) && ($pageInfo[1] != "page")){
				$pQ = mysql_query("SELECT `name` FROM `m_news_entries` WHERE `id` = '".$pageInfo[1]."' OR `permalink` = '".$pageInfo[1]."' LIMIT 1");
				$info = mysql_fetch_array($pQ);
				$title = $info['name'];
			}
		}
		
		return $title;
	}
	
	
	// This function checks to see if the module called is active. If set to inactive, this function will return false;
	function checkModule( $module ){
		
		$query = mysql_query( "SELECT `status` FROM `modules` WHERE `id` = '".$module."' LIMIT 1" );
		if( mysql_num_rows($query) > 0 ){
			
			$info = mysql_fetch_assoc( $query );
			
			if( $info['status'] == 1 ){
				return true;
			}
			
		}
		
		return false;
		
	}
	
	
	// This function will load the value of the stylesheet delimiter passed
	function load_stylesheet_limit( $id ){
		$query = mysql_query( "SELECT * FROM `stylesheet_limitations` WHERE `id` = '".$id."' LIMIT 1" );
		$info = mysql_fetch_assoc( $query );
		return $info;
	}

	// Queues a CSS file/url into the global $css array
	function queue_stylesheet($file_or_array, $prepend = false, $position = 0, $type = 0, $before = null, $limit = 1, $order = 9999) {
		global $css;

		$sheet = array(
			'url'       => $file_or_array,
			'position'  => $position,
			'type'      => $type,
			'before'    => $before,
			'limit'     => $limit,
			'order'     => $order,
		);

		if (is_array($file_or_array))
			$sheet = array_replace($sheet, $file_or_array);

		if (!key_exists($sheet['url'], $css)) {
			if ($prepend)
				$css = array($sheet['url'] => $sheet) + $css;
			else
				$css[$sheet['url']] = $sheet;
		}
	}
	
	
	// This function will load the stylesheets into the main wrapper
	function load_stylesheets($position = 0){
		global $css;
		
		$settings = siteSettings( '`ps_minify_css`' );

		// queue the css
		$stmt   = "SELECT `id`, `url`, `limit`, `type`, `before`, `position` FROM `stylesheets` WHERE `status` = '1' AND `position` = '$position' ORDER BY `order` ASC";
		$query  = mysql_query($stmt);

		while ($r = mysql_fetch_assoc($query))
			queue_stylesheet($r, true);

		// sort
		usort($css, function ($item1, $item2) {
			return $item1['order'] <=> $item2['order'];
		});

		// print the css
		$sources = '';

		foreach ($css as $stylesheet) {

			if ($stylesheet['position'] == $position) {

				// if external url
				if (str_starts_with($stylesheet['url'], 'http') || str_starts_with($stylesheet['url'], '//')) {
					$internal   = false;
					$file       = null;

					if (str_starts_with($stylesheet['url'], '//'))
						$url = 'http:'.$stylesheet['url'];
					else
						$url = $stylesheet['url'];
				} else {
					$internal   = true;
					$file       = BASE_DIR.'/sources/css/'.$stylesheet['url'];
					$url        = returnURL().'/sources/css/'.$stylesheet['url'];
				}

				// preceding HTML
				if ($stylesheet['before'])
					$sources .= $stylesheet['before']."\n";

				// if minifying
				if ($stylesheet['type'] == 0) {

					if ($internal)
						$file_to_load = $file;
					else
						$file_to_load = $url;

					$content = '';

					$content .= '<style>';

					if ($settings['ps_minify_css'])
						$content .= '/* '.$url.' */'.minify_css(file_get_contents($file_to_load));
					else
						$content .= '/* '.$url.' */'.file_get_contents($file_to_load);

					$content = str_replace('@font-face{', '@font-face{font-display:auto;', $content);
					$content .= '</style>'."\n";

					$sources .= $content;
				} else {

					if ($stylesheet['limit'] != 1) {

						$limit = load_stylesheet_limit($stylesheet['limit']);

						$sources .= '<!--'.$limit['value'].'>'."\n";

						if ($stylesheet['limit'] == 3)
							$sources .= '<!-->'."\n";
					}

					$url .= '?'.cache_refresh();

					$sources .= '<link';
					$sources .= ' type="text/css"';
					$sources .= ' rel="stylesheet"';
					$sources .= ' href="'.$url.'"';
					$sources .= ' />'."\n";

					if ($stylesheet['limit'] != 1) {

						if ($stylesheet['limit'] == 3)
							$sources .= '<!-->'."\n";

						$sources .= '<![endif]-->'."\n";
					}
				}
			}
		}

		echo $sources;
	}

	// Queues a JS file/url into the global $js array
	function queue_javascript($file_or_array, $position = 0, $order = 9999) {
		global $js;

		$script = array(
			'url'       => $file_or_array,
			'position'  => $position,
			'order'     => $order,
		);

		if (is_array($file_or_array))
			$script = array_replace($script, $file_or_array);

		if (!key_exists($script['url'], $js))
			$js[$script['url']] = $script;
	}
	
	// This function will load the stylesheets into the main wrapper
	function load_javascript($position = 0){
		global $js;
		
		$settings = siteSettings( '`ps_minify_js`' );

		// queue the js
		$query = mysql_query( "SELECT * FROM `javascript` WHERE `status` = '1' AND `position` = '$position' ORDER BY `order` ASC" );

		while ($r = mysql_fetch_assoc($query))
			queue_javascript($r, true);

		// sort
		usort($js, function ($item1, $item2) {
			return $item1['order'] <=> $item2['order'];
		});

		// print the scripts
		$sources = '';

		foreach ($js as $j) {

			if ($j['position'] == $position) {

				if(
					( substr($j['url'], 0, 4) == 'http' ) ||
					( substr($j['url'], 0, 2) == '//' )
				){
					$sources .= '<script src="'.$j['url'].'?'.cache_refresh().'"></script>' . "\n";
				} else {
					$sources .= '<script src="'.returnURL()."/sources/js/".$j['url'].'?'.cache_refresh().'"></script>' . "\n";
				}
			}
		}
		
		echo $sources;
		
	}
	
	
	function ico_settings(){
		
		$settings = siteSettings( '`favicon`, `theme_color`' );
		
		if( $settings['favicon'] != '' ){
			echo '<link rel="apple-touch-icon" sizes="180x180" href="'.returnURL().'/uploads/ico/apple-touch-icon.png?v='.$settings['favicon'].'">' . "\n";
			echo '<link rel="icon" type="image/png" sizes="16x16" href="'.returnURL().'/uploads/ico/favicon-16x16.png">' . "\n";
			echo '<link rel="icon" type="image/png" sizes="32x32" href="'.returnURL().'/uploads/ico/favicon-32x32.png">' . "\n";
			echo '<link rel="icon" type="image/png" sizes="192x192" href="'.returnURL().'/uploads/ico/android-chrome-192x192.png">' . "\n";
			echo '<link rel="manifest" href="'.returnURL().'/manifest.json?v='.$settings['favicon'].'">' . "\n";
		}
		
		if( $settings['theme_color'] != '' ){
			echo '<meta name="theme-color" content="'.$settings['theme_color'].'">' . "\n";
		}
		
	}
	
	
	// This function will load stylesheets into a comma seperated list for editors
	function editor_stylesheets($wrap = '\''){
		
		$list = '';
		
		$query = mysql_query( "SELECT * FROM `stylesheets` WHERE `status` = '1' AND `editor` ='1' ORDER BY `order` ASC" );
		while( $info = mysql_fetch_assoc($query) ){
			
			if( $list != '' ){ $list .= ','; }
			
			if( 
				( substr($info['url'], 0, 4) == 'http' ) || 
				( substr($info['url'], 0, 2) == '//' )
			){
				$list .= $wrap.$info['url'].'?'.time().$wrap;
			} else {
				$list .= $wrap.returnURL().'/sources/css/'.$info['url'].'?'.time().$wrap;
			}
			
		}
		
		return $list;
		
	}
	
	
	// This function checks to see if the user's IP address has been blocked. If so, it displays the "offline" page with a notification of block.
	function user_blocked(){
		
		$query = mysql_query( "SELECT `id` FROM `blocked_users` WHERE `ip` = '".$_SERVER['REMOTE_ADDR']."' LIMIT 1" );
		
		if( mysql_num_rows($query) > 0 ){
			return true;
		}
		
		return false;
		
	}
	
	
	// This function displays the saved meta viewport tags into the head of the website body
	function set_viewport(){
		
		$settings = siteSettings( "`viewport`" );
		$viewport = json_decode( $settings['viewport'], true );
		
		$tag = '';
		
		if( $viewport['width'] != '' ){
			if( $tag != '' ){ $tag .= ', '; }
			$tag .= 'width='.$viewport['width'];
		}
		
		if( $viewport['height'] != '' ){
			if( $tag != '' ){ $tag .= ', '; }
			$tag .= 'height='.$viewport['height'];
		}
		
		if( $viewport['initial_scale'] != '' ){
			if( $tag != '' ){ $tag .= ', '; }
			$tag .= 'initial-scale='.$viewport['initial_scale'];
		}
		
		if( $viewport['min_scale'] != '' ){
			if( $tag != '' ){ $tag .= ', '; }
			$tag .= 'minimum-scale='.$viewport['min_scale'];
		}
		
		if( $viewport['max_scale'] != '' ){
			if( $tag != '' ){ $tag .= ', '; }
			$tag .= 'maximum-scale='.$viewport['max_scale'];
		}
		
		if( $viewport['scalable'] != '' ){
			if( $tag != '' ){ $tag .= ', '; }
			$tag .= 'user-scalable='.$viewport['scalable'];
		}
		
		echo '<meta name="viewport" content="'.$tag.'" />'; 
		
	}
	
	
	// This function displays the saved OG tags into the head of the website body
	function set_og_tags(){
	    
		global $page;
		
		$settings = siteSettings();
		
		$tags = array(
			'og:title' 			=> $settings['title'],
			'og:description' 	=> $settings['description'],
			'og:image' 			=> '',
			'og:type' 			=> 'website',
			'og:url' 			=> returnURL(),
		);
		
		if( $page['og_title'] ){
			$tags['og:title'] = $page['og_title'];
		} else if( $page['title'] ){
			$tags['og:title'] = $page['title'].' - '.$settings['title'];
		}
		
		if( $page['og_description'] ){
			$tags['og:description'] = $page['og_description'];
		} else if( $page['description'] ){
			$tags['og:description'] = $page['description'];
		}
		
		if( $page['og_image'] ){
			if( (substr($page['og_image'], 0, 4) == 'http') || (substr($page['og_image'], 0, 2) == '//') ){
				$tags['og:image'] = $page['og_image'];
			} else {
				$tags['og:image'] = returnURL().'/uploads/og_images/'.$page['og_image'];
			}
		} else if( $settings['image'] ){
			$tags['og:image'] = returnURL().'/uploads/og_images/'.$settings['image'];
		}
		
		if( $_GET['act'] ){
			$tags['og:url'] .= '/'.$_GET['act'];
		}
		
		$output = '';
		
		foreach( $tags as $key => $value ){
			$value = trim( $value );
			if( $value != '' ){
				$output .= '<meta property="'.$key.'" content="'.$value.'" />' . "\n";
			}
		}
		
		echo $output;
		
	}
	
	
	// This function will var_dump the passed output encased by pre tags for legibility.
	function pre_dump( $output, $element = 'pre' ){
		echo '<'.$element.'>';
			var_dump($output);
		echo '</'.$element.'>';
	}
	
	
	// This function pulls the custom head settings from Site Settings and outputs the parsed result.
	function custom_head(){
		if( strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') === false ){
			$settings = siteSettings( '`head`' );
			echo $settings['head'];
		}
	}
	
	
	// This function pulls the custom opening <body> settings from Site Settings and outputs the parsed result.
	function custom_body_open(){
		if( strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') === false ){
			$settings = siteSettings( '`body_open`' );
			echo $settings['body_open'];
		}
	}
	
	
	// This function pulls the custom closing </body> settings from Site Settings and outputs the parsed result.
	function custom_body_close(){
		if( strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') === false ){
			$settings = siteSettings( '`body_close`' );
			echo $settings['body_close'];
		}
	}
	
	
	// This function pulls the custom head settings from Site Settings and outputs the parsed result.
	function page_head(){
		if( strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') === false ){
			$page = getPage( $_GET['act'], '`head`' );
			echo $page['head'];
		}
	}
	
	
	// This function pulls the custom opening <body> settings from Site Settings and outputs the parsed result.
	function page_body_open(){
		if( strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') === false ){
			$page = getPage( $_GET['act'], '`body_open`' );
			echo $page['body_open'];
		}
	}
	
	
	// This function pulls the custom closing </body> settings from Site Settings and outputs the parsed result.
	function page_body_close(){
		if( strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') === false ){
			$page = getPage( $_GET['act'], '`body_close`' );
			echo $page['body_close'];
		}
	}
	
	
	// This builds the crons.txt file, which can be used to push the new crontab.
	function build_crontab(){
		
		$tab = '';
		$tab .= 'SHELL="/bin/bash"'.PHP_EOL;
		$tab .= 'MAILTO=""'.PHP_EOL;
		
		$query = mysql_query("SELECT * FROM `crons` WHERE `status` = '1' ORDER BY `order` ASC");
		while( $cron = mysql_fetch_assoc($query) ){
			if( $cron['command'] != '' ){
				$tab .= $cron['command'].PHP_EOL;
			}
		}
		
		file_put_contents( BASE_DIR.'/cron/crons.txt', $tab );
		
	}
	
	
	// This pushes crons.txt to overwrite the cron tabs.
	function set_crontab(){
		$file = BASE_DIR.'/cron/crons.txt';
		echo shell_exec( 'crontab -r' );
		echo shell_exec( 'crontab '.$file );
		if( file_exists($file) ){ unlink( $file ); } 
	}
	
	
	// This returns the passed string formatted as a permalink/slug
	function slugify( $string ){
		$slug = iconv( 'UTF-8', 'ASCII//TRANSLIT', $string );
		$slug = trim( $slug );
		$slug = strtolower( $slug );
		$slug = preg_replace( '/[^A-Za-z0-9- ]/', '', $slug );
		$slug = str_replace( ' ', '-', $slug );
		$slug = preg_replace( '/-{2,}/','-', $slug );
		return $slug;
	}
	
	
	// This returns the first element of a permalink/slug, for usage when ID is the first element of a permalink/slug
	function slug_split( $slug ){
		$parts = explode( '-', $slug );
		return $parts;
	}


	$ep_pages = array();
	$rQ = mysql_query( "SELECT `id`, `link` FROM `pages` ORDER BY `id` ASC" );
	while( $r = mysql_fetch_assoc($rQ) ){
		if( $r['link'] == 'home' ){
			$ep_pages[$r['id']] = returnURL();
		} else {
			$ep_pages[$r['id']] = returnURL().'/'.$r['link'];
		}
	}

	global $ep_pages;
	
	
	// This returns the full URL of the passed ID of a page
	function get_page_url( $id ){
		global $ep_pages;
		return $ep_pages[$id];
	}
	
	
	// This requires in the "preloaders" as specified in the database
	function preloaders(){
		
		$files = array();
		
		$query = mysql_query( "SELECT `filename` FROM `preloaders` WHERE `status` = '1' ORDER BY `order` ASC" );
		while( $file = mysql_fetch_assoc($query) ){
			if( file_exists(BASE_DIR.'/'.$file['filename']) ){
				$files[] = BASE_DIR.'/'.$file['filename'];
			}
		}
		
		return $files;
		
	}
	
	
	// This returns an encoded version of the passed e-mail address
	function encode_email( $email ) {
		$output = '';
		for ($i = 0; $i < strlen($email); $i++) { 
			$output .= '&#'.ord($email[$i]).';'; 
		}
		return $output;
	}
	
	
	// This function will return a full linking properties based off the records "link type" structure.
	function link_type_url($item){
		
		$result = array();
		
		$result['link'] = "#";
		$result['onclick'] = "return false;";
		$result['target'] = "";
		
		if($item['link_type'] > 0){
			
			if($item['link_type'] == "1"){
				$result['link'] = $item['url'];
				$result['onclick'] = "";
				$result['target'] = $item['target'];
			} else {
				$type = mysql_fetch_array( mysql_query("SELECT * FROM `m_link_types` WHERE `status` = '1' ORDER BY `id` ASC") );
				$result['link'] = get_page_url($type['page']);
				$ref = mysql_fetch_array( mysql_query("SELECT * FROM `".$type['table']."` WHERE `id` = '".$item['ref_id']."' LIMIT 1") );
				if($ref['permalink']){
					$result['link'] .= "/".$ref['permalink'];
				} else {
					$result['link'] .= "/".$ref['id'];
				}
				$result['onclick'] = "";
				$result['target'] = $item['target'];
			}
			
		}
		
		return $result;
	}
	
	
	// This function will return a full linking properties based off the records "link type" structure.
	function clean_filename($file){
		$file = iconv( 'UTF-8', 'ASCII//TRANSLIT', $file );
		$file = trim( $file );
		$file = strtolower( $file );
		$file = preg_replace( "/[^A-Za-z0-9-._ ]/", '', $file );
		$file = str_replace( ' ', '-', $file );
		$file = preg_replace( '/-{2,}/','-', $file );
		return $file;
	}


	// The function will return an excerpt if it exceeds certain char limit
    function summary( $string, $length ){
        if( strlen($string) > $length ){
            $string = substr( $string, 0, ($length-3) ).'...';
        }
        return $string;
    }
	
	
	function img_url( $path, $width, $height, $mode = 'scale' ){
		
		if( substr($path, 0, 1) == '/' ){
			$path = substr( $path, 1 );
		}
		
		$url = returnURL().'/image/'.$mode.'/'.$width.'/'.$height.'/'.$path;
		return $url;
		
	}


	function format_bytes( $size ){
		$units = array(' B', ' KB', ' MB', ' GB', ' TB');
		for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
		return round($size, 2).$units[$i];
	}
	
	
	function entities( $array, $omit = array() ){
		if( is_array($array) ){
			foreach( $array as $key => $value ){
				if( !in_array($key, $omit) ){
					$array[$key] = htmlentities( $array[$key] );
				}
			}
		} else {
			$array = htmlentities( $array );
		}
		return $array;
	}
	

	function has_slashes( $string ){
		if( strpos($string, '\\') !== false ){
			return true;
		} else {
			return false;
		}
	}
	
	
	function strip_all_slashes( $string ){
		while( strpos($string, '\\') !== false ){
			$string = stripslashes( $string );
		}
		return $string;
	}
	

	function strip_and_slash( $string ){
		$string = strip_all_slashes( $string );
		$string = addslashes( $string );
		return $string;
	}
	
	
	function query_build_set( $array ){
		if( is_array($array) ){
			
			$set = "";
			
			foreach( $array as $column => $value ){
				
				if( is_array($value) ){
					$value = json_encode( $value );
				} else {
					$value = replace_smartquotes( $value );
				}
				
				if( $set != '' ){ $set .= ", "; }
				$set .= "`".$column."` = '".strip_and_slash($value)."'";
				
			}
			
			if( $set != '' ){
				return "SET ".$set;
			} else {
				return false;
			}
			
		} else {
			return false;
		}
	}


	function kv_array( $table, $key_column, $value_column, $where = false ){
		
		if( $where ){
			if( substr($where, 0, 5) != 'WHERE' ){
				$where = "WHERE ".$where;
			}
		} else {
			$where = '';
		}
		
		$output = array();
		
		$query = mysql_query( "SELECT `".$key_column."`, `".$value_column."` FROM `".$table."` ".$where." ORDER BY `".$value_column."` ASC" );
		while( $record = mysql_fetch_array($query) ){
			$output[$record[$key_column]] = $record[$value_column];
		}
		
		return $output;
			
	}
	
	
	function replace_smartquotes( $string ){
	
		$chr_map = array(
			"\xC2\x82" 		=> "'",
			"\xC2\x8B" 		=> "'",
			"\xC2\x91" 		=> "'",
			"\xC2\x92" 		=> "'",
			"\xC2\x9B" 		=> "'",
			"\xE2\x80\x98" 	=> "'",
			"\xE2\x80\x99" 	=> "'",
			"\xE2\x80\x9A" 	=> "'",
			"\xE2\x80\x9B" 	=> "'",
			"\xE2\x80\xB9" 	=> "'", 
			"\xE2\x80\xBA"	=> "'",
			"\xC2\x84" 		=> '"',
			"\xC2\x93" 		=> '"',
			"\xC2\x94" 		=> '"',
			"\xE2\x80\x9C" 	=> '"',
			"\xE2\x80\x9D" 	=> '"',
			"\xE2\x80\x9E" 	=> '"',
			"\xE2\x80\x9F" 	=> '"',
		);
		
		$chr = array_keys( $chr_map );
		$rpl = array_values( $chr_map );
		$string = str_replace( $chr, $rpl, html_entity_decode($string, ENT_QUOTES, "UTF-8") );
		
		return $string;
	
	}


	function minify_css( $css ){
		
		$css = str_replace( "\n", '', $css );
		$css = str_replace( "\r", '', $css );
		$css = str_replace( "\t", '', $css );
	
		preg_match_all( "/\/\*(.*?)\*\//", $css, $output );
		foreach( $output[0] as $instance ){
			$css = str_replace( $instance, '', $css );
		}
	
		$css = str_replace( '  ', ' ', $css );
		$css = str_replace( ': ', ':', $css );
		$css = str_replace( '; ', ';', $css );
		$css = str_replace( '{ ', '{', $css );
		$css = str_replace( ' {', '{', $css );
		$css = str_replace( '} ', '}', $css );
		$css = str_replace( ' }', '}', $css );
		
		return $css;
		
	}
	
	
	function _minify_js($input) {
		return preg_replace(
			array(
				// Remove inline comment(s) [^1]
				'#\s*\/\/.*$#m',
				// Remove white-space(s) around punctuation(s) [^2]
				'#\s*([!%&*\(\)\-=+\[\]\{\}|;:,.<>?\/])\s*#',
				// Remove the last semi-colon and comma [^3]
				'#[;,]([\]\}])#',
				// Replace `true` with `!0` and `false` with `!1` [^4]
				'#\btrue\b#', '#false\b#', '#return\s+#'
			),
			array(
				// [^1]
				"",
				// [^2]
				'$1',
				// [^3]
				'$1',
				// [^4]
				'!0', '!1', 'return '
			),
		$input);
	}
	
	
	function minify_js($input) {
		if( ! $input = trim($input)) return $input;
		// Create chunk(s) of string(s), comment(s), regex(es) and 
		global $SS, $CC;
		$input = preg_split('#(' . $SS . '|' . $CC . '|\/[^\n]+?\/(?=[.,;]|[gimuy]|$))#', $input, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
		$output = "";
		foreach($input as $v) {
			if(trim($v) === "") continue;
			if(
				($v[0] === '"' && substr($v, -1) === '"') ||
				($v[0] === "'" && substr($v, -1) === "'") ||
				($v[0] === '/' && substr($v, -1) === '/')
			) {
				// Remove if not detected as important comment ...
				if(substr($v, 0, 2) === '//' || (substr($v, 0, 2) === '/*' && substr($v, 0, 3) !== '/*!' && substr($v, 0, 8) !== '/*@cc_on')) continue;
				$output .= $v; // String, comment or regex ...
			} else {
				$output .= _minify_js($v);
			}
		}
		return preg_replace(
			array(
				// Minify object attribute(s) except JSON attribute(s). From `{'foo':'bar'}` to `{foo:'bar'}` [^1]
				'#(' . $CC . ')|([\{,])([\'])(\d+|[a-z_]\w*)\3(?=:)#i',
				// From `foo['bar']` to `foo.bar` [^2]
				'#([\w\)\]])\[([\'"])([a-z_]\w*)\2\]#i'
			),
			array(
				// [^1]
				'$1$2$4',
				// [^2]
				'$1.$3'
			),
		$output);
	}
	
	
	function pluralize( $count, $singular, $plural = false ){
		
		if( !$plural ){
			$plural = $singular.'s';
		}
		
		if( $count == 1 ){
			return $count.' '.$plural;
		} else {
			return $count.' '.$singular;
		}
		
	}
	
	
	function valid_email( $email ){
		return filter_var( $email, FILTER_VALIDATE_EMAIL );
	}

    // checks to see if value in array contains a string
    function array_str_contains($array, $search) {
		foreach ($array as $item) {
			if (str_contains($search, $item))
				return true;
		}

		return false;
    }

	// PHP 7 compatibility

	if (!function_exists('array_key_first')) {
		function array_key_first(array $array) {
			foreach($array as $key => $unused)
				return $key;

			return NULL;
		}
	}

	if (!function_exists('array_key_last')) {
		function array_key_last(array $array) {
			if (!is_array($array) || empty($array))
				return null;

			return array_keys($array)[count($array) - 1];
		}
	}

	// PHP 8 compatibility

	if (!function_exists('str_starts_with')) {
		function str_starts_with($haystack, $needle) {
			return strncmp($haystack, $needle, strlen($needle)) === 0;
		}
	}

	if (!function_exists('str_ends_with')) {
		function str_ends_with($haystack, $needle) {
			return $needle === '' || $needle === substr($haystack, -strlen($needle));
		}
	}

	if (!function_exists('str_contains')) {
		function str_contains($haystack, $needle) {
			return $needle !== '' && mb_strpos($haystack, $needle) !== false;
		}
	}


	function is_admin(){
		
		$user = $_COOKIE['admin_user'];
		$pass = $_COOKIE['admin_pass'];
		
		if( !$user || !$pass ){
			return false;
		}
		
		$check = mysql_num_rows( mysql_query( "SELECT `id` FROM `administrators` WHERE `id` = '".$user."' AND `password` = '".$pass."' LIMIT 1" ) );
		
		if( $check <= 0 ){
			return false;
		}
		
		return true;
		
	}


	function admin_bar(){
		
		global $admin_bar;
		
		if( !is_admin() ){ echo ''; return; }

		$admin_bar_status   = !isset($_COOKIE['admin_bar']) || filter_var($_COOKIE['admin_bar'], FILTER_VALIDATE_BOOLEAN);
		$admin_bar_class    = !$admin_bar_status ? 'closed' : '';

		$output = '';

		$output .= '<div id="admin_bar" class="admin-bar admin-bar-v2 '.$admin_bar_class.'">';

			$output .= '<div class="admin-bar-left">';
		
				$output .= '<a href="/admin/" target="_blank" title="Go to Administrative Control Panel" class="logo">';
					$output .= '<img src="/admin/images/ep-icon.png">';
				$output .= '</a>';

				$output .= '<div class="admin-bar-items">';

					foreach( $admin_bar as $btn ){
						$output .= '<a href="'.$btn['link'].'" target="_blank" class="button admin-bar-item">';
							$output .= $btn['button_text'];
						$output .= '</a>';
					}

				$output .= '</div>';

			$output .= '</div>';

			$output .= '<div class="admin-bar-right">';

				$output .= '<div class="admin-bar-show-hide">';
					$output .= '<div class="admin-bar-icon admin-bar-icon-close" title="Hide Admin Bar">&times;</div>';
					$output .= '<div class="admin-bar-icon admin-bar-icon-open" title="Show Admin Bar">&#9656;</div>';
				$output .= '</div>';

			$output .= '</div>';

		$output .= '</div>';

		$output .= '
			<script>
				jQuery_defer(function() {
				    $(".admin-bar-show-hide").on("click", function() {
				        const $admin_bar = $(".admin-bar .admin-bar-items").parents(".admin-bar");
				        
				        if ($admin_bar.hasClass("closed")) {
				            $admin_bar.removeClass("closed");
				            document.cookie = "admin_bar=1";
				        } else {
				            $admin_bar.addClass("closed");
				            document.cookie = "admin_bar=0";
				        }
				    });
				});
			</script>';
		
		echo $output;
		
	}


	function add_to_admin_bar( $button_text, $link ){
		
		global $admin_bar;
		
		$admin_bar[] = array(
			'button_text' => $button_text,
			'link' => $link
		);
		
	}

	function get_robots() {

		global $settings, $page;

		if( $settings['allow_index'] == '0' && !array_str_contains(explode(',', $settings['user_agents']), $_SERVER['HTTP_USER_AGENT']) ){
			$robots = 'noindex';
			http_response_code( 404 );
		} else {
			if( ($page['status'] == '2') || ($page['status'] == '3') ){
				$robots = 'noindex,nofollow';
			} else {
				$robots = 'index,follow';
			}
		}

		return $robots;
	}
	

	$admin_bar	= array();
	$settings 	= siteSettings();
	$system 	= systemInfo();
	$js         = array();
	$css        = array();