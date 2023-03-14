<?
	
	
	$stmt = "SELECT * FROM `m_staff` WHERE `category` = '".$category_id."' AND `permalink` = '".$request[1]."' AND `status` = '1' ORDER BY `order` DESC LIMIT 1";
	

	$rQ = mysql_query( $stmt );
	if( mysql_num_rows($rQ) > 0 ){
		
		$category = mysql_fetch_assoc( mysql_query( "SELECT `name` FROM `m_staff_categories` WHERE `id` = '".$category_id."' LIMIT 1" ) );
		$category = $category['name'];
		
		$r = mysql_fetch_assoc( $rQ );

		$id				= $r['id'];
		$first_name		= $r['first'];
		$middle_name	= $r['middle'];
		$last_name		= $r['last'];
		$full_name		= $first_name.' '.$middle_name.' '.$last_name;
		$position		= false;
		$department		= false;
		$email			= false;
		$phone			= false;
		$fax			= false;
		$bio			= false;
		$social			= json_decode( $r['social'], true );
		$photo			= false;
		$permalink		= $page_url.'/'.$r['permalink'];

		echo '<div class="staff_module profile" data-category-id="'.$category_id.'">';
			
			if( $r['position'] ){
				$position = $r['position'];
			}
			
			if( $r['department'] ){
				$department = $r['department'];
			}
			
			if( $r['email'] ){
				$email = $r['email'];
			}
			
			if( $r['phone'] ){
				$phone = $r['phone'];
			}
			
			if( $r['fax'] ){
				$fax = $r['fax'];
			}
			
			if( $r['bio'] ){
				$bio = $r['bio'];
			}
			
			if( $r['facebook'] ){
				$facebook = $r['facebook'];
			}
			
			if( $r['twitter'] ){
				$twitter = $r['twitter'];
			}
			
			if( $r['linkedin'] ){
				$linkedin = $r['linkedin'];
			}
			
			if( $r['photo'] ){
				$photo = 'staff/'.$r['photo'];
			}
			
			require BASE_DIR.'/templates/modules/staff/profile.php';
		
		echo '</div>';
		
	} else {
	
		redirect( $page_url );
		die();
	
	}