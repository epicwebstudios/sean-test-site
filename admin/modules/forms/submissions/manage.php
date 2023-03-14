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
			<td class="left">Log Value:</td>
			<td class="right black">
				<div><? echo $info['log_value']; ?></div>
			</td>
		</tr>
		<tr>
			<td class="left">Submitted On:</td>
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
        <? if( $info['referral'] ){ ?>
            <tr>
                <td class="left">Referring URL:</td>
                <td class="right black">
                    <div><? echo $info['referral']; ?></div>
                </td>
            </tr>
        <? } ?>
        <? if( $info['on_page'] ){ ?>
            <tr>
                <td class="left">From Page:</td>
                <td class="right black">
                    <div><? echo $info['on_page']; ?></div>
                </td>
            </tr>
        <? } ?>
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
            <?
				foreach( $fields as $field ){
            		if( $field['value'] != '' ){
						
						if( substr($field['value'], 0, 4) == 'http' ){
							$field['value'] = '<a href="'.$field['value'].'" target="_blank">'.$field['value'].'</a>';
						}
						
			?>
                    <tr>
                        <td class="left"><? echo $field['label']; ?>:</td>
                        <td class="right black">
                            <div><? echo nl2br( $field['value'] ); ?></div>
                        </td>
                    </tr>
                    
            <?
					}
				}
			?>
        </tbody>
    </table>

<?
	}
?>

<? if( ($info['emailed_to']) || ($info['email_contents']) ){ ?>
        
    &nbsp;
    
    <table class="form">
        <thead>
            <tr>
                <td colspan="2">E-mailed Submission Details</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="left">Sent To:</td>
                <td class="right black">
                    <div><? echo nl2br( $info['emailed_to'] ); ?></div>
                </td>
            </tr>
            <tr>
                <td class="left">Message:</td>
                <td class="right black">
                    <div><? echo nl2br( $info['email_contents'] ); ?></div>
                </td>
            </tr>
        </tbody>
    </table>

<? } ?>

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




