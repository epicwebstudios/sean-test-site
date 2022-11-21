<?
	define( 'ADMIN_PANEL', true );
	$path = explode( '/admin', __DIR__ );
	require_once $path[0].'/core/core.php';
?>

<!DOCTYPE html>
<html>

	<head>
    	<script type="text/javascript" src="//js.ewsapi.com/jquery/jquery-1.10.2.min.js"></script>
    	<script type="text/javascript">
			
			function set_embed(){
				
				var value = '';
				var type;
				
				var sc_id = document.getElementById('sc_id');
				sc_id = sc_id.value;
				var autoplay = document.getElementById('autoplay');
				autoplay = autoplay.options[autoplay.selectedIndex].value;
				var width = document.getElementById('width');
				width = width.options[width.selectedIndex].value;
				var align = document.getElementById('align');
				align = align.options[align.selectedIndex].value;
				
				var lookup_url = 'oembed.php?u=';
				lookup_url += sc_id;
				
				if(sc_id != ''){
					
					$.ajax({
						url: lookup_url
					}).done(function( data ) {
						
						if( data == 'error' ){
							alert("The URL you entered is not a valid SoundCloud URL.");
						} else {
							
							if( data.indexOf("users") > 1 ){
								type = 2;
							} else {
								type = 1;
							}
														
							if(type == 1){
								value = '<iframe scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url='+data+'&color=ff5500&auto_play='+autoplay+'&hide_related=false&show_comments=false&show_user=true&show_reposts=false&show_artwork=false" width="100%" height="116" style="width: 100%; height: 116px;"></iframe>';
							} else {
								value = '<iframe scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url='+data+'&color=ff5500&auto_play='+autoplay+'&hide_related=false&show_comments=false&show_user=true&show_reposts=false&show_artwork=false" width="100%" height="450" style="width: 100%; height: 450px;"></iframe>';
							}
							
							if( width != '100' ){
								if( align == 'ma' ){
									value = '<div class="w_'+width+' ma"><div class="p_a">'+value+'</div></div>';
								} else {
									if( align == 'l'){
										value = '<div class="l w_'+width+'"><div class="p_r p_b">'+value+'</div></div>';
									} else {
										value = '<div class="r w_'+width+'"><div class="p_l p_b">'+value+'</div></div>';
									}
								}
							}
							
							$('#embed').val(value);
							
						}
						
					});
				
				} else {
					value = '';
					$('#embed').val(value);
				};
				
			}
			
        </script>
        <link type="text/css" rel="stylesheet" href="//css.ewsapi.com/global/global.css">
        <link type="text/css" rel="stylesheet" href="//css.ewsapi.com/dialog/dialog.min.css">
    </head>

	<body>
		<p>Insert a SoundCloud embed directly into this page.</p>
        
        <input type="hidden" id="embed" value="">
        
        <div class="set">
        	<div class="label">SoundCloud User or Track URL:</div>
            <div class="field">
            	<input type="text" id="sc_id" placeholder="Example: https://soundcloud.com/epicwebstudios" onkeyup="set_embed();">
            </div>
        </div>
        
        <div class="set">
        	<div class="label">Automatically Play?</div>
            <div class="field">
            	<select id="autoplay" onchange="set_embed();">
                	<option value="true">Yes</option>
                    <option value="false" selected>No</option>
                </select>
            </div>
        </div>
        
        <div class="l w_50">
        	<div class="p_r">
                <div class="set">
                    <div class="label">Embed Width</div>
                    <div class="field">
                        <select id="width" onchange="set_embed();">
                            <option value="100" selected>100%</option>
                            <option value="90">90%</option>
                            <option value="83">83%</option>
                            <option value="80">80%</option>
                            <option value="75">75%</option>
                            <option value="70">70%</option>
                            <option value="66">66%</option>
                            <option value="60">60%</option>
                            <option value="50">50%</option>
                            <option value="40">40%</option>
                            <option value="33">33%</option>
                            <option value="30">30%</option>
                            <option value="25">25%</option>
                            <option value="20">20%</option>
                            <option value="16">16%</option>
                            <option value="10">10%</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="l w_50">
        	<div class="p_l">
                <div class="set">
                    <div class="label">Alignment</div>
                    <div class="field">
                        <select id="align" onchange="set_embed();">
                            <option value="ma" selected>Center</option>
                            <option value="l">Left (Wraps Text)</option>
                            <option value="r">Right (Wraps Text</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="c"></div>
        
	</body>
    
</html>