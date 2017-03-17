<?php
/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/3/17
 * Time: 上午 11:32
 */
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="http://semanticlab.com/js/vue/Template.js"></script>
</head>
<body>

</body>

<script>

    var data = [{b0_0: 'test 0_0'}, {b0_1: 'test 0_1'}, {b0_2: 'test 0_2'}, {b1_0: 'test 1_0'}, {b0_1: 'test 1_1'}, {b0_2: 'test 1_2'}, {b2_0: 'test 2_0'}, {b0_1: 'test 2_1'}, {b0_2: 'test 2_2'} ];

    let temp0 = new Template({
    	template: 'temp0',
        block0: {
    		componentData: [ data[0], data[1], data[2] ],
            lg: [0, 3],
            md: [0, 4],
            sm: [1, 5],
            xs: [0, 12]
        },
		block1: {
			componentData: [ data[3], data[4], data[5] ],
			lg: 4,
			xs: 12
        },
		block2: {
			componentData: [ data[6], data[7], data[8] ]
        }
    }).config;
    console.log(temp0);

</script>

</html>
