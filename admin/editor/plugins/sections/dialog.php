<?
	define( 'ADMIN_PANEL', true );
	$path = explode( '/admin', __DIR__ );
	require_once $path[0].'/core/core.php';
	require_once __DIR__.'/functions.php';
?>

<!DOCTYPE html>
<html>

	<head>
    	<script type="text/javascript" src="//js.ewsapi.com/jquery/jquery-1.10.2.min.js"></script>
    	<script type="text/javascript">
			
			function set_snippet(){
				
				var class_name = '';
				var content = '';
				var snippet = '';
				
				var select_type = $('#type').val();
				var select_color = $('#color').val();
				
				if( (select_type == 'section_wrapped') || (select_type == 'section_full_width') ){
					
					class_name = 'section';
					
					if( select_type == 'section_full_width' ){
						content += '<p>Full-width content goes here. Typically only used for module shortcodes.</p>';
					}
					
					if( select_type == 'section_wrapped' ){
						content += '<div class="wrapper">';
							content += '<h2>Section Title</h2>';
							content += '<p>Content goes here.</p>';
						content += '</div>';
					}
					
				}
				
				if( (select_type == 'half_panel_left') || (select_type == 'half_panel_right') ){
					
					if( select_type == 'half_panel_left' ){
						class_name = 'half_panel half_left';
					}
					
					if( select_type == 'half_panel_right' ){
						class_name = 'half_panel half_right';
					}
				
					content += '<div class="photo" style="background-image: url(\'../uploads/url-to-image.jpg\');">&nbsp;</div>';
					content += '<div class="wrapper">';
						content += '<div class="content">';
							content += '<h2>Half Panel Title</h2>';
							content += '<p>Content goes here.</p>';
						content += '</div>';
					content += '</div>';
				
				}
				
				snippet += '<div class="' + class_name + ' ' + select_color + '">';
					snippet += content;
				snippet += '</div>';
				
				$('#snippet').val( snippet );
				
			}
			
			$(document).ready( function(){
				set_snippet();
			});
			
        </script>
        <link type="text/css" rel="stylesheet" href="//css.ewsapi.com/global/global.css">
        <link type="text/css" rel="stylesheet" href="//css.ewsapi.com/dialog/dialog.min.css">
    </head>

	<body>
        
        <input type="hidden" id="snippet" value="">
        
        <div class="set">
        	<div class="label">Section Type:</div>
            <div class="field">
            	<select id="type" onchange="set_snippet();">
                	<option value="section_wrapped">Content Section</option>
                    <? /* <option value="section_full_width">Section: Full-Width Content</option> */ ?>
                    <option value="half_panel_left">Half Panel: Left Content</option>
                    <option value="half_panel_right">Half Panel: Right Content</option>
                </select>
            </div>
        </div>
        
        <div class="set">
        	<div class="label">Background Color:</div>
            <div class="field">
            	<select id="color" onchange="set_snippet();">
                	<option value="bg_white">White</option>
                	<option value="bg_green">Green</option>
                	<option value="bg_l_grey">Light Grey</option>
                	<option value="bg_sky_blue">Sky Blue</option>
                	<option value="bg_l_blue">Light Blue</option>
                	<option value="bg_m_blue">Medium Blue</option>
                	<option value="bg_d_blue">Dark Blue</option>
                    <option value="bg_purple">Purple</option>
                </select>
            </div>
        </div>
        
	</body>
    
</html>