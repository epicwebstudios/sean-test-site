<?
	echo '<div class="cta_module listing cta_module_category_'.$cta_category_id.'">';

	foreach ($ctas as $cta) {
		require $this_dir.'/cta.php';
		require BASE_DIR.'/templates/modules/cta/display.php';
	}

	echo '</div>';