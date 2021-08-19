<?
	
	
	// Possible removal.
	function parseDate( $time, $type = 1 ){
		displayDate( $time, $type );
	}
	
	
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
	
	
	function get_item( $id, $table ){
		$query = mysql_query("SELECT * FROM `".$table."` WHERE `id` = '".$id."' LIMIT 1");
		$info = mysql_fetch_assoc($query);
		return $info;
	}
	
	
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
	
	
	// Possible removal.
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
	
	
	function browser_title( $string ){
		echo "<script>document.title='".$string." (epicPlatform)';</script>";
	}
	
	
	// Possible removal.
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
		}
		
		file_put_contents( $file, $contents );
		
	}
	
	
	function create_revision( $id, $table = "pages" ){
		$user 		= $_COOKIE['admin_user'];
		$rev_key 	= md5( time().'-'.$id );
		$info 		= mysql_fetch_assoc( mysql_query("SELECT * FROM `".$table."` WHERE `id` = '".$id."' LIMIT 1") );
		$records 	= json_encode( $info );
		mysql_query( "INSERT INTO `revisions` SET `p_id` = '".$info['id']."', `table` = '".$table."', `records` = '".addslashes($records)."', `admin` = '".$user."', `rev_key` = '".$rev_key."', `date` = '".time()."'" );
	}
	
	
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
	
	
	// Possible removal.
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
	
	
	function log_message( $text, $type = false, $title = false ){
		global $messages;
		$messages[] = array( 'type' => $type, 'title' => $title, 'text' => $text );
	}
	
	
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

	function get_url_from_path($path, $base_url = false) {
		if (!$base_url)
			$base_url = returnURL();

		$domain             = rtrim($base_url, '/');
		$path_without_base  = str_replace('\\', '/', ltrim(str_replace(BASE_DIR, '', $path), DIRECTORY_SEPARATOR));

		return $domain.'/'.$path_without_base;
	}
	
	
	// Rather than continuing to add to this file, start moving to individualized files.
	
	
	require dirname( __FILE__ ).'/functions/account.php';
	require dirname( __FILE__ ).'/functions/menu.php';
	require dirname( __FILE__ ).'/functions/reorder.php';
	require dirname( __FILE__ ).'/functions/helpers.php';
	require dirname( __FILE__ ).'/functions/colors.php';
	require dirname( __FILE__ ).'/functions/ico.php';
	require dirname( __FILE__ ).'/functions/fields.php';
	require dirname( __FILE__ ).'/functions/ajax.php';
	require dirname( __FILE__ ).'/functions/module.php';
	require dirname( __FILE__ ).'/functions/export.php';
	
	
