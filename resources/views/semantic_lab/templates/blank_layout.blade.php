<?php
/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/2/2
 * Time: 下午 05:01
 */
?>

<body>

    <div class="row">
        <div id="logoText" class="col-md-offset-2 col-md-8 col-sm-offset-1 col-md-10 col-xs-12">
            @yield('logoText')
        </div>
    </div>

    <div class="row">
        <div id="infoBlock" class="col-md-offset-2 col-md-8 col-sm-offset-1 col-md-10 col-xs-12">
            @yield('infoBlock')
        </div>
    </div>

</body>
<style>
    html, body{
        border: 0;
        margin: 0;
        padding: 0;
        background-color: #ffffff;
        color: #8c8c8c;
        font-family: "Helvetica Neue";
        vertical-align: middle;
        line-height: 100%;
    }

    .row{
        border: 0;
        margin-right: 0;
        margin-left: 0;
        padding: 0;
    }

    #logoText{
        text-align: center;
        color: #ff7766;
        font-size: 120px;
        background-color: #8c8c8c;
    }

    #infoBlock{
        text-align: center;
        color: #6677ff;
        font-size: 16px;
        background-color: #636b6f;
    }
</style>
