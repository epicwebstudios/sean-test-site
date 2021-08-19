<script src="<? mainURL(); ?>/admin/editor/tinymce.min.js"></script>
<script type="text/javascript">
	
	tinymce.init({
		selector: 					'textarea.editor',
		theme: 						'modern',
		plugins: 					[
										'advlist autolink lists link image charmap hr anchor pagebreak',
										'searchreplace wordcount visualblocks visualchars code fullscreen',
										'media nonbreaking table contextmenu directionality',
										'emoticons paste textcolor colorpicker textpattern imagetools',
										'youtube vimeo shortcode responsivefilemanager, grid, soundcloud codemirror'
									],
		menubar:					false,
		toolbar1: 					'bold italic underline strikethrough superscript subscript | link code',
		image_advtab: 				true,
		content_css: 				[<? echo editor_stylesheets(); ?>,'<? echo returnURL().'/sources/css/editor.css?'.time(); ?>'],
		extended_valid_elements: 	'*[*]',
		valid_children : 			'+body[style]',
		verify_html: 				false,
        link_class_list: 			[
										{ title: 'Standard Link', value: '' },
										{ title: 'Button', value: 'btn' }
									],
		link_list: 					'<? mainURL(); ?>/admin/sources/php/link_list.php',
        codemirror: 				{
										indentOnInit: true,
										fullscreen: false,
										config: { mode: 'application/x-httpd-php', lineNumbers: true },
										width: 800,
										height: 600,
										saveCursorPosition: true,
										cssFiles: [ 'theme/neat.css', 'theme/elegant.css' ],
										jsFiles: [ 'mode/clike/clike.js', 'mode/php/php.js', ]
									},
	});
	
</script>