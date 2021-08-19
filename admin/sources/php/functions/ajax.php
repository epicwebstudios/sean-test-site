<?

	function ajax_section( $name ){
			
		echo '&nbsp;<br>&nbsp;';	
		
		echo '<div class="ajax_section" id="'.$name.'">';
			
			echo '<div class="listing"></div>';
			
			echo '<div class="loading">';
				echo '<div class="icon">';
					echo '<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>';
				echo '</div>';
			echo '</div>';
			
		echo '</div>';
			
		echo '<script type="text/javascript">';
			echo "ajax_listing( '".$name."', '".$_GET['i']."' );";
		echo '</script>';
		
	}

