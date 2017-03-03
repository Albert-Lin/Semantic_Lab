<?php
/**
 * Created by PhpStorm.
 * User: Albert Lin
 * Date: 2017/2/14
 * Time: 下午 11:47
 */
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
    @font-face {
        font-family: HelveticaNeueThin;
        src: url('http://semanticlab.com/css/fonts/HelveticaNeue Thin.ttf') format('truetype');
    }

    html, body{
        font-family: HelveticaNeueThin;
        font-size: 16px;
        font-weight: 600;
    }
    #theBlock{
        padding: 0;
        margin: 0;
    }
    .h100{
        height: 100%;
    }
    .h10{
        height: 10%;
    }
    #container{
        margin: 0;
        padding-left: 15px;
        padding-right: 15px;
        border: 0;
    }
    .prefix{
        height: 30px;
        /*background-color: #ffbb66;*/
        line-height: 30px;
        text-align: left;
        vertical-align: middle;
        margin-left: 5px;
        margin-right: 5px;
    }
    .rowBlock{
        margin: 0;
    }
    .container{
        background-color: #ffffff;
        padding: 20px 5px 0 5px;
        margin: 0 5px 0 5px;
        box-shadow: 0 4px 20px 0 rgba(60, 32, 64, 0.5);
    }
    .block{
        line-height: 100%;
        text-align: center;
        vertical-align: middle;
        word-break: break-all;
    }
</style>

<div id="theBlock" class="row">
    <div id="container" class="col-md-12">

        @foreach($data as $key => $routes)
            <div class="row rowBlock">
                <div class="col-md-2 prefix">
                    {{$key}}
                </div>
            </div>
            <div class="row h10 rowBlock">
                @foreach($routes as $index => $route)
                    <div class="col-md-2 h100 container">
                        <a href="http://semanticlab.com/{{$route}}">
                            <div class="block h100">
                                {{$route}}
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <br>
        @endforeach

    </div>
</div>
