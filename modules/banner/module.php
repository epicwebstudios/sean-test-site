<?
	global $page, $settings;

	if ($page['banner']) {

        $banner_title       = $page['banner_title'];
		$banner_supertitle  = $page['banner_supertitle'];
        $banner_subtitle    = $page['banner_subtitle'];
        $banner_type        = $page['banner_type'];
        $banner_image       = null;
        $banner_video_html  = null;
        $banner_video_image = null;

        if ($banner_type == 0) {

            // banner image
            if (isset($page['banner_image_custom']) && $page['banner_image_custom'])
                $banner_image = $page['banner_image_custom'];
            else {
                if ($page['banner_image'])
                    $banner_image = '/layout/banner/'.$page['banner_image'];
                else
                    $banner_image = '/layout/banner/'.$settings['banner_image'];
            }

            $banner_image = img_url($banner_image, 1920, 1920);

        } elseif ($banner_type == 1) {

            // banner video
            if ($page['banner_video_type'] == 1)
                $banner_video_html = '<video muted autoplay loop><source type="video/mp4" src="'.returnURL().'/uploads/layout/banner/'.$page['banner_video_file'].'"></video>';
            elseif ($page['banner_video_type'] == 2) {
                preg_match('#(?<=(?:v|i)=)[a-zA-Z0-9-]+(?=&)|(?<=(?:v|i)\/)[^&\n]+|(?<=embed\/)[^"&\n]+|(?<=(?:v|i)=)[^&\n]+|(?<=youtu.be\/)[^&\n]+#', $page['banner_video_url'], $banner_video_url_id);
                $banner_video_html = '<iframe src="https://www.youtube-nocookie.com/embed/'.$banner_video_url_id[0].'?rel=0&wmode=transparent&autoplay=1&mute=1&controls=0&showinfo=0&autohide=1&fs=0&cc_load_policy=1&loop=1&modestbranding=1&playlist='.$banner_video_url_id[0].'"></iframe>';
            } elseif ($page['banner_video_type'] == 3) {
                preg_match('/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^\/]*)\/videos\/|album\/(?:\d+)\/video\/|video\/|)(\d+)(?:[a-zA-Z0-9_\-]+)?/i', $page['banner_video_url'], $banner_video_url_id);
                $banner_video_html = '<iframe class="lazy" data-src="https://player.vimeo.com/video/'.$banner_video_url_id[1].'?background=1&muted=1&loop=1&autoplay=1&autopause=0" allow=autoplay></iframe>';
            } else
                $banner_video_html = '';

            $banner_video_image = $page['banner_video_thumbnail'] ? img_url('/layout/banner/'.$page['banner_video_thumbnail'], 1920, 1920) : null;
        }

        // banner buttons
        if ($page['banner_button']) {
            $stmt           = "SELECT * FROM `pages_banner_buttons` WHERE `page_id` = ".$page['id']." AND `status` = 1 ORDER BY `order` ASC";
            $banner_buttons = array();
            $query          = mysql_query($stmt);

            while ($r = mysql_fetch_assoc($query))
                $banner_buttons[$r['id']] = $r;

            foreach ($banner_buttons as $key => $button) {
                $banner_button_link_type    = $button['link_type'];
                $banner_button_url          = $button['url'];
                $banner_button_ref_id       = $button['ref_id'];
                $banner_button_anchor       = $button['anchor'];

                // link
                if ($banner_button_link_type == 0)
                    $banner_buttons[$key]['link'] = '#';
                else if ($banner_button_link_type == 1)
                    $banner_buttons[$key]['link'] = $banner_button_url;
                else if ($banner_button_link_type == 2)
                    $banner_buttons[$key]['link'] = get_page_url($banner_button_ref_id);

                // anchor
                if ($banner_button_anchor)
                    $banner_buttons[$key]['link'] .= ($banner_button_link_type!=0?'#':'').$banner_button_anchor;

                // target
                if ($banner_button_link_type == 0 || $banner_button_link_type == 2 || $banner_buttons[$key]['link'] == '#')
                    $banner_buttons[$key]['target'] = '_self';
                else
                    $banner_buttons[$key]['target'] = '_blank';
            }
        } else
            $banner_buttons = null;

        // banner element type
        $banner_element = isset($page['banner_title_h1']) && $page['banner_title_h1'] ? 'h1' : 'div';

        require BASE_DIR.'/templates/modules/banner/banner.php';

        echo '<script>';
		require BASE_DIR.'/templates/modules/banner/javascript.js';
		echo '</script>';
	}