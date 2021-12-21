<table>
	<thead>
        <tr>
            <td colspan="2">File</td>
            <td>Date</td>
            <td>Download</td>
		</tr>
	</thead>
    <tbody>
        
		<? foreach( $files as $file ){ ?>
        	
            <tr class="resource" data-id="<?= $file['id'] ?>">
            
            	<td>
                    <span class="fa <? echo $file['icon']; ?>"></span>
                </td>
                
            	<td>
					<div class="name">
						<a href="<? echo $file['url']; ?>" target="_blank">
							<b><? echo $file['name']; ?></b>
                        </a>
                    </div>
                    <div class="description">
						<? echo $file['description']; ?>
                    </div>
                </td>
                
                <td>
                    <? echo date( 'n/j/Y', $file['date'] ); ?>
                </td>
                
                <td>
                    <a href="<? echo $file['url']; ?>" target="_blank" class="btn">Download</a>
                </td>
                
			</tr>
            
		<? } ?>
        
    </tbody>
</table>