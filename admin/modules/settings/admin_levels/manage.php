<? $info = get_item( $_GET['i'], $database[0] ); ?>


<div class="ca title_box">

    <div class="l">
        <h1><? if( $_GET['act'] == 'add' ){ echo 'Add New'; } else { echo 'Editing'; } ?> <? echo $item_capital; ?></h1>
    </div>
    
    <div class="l">
		<input type="button" value="Return to all <? echo $item_plural_capital; ?>" onclick="window.location = '<? echo $base_url; ?>';">
    </div>
    
    <div class="r">
    </div>

</div>


<form 
	id="page_editor"
    method="post"
    enctype="multipart/form-data"
    action="<? echo $base_url; if( $_GET['act'] == 'edit' ){ echo '&act='.$_GET['act'].'&i='.$_GET['i']; } ?>"
>

    <? field_hidden( 'id', $info['id'] ); ?>
    
	<table class="form">
		<thead>
			<tr>
				<td colspan="2"><? echo $item_capital; ?> Information</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="left">Name:</td>
				<td class="right">
                	<? field_text( 'name', $info['name'] ); ?>
                </td>
			</tr>
			<tr>
				<td class="left">Can Create Pages?</td>
				<td class="right">
                	<?
                    	$options = array( 1 => 'Yes', 0 => 'No' );
						field_select2( 'add_page', $options, $info['add_page'] );
					?>
                </td>
			</tr>
			<tr>
				<td class="left">Status:</td>
				<td class="right">
                	<?
						$options = array( 1 => 'Active / Enabled', 0 => 'Inactive / Disabled' );
                    	field_select2( 'status', $options, $info['status'] );
					?>
                </td>
			</tr>
		</tbody>
	</table>
	
	&nbsp;
    
    <? if( $info['id'] != '1' ){ ?>
    
		<script>
            
            $( document ).ready( function(){
                $( '.admin_page' ).change( function(){
                    
                    var id 		= $( this ).attr( 'data-id' );
                    var parents = $( this ).attr( 'data-parents' );
                    parents		= parents.split( ',' );
                    
                    if( $(this).is(':checked') ){
                        
                        $( '.child_of_' + id ).prop( 'checked', true );
                        
                        for( var i=0; i<=parents.length; i++ ){
                            $( '.admin_page_' + parents[i] ).prop( 'checked', true );
                        }
                        
                    } else {
                        $( '.child_of_' + id ).prop( 'checked', false );
                    }
                    
                });
            });
            
        </script>
    
        <table class="table">
            <thead>
                <tr>
                    <td colspan="200">
                        Administrative Pages
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr class="category">
                    <td>
                    	If you allow access to a child item, the parent item becomes "allowed" by default. Removing access to a parent
                        item removes access to all children.
                    </td>
                </tr>
                
                <? 
                    
                    $checked = array();
                    if( $_GET['act'] == 'edit' ){ 
                        $rQ = mysql_query( "SELECT `page` FROM `".$database[1]."` WHERE `level` = '".$_GET['i']."' ORDER BY `page` ASC" );
                        while( $r = mysql_fetch_assoc($rQ) ){
                            $checked[] = $r['page'];
                        }
                    }
                    
                    $items = menu_items_array( 'listing' );
                    if( count($pages) > 0 ){
                        foreach( $items as $info ){
                            
                            $class = 'admin_page admin_page_'.$info['id'];
                            $parents = explode( ',', $info['parent_list'] );
                            if( count($parents) > 0 ){
                                foreach( $parents as $parent ){
                                    $class .= ' child_of_'.$parent;
                                }
                            }
                            
                ?>
            
                    <tr class="no-border">
                        <td>
                            <label>
                                <input
                                    type="checkbox"
                                    name="admin_page[]"
                                    value="<? echo $info['id']; ?>"
                                    data-id="<? echo $info['id']; ?>"
                                    data-parents="<? echo $info['parent_list']; ?>"
                                    class="<? echo $class; ?>"
                                    style="margin-right: 5px;"
                                    <? if( in_array($info['id'], $checked) ){ ?>
                                        checked="checked"
                                    <? } ?>
                                />
                                <? echo $info['label']; ?>
                            </label>
                            
                        </td>
                    </tr>
                
                <?
                        }
                    } else {
                ?>
        
                    <tr>
                        <td colspan="200" align="center">
                            There are currently no <? echo $item_plural; ?> in the system.
                        </td>
                    </tr>
                
                <?
                    }
                ?>
               
            </tbody>
        </table>
        
        &nbsp;
    
        <table class="table">
            <thead>
                <tr>
                    <td colspan="200">
                        Front-End Pages
                    </td>
                </tr>
            </thead>
            <tbody>
            	<tr class="category">
                	<td>
                    	The following are the individual pages of the website. You can grant this level individual access to edit/delete 
                        to each page as desired. This is only needed if this level can access the "Pages" menu.
                    </td>
              	</tr>
                
                <? 
                    
                    $unchecked = array();
                    if( $_GET['act'] == 'edit' ){ 
                        $rQ = mysql_query( "SELECT `page` FROM `".$database[3]."` WHERE `level` = '".$_GET['i']."' ORDER BY `page` ASC" );
                        while( $r = mysql_fetch_assoc($rQ) ){
                            $unchecked[] = $r['page'];
                        }
                    }
					
					$rQ = mysql_query( "SELECT `id`, `name` FROM `".$database[2]."` ORDER BY `name` ASC" );
                    if( mysql_num_rows($rQ) > 0 ){
                        while( $info = mysql_fetch_assoc($rQ) ){
                            
                ?>
            
                    <tr class="no-border">
                        <td>
                            <label>
                                <input
                                    type="checkbox"
                                    name="page_<? echo $info['id']; ?>"
                                    value="1"
                                    style="margin-right: 5px;"
                                    <? if( !in_array($info['id'], $unchecked) ){ ?>
                                        checked="checked"
                                    <? } ?>
                                />
                                <? echo $info['name']; ?>
                            </label>
                            
                        </td>
                    </tr>
                
                <?
						}
                    } else {
                ?>
        
                    <tr>
                        <td colspan="200" align="center">
                            There are currently no <? echo $item_plural; ?> in the system.
                        </td>
                    </tr>
                
                <?
                    }
                ?>
               
            </tbody>
        </table>
        
        &nbsp;
        
    <? } ?>
	
	<div>
		
        <input
        	type="submit"
            name="<? if( $_GET['act'] == 'edit' ){ echo 'edit'; } else { echo 'add'; } ?>_sub"
            value="Save <? echo $item_capital; ?>"
        >
        
	</div>
  
</form>

<?
	
	// AJAX Table/Records
	
	/*
	if( $_GET['act'] == 'edit' ){
		ajax_section( 'template' );
	}
	*/
	
?>

<?
	if( $_GET['act'] == 'add' ){
		browser_title( 'Add New '.$item_capital );
	} else {
		browser_title( 'Editing '.$item_capital );
	}
?>




