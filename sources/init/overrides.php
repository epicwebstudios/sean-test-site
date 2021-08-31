<?


	// This file can be used to conditionally override $page attributes prior to using them.
	// By default, the system tries to scan the page to automatically take over certain pages if shortcodes are detected.
	// Optionally, you can use a $page['id'] == XXX conditional to implicitly take over a certain page.
	
	
	// Staff Module
	
		$shortcode = 'staff-module';
		if( strpos($page['content'], '{'.$shortcode.'}') !== false ){
			if( $request[1] != '' ){
				
				preg_match_all( "/\{".$shortcode."}(.*?)\{\/".$shortcode."\}/", $page['content'], $snippets );
				$snippet_id = $snippets[1][0];
				
				$record = mysql_fetch_assoc( mysql_query( "SELECT `id`, `first`, `middle`, `last`, `bio`, `photo` FROM `m_staff` WHERE `permalink` = '".$request[1]."' LIMIT 1" ) );
				
				add_to_admin_bar( 'Edit Staff Member', '/admin/?a=48&act=edit&i='.$record['id'] );
				
				$page['title'] 			= $record['first'].' '.$record['middle'].' '.$record['last'];
				$page['description'] 	= summary( strip_tags($record['bio']), 158 );
				$page['content'] 		= '<div class="section"><div class="wrapper">{'.$shortcode.'}'.$snippet_id.'{/'.$shortcode.'}</div></div>';
				
				$page['og_title']		= $record['first'].' '.$record['middle'].' '.$record['last'];
				$page['og_description'] = strip_tags( $record['bio'] );
				
				if( $record['photo'] ){
					$page['og_image']	= returnURL().'/uploads/staff/'.$record['photo'];
				}

				if ($page['banner']) {
					$page['banner_button']      = false;
					$page['banner_title']       = $record['first'].($record['middle']?' '.$record['middle']:'').' '.$record['last'];
					$page['banner_title_h1']    = true;

					// banner photo
					if ($record['photo'])
						$page['banner_image_custom'] = '/staff/'.$record['photo'];
				}
				
			}
		}
	
	
	// News Module
	
		$shortcode = 'news-module';
		if( strpos($page['content'], '{'.$shortcode.'}') !== false ){
			if( $request[1] != '' ){
				
				preg_match_all( "/\{".$shortcode."}(.*?)\{\/".$shortcode."\}/", $page['content'], $snippets );
				$snippet_id = $snippets[1][0];
				
				$page['content'] 			= '<div class="section"><div class="wrapper">{'.$shortcode.'}'.$snippet_id.'{/'.$shortcode.'}</div></div>';
				
				if( $request[1] == 'page' ){
					$page['title'] 			= $page['title'].' - Page '.$request[2];
				} else {
					
					$record = mysql_fetch_assoc( mysql_query("SELECT `id`, `name`, `summary`, `og_title`, `og_description`, `og_image` FROM `m_news_entries` WHERE `permalink` = '".$request[1]."' LIMIT 1") );
									
					add_to_admin_bar( 'Edit News Entry', '/admin/?a=35&act=edit&i='.$record['id'] );
					
					$page['title'] 			= $record['name'];
					$page['description'] 	= summary( strip_tags($record['summary']), 158 );
					
					if( $record['og_title'] != '' ){
						$page['og_title']		= $record['og_title'];
					}
					
					if( $record['og_description'] != '' ){
						$page['og_description']	= $record['og_description'];
					}
					
					if( $record['og_image'] != '' ){
						$page['og_image']		= $record['og_image'];
					}
					
					if( $record['canonical'] != '' ){
						$page['canonical']		= $record['canonical'];
					}

					if ($page['banner']) {
						$page['banner_button']      = false;
						$page['banner_title']       = $record['name'];
						$page['banner_title_h1']    = true;

						// banner photo
						$stmt = "SELECT `filename` FROM `m_news_photos` WHERE `entry` = '".$record['id']."' ORDER BY `order` LIMIT 1";
						$query = mysql_query($stmt);
						$photos = mysql_fetch_assoc($query);

						if ($photos['filename'])
							$page['banner_image_custom'] = '/news/'.$photos['filename'];
					}
					
				}
				
			}
		}
	
	
	// Gallery Module
			
		$shortcode = 'gallery-module-category';
		if( strpos($page['content'], '{'.$shortcode.'}') !== false ){
			if( $request[1] != '' ){
				
				preg_match_all( "/\{".$shortcode."}(.*?)\{\/".$shortcode."\}/", $page['content'], $snippets );
				$snippet_id = $snippets[1][0];
				
				
				if( $request[1] ){
				
					$page['content'] 			= '<div class="section"><div class="wrapper">{'.$shortcode.'}'.$snippet_id.'{/'.$shortcode.'}</div></div>';
						
					$record 	= mysql_fetch_assoc( mysql_query("SELECT `id`, `name`, `description` FROM `m_photo_galleries` WHERE `permalink` = '".$request[1]."' LIMIT 1") );
					$default 	= mysql_fetch_assoc( mysql_query("SELECT `filename` FROM `m_photo_photos` WHERE `gallery` = '".$record['id']."' ORDER BY `order` ASC LIMIT 1") );
									
					add_to_admin_bar( 'Edit Gallery', '/admin/?a=37&act=edit&i='.$record['id'] );
					
					$page['title'] 			= $record['name'];
					$page['description'] 	= summary( strip_tags( $record['description'] ), 158 );
					$page['og_title']		= $page['title'];
					$page['og_description']	= $page['description'];
					$page['og_image']		= returnURL().'/uploads/gallery/'.$default['filename'];

					if ($page['banner']) {
						$page['banner_button']      = false;
						$page['banner_title']       = $record['name'];
						$page['banner_title_h1']    = true;

						// banner photo
						if ($default['filename'])
							$page['banner_image_custom'] = '/gallery/'.$default['filename'];
					}
				}
				
			}
		}
	
	
