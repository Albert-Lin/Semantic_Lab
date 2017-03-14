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
    <script src="//d3js.org/d3.v4.0.0-alpha.4.min.js"></script>
</head>
<body>

    {{--<svg style="width: 400px; height: 400px;">--}}
        {{--<g style="transform: translate(100px, 100px)">--}}
            {{--<path id="path"></path>--}}
            {{--<path id="path2"></path>--}}
        {{--</g>--}}
    {{--</svg>--}}

    <div id="pieChart">
        <pie></pie>
    </div>

</body>
</html>

<script>
//	var arc = d3.arc();
//	var path = arc({
//		innerRadius: 50,
//		outerRadius: 100,
//		startAngle: 0,
//		endAngle: Math.PI
//	});
//	var path2 = arc({
//		innerRadius: 50,
//		outerRadius: 100,
//		startAngle: Math.PI,
//		endAngle: 2*Math.PI
//	});
//
//	document.getElementById('path').setAttribute('d', path);
//	document.getElementById('path2').setAttribute('d', path2);
//
//    console.log(Math.PI);

    function getSVGPath(percent){
		var arc = d3.arc();
		var path = arc({
			innerRadius: 50,
			outerRadius: 100,
			startAngle: 0,
			endAngle: percent*2*Math.PI
		});
		return path;
    }

</script>
<script src=" http://semanticlab.com/js/vue/test/pie.js"></script>
