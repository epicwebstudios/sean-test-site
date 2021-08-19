<?
	require "../../../../sources/init/connect.php";
	require "../../../../sources/init/global.php";
?>

<!DOCTYPE html>
<html>

	<head>
    	<script type="text/javascript" src="//js.ewsapi.com/jquery/jquery-1.10.2.min.js"></script>
    	<script type="text/javascript">
			
			function set_embed(){
				
				var value = '';
						
				value += $('#example').val();	
							
				$('#embed').val( value );
				
			}
			
        </script>
        <link type="text/css" rel="stylesheet" href="//css.ewsapi.com/global/global.css">
        <link type="text/css" rel="stylesheet" href="//css.ewsapi.com/dialog/dialog.min.css">
    </head>

	<body>
    
		<p>Text description</p>
        
        <input type="hidden" id="embed" value="">
        
        <div class="set">
        	<div class="label">Enter anything:</div>
            <div class="field">
            	<input type="text" id="example" placeholder="Hello, World!" onkeyup="set_embed();">
            </div>
        </div>
        
	</body>
    
</html>