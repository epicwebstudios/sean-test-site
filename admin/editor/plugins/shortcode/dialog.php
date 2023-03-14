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
			
			var types = new Array();
			
			<? generate_js_tags(); ?>
			
			function swap_shortcodes(id){
				$('.types').hide();
				if(id != "-"){ $('#type_'+id).show(); }
				set_shortcode(id);
			}
			
			function set_shortcode(id){
				var value;
				if(id == '-'){
					$('#shortcode').val('');
				} else {
					if(types[id]['dynamic']){
						var item_id = document.getElementById('record_'+id);
						item_id = item_id.options[item_id.selectedIndex].value;
						if( item_id != '-' ){
							value = types[id]['start'] + item_id + types[id]['close'];
						} else {
							value = '';
						}
					} else {
						value = types[id]['start'];
					}
					$('#shortcode').val(value);
				}
			}
			
        </script>
        <link type="text/css" rel="stylesheet" href="//css.ewsapi.com/global/global.css">
        <link type="text/css" rel="stylesheet" href="//css.ewsapi.com/dialog/dialog.min.css">
    </head>

	<body>
		<p>Select the type and item you wish to add to the page.</p>
        
        <input type="hidden" id="shortcode" value="">
        
        <div class="set">
        	<div class="label">Module Type:</div>
            <div class="field">
            	<select onchange="swap_shortcodes( this.options[this.selectedIndex].value );" id="type">
                	<option value="-">Choose a module type...</option>
                    <? generate_module_options(); ?>
                </select>
            </div>
        </div>
        
        <?
			$query = mysql_query("SELECT * FROM `shortcodes` WHERE `type` = '1' ORDER BY `name` ASC");
			while($shortcode = mysql_fetch_array($query)){
		?>
        
        <div class="set types" id="type_<? echo $shortcode['id']; ?>" style="display: none;">
        	<div class="label">Item to Insert:</div>
            <div class="field">
                <select id="record_<? echo $shortcode['id']; ?>" onchange="set_shortcode(<? echo $shortcode['id']; ?>);">
                	<?
						$iQ = mysql_query("SELECT `".$shortcode['id_col']."`, `".$shortcode['name_col']."` FROM `".$shortcode['table']."` ORDER BY `".$shortcode['name_col']."` ASC");
						if( mysql_num_rows($iQ) > 0 ){
							while( $item = mysql_fetch_array($iQ) ){
					?>
                    <option value="<? echo $item[$shortcode['id_col']]; ?>"><? echo $item[$shortcode['name_col']]; ?></option>
                    <?
							}
						} else {
					?>
                    <option value="-">No items to insert into page.</option>
                    <?
						}
					?>
                </select>
            </div>
        </div>
        
        <?
			}
		?>
        
	</body>
    
</html>