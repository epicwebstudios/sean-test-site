<div class="testimonial" data-id="<?= $id?>">

	<div class="quote"><? parsePage( $quote ); ?></div>
    
    <div class="tr details">
    	
        <? if( $author ){ ?>
        	<div class="author"><? echo $author; ?></div>
		<? } ?>
    	
        <? if( $organization ){ ?>
        	<div class="organization"><? echo $organization; ?></div>
		<? } ?>
    	
        <? if( $location ){ ?>
        	<div class="location"><? echo $location; ?></div>
		<? } ?>
    	
        <? if( $misc ){ ?>
        	<div class="misc"><? echo $misc; ?></div>
		<? } ?>
        
    </div>

</div>

   
<script type="application/ld+json">
	{ 
		"@type":				"Review",
		"@context":				"http://schema.org",
		"mainEntityOfPage": {
			"@type": 			"WebPage",
			"url": 				"<? echo returnURL().'/'.$_GET['act']; ?>"
		},
		"author":				"<? echo $author; ?>",
		"name":					"<? echo htmlentities( strip_tags($summary) ); ?>",
		"description":			"<? echo htmlentities( strip_tags($quote) ); ?>",
		"reviewRating": {
			"@type": 			"Rating",
			"bestRating": 		"5",
			"worstRating": 		"1",
			"ratingValue": 		"<? echo $rating; ?>"
		},
		"itemReviewed": {
			"@type":			"Thing",
			"@context":			"http://schema.org",
			"name":				"<? echo $settings['name']; ?>"
		}
	}
</script>