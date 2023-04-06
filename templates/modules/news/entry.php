<div class="ca entry" data-id="<?= $id ?>">

    <? if (!$page['banner']) : ?>
        <h1 class="title">
            <? echo $title; ?>
        </h1>
    <? endif; ?>
    
    <div class="date">
        <? echo date( 'F jS, Y, g:i A', $date ); ?>
    </div>


	<? if( $photo ){ ?>
        <div class="l photo">
            <a href="<? echo returnURL().'/uploads/'.$photo['filename']; ?>" class="lightbox_img" alt="<? echo $photo['caption']; ?>">
                <img src="<? echo img_url( $photo['filename'], 150, 150 ); ?>" alt="<? echo $photo['caption']; ?>">
            </a>
        </div>
    <? } ?>
    
    
    <div class="details">
        
        <div class="content">
            <? parsePage( $entry ); ?>
        </div>
        
        <? if( $photos ){ ?>
			
            <div class="tc photos">
            	<?
					foreach( $photos as $photo ){
						
						$thumbnail	= img_url( $photo['filename'], 150, 150 );
						$full_size	= returnURL().'/uploads/'.$photo['filename'];
						$caption	= $photo['caption'];
						
						echo '<a href="'.$full_size.'" class="lightbox_gallery" alt="'.$caption.'">';
							echo '<img src="'.$thumbnail.'" alt="'.$caption.'">';
						echo '</a>';
						
					}
				?>
			</div>
            
		<? } ?>
    
    </div>

    <div class="share_box">
        <?
            // $share = new Share();
            // $share->view_share_button(returnURL().$_SERVER['REQUEST_URI']);
        ?>
    </div>
    

</div>


<p class="tc return">
	<a href="<? echo $page_url; ?>" class="btn">
    	Return to all <? echo $category; ?>
    </a>
</p>

   
<script type="application/ld+json">
	{ 
		"@type":			"NewsArticle",
		"@context":			"http://schema.org",
		"mainEntityOfPage": {
			"@type": 		"WebPage",
			"url": 			"<? echo $link; ?>"
		},
		"inLanguage": 		"en_US",
		"headline": 		"<? echo addcslashes( $title, '"' ); ?>",
		"description": 		"<? echo addcslashes( $summary, '"' ); ?>",
		"articleBody": 		"<? echo addcslashes( strip_tags($entry), '"' ); ?>",
		"url": 				"<? echo $link; ?>",
		"articleSection": 	["<? echo addcslashes( $category, '"' ); ?>"],
		"dateCreated": 		"<? echo date( 'c', $date ); ?>",
		"datePublished": 	"<? echo date( 'c', $date ); ?>",
		"dateModified": 	"<? echo date( 'c', $date ); ?>",
		<? if( $photo ){ ?>
		"thumbnailUrl": 	"<? echo img_url( $photo['filename'], 150, 150 ); ?>",
		"image": {
							"@type": "ImageObject",
							"url": "<? echo img_url( $photo['filename'], 150, 150 ); ?>"
		},
		<? } ?>
		"speakable": {
			"@type":		"SpeakableSpecification",
			"cssSelector": 	[ ".news_module .full_entry .title", ".news_module .full_entry .content" ]
		},
		"author": {
			"@context": 	"http://schema.org",
			"@type": 		"Organization",
			"name": 		"<? echo addcslashes( $settings['name'], '"' ); ?>",
			<? if( $settings['image'] ){ ?>
			"logo": {
				"@type": 	"ImageObject",
				"url": 		"<? echo returnURL().'/uploads/og_images/'.$settings['image']; ?>"
			},
			<? } ?>
			"url": 			"<? echo returnURL(); ?>"
		},
		"creator": {
			"@context": 	"http://schema.org",
			"@type": 		"Organization",
			"name": 		"<? echo addcslashes( $settings['name'], '"' ); ?>",
			<? if( $settings['image'] ){ ?>
			"logo": {
				"@type": 	"ImageObject",
				"url": 		"<? echo returnURL().'/uploads/og_images/'.$settings['image']; ?>"
			},
			<? } ?>
			"url": 			"<? echo returnURL(); ?>"
		},
		"publisher": {
			"@type": 		"Organization",
			"name": 		"<? echo addcslashes( $settings['name'], '"' ); ?>",
			<? if( $settings['image'] ){ ?>
			"logo": {
				"@type": 	"ImageObject",
				"url": 		"<? echo returnURL().'/uploads/og_images/'.$settings['image']; ?>"
			},
			<? } ?>
			"url": 			"<? echo returnURL(); ?>"
		}
	}
</script>


