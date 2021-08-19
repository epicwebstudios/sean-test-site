<?
    global $settings, $page;

    $this_dir = __DIR__;

    require_once $this_dir.'/functions.php';

    $cta_category_id    = isset($cta_category_id) ? $cta_category_id : false;
	$cta_id             = isset($cta_id) ? $cta_id : false;

	if ($cta_id) {
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