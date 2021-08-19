<? if( $colors ){ ?>

	<h2>Colors</h2>
    
    <div class="colors">

		<? foreach( $colors as $color ){ ?>
        
            <div class="color">
            
            	<div class="sample" style="background-color: <? echo $color['hex']; ?>;"></div>
                
                <div class="name">
                	<b><? echo $color['name']; ?></b>
                </div>
                
                <div class="description">
					<? echo $color['description']; ?>
                </div>
                
                <div class="values">
                	
                    <div class="hex">
                    	<b>HEX:</b> <? echo $color['hex']; ?>
                    </div>
                	
                    <div class="rgb">
                    	<b>R:</b> <? echo $color['rgb']['r']; ?>
                        <span class="spacer"></span>
                    	<b>G:</b> <? echo $color['rgb']['g']; ?>
                        <span class="spacer"></span>
                    	<b>B:</b> <? echo $color['rgb']['b']; ?>
                    </div>
                	
                    <div class="cmyk">
                    	<b>C:</b> <? echo $color['cmyk']['c']; ?>%
                        <span class="spacer"></span>
                    	<b>M:</b> <? echo $color['cmyk']['m']; ?>%
                        <span class="spacer"></span>
                    	<b>Y:</b> <? echo $color['cmyk']['y']; ?>%
                        <span class="spacer"></span>
                    	<b>K:</b> <? echo $color['cmyk']['k']; ?>%
                    </div>
                    
                </div>
            
            </div>
        
        <? } ?>
    
    </div>
    
<? } ?>


<? if( $logos ){ ?>

	<h2>Logos</h2>    
    
    <div class="logos">

		<? foreach( $logos as $logo ){ ?>
        
            <div class="logo">
            
            	<? if( $logo['thumbnail'] ){ ?>
                    <div class="thumbnail">
                        <img src="<? echo $logo['thumbnail']; ?>" alt="<? echo htmlentities( $logo['name'] ); ?>">
                    </div>
                <? } ?>
                
                <div class="name">
                	<b><? echo $logo['name']; ?></b>
                </div>
                
                <div class="description">
					<? echo $logo['description']; ?>
                </div>
                
                <div class="formats">
                	<?
					
						$formats = '';
						
						if( $logo['jpg'] ){
							if( $formats != '' ){ $formats .= '<span class="spacer"></span>'; }
							$formats .= '<a href="'.$logo['jpg'].'" target="_blank">JPG</a>';
						}
						
						if( $logo['png'] ){
							if( $formats != '' ){ $formats .= '<span class="spacer"></span>'; }
							$formats .= '<a href="'.$logo['png'].'" target="_blank">PNG</a>';
						}
						
						if( $logo['ai'] ){
							if( $formats != '' ){ $formats .= '<span class="spacer"></span>'; }
							$formats .= '<a href="'.$logo['ai'].'" target="_blank">AI</a>';
						}
						
						if( $logo['psd'] ){
							if( $formats != '' ){ $formats .= '<span class="spacer"></span>'; }
							$formats .= '<a href="'.$logo['psd'].'" target="_blank">PSD</a>';
						}
						
						if( $logo['eps'] ){
							if( $formats != '' ){ $formats .= '<span class="spacer"></span>'; }
							$formats .= '<a href="'.$logo['eps'].'" target="_blank">EPS</a>';
						}
						
						if( $logo['pdf'] ){
							if( $formats != '' ){ $formats .= '<span class="spacer"></span>'; }
							$formats .= '<a href="'.$logo['pdf'].'" target="_blank">PDF</a>';
						}
						
						echo $formats;
						
					?>
                </div>
            
            </div>
        
        <? } ?>
        
	</div>
    
<? } ?>


<? if( $fonts ){ ?>

	<h2>Fonts</h2>    
    
    <div class="fonts">

		<? foreach( $fonts as $font ){ ?>
        
            <div class="font">
                
                <div class="name">
                	<b><? echo $font['name']; ?></b>
                </div>
                
                <div class="description">
					<? echo $font['description']; ?>
                </div>
                
                <? if( $font['file'] ){ ?>
                	<div class="file">
                    	<a href="<? echo $font['file']; ?>" target="_blank">Download</a>
                    </div>
				<? } ?>
                
                <? if( $font['link'] ){ ?>
                	<div class="link">
                    	<a href="<? echo $font['link']; ?>" target="_blank">More Information</a>
                    </div>
				<? } ?>
            
            </div>
        
        <? } ?>
        
	</div>
    
<? } ?>