<div class="banner">
	<div class="wrapper">
		<div class="banner-content">
            <? if ($banner_supertitle) : ?>
                <div class="banner-supertitle"><?= nl2br($banner_supertitle) ?></div>
            <? endif; ?>

			<?= '<'.$banner_element.' class="banner-title">'.$banner_title.'</'.$banner_element.'>' ?>

			<? if ($banner_subtitle) : ?>
				<div class="banner-subtitle"><?= nl2br($banner_subtitle) ?></div>
			<? endif; ?>

			<? if ($page['banner_button'] && $banner_buttons && is_array($banner_buttons) && count($banner_buttons) > 0) : ?>
				<div class="banner-buttons">
					<? foreach ($banner_buttons as $button) : ?>
						<a class="banner-button btn" href="<?= $button['link'] ?>" target="<?= $button['target'] ?>"><?= $button['text'] ?></a>
					<? endforeach; ?>
				</div>
			<? endif; ?>
		</div>
	</div>

	<? if ($banner_type == 0) : ?>
		<div class="banner-image lazy" data-src="<?= $banner_image ?>"></div>
	<? endif; ?>

	<? if ($banner_type == 1) : ?>
		<div class="banner-video-container">
			<div class="banner-video resp_video">
				<?= $banner_video_html ?>
			</div>
		</div>

		<? if ($banner_video_image) : ?>
			<div class="banner-video-thumbnail" style="background-image:url(<?= $banner_video_image ?>)"></div>
		<? endif; ?>
	<? endif; ?>

    <? if ($banner_overlay) : ?>
        <div class="banner-overlay"></div>
    <? endif; ?>
</div>