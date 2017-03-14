<?php
/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/3/14
 * Time: 下午 04:46
 */?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
	{{--<script src=" https://unpkg.com/vue"></script>--}}
    <script src="//d3js.org/d3.v4.0.0-alpha.4.min.js"></script>
</head>
<body>

    <div id="pieChart">
        <component v-for="data in info" :is="data.component" :prop="data.prop"></component>
    </div>

</body>
</html>

<script type="text/javascript">

    function getSVGPath(last, percent){
		var arc = d3.arc();
		var path = arc({
			innerRadius: 50,
			outerRadius: 100,
			startAngle: last*2*Math.PI,
			endAngle: percent*2*Math.PI
		});
		return path;
    }

</script>
<script src=" http://semanticlab.com/js/vue/test/pie.js"></script>
