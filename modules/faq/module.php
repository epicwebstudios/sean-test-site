<?


	global $settings, $page, $request;
	
	
	$page_url 		= get_page_url( $page['id'] );
	$category_id	= $_GET['faq_category_id'];
	$category		= mysql_fetch_assoc( mysql_query( "SELECT * FROM `m_faq_categories` WHERE `id` = '".$category_id."' LIMIT 1" ) );
	
	
	if( $category['status'] == '1' ){
		$rQ = mysql_query( "SELECT * FROM `m_faqs` WHERE `category` = '".$category['id']."' AND `status` = '1' ORDER BY `order` ASC" );
		if( mysql_num_rows($rQ) > 0 ){
	
			require_once BASE_DIR.'/templates/modules/faq/functions.js.php';
			
			echo '<div class="faq_module">';

			// start FAQ schema
			$schema = array(
				'@type'         => 'FAQPage',
				'@context'      => 'http://schema.org',
				'url'           => get_page_url($page['id']),
				'mainEntity'    => array(),
			);
			
			while( $r = mysql_fetch_assoc($rQ) ){

				$id			= $r['id'];
				$question 	= $r['name'];
				$response 	= $r['description'];
				$class 		= '';
				$style 		= '';
				$slug 		= slugify( $id.'-'.strip_tags($question) );
				$permalink 	= get_page_url( $page['id'] ).'/#'.$slug;

				if( $r['collapsed'] == '1' ){
					$class = 'collapsed';
					$style = 'display: none;';
				}

				require BASE_DIR.'/templates/modules/faq/display.php';

				// FAQ schema
				$schema['mainEntity'][] = array(
					'@type' => 'Question',
					'@context' => 'http://schema.org',
					'name' => htmlentities( strip_tags($question) ),
					'text' => htmlentities( strip_tags($question) ),
					'author' => $settings['name'],
                    'answerCount' => '1',
                    'dateCreated' => date( 'c' ),
                    'suggestedAnswer' => array(
						'@type' => 'Answer',
                        'text' => htmlentities( strip_tags($response) ),
                        'author' => $settings['name'],
                        'url' => $permalink,
                        'upvoteCount' => '10',
                        'dateCreated' => date( 'c' ),
					),
                    'acceptedAnswer' => array(
						'@type' => 'Answer',
                        'text' => htmlentities( strip_tags($response) ),
                        'author' => $settings['name'],
                        'url' => $permalink,
                        'upvoteCount' => '10',
                        'dateCreated' => date( 'c' )
					),
				);
			}

			// end FAQ schema
			echo '<script type="application/ld+json">';
			echo json_encode($schema, JSON_PRETTY_PRINT);
			echo '</script>';
		
			echo '</div>';
			
		}
	}


