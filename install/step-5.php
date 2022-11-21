<?
		
		
	$path = explode( '/install', dirname(__FILE__) );
	$path = $path[0];


	$output = array(
		'success' 	=> false,
		'progress'	=> 84,
		'next_step'	=> 6,
		'message' 	=> '',
		'html'		=> '',
	);
	
	
	$website_url = explode( '/install', $_SERVER['SCRIPT_URI'] );
	$website_url = $website_url[0];
	
	
	$contents  = '';
	$contents .= 'User-Agent: *' . "\n";
	$contents .= 'Disallow: /' . "\n";
	file_put_contents( $path.'/robots.txt', $contents );
	
	
	$contents  = '';
	$contents .= '# Enable Compression' . "\n";
	$contents .= '<IfModule deflate_module>' . "\n";
	$contents .= "\t" . '<IfModule filter_module>' . "\n";
	$contents .= "\t" . "\t" . 'AddOutputFilterByType DEFLATE text/plain text/html' . "\n";
	$contents .= "\t" . "\t" . 'AddOutputFilterByType DEFLATE text/xml application/xml application/xhtml+xml application/xml-dtd' . "\n";
	$contents .= "\t" . "\t" . 'AddOutputFilterByType DEFLATE application/rdf+xml application/rss+xml application/atom+xml image/svg+xml' . "\n";
	$contents .= "\t" . "\t" . 'AddOutputFilterByType DEFLATE text/css text/javascript application/javascript application/x-javascript' . "\n";
	$contents .= "\t" . "\t" . 'AddOutputFilterByType DEFLATE font/opentype application/font-otf application/x-font-otf' . "\n";
	$contents .= "\t" . "\t" . 'AddOutputFilterByType DEFLATE font/truetype application/font-ttf application/x-font-ttf' . "\n";
	$contents .= "\t" . '</IfModule>' . "\n";
	$contents .= '</IfModule>' . "\n";
	$contents .= "\n";
	$contents .= 'IndexIgnore *' . "\n";
	$contents .= 'Options -Indexes' . "\n";
	$contents .= "\n";
	$contents .= 'RewriteEngine On' . "\n";
	$contents .= "\n";
	$contents .= '# RewriteCond %{SERVER_PORT} 80' . "\n";
	$contents .= '# RewriteRule ^(.*)$ https://www.domain.com/$1 [R=301,L]' . "\n";
	$contents .= "\n";
	$contents .= '# RewriteCond %{HTTP_HOST} !^www.domain.com$' . "\n";
	$contents .= '# RewriteRule (.*) http://www.domain.com/$1 [R=301,L]' . "\n";
	$contents .= "\n";
	$contents .= 'RewriteCond %{REQUEST_FILENAME} !-f' . "\n";
	$contents .= 'RewriteCond %{REQUEST_FILENAME} !-d' . "\n";
	$contents .= 'RewriteRule ^image(.*)$ /core/image/index.php?act=$1 [L,QSA]' . "\n";
	$contents .= "\n";
	$contents .= 'RewriteCond %{REQUEST_FILENAME} !-f' . "\n";
	$contents .= 'RewriteCond %{REQUEST_FILENAME} !-d' . "\n";
	$contents .= 'RewriteRule ^(.*)$ index.php?act=$1 [L,QSA]' . "\n";
	$contents .= "\n";
	$contents .= '# php -- BEGIN cPanel-generated handler, do not edit' . "\n";
	$contents .= '# Set the “ea-php72” package as the default “PHP” programming language.' . "\n";
	$contents .= '<IfModule mime_module>' . "\n";
	$contents .= '  AddType application/x-httpd-ea-php72 .php .php7 .phtml' . "\n";
	$contents .= '</IfModule>' . "\n";
	$contents .= '# php -- END cPanel-generated handler, do not edit' . "\n";
	file_put_contents( $path.'/.htaccess', $contents );
	
	
	$contents  = '';
	$contents .= 'IndexIgnore *' . "\n";
	$contents .= 'Options -Indexes' . "\n";
	$contents .= "\n";
	$contents .= 'RewriteEngine On' . "\n";
	$contents .= "\n";
	$contents .= 'RewriteCond %{REQUEST_FILENAME} !-f' . "\n";
	$contents .= 'RewriteCond %{REQUEST_FILENAME} !-d' . "\n";
	$contents .= 'RewriteRule ^(.*)$ index.php [L,QSA]' . "\n";
	$contents .= "\n";
	$contents .= '<IfModule mod_security.c>' . "\n";
	$contents .= '	SecFilterEngine Off' . "\n";
	$contents .= '	SecFilterScanPOST Off' . "\n";
	$contents .= '</IfModule>' . "\n";
	$contents .= "\n";
	$contents .= '# php -- BEGIN cPanel-generated handler, do not edit' . "\n";
	$contents .= '# Set the “ea-php72” package as the default “PHP” programming language.' . "\n";
	$contents .= '<IfModule mime_module>' . "\n";
	$contents .= '	AddType application/x-httpd-ea-php72 .php .php7 .phtml' . "\n";
	$contents .= '</IfModule>' . "\n";
	$contents .= '# php -- END cPanel-generated handler, do not edit' . "\n";
	file_put_contents( $path.'/admin/.htaccess', $contents );
	
	
	$output['success'] = true;
	
	$output['html'] .= '<h3>Configuration Setup Successfully</h3>';
	$output['html'] .= '<p>Your new website has been configured successfully.</p>';
	$output['html'] .= '<p><b>Now we will set up some automatic processes and syncing...</b></p>';
	$output['html'] .= '<p><input type="submit" value="Setup Automatic Processes"></p>';


	echo json_encode( $output );
	die();

