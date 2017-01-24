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
            position: absolute;
            width: 80px;
            background-color: #2e3436;
            z-index: 2;
        }

        #pills-box{
            background-color: #bce8f1;
            padding-left: 15px;
            padding-right: 15px;
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

            $('#functions-pills').click(function(){
                var main = $('#main');
                if(status === '0'){console.log(status);
                    main.removeClass('col-md-offset-0');
                    main.removeClass('col-md-12');
                    main.removeClass('col-sm-offset-0');
                    main.removeClass('col-sm-12');
                    main.removeClass('col-xs-offset-0');
                    main.removeClass('col-xs-12');

                    main.addClass('col-md-offset-3');
                    main.addClass('col-md-9');
                    main.addClass('col-sm-offset-5');
                    main.addClass('col-sm-7');
                    main.addClass('col-xs-offset-9');
                    main.addClass('col-xs-3');
                    status = '1';
                }
                else{
                    main.removeClass('col-md-offset-3');
                    main.removeClass('col-md-9');
                    main.removeClass('col-sm-offset-5');
                    main.removeClass('col-sm-7');
                    main.removeClass('col-xs-offset-9');
                    main.removeClass('col-xs-3');

                    main.addClass('col-md-offset-0');
                    main.addClass('col-md-12');
                    main.addClass('col-sm-offset-0');
                    main.addClass('col-sm-12');
                    main.addClass('col-xs-offset-0');
                    main.addClass('col-xs-12');
                    status = '0';
                }
            });

            var functionsPillsDom = $('#functions-pills');
            var width = $('#main').width();
            console.log("OUT: "+width);
            if(width >= 1100){
                functionsPillsDom.css('width', '80px');
            }
            else if(width < 1100 && width >= 750){
                functionsPillsDom.css('width', '80px');
            }
            else{
                functionsPillsDom.css('width', '40px');
            }

            $( window ).resize(function(){
                var functionsPillsDom = $('#functions-pills');
                var width = $('#main').width();
                console.log("IN: "+width);
                if(width >= 1100){
                    functionsPillsDom.css('width', '80px');
                }
                else if(width < 1100 && width >= 750){
                    functionsPillsDom.css('width', '80px');
                }
                else{
                    functionsPillsDom.css('width', '40px');
                }
            });


        });

    </script>

</head>
<body>

    <div id="container" class="row">
        <div id="main" class="col-md-offset-0 col-md-12 col-sm-offset-0 col-sm-12 col-xs-offset-0 col-xs-12">
            <div class="row rowMargin0">
                <div class="col-md-1">
                    <div class="row rowMargin0">
                        {{--<div id="more" class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 col-xs-offset-3 col-xs-6 glyphicon glyphicon-align-justify"></div>--}}
                    </div>
                </div>
            </div>
        </div>
        <div id="sidebar-box" class="col-md-3 col-sm-5 col-xs-9">
            <div id="functions-box" class="row">
                <div id="pills-box" class="col-md-offset-2 col-md-10 col-sm-offset-2 col-sm-10 col-xs-offset-2 col-xs-10">
                    <button class="btn btn-info">SOMETHING</button>
                </div>
            </div>
        </div>
        <div id="functions-pills"></div>

    </div>

</body>
</html>
