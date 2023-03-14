<? global $settings, $system, $page; ?>
<? require_once dirname( __FILE__ ).'/includes/head.php'; ?>

    <div class="viewport">
        <div class="site_container">
    
    
            <!-- Header -->
            <? require_once dirname( __FILE__ ).'/includes/header.php'; ?>
            
    
            <!-- Page Content -->
            <div class="page page_<? echo $page['id']; ?>">
                
                <div class="section">
                	<div class="wrapper">
                    
                    
                    	<? if( $error_msg ){ ?>
                            <div class="notify notify-error">
                            	<h4>We're Sorry...</h4>
                                <div><? echo $error_msg; ?></div>
                            </div>
                        <? } ?>
                
                        	
						<form method="post">
                        	<div class="tc protected_page form">
                            
                                <h3>
                                    This page is password protected.
                                </h3>
                                
                                <div>
                                    Please enter the password to access this page.
                                </div>
                                
                                <div class="field">
                                    <input type="password" name="password" placeholder="Enter Page Password" />
                                </div>
                                
                                <div class="button" >
                                    <input type="submit" name="password_submit" value="Access Page" />
                                </div>
                            
                        	</div>
						</form>
                        
                
                	</div>
                </div>
                
            </div>
            
    
        </div>
    
    
        <!-- Footer -->
        <? require_once dirname( __FILE__ ).'/includes/footer.php'; ?>
            
        
        <? mobile_menu( 1 ); ?>
        
        
    </div>

<? require_once dirname( __FILE__ ).'/includes/foot.php'; ?>