<?php
/**
 * Created by PhpStorm.
 * User: Albert Lin
 * Date: 2017/2/19
 * Time: 上午 09:50
 */
?>

<style>
    .iconCardBox{
        border: 0;
        padding: 10px;
        margin: 0;
        /*background-color: #3C4858;*/
        background-color: #ffffff;
    }

    .icIconBlock{
        width: 80px;
        height: 80px;
        border: 0;
        border-radius: 5px;
        padding: 15px;
        margin-left: 15px;
        margin-right: 15px;
        background-color: #f0564e;
        position: absolute;
        z-index: 50;
        box-shadow: 0 0 15px 0 rgba(255, 100, 100, 0.6);
    }

    .icIcon{
        width: 50px;
        height: 50px;
        border: 0;
        padding: 10px;
        margin: 0;
        color: #ffffff;
        font-size: 30px;
    }

    .icContentBlock{
        padding: 0;
        border: 0;
        margin: 0;
    }

    .icContent{
        border: 0;
        border-radius: 5px;
        padding: 10px;
        margin: 0;
        margin-top: 20px;
        background-color: #ffffff;
        position: absolute;
        z-index: 49;
        box-shadow: 0 0 10px 1px rgba(100, 100, 100, 0.6);
    }
    .icTitle{
        min-height: 65px;
        text-align: right;
    }
    hr{
        border-color: #bbbbbb;
        margin-top: 10px;
        margin-bottom: 10px;
    }
</style>


<div class="iconCardBox">
    <div class="icIconBlock">
        <div class="icIcon glyphicon glyphicon-leaf"></div>
    </div>
    <div class="icContentBlock row">
        <div class="icContent col-md-11">
            <div class="row box0">
                <div class="icTitle col-md-12">
                    TITLE
                </div>
            </div>
            <div class="row box0">
                <div class="icBody col-md-12">
                    <hr>
                    BODY
                </div>
            </div>
            <div class="row box0">
                <div class="icFooter col-md-12">
                    <hr>
                    FOOTER
                </div>
            </div>
        </div>
    </div>
</div>
