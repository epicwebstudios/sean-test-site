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
				
				var video_id = document.getElementById('video_id');
				video_id = video_id.value;
				var information = document.getElementById('information');
				var related = document.getElementById('related');
				var hd = document.getElementById('hd');
				var autoplay = document.getElementById('autoplay');
				var loop = document.getElementById('loop');
				var width = document.getElementById('width');
				var align = document.getElementById('align');
				
				if( video_id.indexOf('youtube.com') >= 0 ){
					var explode = video_id.split("=");
					explode = explode[1].split("&");
					video_id = explode[0];
				} else if( video_id.indexOf('youtu.be') >= 0 ){
					var explode = video_id.split("be/");
					explode = explode[1].split("?");
					video_id = explode[0];
				}
				
				if(video_id != ''){
					
					var url_params = '';
					url_params += video_id + '?';
					
					if( related.options[related.selectedIndex].value == '1'){
						url_params += '&rel=1';
					} else {
						url_params += '&rel=0';
					}
					
					if( information.options[information.selectedIndex].value == '1'){
						url_params += '&showinfo=1';
					} else {
						url_params += '&showinfo=0';
					}
					
					if( hd.options[hd.selectedIndex].value == '1'){
						url_params += '&hd=1';
					} else {
						url_params += '&hd=0';
					}
					
					if( autoplay.options[autoplay.selectedIndex].value == '1'){
						url_params += '&autoplay=1';
					} else {
						url_params += '&autoplay=0';
					}
					
					if( loop.options[loop.selectedIndex].value == '1'){
						url_params += '&loop=1';
					} else {
						url_params += '&loop=0';
					}
					
					var value = '';
					value += '<div class="resp_video">';
					value += '<iframe src="https://www.youtube.com/embed/'+url_params+'" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
					value += '</div>';
					
					width = width.options[width.selectedIndex].value;
					align = align.options[align.selectedIndex].value;
					
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
				
				} else {
					value = '';
				}
				
				$('#embed').val(value);
				
			}
			
        </script>
        <link type="text/css" rel="stylesheet" href="//css.ewsapi.com/global/global.css">
        <link type="text/css" rel="stylesheet" href="//css.ewsapi.com/dialog/dialog.min.css">
    </head>

	<body>
		<p>Insert a YouTube video directly into this page.</p>
        
        <input type="hidden" id="embed" value="">
        
        <div class="set">
        	<div class="label">YouTube URL or ID:</div>
            <div class="field">
            	<input type="text" id="video_id" placeholder="Example: https://www.youtube.com/watch?v=h2Nq0qv0K8M or just h2Nq0qv0K8M" onkeyup="set_embed();">
            </div>
        </div>
        
        <div class="set">
        	<div class="label">Show Video Information?</div>
            <div class="field">
            	<select id="information" onchange="set_embed();">
                	<option value="1">Yes</option>
                    <option value="0" selected>No</option>
                </select>
            </div>
        </div>
        
        <div class="set">
        	<div class="label">Show Related Videos?</div>
            <div class="field">
            	<select id="related" onchange="set_embed();">
                	<option value="1">Yes</option>
                    <option value="0" selected>No</option>
                </select>
            </div>
        </div>
        
        <div class="set">
        	<div class="label">Embed Video in HD?</div>
            <div class="field">
            	<select id="hd" onchange="set_embed();">
                	<option value="1" selected>Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
        </div>
        
        <div class="set">
        	<div class="label">Automatically Play?</div>
            <div class="field">
            	<select id="autoplay" onchange="set_embed();">
                	<option value="1">Yes</option>
                    <option value="0" selected>No</option>
                </select>
            </div>
        </div>
        
        <div class="set">
        	<div class="label">Loop Video Playback?</div>
            <div class="field">
            	<select id="loop" onchange="set_embed();">
                	<option value="1">Yes</option>
                    <option value="0" selected>No</option>
                </select>
            </div>
        </div>
        
        <div class="l w_50">
        	<div class="p_r">
                <div class="set">
                    <div class="label">Video Width</div>
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