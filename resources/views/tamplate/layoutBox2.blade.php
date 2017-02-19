<?php
/**
 * Created by PhpStorm.
 * User: Albert Lin
 * Date: 2017/2/19
 * Time: 下午 03:58
 */
?>

<style>
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
</style>

<div class="layoutBox2 row h100">
    <div class="col-md-offset-1 col-md-10">
        <div class="lb2Title">
            TITLE
        </div>
        <div class="lb2BodyBlock row">
            <div class="lb2Body col-md-12">
                THIS IS CONTENT
            </div>
        </div>
    </div>
</div>