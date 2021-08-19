<?


	global $settings, $page, $request;


	$page_url 	= get_page_url( $page['id'] );
	$package_id = $_GET['identity_package_id'];
	$package 	= mysql_fetch_assoc( mysql_query( "SELECT * FROM `m_identity_packages` WHERE `id` = '".$package_id."' LIMIT 1" ) );
	
	
	if( $package['status'] == '1' ){
		
		
		$colors = false;
		$logos 	= false;
		$fonts 	= false;
		
		
		$rQ = mysql_query( "SELECT * FROM `m_identity_colors` WHERE `package` = '".$package['id']."' ORDER BY `order` ASC" );
		if( mysql_num_rows($rQ) > 0 ){
		
			$colors = array();
			
			while( $r = mysql_fetch_assoc($rQ) ){
				
				$colors[] = array(
					'name' 			=> $r['name'],
					'description' 	=> $r['description'],
					'hex' 			=> $r['color_hex'],
					'rgb' 			=> json_decode( $r['color_rgb'], true ),
					'cmyk' 			=> json_decode( $r['color_cmyk'], true ),
				);
				
			}
		
		}
		
		
		$rQ = mysql_query( "SELECT * FROM `m_identity_logos` WHERE `package` = '".$package['id']."' ORDER BY `order` ASC" );
		if( mysql_num_rows($rQ) > 0 ){
		
			$logos = array();
			
			while( $r = mysql_fetch_assoc($rQ) ){
				
				$thumbnail = false;
				if( $r['thumb'] ){
					$thumbnail = returnURL().'/uploads/identity/logos/'.$r['thumb'];
				}
				
				$jpg = false;
				if( $r['jpg'] ){
					$jpg = returnURL().'/uploads/identity/logos/'.$r['jpg'];
				}
				
				$png = false;
				if( $r['png'] ){
					$png = returnURL().'/uploads/identity/logos/'.$r['png'];
				}
				
				$ai = false;
				if( $r['ai'] ){
					$ai = returnURL().'/uploads/identity/logos/'.$r['ai'];
				}
				
				$psd = false;
				if( $r['psd'] ){
					$psd = returnURL().'/uploads/identity/logos/'.$r['psd'];
				}
				
				$eps = false;
				if( $r['eps'] ){
					$eps = returnURL().'/uploads/identity/logos/'.$r['eps'];
				}
				
				$pdf = false;
				if( $r['pdf'] ){
					$pdf = returnURL().'/uploads/identity/logos/'.$r['pdf'];
				}
				
				$logos[] = array(
					'name' 			=> $r['name'],
					'description' 	=> $r['description'],
					'thumbnail' 	=> $thumbnail,
					'jpg'			=> $jpg,
					'png'			=> $png,
					'ai'			=> $ai,
					'psd'			=> $psd,
					'eps'			=> $eps,
					'pdf'			=> $pdf,
				);
				
			}
		
		}
		
		
		$rQ = mysql_query( "SELECT * FROM `m_identity_fonts` WHERE `package` = '".$package['id']."' ORDER BY `order` ASC" );
		if( mysql_num_rows($rQ) > 0 ){
		
			$fonts = array();
			
			while( $r = mysql_fetch_assoc($rQ) ){
				
				$file = false;
				if( $r['file'] ){
					$file = returnURL().'/uploads/identity/fonts/'.$r['file'];
				}
				
				$link = false;
				if( $r['link'] ){
					$link = $r['link'];
				}
				
				$fonts[] = array(
					'name' 			=> $r['name'],
					'description' 	=> $r['description'],
					'file' 			=> $file,
					'link'			=> $link,
				);
				
			}
		
		}
		
		
		
		echo '<div class="identity_module">';
			require BASE_DIR.'/templates/modules/identity/package.php';
		echo '</div>';
		
		
	}
	

