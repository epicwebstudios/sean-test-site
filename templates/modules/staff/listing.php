<div class="ilb person" data-id="<?= $id ?>">
	
    <? if( $photo ){ ?>
    	<div class="photo">
    		<img src="<? echo img_url( $photo, 150, 150 ); ?>">
        </div>
	<? } ?>
    
    <div class="name">
		<b><? echo $full_name; ?></b>
    </div>
    
    <div class="position">
		<? echo $position; ?>
    </div>
    
	<div class="department">
		<? echo $department; ?>
    </div>
    
    <? if( $email ){ ?>
        <div class="email">
            <? echo $email; ?>
        </div>
    <? } ?>
    
    <? if( $bio ){ ?>
    	<div class="button">
        	<a href="<? echo $permalink; ?>" class="btn">View Profile</a>
        </div>
	<? } ?>
    
</div>