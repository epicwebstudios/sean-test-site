<!DOCTYPE html>
<html lang="en">
	
    <head>

		<?
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
		?>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="generator" content="epicPlatform <? echo $system['version'].'-'.$system['build']; ?>" />
		<meta name="author" content="<? echo $settings['name']; ?>" />
		<meta name="robots" content="<? echo $robots; ?>" />
		
        <title><? if($page['title']){ echo $page['title']." - "; } echo $settings['title']; ?></title>
		<meta name="description" content="<? if($page['description']){ echo $page['description']; } else { echo $settings['description']; } ?>" />
		
		<? if($settings['image']){ ?><link rel="image_src" href="<? mainURL(); ?>/uploads/<? echo $settings['image']; ?>" /><? } ?>
		<link rel="canonical" href="<? echo $page['canonical']; ?>" />

        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
		<?	
			ico_settings();
			load_stylesheets();
			set_viewport();
			set_og_tags();
			custom_head();
			page_head();
		?>
        
        <script>
			function jQuery_defer( method ){
				if( window.jQuery ){
					method();
				} else {
					setTimeout( function(){ jQuery_defer( method ); }, 50 );
				}
			}
		</script>

	</head>

	<body>
    
   		<?
            custom_body_open();
            page_body_open();
        ?>
		