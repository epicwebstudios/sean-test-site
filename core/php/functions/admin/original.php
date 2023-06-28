<?
	

	/**
	 * Set browser title, using JavaScript.
	 *
	 * @param string $title Desired browser title.
	 *
	 * @return void
	 */
	
	function browser_title( $string ){
		echo "<script>document.title='".$string." (epicPlatform)';</script>";
	}
	

	/**
	 * Set browser title of administrative module, using JavaScript.
	 *
	 * This function has been deprecated in favor of browser_title().
	 *
	 * @param string $item_capital The capitalized singular name of the module.
	 * @param string $item_plural_capital The capitalized plural name of the module.
	 *
	 * @return void
	 */

	function changeTitle( $item_capital, $item_plural_capital ){
		if(!$_GET['act']){
			echo "<script>document.title='Managing ".$item_plural_capital." (epicPlatform)';</script>";
		} else {
			if($_GET['act'] == "add"){
				echo "<script>document.title='Add New ".$item_capital." (epicPlatform)';</script>";
			} else {
				echo "<script>document.title='Editing ".$item_capital." (epicPlatform)';</script>";
			}
		}
	}
	

	/**
	 * Save a database record's current values as a revision.
	 *
	 * @param int $id Record ID.
	 * @param string $table Database table name.
	 *
	 * @return void
	 */
	
	function create_revision( $id, $table = "pages" ){
		$user 		= $_COOKIE['admin_user'];
		$rev_key 	= md5( time().'-'.$id );
		$info 		= mysql_fetch_assoc( mysql_query("SELECT * FROM `".$table."` WHERE `id` = '".$id."' LIMIT 1") );
		$records 	= json_encode( $info );
		mysql_query( "INSERT INTO `revisions` SET `p_id` = '".$info['id']."', `table` = '".$table."', `records` = '".addslashes($records)."', `admin` = '".$user."', `rev_key` = '".$rev_key."', `date` = '".time()."'" );
	}
	

	/**
	 * Display the administrative page's name.
	 *
	 * @param int $page Page ID.
	 *
	 * @return void
	 */
	
	function displayPageName( $page ){
		
		$page = explode( '?', $page );
		$page = explode( '&', $page[1] );
		$page = str_replace( 'a=', '', $page[0] );
		
		if( $page != 'logout' ){
			$query = mysql_query( "SELECT * FROM `admin_pages` WHERE `id` = '".$page."' LIMIT 1" );
			$info = mysql_fetch_assoc($query);
		} else {
			$info['name'] = 'Logged Out';
		}
		
		echo $info['name'];
		
	}
	

	/**
	 * Display the administrative page's name.
	 *
	 * @param array $list Keys to specifically keep in the URL.
	 * @param array $omit Optional. Any keys to omit from the URL. Defaults to false.
	 * @param boolean $echo Optional. Whether or not to display the URL vs. return. Defaults to false.
	 *
	 * @return void|string Resulting URL.
	 */
	
	function filter_string( $list, $omit = false, $echo = false ) {
		
		$string = '';
		
		$omit_array = explode( ',', $omit );
		if( count($omit_array) > 1 ){
			$omit = $omit_array;
		}
		
		foreach( $list as $filter ){
			if( is_array($omit) ){
				if( ($_GET[$filter] != '') && (!in_array($filter, $omit)) ){
					$string .= '&'.$filter.'='.$_GET[$filter];
				}
			} else {
				if( ($_GET[$filter] != "") && ($filter != $omit) ){
					$string .= '&'.$filter.'='.$_GET[$filter];
				}
			}
		}
		
		if( $echo ){
			echo $string;
		} else {
			return $string;
		}
		
	}
	

	/**
	 * Get specific page block.
	 *
	 * Deprecated due to changes in page handling.
	 *
	 * @param int $block Page block ID.
	 *
	 * @return array Page block details.
	 */
	
	function getBlock( $block ){
		
		$query = mysql_query("SELECT * FROM `page_blocks` WHERE `id` = '".$block."' LIMIT 1");
		if(mysql_num_rows($query) > 0){
			$info = mysql_fetch_assoc($query);
			if($info['status'] == 2){
				$error = true;
			}
		} else {
			$error = true;
		}
		
		if(!$error){
			return $info;
		} else {
			return false;
		}
	
	}

	
	/**
	 * Get specific record's values from database.
	 *
	 * @param int $id Record ID.
	 * @param string $table Table name.
	 *
	 * @return array Record values.
	 */
	
	function get_item( $id, $table ){
		$query = mysql_query("SELECT * FROM `".$table."` WHERE `id` = '".$id."' LIMIT 1");
		$info = mysql_fetch_assoc($query);
		echo "<h2>This is info: ".$info."</h2>";
		return $info;
		
	}

	
	/**
	 * Get and pull in administrative page or module. 
	 *
	 * @param int $id Page ID.
	 *
	 * @return void.
	 */
	
	function get_page( $id = 1 ){
		
		if( $id == '' ){
			$id = 1;
		}
		
		$query = mysql_query( "SELECT * FROM `admin_pages` WHERE `id` = '".$id."' LIMIT 1" );
		
		if( mysql_num_rows($query) > 0 ){
			
			$info = mysql_fetch_assoc( $query );
			
			if( $info['page'] ){
				if( hasPermission($_COOKIE['admin_user'], $info['id']) ){
					if( file_exists(ADMIN_DIR.'/modules/'.$info['page']) ){
						require ADMIN_DIR.'/modules/'.$info['page'];
						return;
					} else {
						redirect( '?a=1&e=missing-files' );
					}
				} else {
					redirect( '?a=1&e=permission' );
				}
			} else {
				redirect( '?a=1&e=not-available' );
			}
			
		} else {
			redirect( '?a=1&e=missing-record' );
		}
		
	}

	
	/**
	 * Generate an accessible URL from a local server path.
	 *
	 * @param string $path Path to convert.
	 * @param string $base_url Optional. Custom base URL to use. Defaults to site URL.
	 *
	 * @return string Generated URL.
	 */

	function get_url_from_path($path, $base_url = false) {
		if (!$base_url)
			$base_url = returnURL();

		$domain             = rtrim($base_url, '/');
		$path_without_base  = str_replace('\\', '/', ltrim(str_replace(BASE_DIR, '', $path), DIRECTORY_SEPARATOR));

		return $domain.'/'.$path_without_base;
	}

	
	/**
	 * Log administrative user's action.
	 *
	 * @param string $action Specific action taken by administrator.
	 *
	 * @return void.
	 */
	
	function log_action( $action ){
		
		$admin 	= $_COOKIE['admin_user'];
		$page 	= $_SERVER['SCRIPT_NAME'];
		
		if( $_GET['a'] ){
			$page = $page.'?a='.$_GET['a'];
		}
		
		if( $_GET['act'] ){
			$page = $page.'&act='.$_GET['act'];
		}
		
		if( $_GET['i'] ){
			$page = $page.'&i='.$_GET['i'];
		}
		
		if( $_GET['p'] ){
			$page = $page.'&p='.$_GET['p'];
		}
		
		mysql_query("INSERT INTO `admin_action_logs` SET `admin` = '".$admin."', `action` = '".$action."', `page` = '".$page."', `date` = '".time()."'");
		
	}

	
	/**
	 * Log administrative user's current backend activity.
	 *
	 * @return void.
	 */
	
	function log_activity(){
		
		$admin 	= $_COOKIE['admin_user'];
		$page 	= $_SERVER['SCRIPT_NAME'];
		
		if( $_GET['a'] ){
			$page = $page.'?a='.$_GET['a'];
		}
		
		if( $_GET['act'] ){
			$page = $page.'&act='.$_GET['act'];
		}
		
		if( $_GET['i'] ){
			$page = $page.'&i='.$_GET['i'];
		}
		
		if( $_GET['p'] ){
			$page = $page.'&p='.$_GET['p'];
		}
		
		mysql_query( "INSERT INTO `admin_activity` SET `admin` = '".$admin."', `page` = '".$page."', `date` = '".time()."'" );
		mysql_query( "UPDATE `administrators` SET `lastActivity` = '".time()."' WHERE `id` = '".$admin."' LIMIT 1" );
		
	}

	
	/**
	 * Log specific message to display to user.
	 *
	 * @param string $text Message text.
	 * @param string $type Optional. Type of message, 'error', 'success', 'warning' or empty.
	 * @param string $title Optional. Title of message.
	 *
	 * @return void.
	 */
	
	function log_message( $text, $type = false, $title = false ){
		global $messages;
		$messages[] = array( 'type' => $type, 'title' => $title, 'text' => $text );
	}

	
	/**
	 * Convert UNIX timestamp to a specific display version.
	 *
	 * Deprecated. Used as a compatibility wrapper function of displayDate();
	 *
	 * @param int $time UNIX timestamp.
	 * @param int $type Output type.
	 *
	 * @return void.
	 */

	function parseDate( $time, $type = 1 ){
		displayDate( $time, $type );
	}
	

	/**
	 * Generate JavaScript handler for converting a name field to an slug/permalink field.
	 *
	 * Deprecated due to new fields handling.
	 *
	 * @param string $origin Origin field ID.
	 * @param string $result Destination field ID.
	 *
	 * @return void.
	 */

	function permalink_convert($origin, $result){
		
		echo '<script type="text/javascript">';
			echo '$(document).ready( function(){';
				echo '$(\'#'.$origin.'\').keyup( function(){';
					echo 'var string = $(this).val().toLowerCase();';
					echo 'string = string.replace(/[^a-zA-Z0-9 ]+/g, \'\');';
					echo 'string = string.replace(/ /g, \'-\');';
					echo '$(\'#'.$result.'\').val(string);';
				echo '});';
			echo '});';
		echo '</script>';
	
	}
	

	/**
	 * Display all specified messages generated by administrative module processing.
	 *
	 * @return void.
	 */
	
	function show_messages(){
		
		global $messages;
		
		if( !empty($messages) ) {
            foreach ($messages as $message) {

                $type = $message['type'];
                $title = strip_all_slashes($message['title']);
                $text = '<div>' . strip_all_slashes($message['text']) . '</div>';

                if ($title) {
                    $title = '<h4>' . $message['title'] . '</h4>';
                }
                if ($type) {
                    $type = 'notify-' . $type;
                }

                echo '<div class="notify ' . $type . '">';
                echo $title;
                echo $text;
                echo '</div>';

            }
        }
	}
	

	/**
	 * Generate robots.txt file, based on current settings.
	 *
	 * @return void.
	 */
	
	function update_robots(){
		
		$settings = siteSettings();
		
		$file = BASE_DIR.'/robots.txt';
		
		$contents = '';
		
		$contents .= 'User-Agent: *' . "\n";
		$contents .= 'Disallow: /admin/';
		
		$query = mysql_query( "SELECT `file_path` FROM `file_manager` WHERE `disallow_index` = '1' " );
		while( $info = mysql_fetch_assoc($query) ){
			$path = $info['file_path'];
			$path = str_replace( BASE_DIR, '', $path );
			$path = str_replace( '//', '/', $path );
			if( is_dir($info['file_path']) ){ $path .= '/'; }
			$contents .= "\n" . 'Disallow: '.$path;
		}
		
		$query = mysql_query( "SELECT * FROM `pages` WHERE `spider` = '1' OR `status` != '1'" );
		while( $info = mysql_fetch_assoc($query) ){
			$contents .= "\n" . 'Disallow: /'.$info['link'];
		}
		
		$sitemap = BASE_DIR.'/sitemap.xml';
		
		if( file_exists($sitemap) ){
			$contents .= "\n" . 'Sitemap: '.returnURL().'/sitemap.xml';
		}
		
		if( $settings['allow_index'] == '0' ){
			$contents  = '';
			$contents .= 'User-Agent: *' . "\n";
			$contents .= 'Disallow: /';

			if ($settings['user_agents']) {

				$contents  .= "\n\n";

				foreach (explode(',', $settings['user_agents']) as $user_agent) {

					if ($user_agent != 'Googlebot')
						$contents .= "User-Agent: $user_agent\n";
				}

				$contents  .= "Disallow: /admin";
			}
		}
		
		file_put_contents( $file, $contents );
		
	}

