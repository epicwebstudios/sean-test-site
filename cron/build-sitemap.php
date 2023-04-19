<?


	$path = explode( '/cron', dirname(__FILE__) );
	define( 'CORE_DIR', $path[0].'/core' );
	
	require_once CORE_DIR.'/core.php';
	
	line("Sitemap Builder Cron");
	line("&nbsp;");
	line("Starting XML file build...");

	$content  = '';
	$content .= '<?xml version="1.0" encoding="utf-8"?>' . "\n";
	$content .= '<urlset';
		$content .= ' xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"';
		$content .= ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"';
		$content .= ' xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"';
	$content .= '>' . "\n";
	
		line("- Pulling in pages...");

		$rQ = mysql_query( "SELECT `link`, `modified`, `content` FROM `pages` WHERE `status` = '1' ORDER BY `link` ASC" );
		while( $r = mysql_fetch_assoc($rQ) ){
		
			$location	= returnURL().'/'.$r['link'];
			$page_url	= $location;
			$frequency 	= 'always';
			$priority	= '0.8';
			$modified	= date( 'c' );
			
			if( $r['link'] == 'home' ){
				$location = returnURL();
			}
			
			$content .= "\t" . '<url>' . "\n";
				$content .= "\t" . "\t" . '<loc>'.$location.'</loc>' . "\n";
				$content .= "\t" . "\t" . '<lastmod>'.$modified.'</lastmod>' . "\n";
				$content .= "\t" . "\t" . '<changefreq>'.$frequency.'</changefreq>' . "\n";
				$content .= "\t" . "\t" . '<priority>'.$priority.'</priority>' . "\n";
			$content .= "\t" . '</url>' . "\n";
			
			$shortcode = 'news-module';
			if( strpos($r['content'], '{'.$shortcode.'}') !== false ){
				
				preg_match_all( "/\{".$shortcode."}(.*?)\{\/".$shortcode."\}/", $r['content'], $snippets );
				$snippet_id = $snippets[1][0];
				
				$sQ = mysql_query( "SELECT `permalink` FROM `m_news_entries` WHERE `category` = '".$snippet_id."' AND `status` = '1' ORDER BY `date` ASC" );
				while( $s = mysql_fetch_assoc($sQ) ){
					
					$location 	= $page_url.'/'.$s['permalink'];
					$frequency 	= 'always';
					$priority	= '0.8';
					$modified	= date( 'c' );
			
					$content .= "\t" . '<url>' . "\n";
						$content .= "\t" . "\t" . '<loc>'.$location.'</loc>' . "\n";
						$content .= "\t" . "\t" . '<lastmod>'.$modified.'</lastmod>' . "\n";
						$content .= "\t" . "\t" . '<changefreq>'.$frequency.'</changefreq>' . "\n";
						$content .= "\t" . "\t" . '<priority>'.$priority.'</priority>' . "\n";
					$content .= "\t" . '</url>' . "\n";
					
				}
				
			}
			
			
			$shortcode = 'staff-module';
			if( strpos($r['content'], '{'.$shortcode.'}') !== false ){
				
				preg_match_all( "/\{".$shortcode."}(.*?)\{\/".$shortcode."\}/", $r['content'], $snippets );
				$snippet_id = $snippets[1][0];
				
				$sQ = mysql_query( "SELECT `permalink` FROM `m_staff` WHERE `category` = '".$snippet_id."' AND `status` = '1' ORDER BY `last` ASC" );
				while( $s = mysql_fetch_assoc($sQ) ){
					
					$location 	= $page_url.'/'.$s['permalink'];
					$frequency 	= 'always';
					$priority	= '0.8';
					$modified	= date( 'c' );
			
					$content .= "\t" . '<url>' . "\n";
						$content .= "\t" . "\t" . '<loc>'.$location.'</loc>' . "\n";
						$content .= "\t" . "\t" . '<lastmod>'.$modified.'</lastmod>' . "\n";
						$content .= "\t" . "\t" . '<changefreq>'.$frequency.'</changefreq>' . "\n";
						$content .= "\t" . "\t" . '<priority>'.$priority.'</priority>' . "\n";
					$content .= "\t" . '</url>' . "\n";
					
				}
				
			}
			
			
			$shortcode = 'gallery-module-category';
			if( strpos($r['content'], '{'.$shortcode.'}') !== false ){
				
				preg_match_all( "/\{".$shortcode."}(.*?)\{\/".$shortcode."\}/", $r['content'], $snippets );
				$snippet_id = $snippets[1][0];
				
				$sQ = mysql_query( "SELECT `permalink` FROM `m_photo_galleries` WHERE `category` = '".$snippet_id."' AND `status` = '1' ORDER BY `order` ASC" );
				while( $s = mysql_fetch_assoc($sQ) ){
					
					$location 	= $page_url.'/'.$s['permalink'];
					$frequency 	= 'always';
					$priority	= '0.8';
					$modified	= date( 'c' );
			
					$content .= "\t" . '<url>' . "\n";
						$content .= "\t" . "\t" . '<loc>'.$location.'</loc>' . "\n";
						$content .= "\t" . "\t" . '<lastmod>'.$modified.'</lastmod>' . "\n";
						$content .= "\t" . "\t" . '<changefreq>'.$frequency.'</changefreq>' . "\n";
						$content .= "\t" . "\t" . '<priority>'.$priority.'</priority>' . "\n";
					$content .= "\t" . '</url>' . "\n";
					
				}
				
			}

			$shortcode = 'video-categories';
			if( strpos($r['content'], '{'.$shortcode.'}') !== false ){
				
				preg_match_all( "/\{".$shortcode."}(.*?)\{\/".$shortcode."\}/", $r['content'], $snippets );
				$snippet_id = $snippets[1][0];
				
				$sQ = mysql_query( "SELECT `permalink` FROM `m_videos` WHERE `status` = '1'" );
				while( $s = mysql_fetch_assoc($sQ) ){
					
					$location 	= $page_url.'/'.$s['permalink'];
					$frequency 	= 'always';
					$priority	= '0.8';
					$modified	= date( 'c' );
			
					$content .= "\t" . '<url>' . "\n";
						$content .= "\t" . "\t" . '<loc>'.$location.'</loc>' . "\n";
						$content .= "\t" . "\t" . '<lastmod>'.$modified.'</lastmod>' . "\n";
						$content .= "\t" . "\t" . '<changefreq>'.$frequency.'</changefreq>' . "\n";
						$content .= "\t" . "\t" . '<priority>'.$priority.'</priority>' . "\n";
					$content .= "\t" . '</url>' . "\n";
					
				}
				
			}
			
		
		}

	line("- ".$count." page(s) pulled in!");
	line("&nbsp;");
	
	
	$content .= '</urlset>';

	line("Finished XML file build.");
	line("&nbsp;");
	line("Pushed content to XML file.");
	line("&nbsp;");
	line("Sitemap file built successfully!");
	
	file_put_contents( BASE_DIR.'/sitemap.xml', $content );


