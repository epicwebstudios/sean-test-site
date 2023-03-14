<? require_once dirname( __FILE__ ).'/functions.php'; ?>

<div class="ca">
    	
	<?
		
		if( $_GET['e'] ){
		
			if( $_GET['e'] == 'permission' ){
				$title 		= 'Permission Error';
				$message	= 'You do not have permission to access this page.';
			} else if( $_GET['e'] == 'missing-files' ){
				$title 		= 'Files Error';
				$message	= 'The module files for this section cannot be found.';
			} else if( $_GET['e'] == 'not-available' ){
				$title 		= 'Reference Error';
				$message	= 'This section cannot be accessed through the administrative panel.';
			} else if( $_GET['e'] == 'missing-record' ){
				$title 		= 'Record Error';
				$message	= 'The module you are trying to access cannot be found.';
			}
			
			echo '<div class="notify notify-error">';
			echo '<h4>'.$title.'</h4>';
			echo '<div>'.$message.'</div>';
			echo '</div>';
			
		}
			
	?>


	<div class="l w_30">
    	<div class="tc p_r">
            
            <h1 style="padding-top: 100px;">Welcome to your control panel!</h1>
            
            <div>You can control nearly every asset of your website by using the tools in the menu bar above.</div>
            
            <div>&nbsp;</div>
            <div>&nbsp;</div>
            
            <h3>Stuck on something?</h3>
            
            <div>Feel free to use the "<b>Support</b>" menu above for assistance!</div>
            
            <div>&nbsp;</div>
            <div>&nbsp;</div>
            
            <div>
				<?
					$img  = 'https://www.epicwebstudios.com/platform/update/check.php';
					$img .= '?v='.EP_VERSION;
					$img .= '&large=true';
					if( $_COOKIE['ews_dark_mode'] == '1' ){
						$img .= '&dark=true';
					}
						
					echo '<img src="'.$img.'" style="width: 300px;">';
				?>
			</div>
            
        </div>
    </div>
    
    
    <div class="l w_70">
    	<div class="p_l">
        
            <table class="table">
                <thead>
                    <tr>
                        <td colspan="3">Latest Modifications</td>
                    </tr>
                </thead>
                <tbody>
                    <tr class="category">
                    	<td>Action</td>
                        <td style="width: 300px;">Administrator</td>
                        <td style="width: 300px;">Date</td>
                    </tr>
                    <?
						if( count($actions) > 0 ){
                    		foreach( $actions as $action ){
					?>
                    	
                        <tr>
                        	
                            <td>
								<? echo $action['action']; ?>
                            </td>
                            
                            <td>
								<? echo '<b>'.$administrators[$action['admin']]['name'].'</b> ('.$administrators[$action['admin']]['username'].')'; ?>
                            </td>
                            
                            <td>
								<? parseDate( $action['date'], 2 ); ?>
                            </td>
                            
                        </tr>
                        
                    <?
                    		}
						} else {
					?>
                    	
                        <tr>
                        	<td colspan="3" align="center">
                            	There have been no modifications as of yet.
                            </td>
                        </tr>
                        
                    <?
						}
					?>
                </tbody>
            </table>
        
        </div>
    </div>


</div>


&nbsp;


<table class="table">
    <thead>
        <tr>
            <td colspan="4">Latest Administrator Activity</td>
        </tr>
    </thead>
    <tbody>
        <tr class="category">
            <td style="width: 300px;">Administrator</td>
            <td style="width: 300px;">Username</td>
            <td>Page</td>
            <td style="width: 300px;">Last Activity</td>
        </tr>
		<? foreach( $activity as $info ){ ?>
            
            <tr>
            
                <td>
					<b><? echo $administrators[$info['admin']]['name']; ?></b>
                </td>
                
                <td>
					<? echo $administrators[$info['admin']]['username']; ?>
                </td>
                
                <td>
                	<a href="?a=<? echo $info['page']; ?>">
						<b><? echo $admin_pages[$info['page']]['name']; ?></b>
                    </a>
                </td>
                
                <td>
					<? parseDate( $info['date'], 2 ); ?>
                </td>
                
            </tr>
            
        <?
            }
        ?>
    </tbody>
</table> 



