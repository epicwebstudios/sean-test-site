<? $info = get_item( $_GET['id'], $database[0] ); ?>

<script>


    function toggle_link_type(){
        $( '.link_type' ).hide();

        let id = $( '#link_type' ).val();

        $( '.link_type_' + id ).show();
    }

    $(document).ready(function() {
        toggle_link_type();
    });
</script>

<form 
	id="page_editor"
    method="post"
    enctype="multipart/form-data"
    action="<? echo $base_url; echo '?act='.$_GET['act'].'&i='.$_GET['i']; if( $_GET['act'] == 'edit' ){ echo '&id='.$_GET['id']; } ?>"
>

    <? field_hidden( 'parent', $_GET['i'] ); ?>
    <? field_hidden( 'id', $info['id'] ); ?>

    <table class="form">
        <thead>
            <tr>
                <td colspan="2">
                    <? if( $_GET['act'] == 'add' ){ echo 'Add New'; } else { echo 'Editing'; } ?>
                    <? echo $item_capital; ?>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="left">Button Text:</td>
                <td class="right">
                    <? field_text( 'text', $info['text'] ); ?>
                    <div>Will default to "Read More" if blank</div>
                </td>
            </tr>
            <tr>
                <td class="left">Link Type:</td>
                <td class="right">
                    <?
                        $link_types = array(
                            0 => array( 'name' => 'Do Not Link', 	'table' => false, 	'id' => false, 	'label' => false ),
                            1 => array( 'name' => 'External URL', 	'table' => false, 	'id' => false, 	'label' => false ),
                            2 => array( 'name' => 'Internal Page', 	'table' => 'pages', 'id' => 'id', 	'label' => 'name' ),
                        );
    
                        $link_type_options = array();
    
                        foreach( $link_types as $key => $value ){
                            $link_type_options[$key] = $value['name'];
                        }
                    ?>
                    <? field_select2( 'link_type', $link_type_options, $info['link_type'], '', 'onchange="toggle_link_type();"' ); ?>
                </td>
            </tr>
            <tr class="link_type link_type_1">
                <td class="left">External URL:</td>
                <td class="right">
                    <? field_text( 'url', $info['url'] ); ?>
                    <div>You must include the <b>http://</b> to ensure the URL functions correctly.</div>
                </td>
            </tr>
    
            <?
                foreach( $link_types as $key => $single ){
                    if( $single['table'] ){
                        $options = kv_array( $single['table'], $single['id'], $single['label'] );
                        ?>
                        <tr class="link_type link_type_<? echo $key; ?>">
                            <td class="left"><? echo $single['name']; ?>:</td>
                            <td class="right">
                                <? field_select2( 'ref_id_'.$key, $options, $info['ref_id'] ); ?>
                            </td>
                        </tr>
                        <?
                    }
                }
            ?>
            <tr>
                <td class="left">Anchor:</td>
                <td class="right">
		            <? field_text( 'anchor', $info['anchor'] ); ?>
                    <div>Element ID to link to. Do not include '#'.</div>
                </td>
            </tr>
            <tr>
                <td class="left">Status:</td>
                <td class="right">
                    <?
                        $options = array( 1 => 'Active / Visible', 0 => 'Inactive / Hidden' );
                        field_select2( 'status', $options, $info['status'] );
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
    
    &nbsp;
    
    <div>
		
        <input
        	type="submit"
            name="<? if( $_GET['act'] == 'edit' ){ echo 'edit'; } else { echo 'add'; } ?>_sub"
            value="Save <? echo $item_capital; ?>"
        >
        
        &nbsp;
        
        <input
            type="button"
            name="cancel"
            value="Cancel"
            onclick="window.parent.lb_close();"
        >
        
    </div>

</form>