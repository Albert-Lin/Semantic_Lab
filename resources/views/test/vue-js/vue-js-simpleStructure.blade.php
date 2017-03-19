<?php
/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/3/17
 * Time: 下午 05:34
 */?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="//d3js.org/d3.v4.0.0-alpha.4.min.js"></script>
    <script src=" http://semanticlab.com/js/Dom.js"></script>
    <script src=" http://semanticlab.com/js/test/d3/d3_plugin.js"></script>
    <script src=" http://semanticlab.com/js/vue/Template.js"></script>

	<style>
		html, body, #root{
			background-color: #333333;
			padding: 0;
			border: 0;
			margin: 0;
		}
	</style>

</head>
<body>

    <div id="root">
        <component :is="currentTemplate.template" :prop="currentTemplate.prop"></component>
	    <button v-on:click="changeTemp('temp0')">change</button>
    </div>

</body>
</html>
<script>
    var ctrlData = {!! $ctrlData !!};

    var templates = [];
    let blank = new Template({
    	template: 'blank',
        block0: {
			componentData: [ctrlData[0], ctrlData[1], ctrlData[2], ctrlData[3], ctrlData[4], ctrlData[5]],
        },
    }).config;

    let temp0 = new Template({
    	template: 'temp0',
		block0: {
			componentData: [ctrlData[4], ctrlData[5]],
			lg: [0, 4],
			md: [0, 6],
		},
		block1: {
			componentData: [ctrlData[2], ctrlData[3]],
			lg: [3, 3],
			md: [0, 6],
		},
		block2: {
			componentData: [ctrlData[0], ctrlData[1]],
			lg: [2, 4],
			md: [0, 6],
		},
    }).config;

	templates.push(blank, temp0);
</script>
<script src=" http://semanticlab.com/js/vue/test/Root.js"></script>