<?php
/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/1/20
 * Time: 下午 01:11
 */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <style type="text/css">

    html, body, #container{
        width:100%;
        height: 100%;
        margin: 0;
        padding: 0;
        border: 0;
    }
        .container{
            height: 100%;
            font-family: Hack;
            color: #ffffff;
            margin: 0;
            padding: 0;
        }

        #container0{
            border-left: 6px solid #ff4444;
            background-color: #ff8888;
        }

        #container1{
            border-left: 6px solid #44aa44;
            background-color: #88ff88;
        }

        #container2{
            height: 100%;
            font-family: Hack;
            color: #ffffff;
            margin: 0;
            border-left: 6px solid #4444ff;
            background-color: #8888ff;
        }


    </style>
    <!-- FOR JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- FOR BOOTSTRAP -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

    <div id="container" class="row">

        <div id="container0" class="container col-md-4 row">
            <div class="col-md-4" style="background-color: #ffbb00"> col-md-4 </div>
            <div class="col-md-8" style="background-color: #ffbb66"> col-md-8 </div>
            <div class="col-md-4" style="background-color: #dd7733"> col-md-4 </div>
        </div>

        <div id="container1" class="container col-md-4 row">

            <div class="col-md-2" style="background-color: #0fff00"> md-2 </div>
            <div class="col-md-2" style="background-color: #00bb66"> md-2 </div>
            <div class="col-md-2" style="background-color: #0fff00"> md-2 </div>
            <div class="col-md-2" style="background-color: #00bb66"> md-2 </div>
            <div class="col-md-2" style="background-color: #0fff00"> md-2 </div>
            <div class="col-md-2" style="background-color: #00bb66"> md-2 </div>

            <div class="col-md-12"><hr></div>
            <div class="row col-md-12">
                <div class="col-md-2 col-xs-6" style="background-color: #0fff00"> md-2 xs-6 G1</div>
                <div class="col-md-2 col-xs-6" style="background-color: #00bb66"> md-2 xs-6 G1</div>
                <div class="col-md-2 col-xs-6" style="background-color: #0fff00"> md-2 xs-6 G2</div>
                <div class="col-md-2 col-xs-6" style="background-color: #00bb66"> md-2 xs-6 G2</div>
                <div class="col-md-2 col-xs-6" style="background-color: #0fff00"> md-2 xs-6 G3</div>
                <div class="col-md-2 col-xs-6" style="background-color: #00bb66"> md-2 xs-6 G3</div>
            </div>
        </div>


        <div id="container2" class="col-md-4">
            <div class="row">
                <div class="col-md-6 col-xs-6" style="background-color: #006fff"> md-6 xs-6 G1</div>
                <div class="col-md-6 col-xs-6" style="background-color: #0646ff"> md-6 xs-6 G1</div>
            </div>
            <div><hr></div>
            <div class="row">
                <div class="col-md-4 col-md-offset-2" style="background-color: #006fff"> md-4 offset-2</div>
                <div class="col-md-2 col-md-offset-2" style="background-color: #0646ff"> md-2 offset-2 </div>
            </div>
        </div>

    </div>

</body>
</html>
