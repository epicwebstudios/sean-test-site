<?
	
	
	if( $category_id ){
		$stmt = "SELECT * FROM `m_staff` WHERE `category` = '".$category_id."' AND `status` = '1' ORDER BY `order` ASC";
	} else {
		$stmt = "SELECT * FROM `m_staff` WHERE `status` = '1' ORDER BY `order` ASC";
	}
	

	$rQ = mysql_query( $stmt );
	if( mysql_num_rows($rQ) > 0 ){
		
		echo '<div class="staff_module listing" data-id="'.$category_id.'">';
		
			while( $r = mysql_fetch_assoc($rQ) ){
			
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
				
				require BASE_DIR.'/templates/modules/staff/listing.php';
			
			}
		
		echo '</div>';
		
	}


