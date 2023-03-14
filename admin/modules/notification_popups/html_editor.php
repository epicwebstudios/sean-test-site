<script src="<? mainURL(); ?>/admin/editor/tinymce.min.js"></script>
<script type="text/javascript">
	
	function file_manager( field_name, url, type, win ){
		
		var editor 	= tinymce.activeEditor;
		var w		= ( window.innerWidth * .75 );
		var h		= ( window.innerHeight * .75 );
		var browser	= '';
		browser		+= '<? mainURL(); ?>/admin/files/index.php?';
		browser		+= '&callback=' + field_name;
		browser		+= '&type=' + type;
		//browser	+= '&directory=/uploads/forms';
		if( url ){
			browser	+= '&file=' + url;
		}
		
		tinymce.activeEditor.windowManager.open(
			{
				title: 'File Manager',
				file: browser,
				width: w,
				height: h,
				resizable: !0,
				maximizable: !0,
				inline: 1
			}
		);
		
	}
	
	tinymce.init({
		selector: 					'textarea.editor',
		theme: 						'modern',
		plugins: 					[
										'advlist autolink lists link image charmap hr anchor pagebreak',
										'searchreplace wordcount visualblocks visualchars code fullscreen',
										'media nonbreaking table contextmenu directionality',
										'emoticons paste textcolor colorpicker textpattern imagetools',
										'youtube vimeo shortcode grid soundcloud codemirror'
									],
		fontsize_formats:			'8px 10px 12px 14px 16px 18px 20px 24px 36px 48px 72px',
		toolbar1: 					'styleselect fontsizeselect forecolor backcolor | bold italic underline strikethrough superscript subscript | alignleft aligncenter alignright alignjustify',
		toolbar2: 					'undo redo | bullist numlist outdent indent | grid | link anchor image youtube vimeo soundcloud shortcode | code fullscreen',
		image_advtab: 				true,
		content_css: 				[<? echo editor_stylesheets(); ?>,'<? echo returnURL().'/sources/css/editor.css?'.time(); ?>', '<? echo $dir_url.'/src/editor.css?'.time(); ?>'],
		extended_valid_elements: 	'*[*]',
		valid_children : 			'+body[style]',
		verify_html: 				false,
        link_class_list: 			[
										{ title: 'Standard Link', value: '' },
										{ title: 'Button', value: 'btn' }
									],
		removed_menuitems: 			'newdocument',
		height: 					'300px',
        //forced_root_block: 		'',
		link_list: 					'<? mainURL(); ?>/admin/sources/php/link_list.php',
		imagetools_toolbar: 		'rotateleft rotateright | imageoptions',
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
        file_browser_callback: 		function( field_name, url, type, win ){
										file_manager( field_name, win.document.getElementById( field_name ).value, type, win );
									}
	});
	
</script>