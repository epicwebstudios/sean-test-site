<div class="person ca" data-id="<?= $id ?>">

	<? if( $photo ){ ?>
    	<div class="l photo">
        	<a href="<? echo returnURL().'/uploads/'.$photo; ?>" class="lightbox_img" alt="<? echo $full_name; ?>">
        		<img src="<? echo img_url( $photo, 150, 150 ); ?>">
            </a>
        </div>
	<? } ?>

	<div class="details">
    
        <div class="name">
            <b><? echo $full_name; ?></b>
        </div>
        
        <div class="position">
            <? echo $position; ?>
        </div>
        
        <div class="department">
            <? echo $department; ?>
        </div>
        
        <div class="email">
            <a href="mailto:<? echo $email; ?>"><? echo $email; ?></a>
        </div>
        
        <div class="phone">
            <? echo $phone; ?>
        </div>
        
        <div class="fax">
            <? echo $fax; ?>
        </div>
        
        <div class="social">
            
            <? if( $social['facebook'] ){ ?>
                <a href="<? echo $social['facebook']; ?>" target="_blank"><span class="fa fa-fw fa-facebook"></span></a>
            <? } ?>
            
            <? if( $social['twitter'] ){ ?>
                <a href="<? echo $social['twitter']; ?>" target="_blank"><span class="fa fa-fw fa-twitter"></span></a>
            <? } ?>
            
            <? if( $social['instagram'] ){ ?>
                <a href="<? echo $social['twitter']; ?>" target="_blank"><span class="fa fa-fw fa-instagram"></span></a>
            <? } ?>
            
            <? if( $social['linkedin'] ){ ?>
                <a href="<? echo $social['linkedin']; ?>" target="_blank"><span class="fa fa-fw fa-linkedin"></span></a>
            <? } ?>
            
        </div>
        
        <div class="bio">
            <? parsePage( $bio ); ?>
        </div>
    
    </div>
    
</div>

<p class="tc return">
	<a href="<? echo $page_url; ?>" class="btn">
    	Return to <? echo $category; ?>
    </a>
</p>

   
<script type="application/ld+json">
	{ 
		"@type":						"Person",
		"@context":						"http://schema.org",
		"mainEntityOfPage": {
			"@type": 					"WebPage",
			"url": 						"<? echo returnURL().'/'.$_GET['act']; ?>"
		},
		"name":							"<? echo $full_name; ?>",
		"jobTitle":						"<? echo $position; ?>",
		<? if( $email ){ ?>
		"email": 						"<? echo $email; ?>",
		<? } ?>
		<? if( $phone ){ ?>
		"telephone": 					"<? echo $phone; ?>",
		<? } ?>
		<? if( $fax ){ ?>
		"faxNumber": 					"<? echo $fax; ?>",
		<? } ?>
		<? if( $photo ){ ?>
		"image":						"<? echo returnURL().'/uploads/'.$photo; ?>",
		<? } ?>
		"disambiguatingDescription": 	"<? echo htmlentities( strip_tags($bio) ); ?>",
		"url":	 						"<? echo returnURL().'/'.$_GET['act']; ?>"
	}
</script>