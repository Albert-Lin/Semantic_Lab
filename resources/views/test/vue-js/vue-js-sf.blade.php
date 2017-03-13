<?php
/**
 * Created by PhpStorm.
 * User: Albert Lin
 * Date: 2017/3/12
 * Time: 下午 03:28
 */
?>

<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>
<body>
	<div id="singleFile">
		<comment v-for="obj in info" :is="obj.component" :prop="obj.prop" ></comment>
		<input type="text" v-model="name" />
		<input type="text" v-model="mvp" />
		<input type="text" v-model="team" />
	</div>
</body>
</html>
<script>
	var passData = passData = {!! $data !!};

	function getPassData(){
		return passData;
	}
</script>
<script src=" http://semanticlab.com/js/vue/test/vueSf.js"></script>
