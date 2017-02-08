<?php
/**
 * Created by PhpStorm.
 * User: Albert Lin
 * Date: 2017/2/9
 * Time: 上午 01:06
 */
?>

<style>
    .layoutBox{
        padding: 0;
        margin-top: 5%;
        background-color: #FFFFFF;
        box-shadow: 0 4px 10px 0 rgba(60, 32, 64, 0.5), 0 6px 40px 0 rgba(60, 32, 64, 0.49);
        font-weight: bolder;
    }

    .layoutBox>.boxHeader{
        padding-top: 20px;
        padding-right: 15px;
        padding-bottom: 20px;
        padding-left: 15px;
        background-color: #5b88de;
    }

    .layoutBox>.boxBody{
        padding: 15px;
    }

    .layoutBox>.boxFooter{
        padding: 8px;
    }
</style>


<div class="row">
    <div id="BOXID" class="col-md-offset-1 col-md-10 layoutBox">
        <div class="boxHeader">TITLE:</div>

        <div id="sparqlEditor" class="boxBody">
            BODY
        </div>

        <div class="boxFooter">FOOTER</div>
    </div>
</div>
