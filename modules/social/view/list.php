<?
    foreach ($socials as $social) {
	    $id             = $social['id'];
        $type           = $social['type'];
        $link           = $social['link'];
        $text           = $social_types[$type]['alt'];
        $icon_tag       = '<i class="social-icon fa fa-'.$social_types[$type]['icon_tag'].'" aria-hidden="true"></i>';
        $icon_unicode   = $social_types[$type]['icon_unicode'];

        require BASE_DIR.'/templates/modules/social/display.php';
    }