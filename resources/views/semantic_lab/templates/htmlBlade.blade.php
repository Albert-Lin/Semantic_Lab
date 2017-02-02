<?php
/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/2/2
 * Time: 下午 04:36
 */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title> @yield('title') </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style>
        @section('css')
        html, body{
            width: 100%;
            height: 100%;
            border: 0;
            margin: 0;
            padding: 0;
            font-family:;
        }
        @show
    </style>

    @yield('js')

</head>
<html>
    <body>
        @yield('body')
    </body>
</html>
