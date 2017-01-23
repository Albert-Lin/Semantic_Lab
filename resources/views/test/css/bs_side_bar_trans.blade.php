<?php
/**
 * Created by PhpStorm.
 * User: Albert Lin
 * Date: 2017/1/23
 * Time: 下午 09:48
 */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{$title}}</title>

    <!-- FOR BOOTSTRAP -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- FOR JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- FOR BOOTSTRAP -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style type="text/css">
        html, body, #container{
            height: 100%;
            border: 0;
            margin: 0;
            padding: 0;
        }

        #main, #sidebar-box, #functions-box, #functions-pills, #pills-box{
            height: 100%;
            border: 0;
            padding: 0;
        }

        #container{
            background-color: #3C4858;
        }

        #main{
            background-color: #3097D1;
            z-index: 1;
            transition: all 1s;
        }

        #sidebar-box{
            position: absolute;
            background-color: #122b40;
            z-index: 0;
        }

        #functions-pills{
            background-color: #2e3436;
            float: left;
        }

        #pills-box{
            background-color: #bce8f1;
        }

        .glyphicon-align-justify{
            font-size: 24px;
            color: #ffffff;
        }

        .rowMargin0{
            margin: 0;
        }

    </style>
    <script type="text/javascript">

        var status = '0';

        $( document ).ready(function(){

            $('#more').click(function(){
                var main = $('#main');
                if(status === '0'){console.log(status);
                    main.removeClass('col-md-offset-0');
                    main.removeClass('col-md-12');
                    main.addClass('col-md-offset-3');
                    main.addClass('col-md-9');
                    status = '1';
                }
                else{
                    main.removeClass('col-md-offset-3');
                    main.removeClass('col-md-9');
                    main.addClass('col-md-offset-0');
                    main.addClass('col-md-12');
                    status = '0';
                }
            });

        });

    </script>

</head>
<body>

    <div id="container" class="row">
        <div id="main" class="col-md-offset-0 col-md-12">
            <div class="row rowMargin0">
                <div class="col-md-1">
                    <div class="row rowMargin0">
                        <div id="more" class="col-md-offset-3 col-md-6 glyphicon glyphicon-align-justify"></div>
                    </div>
                </div>
            </div>
        </div>
        <div id="sidebar-box" class="col-md-3">
            <div id="functions-box" class="row">
                <div id="functions-pills" class="col-md-2"></div>
                <div id="pills-box" class="col-md-10">
                    <button class="btn btn-info">SOMETHING</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
