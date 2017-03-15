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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="//d3js.org/d3.v4.0.0-alpha.4.min.js"></script>
    <script src=" http://semanticlab.com/js/test/d3/d3_plugin.js"></script>
</head>
<body>

    {{--<div class="row">--}}
        {{--<div class="col-lg-offset-4 col-md-4">--}}
            {{--<div id="pieChart">--}}
                {{--<component v-for="data in info" :is="data.component" :prop="data.prop"></component>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}


    <div  id="pieChart">
        <div class="row">
            <div class="col-md-4"><component v-if="info[1]" :is="info[1].component" :id="info[1].index" :index="info[1].index" :prop="info[1].prop"></component></div>
            <div class="col-md-4"><component v-if="info[0]" :is="info[0].component" :id="info[0].index" :index="info[0].index" :prop="info[0].prop"></component></div>
            <div class="col-md-4"><component v-if="info[2]" :is="info[2].component" :id="info[2].index" :index="info[2].index" :prop="info[2].prop"></component></div>
        </div>
        <div class="row">
            <div class="col-md-4"><component v-if="info[3]" :is="info[3].component" :id="info[3].index" :index="info[3].index" :prop="info[3].prop"></component></div>
            <div class="col-md-4"><component v-if="info[0]" :is="info[0].component" :id="info[0].index" :index="info[0].index" :prop="info[0].prop"></component></div>
            <div class="col-md-4"><component v-if="info[5]" :is="info[5].component" :id="info[5].index" :index="info[5].index" :prop="info[5].prop"></component></div>
        </div>
    </div>

</body>
</html>

<script type="text/javascript">

    function getSVGPath(last, percent){
        return d3.arc({
			innerRadius: 50,
			outerRadius: 100,
			startAngle: last*2*Math.PI,
			endAngle: percent*2*Math.PI
		});
    }

</script>
<script src=" http://semanticlab.com/js/vue/test/pie.js"></script>
