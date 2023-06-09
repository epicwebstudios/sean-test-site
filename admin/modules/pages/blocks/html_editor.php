<script src="<? mainURL(); ?>/admin/editor/tinymce.min.js"></script>
<script type="text/javascript">

    function filemanager( id, value, type, win ){

        e = tinymce.activeEditor;
        t = id;
        a = type;
        s = win;

        var r = ( window.innerWidth - 30 ),
            g = ( window.innerHeight - 60 );

        if( r > 1800 && (r = 1800), g > 1200 && (g = 1200), r > 600 ){
            var d = ( (r - 20) % 138 );
            r = ( r - d + 10 );
        }

        urltype = 2, "image" == a && (urltype = 1), "media" == a && (urltype = 3);

        var o = "RESPONSIVE FileManager";
        "undefined" != typeof e.settings.filemanager_title && e.settings.filemanager_title && (o = e.settings.filemanager_title);

        var l = "key";
        "undefined" != typeof e.settings.filemanager_access_key && e.settings.filemanager_access_key && (l = e.settings.filemanager_access_key);

        var f = "";
        "undefined" != typeof e.settings.filemanager_sort_by && e.settings.filemanager_sort_by && (f = "&sort_by=" + e.settings.filemanager_sort_by);

        var m = "false";
        "undefined" != typeof e.settings.filemanager_descending && e.settings.filemanager_descending && (m = e.settings.filemanager_descending);

        var c = "";
        "undefined" != typeof e.settings.filemanager_subfolder && e.settings.filemanager_subfolder && (c = "&fldr=" + e.settings.filemanager_subfolder);

        var v = "";
        "undefined" != typeof e.settings.filemanager_crossdomain && e.settings.filemanager_crossdomain && (v = "&crossdomain=1", window.addEventListener ? window.addEventListener("message", n, !1) : window.attachEvent("onmessage", n)),

            tinymce.activeEditor.windowManager.open(
                {
                    title: o,
                    file: e.settings.external_filemanager_path + "dialog.php?type=" + urltype + "&descending=" + m + f + c + v + "&lang=" + e.settings.language + "&akey=" + l,
                    width: r,
                    height: g,
                    resizable: !0,
                    maximizable: !0,
                    inline: 1
                },
                {
                    setUrl: function(n){
                        var i = s.document.getElementById(t);
                        if (i.value = e.convertURL(n), "createEvent" in document) {
                            var a = document.createEvent("HTMLEvents");
                            a.initEvent("change", !1, !0), i.dispatchEvent(a)
                        } else i.fireEvent("onchange")
                    }
                }
            )

    }
	
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
		fontsize_formats:			'8px 10px 12px 14px 16px 18px 20px 24px 36px 48px 72px',
		toolbar1: 					'styleselect fontsizeselect forecolor backcolor | bold italic underline strikethrough superscript subscript | alignleft aligncenter alignright alignjustify',
		toolbar2: 					'undo redo | bullist numlist outdent indent | grid | link anchor image youtube vimeo soundcloud shortcode | code fullscreen',
		image_advtab: 				true,
		content_css: 				[<? echo editor_stylesheets(); ?>,'<? echo returnURL().'/sources/css/editor.css?'.time(); ?>','<? echo returnURL().'/sources/css/block.css?'.time(); ?>'],
		extended_valid_elements: 	'*[*]',
		valid_children : 			'+body[style]',
		verify_html: 				false,
        link_class_list: 			[
										{ title: 'Link', value: '' },
										{ title: 'Button', value: 'btn' }
									],
		removed_menuitems: 			'newdocument',
		height: 					'500px',
        // forced_root_block: 		'',
		external_filemanager_path: 	'<? mainURL(); ?>/admin/filemanager/',
		filemanager_title: 			'File Manager',
		external_plugins: 			{ 'filemanager' : '<? mainURL(); ?>/admin/filemanager/plugin.min.js'},
        codemirror: 				{
										indentOnInit: true,
										fullscreen: false,
										config: {
											mode: 'application/x-httpd-php',
											lineNumbers: true
										},
										width: 800,
										height: 600,
										saveCursorPosition: true,
										cssFiles: [
											'theme/neat.css',
											'theme/elegant.css'
										],
										jsFiles: [
											'mode/clike/clike.js',
											'mode/php/php.js',
										]
									},
        file_browser_callback: 		function( field_name, url, type, win ){
										func_value = win.document.getElementById( field_name ).value;
										filemanager( field_name, func_value, type, win );
									}
	});
	
</script>