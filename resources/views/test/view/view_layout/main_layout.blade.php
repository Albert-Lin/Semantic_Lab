<?php
/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/1/19
 * Time: 上午 11:48
 */

?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> @yield('title') </title>
    <style type="text/css">
        html, body{
            width: 100%;
            height:100%;
            margin: 0;
            padding: 0;
            border: 0;
        }

        .container{
            width: 25%;
            height:100%;
            font-family: Hack;
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 18px;
            color: #FFF;
            float: left;
            overflow-x: auto;
        }

        #container0{
            background-color: #ff6666;
        }

        #container1-1{
            background-color: #2ab27b;
        }

        #container1-2{
            background-color: #398439;
        }

        #container2{
            background-color: #2a88bd;
        }
    </style>
</head>
<body>

    <div id="container0" class="container">
        <pre>Container 0 is for @ yield function </pre>
        @yield('cont0')
    </div>
    <div id="container1-1" class="container">
        <pre>Container 1-1 is for @ section function </pre>
        @section('cont1-1')
            <p>This content is set default in "main_layout.blade.php"</p>
        @show
    </div>
    <div id="container1-2" class="container">
        <pre>Container 1-2 is for @ section function </pre>
        @section('cont1-2')
            <p>This content is set default in "main_layout.blade.php"</p>
        @show
    </div>
    <div id="container2" class="container">
        <pre>Container 2 is for @ include function </pre>
        @include('test.view.view_layout.included_layout')
    </div>

</body>
</html>
