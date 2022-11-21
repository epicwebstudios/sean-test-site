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
				
				var width = $('#width').val();
				var align = $('#align').val();
				var height = $('#height').val();
				var amount = parseInt( $('#amount').val() );
				
				var p_t = $('#p_t').is(":checked");
				var p_b = $('#p_b').is(":checked");
				var p_l = $('#p_l').is(":checked");
				var p_r = $('#p_r').is(":checked");
				var p_a = $('#p_a').is(":checked");
				
				var value;
				var class_string = 'grid_box';
				var sub_class_string = false;
				var style_string = false;
				var fill;
				
				// Set classes
				
					class_string += ' ' + align;
					class_string += ' w_' + width;
				
				// Set sub classes
				
					if( (p_a) || ((p_l) && (p_r) && (p_t) && (p_b)) ){
						sub_class_string = 'p_a';
					} else {
						
						if( (p_l) || (p_r) || (p_t) || (p_b) ){
							sub_class_string = '';
						}
						
						if( p_l ){
							if( sub_class_string ){ sub_class_string += ' '; }
							sub_class_string += 'p_l';
						}
						
						if( p_r ){ 
							if( sub_class_string ){ sub_class_string += ' '; }
							class_string += 'p_r '; 
						}
						
						if( p_t ){ 
							if( sub_class_string ){ sub_class_string += ' '; }
							sub_class_string += 'p_t '; 
						}
						
						if( p_b ){ 
							if( sub_class_string ){ sub_class_string += ' '; }
							sub_class_string += 'p_b '; 
						}
						
					}
				
				// Set styles
				
					if( height ){
						if( style_string ){ style_string += ' '; }
						style_string = 'height: '+height+'px;';
					}
					
				// Run loop to create grid
				
					value = '';
					value += '<div class="grid">';
				
					for( var i=1; i<=amount; i++ ){
						
						fill = 'Box #' + i;
						
						value += '<div class="' + class_string + '">';
							if( (sub_class_string) || (style_string) ){
								value += '<div';
									if( sub_class_string ){ value += ' class="' + sub_class_string + '" '; }
									if( style_string ){ value += ' style="' + style_string + '" '; }
								value += '><p>' + fill + '</p></div>';
							} else {
								value += fill;
							}
						value += '</div>';
						
					}
					
					value += '</div>';
					
				// Set embed
				
					$('#embed').val(value);
				
			}
			
			function set_count( width ){
				count = 1;
				if( width == '50' ){ count = 2; }
				if( width == '33' ){ count = 3; }
				if( width == '25' ){ count = 4; }
				if( width == '20' ){ count = 5; }
				if( width == '16' ){ count = 6; }
				if( width == '10' ){ count = 10; }
				$('#amount').val( count );
				set_embed();
			}
			
        </script>
        <link type="text/css" rel="stylesheet" href="//css.ewsapi.com/global/global.css">
        <link type="text/css" rel="stylesheet" href="//css.ewsapi.com/dialog/dialog.min.css">
    </head>

	<body>
		<p>Insert a Grid Element into this page.</p>
        
        <input type="hidden" id="embed" value="">
       
        
        <div class="l w_50">
        	<div class="p_r">
                <div class="set">
                    <div class="label">Grid Element Width</div>
                    <div class="field">
                        <select id="width" onchange="set_count( $(this).val() );">
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
                    <div class="label">Grid Element Height</div>
                    <div class="field">
                        <input type="text" id="height" value="" onkeyup="set_embed();">
                    </div>
                </div>
        	</div>
        </div>
        
        <div class="c"></div>
       
        <div class="l w_66">
        	<div class="p_r">
                <div class="set">
                    <div class="label">Element Alignment</div>
                    <div class="field">
                        <select id="align" onchange="set_embed();">
                            <option value="l" selected>Left (Floating)</option>
                            <option value="r">Right (Floating)</option>
                            <option value="ma">Center</option>
                        </select>
                    </div>
                </div>
        	</div>
        </div>
       
        <div class="l w_33">
        	<div class="p_l">
                <div class="set">
                    <div class="label"># of Elements</div>
                    <div class="field">
                        <input type="text" id="amount" value="1" onkeyup="set_embed();">
                    </div>
                </div>
        	</div>
        </div>
        
        <div class="c"></div>
        
        <div class="set">
            <div class="label">Spacing / Padding</div>
            <div class="field tc">
                <input type="checkbox" id="p_l" onchange="set_embed();"> <label for="p_l">Left</label>
                &nbsp;&nbsp;&nbsp;
                <input type="checkbox" id="p_r" onchange="set_embed();"> <label for="p_r">Right</label>
                &nbsp;&nbsp;&nbsp;
                <input type="checkbox" id="p_t" onchange="set_embed();"> <label for="p_t">Top</label>
                &nbsp;&nbsp;&nbsp;
                <input type="checkbox" id="p_b" onchange="set_embed();"> <label for="p_b">Bottom</label>
                &nbsp;&nbsp;&nbsp;
                <input type="checkbox" id="p_a" onchange="set_embed();" checked> <label for="p_a">All Sides</label>
            </div>
        </div>
        
        
        
	</body>
    
</html>