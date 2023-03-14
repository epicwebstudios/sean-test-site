<?
	$default_image = \cta\get_default_image($cta['category']);

	$id             = $cta['id'];
	$name           = $cta['name'];
	$category_id    = $cta['category'];
	$content        = $cta['content'];
	$image          = $cta['image'] ?: $default_image;
	$image          = img_url('/layout/cta/'.$image, 1200, 1200);
	$image_type     = $cta_category['image_type'];
	$supertitle     = $cta['supertitle'];
	$button         = $cta['button'];
	$buttons        = null;
	$link           = null;
	$target         = null;

	if ($button) {
		$buttons = \cta\get_buttons($id);

		if ($buttons) {
			foreach ($buttons as $button_key => $button_) {

				if ($button_['link_type'] == 0)
					$buttons[$button_key]['link'] = '#';
				else if ($button_['link_type'] == 1)
					$buttons[$button_key]['link'] = $button_['url'];
				else if ($button_['link_type'] == 2)
					$buttons[$button_key]['link'] = get_page_url($button_['ref_id']);
				else
					$buttons[$button_key]['link'] = '#';

				$buttons[$button_key]['target'] = $button_['link_type'] == 0 || $button_['link_type'] == 2 || $buttons[$button_key]['link'] == '#' ? '_self' : '_blank';
			}
		}
	} else {
		if ($cta['link_type'] == 0)
			$link = '#';
		else if ($cta['link_type'] == 1)
			$link = $cta['url'];
		else if ($cta['link_type'] == 2)
			$link = get_page_url($cta['ref_id']);
		else
			$link = '#';

		$target = $cta['link_type'] == 0 || $cta['link_type'] == 2 || $link == '' ? '_self' : '_blank';
	}