<style>
	
	input[type=file],
	input[type=file]::-webkit-file-upload-button { cursor: pointer; }
	#deep_search { width: 300px; }
	#deep_search_clear { display: none; }
	.breadcrumb a { color: inherit; }
	.breadcrumb .fa-folder { margin-right: .5em; }
	.table tbody td.icon { padding: 0; border-right: 1px solid #DEE2E6; background-color: #FAFAFA; }
	.icon span { position: absolute; z-index: 5; top: 50%; left: 50%; transform: translate(-50%,-50%); font-size: 1.25em; }
	.icon a { position: absolute; z-index: 10; top: 0; left: 0; right: 0; bottom: 0; display: block; width: 100%; height: 100%; }
	.icon div { position: absolute; z-index: 5; top: 0; left: 0; right: 0; bottom: 0; display: block; width: 100%; height: 100%; background-position: center center; background-repeat: no-repeat; background-size: cover; }
	.icon .fa-arrow-left { color: #999 !important; }
	.icon .fa-file-image { color: #FFF !important; }
	.icon .fa-file-video { color: #CE1312 !important; }
	.icon .fa-file-audio { color: #9558B4 !important; }
	.icon .fa-file-word { color: #103F91 !important; }
	.icon .fa-file-spreadsheet,
	.icon .fa-file-csv { color: #185C37 !important; }
	.icon .fa-file-powerpoint { color: #B8391A !important; }
	.icon .fa-file-pdf { color: #EF0013 !important; }
	.icon .fa-file-alt { color: #333 !important; }
	.icon .fa-file-code { color: #0A3000 !important; }
	.breadcrumb .fa-folder,
	.icon .fa-folder,
	.icon .fa-file-archive { color: #FFDA5B !important; }
	.tc_l_grey { color: #999; }
	
	/* File Uploader */
	
	.file-uploader,
	.file-uploader * { 
		cursor: pointer;
	}
	
	.file-uploader span {
		display: none;
	}
	
	.ajax-file-upload-error {
		display: none;
	}
	
	.file-uploader:hover a.btn { 
		opacity: .85;
	}

	.ajax-file-upload {
		font-family: inherit;
		font-size: inherit;
		line-height: inherit;
		margin: 0;
		padding: 0;
		font-weight: normal;
		height: auto;
		background: none;
		border: 0;
		border-radius: 0;
		box-shadow: none;
	}

	.ajax-file-upload:hover {
		background: none;
		box-shadow: none;
	}

	.ajax-file-upload:hover input[type="button"] {
		background-color: transparent;
		color: #FFF;
	}

	.ajax-upload-dragdrop {
		padding: 0;
	}

	.ajax-file-upload-statusbar {
		display: inline-block;
		float: none;
		border: 1px solid rgba(0,0,0,.15);
	}

	.ajax-file-upload-progress {
		margin-left: 5px;
	}

	.ajax-file-upload-bar {
		border-radius: 2px;
	}

	.ajax-file-upload { 
		overflow: inherit !important;
	}

	.breadcrumb .actions .ilb {
		vertical-align: middle;
	}

	.ajax-upload-dragdrop {
		vertical-align: middle;
		width: auto !important;
	}

	#upload_queue {
		z-index: 100000;
		left: 0;
		right: 0;
		bottom: 0;
		overflow-x: auto;
		white-space: nowrap;
	}

	#upload_queue::-webkit-scrollbar {
		width: 10px;
	}

	#upload_queue::-webkit-scrollbar-track {
		background: transparent; 
	}

	#upload_queue::-webkit-scrollbar-track:hover {
		background-color: rgba(0,0,0,.1);
	}

	#upload_queue::-webkit-scrollbar-thumb {
		background: #999;
	}

	#upload_queue::-webkit-scrollbar-thumb:hover {
		  background: #666; 
	}

</style>