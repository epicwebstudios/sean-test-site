<?
	echo '<div class="cta_module listing" data-id="'.$cta_category_id.'">';

	foreach ($ctas as $cta) {
		require $this_dir.'/cta.php';
		require BASE_DIR.'/templates/modules/cta/display.php';
	}

	echo '</div>';