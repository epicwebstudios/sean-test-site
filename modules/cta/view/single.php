<?
	echo '<div class="cta_module single" data-id="'.$cta_id.'" data-category-id="'.$cta_category['id'].'">';

	require $this_dir.'/cta.php';
	require BASE_DIR . '/templates/modules/cta/display.php';

	echo '</div>';