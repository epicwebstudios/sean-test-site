<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,700">
		<link rel="stylesheet" href="https://css.ewsapi.com/reset/reset.min.css">
		<link rel="stylesheet" href="https://css.ewsapi.com/global/global.v3.css">
		<link rel="stylesheet" href="https://css.ewsapi.com/icons/fa5/icons.min.css">
		<link rel="stylesheet" href="src/dnd-uploader.css?<? echo time(); ?>">
		<link rel="stylesheet" href="src/stylesheet.css?<? echo time(); ?>">
		<style>
			.error {
				position: fixed;
				top: 50%;
				left: 0;
				right: 0;
				padding: 0 2em;
				transform: translateY(-50%);
				font-size: 1.5em;
				font-weight: bold;
				color: #B32527;
			}
		</style>
	</head>

	<body>
		<div class="tc error"><? echo $error; ?></div>
	</body>
	
</html>