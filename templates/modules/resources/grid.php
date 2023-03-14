<div class="tc resources_grid">
<?
	foreach( $files as $file ){	
		echo '<div class="ilb w_25">';
?>

    <div class="resource p_a" data-id="<?= $file['id'] ?>">
    
    	<div class="icon">
            <a href="<? echo $file['url']; ?>" target="_blank">
        		<span class="fa <? echo $file['icon']; ?>"></span>
            </a>
        </div>
    
        <div class="name">
            <a href="<? echo $file['url']; ?>" target="_blank">
                <b><? echo $file['name']; ?></b>
            </a>
        </div>
        
        <div class="description">
            <? echo $file['description']; ?>
        </div>
        
    </div>

<?
		echo '</div>';
	}
?>
</div>