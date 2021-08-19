<?
	echo '<div class="cta_module single cta_module_category_'.$cta_category['id'].'">';

	require $this_dir.'/cta.php';
	require BASE_DIR . '/templates/modules/cta/display.php';

	echo '</div>';