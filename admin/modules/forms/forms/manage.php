<?
	
	$info = get_item( $_GET['i'], $database[0] );
	
	if( ($_GET['act'] == 'add') || ($info['button_text'] == '') ){ 
		$info['button_text'] = 'Submit';
	}
	
?>


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

<? if( $_GET['act'] == 'edit' ){ ?>
	<script>
    
        function reload_log_fields(){
        
			var selected = $( '#log_field' ).val();
		
            var request = $.ajax({
                url: ajax_url + '/log_fields.php?i=<? echo $info['id']; ?>&s=' + selected,
                type: 'get'
            });
            
            request.done( function( response, textStatus, jqXHR ){
                $( '#log_field' ).html( response );
            });
        
        }
    
    </script>
<? } ?>


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
                <td class="left">Description:</td>
                <td class="right">
                    <? field_textarea( 'description', $info['description'] ); ?>
                </td>
            </tr>
            <tr>
                <td class="left">Submit Button Text:</td>
                <td class="right">
                    <? field_text( 'button_text', $info['button_text'] ); ?>
                </td>
            </tr>
            <? if( $_GET['act'] == 'edit' ){ ?>
                <tr>
                    <td class="left">Log Field:</td>
                    <td class="right">
                        <? field_select( 'log_field', $log_fields, $info['log_field'] ); ?>
                        <div>This information in this field will be displayed in "Form Submissions" for each submission.</div>
                    </td>
                </tr>
            <? } ?>
            <tr>
                <td class="left">Contact E-mails:</td>
                <td class="right">
                    <? field_textarea( 'email_to', $info['email_to'] ); ?>
                    <div>The e-mail addresses which will be sent a copy of all submissions.</div>
                    <div>Seperate multiple e-mail addreses with a comma.</div>
                </td>
            </tr>
			<tr>
				<td class="left">Thank You Page:</td>
				<td class="right">
                	<? field_select2( 'thank_you', $site_pages, $info['thank_you'] ); ?>
                    <div>The page to redirect the user to upon submission of the form.</div>
                </td>
			</tr>
			<tr>
				<td class="left">Lead Capture:</td>
				<td class="right">
                	<?
						$options = array( 1 => 'Enabled', 0 => 'Disabled' );
                    	field_select2( 'lead_capture', $options, $info['lead_capture'] );
					?>
                    <div>If enabled, the system will capture data as the user inputs it into the form.</div>
					<div>With this enabled, you can see forms that are partially filled out and/or not submitted.</div>
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
            <? if( $_GET['act'] == 'edit' ){ ?>
                <tr>
                    <td class="left">Submissions:</td>
                    <td class="right">
						<div>
                       		<a href="?a=45&f_f=<? echo $info['id']; ?>">
                            	View All Submissions
                            </a>
                        </div>
                    </td>
                </tr>
            <? } ?>
            <? if( $_GET['act'] == 'edit' ){ ?>
            	<? if( $info['lead_capture'] == '1' ){ ?>
                    <tr>
                        <td class="left">Leads:</td>
                        <td class="right">
                        	<div>
                            	<a href="?a=60&f_f=<? echo $info['id']; ?>">
                                	View All Lead Captures
                                </a>
                            </div>
                        </td>
                    </tr>
            	<? } ?>
            <? } ?>
            <tr>
                <td class="left">Google Recaptcha V2:</td>
                <td class="right">
                    <?
                    $options = array( 0 => 'Inactive / Disabled',1 => 'Active / Enabled' );
                    field_select2( 'recaptcha', $options, $info['recaptcha'] );
                    ?>
                    <div>Please <a href="https://www.google.com/recaptcha/admin" target="_blank">register</a> the domain and get the site keys for this option.</div>
                </td>
            </tr>
		</tbody>
	</table>

    &nbsp;

    <table class="form recaptcha-setting recaptcha-setting-1">
        <thead>
        <tr><td colspan="2">reCAPTCHA API Keys</td></tr>
        </thead>
        <tbody>
        <tr>
            <td class="left">Site Key:</td>
            <td class="right"><? field_text( 'recaptcha_site_key', $info['recaptcha_site_key'] ); ?></td>
        </tr>
        <tr>
            <td class="left">Secret Key:</td>
            <td class="right"><? field_text( 'recaptcha_secret_key', $info['recaptcha_secret_key'] ); ?></td>
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
        
	</div>
  
</form>

<?

	if( $_GET['act'] == 'edit' ){
		ajax_section( 'fields' );
	}
	
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

<script>
    $(function() {
        bind_toggle('#recaptcha', 'recaptcha-setting');
    });
</script>


