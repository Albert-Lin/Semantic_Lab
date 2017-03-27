<?php
/**
 * Created by PhpStorm.
 * User: Albert Lin
 * Date: 2017/3/26
 * Time: 上午 08:28
 */
?>

<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>{{ $title }}</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<style>
		html, body, #sideBarRoot{
			width: 100%;
			height: 100%;
			background-color: #333333;
			padding: 0;
			border: 0;
			margin: 0;
		}
	</style>
</head>
<body>

	<div id="sideBarRoot">
		<animated_v_sidebar :prop="prop"></animated_v_sidebar>
	</div>

</body>
</html>
<script src="http://semanticlab.com/js/vue/test/SideBarRoot.js"></script>
