<?php
/**
 * Created by PhpStorm.
 * User: Albert Lin
 * Date: 2017/3/28
 * Time: 上午 12:46
 */
?>

<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>{{ $title }}</title>
</head>
<body>


	<div id="root">
		<component :is="data.component"></component>
	</div>


</body>
</html>
<script src="http://semanticlab.com/js/vue/test/es6Extends.js"></script>