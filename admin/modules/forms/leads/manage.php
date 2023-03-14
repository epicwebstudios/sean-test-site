<? $info = get_item( $_GET['i'], $database[0] ); ?>


<div class="ca title_box">

    <div class="l">
        <h1><? if( $_GET['act'] == 'add' ){ echo 'Add New'; } else { echo 'Viewing'; } ?> <? echo $item_capital; ?></h1>
    </div>
    
    <div class="l">
		<input type="button" value="Return to all <? echo $item_plural_capital; ?>" onclick="window.location = '<? echo $base_url; ?>';">
    </div>
    
    <div class="r">
    </div>

</div>

<table class="form">
	<thead>
		<tr>
			<td colspan="2"><? echo $item_capital; ?> Information</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="left">Submission ID:</td>
			<td class="right black">
				<div><? echo $info['id']; ?></div>
			</td>
		</tr>
		<tr>
			<td class="left">Form:</td>
			<td class="right black">
				<div><? echo $forms[$info['form']]; ?></div>
			</td>
		</tr>
		<tr>
			<td class="left">Last Edit Date:</td>
			<td class="right black">
				<div><? echo date( 'n/j/Y, g:i A', $info['date'] ); ?></div>
			</td>
		</tr>
		<tr>
			<td class="left">IP Address:</td>
			<td class="right black">
				<div><? echo $info['ip']; ?></div>
			</td>
		</tr>
		<tr>
			<td class="left">Browser:</td>
			<td class="right black">
				<div><? echo $info['browser']; ?></div>
			</td>
		</tr>
	</tbody>
</table>

<?
	$fields = json_decode( $info['fields'], true );
	if( is_array($fields) ){
?>
        
    &nbsp;
    
    <table class="form">
        <thead>
            <tr>
                <td colspan="2"><? echo $item_capital; ?> Entries</td>
            </tr>
        </thead>
        <tbody>
            <? foreach( $fields as $field ){ ?>
            	<? if( $field['value'] != '' ){ ?>
                    <tr>
                        <td class="left"><? echo $field['label']; ?>:</td>
                        <td class="right black">
                            <div><? echo nl2br( $field['value'] ); ?></div>
                        </td>
                    </tr>
                <? } ?>
            <? } ?>
        </tbody>
    </table>

<?
	}
?>

&nbsp;

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
		browser_title( 'Viewing '.$item_capital );
	}
?>




