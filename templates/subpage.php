<? global $settings, $system, $page; ?>
<? require_once dirname( __FILE__ ).'/includes/head.php'; ?>

    <div class="viewport">
        <div class="site_container">
    
    
            <!-- Header -->
            <? require_once dirname( __FILE__ ).'/includes/header.php'; ?>
            
    
            <!-- Page Content -->
            <div class="page page_<? echo $page['id']; ?>">
                <? require_once BASE_DIR.'/modules/banner/module.php'; ?>
                <? parsePage( $page['content'] ); ?>
            </div>
            
    
        </div>
    
    
        <!-- Footer -->
        <? require_once dirname( __FILE__ ).'/includes/footer.php'; ?>
            
        
        <? mobile_menu( 1 ); ?>
    
    
        <?
            /* These can be used or eliminated, depending on layout.
    
                <!-- Left Side Blocks -->
                <? 
					if( checkBlocks($page['template'], 1) ){
                    	getBlocks( $page['template'], 1 );
                	}
				?>
    
                <!-- Right Side Blocks -->
                <? 
					if( checkBlocks($page['template'], 2) ){
                    	getBlocks( $page['template'], 2 );
                	}
				?>
    
            */
        ?>
        
        
    </div>

<? require_once dirname( __FILE__ ).'/includes/foot.php'; ?>