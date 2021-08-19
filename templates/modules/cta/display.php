<div class="cta cta-<?= $id ?>">

	<? if ($image && $image_type == 0) : ?>
        <div class="cta-image-div lazy" data-src="<?= $image ?>" aria-label="<?= $name ?>"></div>

        <div class="cta-overlay"></div>
	<? endif; ?>

    <div class="cta-content-container">
		<? if ($image && $image_type == 1) : ?>
            <div class="cta-image-container">
                <img class="cta-image-img" src="<?= $image ?>" alt="<?= $name ?>" />
            </div>
		<? endif; ?>

        <? if ($supertitle) : ?>
        <div class="cta-supertitle"><?= $supertitle ?></div>
        <? endif; ?>

        <div class="cta-name"><?= $name ?></div>
        <div class="cta-content"><?= nl2br($content) ?></div>

		<? if ($button && $buttons) : ?>
            <div class="cta-buttons">
                <? foreach ($buttons as $button_) : ?>
                    <div class="cta-button">
                        <a class="btn" href="<?= $button_['link'] ?>" target="<?= $button_['target'] ?>"><?= ($button_['text']) ?: 'Read More' ?></a>
                    </div>
                <? endforeach; ?>
            </div>
		<? else: ?>
            <a class="cta-link" href="<?= $link ?>" target="<?= $target ?>"><?= $name ?></a>
		<? endif; ?>
    </div>
</div>