<?
    global $settings, $page;

    $this_dir = __DIR__;

    require_once $this_dir.'/functions.php';

	$cta_view           = $cta_view ?? null;
    $cta_category_id    = $cta_category_id ?? false;
	$cta_id             = $cta_id ?? false;

	if ($cta_view == 'single' && $cta_id) {
	    $cta            = \cta\get_cta_from_id($cta_id);
	    $cta_category   = \cta\get_category_from_cta_id($cta['category']);
	    
	    if ($cta && $cta_category)
            require $this_dir.'/view/single.php';

    } elseif ($cta_category_id) {
		$ctas           = \cta\get_ctas_from_category_id($cta_category_id);
		$cta_category   = \cta\get_category_from_cta_id($cta_category_id);

		if ($ctas)
			require $this_dir.'/view/list.php';
    }

	unset($cta_view);
	unset($cta_category_id);
	unset($cta_id);