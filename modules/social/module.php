<?
    require_once __DIR__.'/functions.php';

	// types
	$social_types = \social_media_icons\get_types();

	// items
    $socials = \social_media_icons\get_items();

    echo '<div class="social_module">';

    require __DIR__.'/view/list.php';

    echo '</div>';