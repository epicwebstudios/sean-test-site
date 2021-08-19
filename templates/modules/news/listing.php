<div class="ca entry">


	<? if( $photo ){ ?>
        <div class="l photo">
            <a href="<? echo $link; ?>">
                <img src="<? echo img_url( $photo, 150, 150 ); ?>" alt="<? echo $title; ?>">
            </a>
        </div>
    <? } ?>
    
    
    <div class="details">

        <h3 class="title">
            <a href="<? echo $link; ?>">
                <? echo $title; ?>
            </a>
        </h3>
        
        <div class="date">
            <? echo date( 'F jS, Y, g:i A', $date ); ?>
        </div>
        
        <div class="content">
            <? echo $summary; ?>
        </div>
        
        <p>
        	<a href="<? echo $link; ?>" class="btn">Read More</a>
        </p>
    
    </div>


</div>