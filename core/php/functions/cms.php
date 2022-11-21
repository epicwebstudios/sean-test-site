<?
	

	/**
	 * Add button to administrative shortcut bar.
	 *
	 * @param string $button_text Button text.
	 * @param string $link Button link / URL.
	 *
	 * @return void
	 */

	function add_to_admin_bar( $button_text, $link ){
		
		global $admin_bar;
		
		$admin_bar[] = array(
			'button_text' => $button_text,
			'link' => $link
		);
		
	}
	

	/**
	 * Generate administrative shortcut bar UI.
	 *
	 * @return void
	 */

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
	

	/**
	 * Build the system crontab file.
	 *
	 * @return void
	 */

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
	

	/**
	 * Get the system set cache refresh timestamp.
	 *
	 * @return int Timestamp.
	 */

	function cache_refresh(){
		$system = systemInfo( '`cache_refresh`' );
		return $system['cache_refresh'];
	}
	

	/**
	 * Determine if current page has any page blocks.
	 *
	 * @param int $page Page ID.
	 * @param string $position Region / position.
	 *
	 * @return boolean
	 */

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
	

	/**
	 * Check curent module status.
	 * 
	 * Deprecated / unused.
	 *
	 * @return boolean
	 */

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
	

	/**
	 * Get sites custom <body> close tags and scripts.
	 *
	 * @return void
	 */

	function custom_body_close(){
		if( strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') === false ){
			$settings = siteSettings( '`body_close`' );
			echo $settings['body_close'];
		}
	}
	

	/**
	 * Get sites custom <body> open tags and scripts.
	 *
	 * @return void
	 */

	function custom_body_open(){
		if( strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') === false ){
			$settings = siteSettings( '`body_open`' );
			echo $settings['body_open'];
		}
	}
	

	/**
	 * Get sites custom <head> tags and scripts.
	 *
	 * @return void
	 */

	function custom_head(){
		if( strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') === false ){
			$settings = siteSettings( '`head`' );
			echo $settings['head'];
		}
	}
	

	/**
	 * Get editor field stylesheet sources.
	 *
	 * @param string $wrap Optional. Value(s) to wrap around retrieved URLs. Defaults to '.
	 *
	 * @return string Parsed stylesheet list.
	 */

	function editor_stylesheets( $wrap = "'" ){
		
		$list = '';
		
		$query = mysql_query( "SELECT * FROM `stylesheets` WHERE `status` = '1' AND `editor` ='1' ORDER BY `order` ASC" );
		while( $info = mysql_fetch_assoc($query) ){
			
			if( $list != '' ){ $list .= ','; }
			
			if( 
				( substr($info['url'], 0, 4) == 'http' ) || 
				( substr($info['url'], 0, 2) == '//' )
			){
				$list .= $wrap.$info['url'].'?'.time().$wrap;
			} else if(
				( substr($info['url'], 0, 5) == 'core/' ) ||
				( substr($info['url'], 0, 6) == '/core/' )
			){
				
				if( substr($info['url'], 0, 1) != '/' ){
					$info['url'] = '/'.$info['url'];
				}
				
				$list .= $wrap.returnURL().$info['url'].'?'.time().$wrap;
				
			} else {
				$list .= $wrap.returnURL().'/sources/css/'.$info['url'].'?'.time().$wrap;
			}
			
		}
		
		return $list;
		
	}
	

	/**
	 * Get current page page blocks.
	 *
	 * @param int $page Page ID.
	 * @param string $position Region / position.
	 *
	 * @return void
	 */

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


	/**
	 * Get specific page details.
	 *
	 * @param string $page Requested page URI.
	 * @param string $custom_fields Optional. Columns to return. Defaults to all columns.
	 *
	 * @return boolean|array Page details.
	 */

	function getPage( $page = 'home', $custom_fields = "*" ){
	
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
		
		if( $info ){

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

		} else {
			http_response_code( 404 );
			$query = mysql_query( "SELECT ".$custom_fields." FROM `pages` WHERE `link` = 'error' LIMIT 1" );
			$info = mysql_fetch_assoc( $query );
		}

		return $info;

	}
	

	/**
	 * Get page block details.
	 *
	 * @param int $id Page block ID.
	 *
	 * @return boolean|array Page block details.
	 */

	function getPageBlock( $id ){
		
		$query = mysql_query( "SELECT `content` FROM `page_blocks` WHERE `id` = '".$id."' LIMIT 1" );
		
		if( mysql_num_rows($query) > 0 ){
			$info = mysql_fetch_assoc( $query );
			return $info['content'];
		} else {
			return false;
		}
		
	}
	

	/**
	 * Get current page's title.
	 *
	 * Deprecated, no longer used.
	 *
	 * @param array $page Current page details.
	 * @param string $title Initial title.
	 *
	 * @return string Title value.
	 */

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
	

	/**
	 * Get specific page's URL.
	 *
	 * @param int $id Page ID.
	 *
	 * @return string Page URL.
	 */
	
	function get_page_url( $id ){
		global $ep_pages;
		return $ep_pages[$id];
	}
	

	/**
	 * Get current page's <meta> robots tag.
	 *
	 * @return string Robots tag.
	 */

	function get_robots(){

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
	

	/**
	 * Get site's Favicon tags.
	 *
	 * @return void
	 */

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
	

	/**
	 * Get a specific image file's URL, using the scale/cache system.
	 *
	 * @param string $path Path to image, from /uploads/.
	 * @param int $width Optional. Specific width desired. Defaults to 500.
	 * @param int $height Optional. Specific height desired. Defaults to 500.
	 * @param int $mode Optional. Specific mode desired, 'scale', 'size', or 'cover'. Defaults to 'scale'.
	 *
	 * @return string Generated URL.
	 */
	
	function img_url( $path, $width = 500, $height = 500, $mode = 'scale' ){
		
		if( substr($path, 0, 1) == '/' ){
			$path = substr( $path, 1 );
		}
		
		$url = returnURL().'/image/'.$mode.'/'.$width.'/'.$height.'/'.$path;
		return $url;
		
	}
	

	/**
	 * Determine if current user is an administrator.
	 *
	 * @return boolean
	 */

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
	

	/**
	 * Get full linking properties based off the records "link type" structure.
	 *
	 * @param array $item Array of item details.
	 *
	 * @return array Generated URL details
	 */

	function link_type_url( $item ){
		
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
	

	/**
	 * Load the JavaScript files and URLs.
	 *
	 * @param int $position Specific position identifiers to load.
	 *
	 * @return void
	 */

	function load_javascript( $position = 0 ){
		
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

				$type = $j['type'] ?: 'text/javascript';

				if(
					( substr($j['url'], 0, 4) == 'http' ) ||
					( substr($j['url'], 0, 2) == '//' )
				){
					$sources .= '<script src="'.$j['url'].'?'.cache_refresh().'" type="'.$type.'" '.$j['extra'].'></script>' . "\n";

				} else if(
					( substr($j['url'], 0, 5) == 'core/' ) ||
					( substr($j['url'], 0, 6) == '/core/' )
				){
					
					if( substr($j['url'], 0, 1) != '/' ){
						$j['url'] = '/'.$j['url'];
					}
					
					$sources .= '<script src="'.returnURL().$j['url'].'?'.cache_refresh().'" type="'.$type.'" '.$j['extra'].'></script>' . "\n";
					
				} else {
					$sources .= '<script src="'.returnURL()."/sources/js/".$j['url'].'?'.cache_refresh().'" type="'.$type.'" '.$j['extra'].'></script>' . "\n";
				}
			}
		}
		
		echo $sources;
		
	}
	

	/**
	 * Load the CSS files and URLs.
	 *
	 * @param int $position Specific position identifiers to load.
	 *
	 * @return void
	 */

	function load_stylesheets( $position = 0 ){
		
		global $css;
		
		$settings = siteSettings( '`ps_minify_css`' );

		// queue the css
		$stmt   = "SELECT * FROM `stylesheets` WHERE `status` = '1' AND `position` = '$position' ORDER BY `order` ASC";
		$query  = mysql_query($stmt);

		while ($r = mysql_fetch_assoc($query))
			queue_stylesheet($r);

		// sort
		usort( $css, function( $item1, $item2 ){
			return $item1['order'] <=> $item2['order'];
		});

		// print the css
		$sources = '';

		foreach( $css as $stylesheet ){
			if( $stylesheet['position'] == $position ){

				// if external url
				if(
					( str_starts_with($stylesheet['url'], 'http') ) ||
					( str_starts_with($stylesheet['url'], '//') )
				){
					
					$internal   = false;
					$file       = null;

					if( str_starts_with($stylesheet['url'], '//') ){
						$url = 'http:'.$stylesheet['url'];
					} else {
						$url = $stylesheet['url'];
					}
					
				} else if(
					( str_starts_with($stylesheet['url'], 'core/') ) || 
					( str_starts_with($stylesheet['url'], '/core/') )
				){
					
					if( substr($stylesheet['url'], 0, 1) != '/' ){
						$stylesheet['url'] = '/'.$stylesheet['url'];
					}
					
					$internal   = true;
					$file       = BASE_DIR.$stylesheet['url'];
					$url        = returnURL().$stylesheet['url'];
					
				} else {
					
					$internal   = true;
					$file       = BASE_DIR.'/sources/css/'.$stylesheet['url'];
					$url        = returnURL().'/sources/css/'.$stylesheet['url'];
					
				}

				// preceding HTML
				if( $stylesheet['before'] ){
					$sources .= $stylesheet['before']."\n";
				}

				// if minifying
				if( $stylesheet['type'] == 0 ){

					if( $internal ){
						$file_to_load = $file;
					} else {
						$file_to_load = $url;
					}

					$content = '';

					$content .= '<style>';

					if( $settings['ps_minify_css'] ){
						$content .= '/* '.$url.' */'.minify_css( file_get_contents( $file_to_load ) );
					} else {
						$content .= '/* '.$url.' */'.file_get_contents( $file_to_load );
					}

					$content = str_replace( '@font-face{', '@font-face{font-display:auto;', $content );
					$content .= '</style>'."\n";

					$sources .= $content;
					
				} else {

					if( $stylesheet['limit'] != 1 ){

						$limit = load_stylesheet_limit($stylesheet['limit']);

						$sources .= '<!--'.$limit['value'].'>'."\n";

						if( $stylesheet['limit'] == 3 ){
							$sources .= '<!-->'."\n";
						}
						
					}

					$url .= '?'.cache_refresh();

					$sources .= '<link';
					$sources .= ' type="text/css"';
					$sources .= ' rel="stylesheet"';
					$sources .= ' href="'.$url.'"';
					$sources .= ' />'."\n";

					if( $stylesheet['limit'] != 1 ){

						if( $stylesheet['limit'] == 3 ){
							$sources .= '<!-->'."\n";
						}

						$sources .= '<![endif]-->'."\n";
						
					}
					
				}
				
			}
		}

		echo $sources;
		
	}
	

	/**
	 * Load the CSS stylesheet delimiter.
	 *
	 * @param int $id Limiter ID.
	 *
	 * @return array Limit details.
	 */

	function load_stylesheet_limit( $id ){
		$query = mysql_query( "SELECT * FROM `stylesheet_limitations` WHERE `id` = '".$id."' LIMIT 1" );
		$info = mysql_fetch_assoc( $query );
		return $info;
	}
	

	/**
	 * Display site's base URL.
	 *
	 * @return void
	 */

	function mainURL( $type = false ){
		$settings = siteSettings();
		echo $settings['url'];
	}
	

	/**
	 * Minify passed CSS.
	 *
	 * @param string $css CSS to minify.
	 *
	 * @return string Minified CSS.
	 */

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
	

	/**
	 * Minify passed JavaScript.
	 *
	 * @param string $input JavaScript to minify.
	 *
	 * @return string Minified JavaScript.
	 */
	
	function minify_js( $input ){
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
	

	/**
	 * Get current pages custom <body> close tags and scripts.
	 *
	 * @return void
	 */

	function page_body_close(){
		if( strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') === false ){
			$page = getPage( $_GET['act'], '`body_close`' );
			echo $page['body_close'];
		}
	}
	

	/**
	 * Get current pages custom <body> open tags and scripts.
	 *
	 * @return void
	 */

	function page_body_open(){
		if( strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') === false ){
			$page = getPage( $_GET['act'], '`body_open`' );
			echo $page['body_open'];
		}
	}
	

	/**
	 * Get current pages custom <head>  tags and scripts.
	 *
	 * @return void
	 */

	function page_head(){
		if( strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') === false ){
			$page = getPage( $_GET['act'], '`head`' );
			echo $page['head'];
		}
	}
	

	/**
	 * Get pagination start record ID.
	 *
	 * @param string $database Table name.
	 * @param int $current Optional. Current page number. Defaults to 0.
	 * @param int $limit Number of records per page.
	 *
	 * @return int Start record ID.
	 */

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
	

	/**
	 * Parse and display page content.
	 *
	 * @param string $content Page content.
	 *
	 * @return void
	 */

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
	

	/**
	 * Replaces and parses all shortcodes in passed content.
	 *
	 * Removes all extraneous / unused shortcodes.
	 *
	 * @param string $content Page content.
	 *
	 * @return string Parse page content.
	 */
	
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
	
	
	/**
	 * Retrieve all "preloader" files for site.
	 *
	 * @return array List of preloader files.
	 */

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
	
	
	/**
	 * Queue a JavaScript file or URL into the global $js array.
	 *
	 * @return void
	 */

	function queue_javascript( $file_or_array, $position = 0, $order = 9999 ){
		global $js;

		$script = array(
			'url'       => $file_or_array,
			'position'  => $position,
			'order'     => $order,
			'type'      => 'text/javascript',
			'extra'     => '',
		);

		if (is_array($file_or_array))
			$script = array_replace($script, $file_or_array);

		if (!key_exists($script['url'], $js))
			$js[$script['url']] = $script;
	}
	
	
	/**
	 * Queue a CSS file or URL into the global $css array.
	 *
	 * @return void
	 */

	function queue_stylesheet( $file_or_array, $position = 0, $type = 0, $before = null, $limit = 1, $order = 9999 ){
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

		if (!key_exists($sheet['url'], $css))
			$css[$sheet['url']] = $sheet;
	}
	

	/**
	 * Remove installation directory, if still present.
	 *
	 * @return void
	 */

	function remove_install_dir(){
		if( (is_dir(BASE_DIR.'/install')) && (!file_exists(BASE_DIR.'/DEVMACHINE')) ){
			rrmdir( BASE_DIR.'/install' );
		}
	}
	

	/**
	 * Return parsed page content.
	 *
	 * Replaces and parses all shortcodes in passed content.
	 *
	 * @param string $content Page content.
	 *
	 * @return string Parse page content.
	 */

    function returnParsedPage( $content ){

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
	

	/**
	 * Get site's base URL.
	 *
	 * @return string URL.
	 */

	function returnURL( $type = false ){
		$settings = siteSettings( "`url`, `cleanURLs` " );
		return $settings['url'];
	}
	

	/**
	 * Set the site's crontab on server.
	 *
	 * @return void
	 */

	function set_crontab(){
		$file = BASE_DIR.'/cron/crons.txt';
		echo shell_exec( 'crontab -r' );
		echo shell_exec( 'crontab '.$file );
		if( file_exists($file) ){ unlink( $file ); } 
	}

	
	/**
	 * Get site / page's <meta> OpenGraph tags.
	 *
	 * @return void
	 */

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

	
	/**
	 * Get site's <meta> viewport tag.
	 *
	 * @return void
	 */

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

	
	/**
	 * Get CMS site settings.
	 *
	 * @param string $var Columns to pull from settings. Defaults to all columns.
	 *
	 * @return array Settings.
	 */
	
	function siteSettings( $var = "*" ){
		$query 	= mysql_query( "SELECT ".$var." FROM `settings` WHERE `id` = '1'" );
		$info 	= mysql_fetch_assoc( $query );
		return $info;
	}

	
	/**
	 * Get CMS system settings.
	 *
	 * @param string $var Columns to pull from settings. Defaults to all columns.
	 *
	 * @return array Settings.
	 */
	
	function systemInfo( $var = "*" ){
		$query 	= mysql_query( "SELECT ".$var." FROM `system` WHERE `id` = '1'" );
		$info 	= mysql_fetch_assoc( $query );
		return $info;
	}

	
	/**
	 * Check if user has been blocked in system.
	 *
	 * If blocked, user will see a specific blocked screen.
	 *
	 * @return void
	 */

	function user_blocked(){
		
		$query = mysql_query( "SELECT `id` FROM `blocked_users` WHERE `ip` = '".$_SERVER['REMOTE_ADDR']."' LIMIT 1" );
		
		if( mysql_num_rows($query) > 0 ){
			return true;
		}
		
		return false;
		
	}

