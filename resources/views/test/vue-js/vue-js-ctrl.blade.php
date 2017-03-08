<?php
/**
 * Created by PhpStorm.
 * User: Albert Lin
 * Date: 2017/3/9
 * Time: 上午 12:30
 */
?>

<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<script src=" https://unpkg.com/vue"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

</head>
<body>

</body>
</html>
<script>

	var ctrlData;
	var conponents = [];

	$(function(){
		ctrlData = {!! $data !!};
		console.log(ctrlData);
	});

</script>

