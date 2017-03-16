<?php
/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/3/16
 * Time: 上午 09:44
 */
?>

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
    <style>
        body, html, #gridSystem{
            height: 100%;
            width: 100%;
            padding: 10px;
            border: 0;
            margin: 0;
        }
    </style>
</head>
<body>

    <div id="gridSystem">
        <component v-for="data in info" :is="data.component" :prop="data.prop"></component>
    </div>

</body>
</html>
<script>
    window.ctrlData = {!! $ctrlData !!};
</script>
<script src=" http://semanticlab.com/js/vue/test/gridSystem.js"></script>