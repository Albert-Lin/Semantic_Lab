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
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="//d3js.org/d3.v4.0.0-alpha.4.min.js"></script>
	<script src=" http://semanticlab.com/js/vue/Template.js"></script>
	<script src=" http://semanticlab.com/js/vue/vueConfig.js"></script>

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
        <component v-if="info.length > 0" :is="currentTemplate.template" :prop="currentTemplate.prop" ref="currentTemplateRef"></component>
	    <button v-on:click="changeTemp('temp0')">change</button>
    </div>

</body>
</html>
<script>

    {{--var serviceData = {!! $ctrlData !!};--}}

//	config.setTemplate({
//		template: 'blank',
//		block0: {
//			componentData: [serviceData[0], serviceData[1], serviceData[2], serviceData[3], serviceData[4], serviceData[5]],
//		},
//	})
//		.setTemplate({
//			template: 'temp0',
//			block0: {
//				componentData: [serviceData[4], serviceData[5]],
//				lg: [0, 4],
//				md: [0, 6],
//			},
//			block1: {
//				componentData: [serviceData[2], serviceData[3]],
//				lg: [3, 3],
//				md: [0, 6],
//			},
//			block2: {
//				componentData: [serviceData[0], serviceData[1]],
//				lg: [2, 4],
//				md: [0, 6],
//			},
//		})
//		.setVueConfig(['blank', 'temp0'], ['gridSystem'])
//		.setComponents(serviceData);

//	config.setTemplate({});

</script>
<script src=" http://semanticlab.com/js/vue/test/Root.js"></script>