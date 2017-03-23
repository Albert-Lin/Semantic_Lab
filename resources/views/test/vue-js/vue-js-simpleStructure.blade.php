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
            width: 100%;
            height: 100%;
			background-color: #333333;
			padding: 0;
			border: 0;
			margin: 0;
		}
        .blankContainer, .temp0Container{
            overflow-x: hidden;
            overflow-y: auto;
        }

        #root > div{
            padding: 10px;
        }
	</style>

</head>
<body>

    <div id="root">
        <component v-if="info.length > 0" :is="currentTemplate.template" :prop="currentTemplate.prop"></component>
	    <div><button v-on:click="changeTemp()">change</button></div>
    </div>

</body>
</html>
<script src=" http://semanticlab.com/js/vue/test/Root.js"></script>
<style>
    .blankContainer, .temp0Container{
        overflow-x: hidden;
        overflow-y: auto;
        height: 94%;
    }
</style>