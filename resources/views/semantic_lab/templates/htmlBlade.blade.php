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
            background-image: url('http://semanticlab.com/image/slbg.png');
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

        @section('css')
        @show
    </style>

    <script>

        function messageBlock(headerText, bodyText, footerText){
            $('#messageHeader').html(headerText);
            $('#messageBody').html(bodyText);
            $('#messageFooter').html(footerText);
        }

        function ajaxCSRFHeader(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }

    </script>
    @section('js')
    @show

</head>
<html>
    <body>
    <input id="domainURI" type="hidden" value="{{ $data['domainURI'] }}"/>
    <div id="messageModal" class="modal fade" role="dialog">
        <div id="messageDialog" class="modal-dialog modal-sm">
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
