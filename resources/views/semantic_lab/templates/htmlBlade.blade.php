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
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title') </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{ $data['domainURI'] }}js/semantic_lab/functions/functions.js"></script>
    <script src="{{ $data['domainURI'] }}js/semantic_lab/functions/ajaxObject.js"></script>
    <script src="{{ $data['domainURI'] }}js/semantic_lab/functions/utility.js"></script>

    <style>
        @font-face {
            font-family: HelveticaNeueThin;
            src: url('http://semanticlab.com/css/fonts/HelveticaNeue Thin.ttf') format('truetype');
        }

        html, body, #messageBlock, #msMain{
            width: 100%;
            height: 100%;
            border: 0;
            margin: 0;
            padding: 0;
            font-family: HelveticaNeueThin;
        }

        body{
            background-image: url('http://semanticlab.com/image/swbg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            /*background: #666666;*/
            /*background: -webkit-linear-gradient(to bottom right, #666666, #aa66aa); !* For Safari 5.1 to 6.0 *!*/
            /*background: -o-linear-gradient(to bottom right, #666666, #aa66aa); !* For Opera 11.1 to 12.0 *!*/
            /*background: -moz-linear-gradient(to bottom right, #666666, #aa66aa); !* For Firefox 3.6 to 15 *!*/
            /*background: linear-gradient(to bottom right, #666666, #aa66aa); !* Standard syntax *!*/
        }

        #messageHeader, #messageBody, #messageFooter{
            border: 0;
            font-weight: 800;
        }
        #messageHeader{
            color: #aa66aa;
            font-size: 24px;
        }
        #messageBody{
            color: #f0ad4e;
            font-size: 18px;
        }
        #messageModalBtn{
            display: none;
        }

        #messageDialog > div > hr{
            margin: 0;
        }

        .layoutBox{
            padding: 0;
            /*margin-top: 5%;*/
            background-color: #FFFFFF;
            box-shadow: 0 4px 10px 0 rgba(60, 32, 64, 0.5), 0 6px 40px 0 rgba(60, 32, 64, 0.49);
            font-weight: bolder;
        }

        .layoutBox>.boxHeader{
            height: 65px;
            padding-top: 20px;
            padding-right: 15px;
            padding-bottom: 20px;
            padding-left: 15px;
            background-color: #5b88de;
            font-size: 18px;
        }

        .layoutBox>.boxBody{
            padding: 15px;
        }

        .layoutBox>.boxFooter{
            padding: 8px;
        }


        .layoutBox2{
            border: 0;
            padding: 10px;
            margin: 0;
            background-color: #ffffff;
        }
        .lb2Title{
            width: calc(100% - 40px);
            min-height: 60px;
            padding: 15px;
            border: 0;
            border-radius: 5px;
            margin-left: 20px;
            background-color: #ff4444;
            box-shadow: 0 0 25px 0 rgba(255, 100, 100, 0.6);
            position: absolute;
            z-index: 50;
            line-height: 30px;
            overflow-y: hidden;
            font-size: 25px;
            font-weight: 400;
        }
        .lb2BodyBlock{
            padding: 0;
            border: 0;
            margin: 0;
        }
        .lb2Body{
            min-height: 150px;
            border: 0;
            border-radius: 5px;
            padding: 55px 20px 20px 20px;
            margin: 20px 0 0 0;
            background-color: #ffffff;
            position: absolute;
            z-index: 49;
            box-shadow: 0 0 10px 1px rgba(100, 100, 100, 0.6);
        }




        .inputError{
            color: #ff0000;
            padding: 10px;
            font-size: 14px;
        }

        .h100{
            height: 100%;
        }
        .h80{
            height: 80%;
        }
        .h70{
            height: 70%;
        }
        .h60{
            height: 60%;
        }
        .h50{
            height: 50%;
        }
        .h45{
            height: 45%;
        }
        .h30{
            height: 30%;
        }

        @section('css')
        @show
    </style>

    <script>

    </script>
    @section('js')
    @show

</head>
<html>
    <body>
    <input id="domainURI" type="hidden" value="{{ $data['domainURI'] }}"/>
    <div id="messageModal" class="modal fade" role="dialog">
        <div id="messageDialog" class="modal-dialog modal-mg">
            <div class="modal-content">
                <div id="messageHeader" class="modal-header"></div>
                <hr>
                <div id="messageBody" class="modal-body"></div>
                <div id="messageFooter" class="modal-footer"></div>
            </div>
        </div>
    </div>
    <div id="messageModalBtn" data-toggle="modal" data-target="#messageModal"></div>

    @yield('body')
    </body>
</html>
