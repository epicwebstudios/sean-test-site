<!DOCTYPE html>
<html lang="en">
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="generator" content="epicPlatform <? echo $system['version'].'-'.$system['build']; ?>" />
		<meta name="author" content="<? echo $settings['name']; ?>" />
		<meta name="robots" content="<? echo get_robots(); ?>" />
		
        <title><? if($page['title']){ echo $page['title']." - "; } echo $settings['title']; ?></title>
		<meta name="description" content="<? if($page['description']){ echo $page['description']; } else { echo $settings['description']; } ?>" />

		<? if($settings['image']) : ?>
            <link rel="image_src" href="<? mainURL(); ?>/uploads/<? echo $settings['image']; ?>" />
        <? endif; ?>

        <link rel="canonical" href="<? echo $page['canonical']; ?>" />

		<?	
			ico_settings();
			load_stylesheets();
			set_viewport();
			set_og_tags();
			custom_head();
			page_head();
            load_javascript(1);
		?>
        
        <script>
			function jQuery_defer( method ){
				if( window.jQuery ){
					method();
				} else {
					setTimeout( function(){ jQuery_defer( method ); }, 50 );
				}
			}

            function jQuery_plugin_defer(plugin, method) {
                jQuery_defer(function() {
                    if (typeof $.fn[plugin] !== 'undefined') {
                        method();
                    } else {
                        setTimeout(function() {
                            jQuery_plugin_defer(plugin, method);
                        }, 50);
                    }
                });
            }
		</script>
	</head>

	<body class="template-<?= $page['template'] ?>">
    
   		<?
            custom_body_open();
            page_body_open();
        ?>