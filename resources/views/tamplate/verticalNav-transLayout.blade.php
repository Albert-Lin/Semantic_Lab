<?php
/**
 * Created by PhpStorm.
 * User: Albert Lin
 * Date: 2017/2/15
 * Time: 下午 10:11
 */
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style>
    html, body, .h100{ height: 100%;}

    #funContentBlock, #mainContentBlock{
        width: 100%;
    }

    .box0{
        border: 0;
        padding: 0;
        margin: 0;
    }

    #funContentBlock{
        /* ALL THE CONTENT OF CURRENT DIV SHOULD BE THE LAST LAYER*/
        position: absolute;
        z-index: 2;
    }
        #funContent{
            background-color: #98cbe8;
            padding-left: 65px;
        }

        .funCont{
            display: none;
        }

    #mainContentBlock{
        float: right;
    }
        #mainContent{
            /* ONLY THE CONTENT OF CURRENT DIV SHOULD BE THE SECOND LAYER*/
            position: absolute;
            z-index: 4;
            background-color: #ff6666;
            transition: 0.7s; /* SHOW THE TRANSITION ANIMATION WHILE CURRENT DIV CSS CHANGE */
            padding-left: 65px;
        }

    #funNavBlock{
        /* ALL THE CONTENT OF CURRENT DIV SHOULD BE THE TOP LAYER*/
        width: 65px; /* THE FIX WIDTH */
        float: left;
        position: absolute;
        z-index: 4;
        background-color: #ffffff;
    }
        .funBtn{
            width: 65px;
            height: 65px;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-color: #ffffff;
            font-size: 20px;
            color: #ffbb00;
            line-height: 65px;
            text-align: center;
            vertical-align: center;
        }
            .funBtn:hover{
                background-color: #98cbe8;
            }
            .funBtn:active{
                background-color: #1b6d85;
            }

</style>


<div class="row box0 h100">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box0 h100">

        <div id="funContentBlock" class="row box0 h100">
            <div id="funContent" class="col-md-3 h100">
                <div id="content0" class="funCont">THIS IS CONTENT 0 OF funContent</div>
                <div id="content1" class="funCont">THIS IS CONTENT 1 OF funContent</div>
                <div id="content2" class="funCont">THIS IS CONTENT 2 OF funContent</div>
            </div>
        </div>

        <div id="mainContentBlock" class="row box0 h100">
            <div id="mainContent" class="col-md-12 h100">
                THIS IS CONTENT OF mainContent
            </div>
        </div>

        <div id="funNavBlock" class="row box0 h100">
            <div id="funBtn0" class="funBtn glyphicon glyphicon-cog" contentId="content0"></div>
            <div id="funBtn1" class="funBtn glyphicon glyphicon-th-list" contentId="content1"></div>
            <div id="funBtn2" class="funBtn glyphicon glyphicon-fire" contentId="content2"></div>
        </div>

    </div>
</div>

<script>

    var lastContent = undefined;
    var clickFun = undefined;
    $(function(){

        $('.funBtn').on('click', function(event){
            var clickId = event.target.id;
            var clickContent = $(this).attr('contentId');

            var mainContent = $('#mainContent');
            if(clickFun !== clickId){
                mainContent.removeClass('col-md-12');
                mainContent.addClass('col-md-offset-3');
                mainContent.addClass('col-md-9');
                mainContent.css('padding-left', '0');

                // IF SET THE VALUE OF CSS,
                // IT WILL SET AS ATTRIBUTE OF SELECTED TAG,
                // ALSO, THE VALUE WILL COVER THE CSS3 SETTING,
                // THEREFORE, WE SET '' TO REMOVE THE SETTING.
                $('#'+clickFun).css('background-color', '');
                $(this).css('background-color', '#98cbe8');
                lastClickFun = clickId;
                clickFun = clickId;

                $('#'+lastContent).css('display', '');
                $('#'+clickContent).css('display', 'block');
                lastContent = clickContent;
            }
            else{
                mainContent.removeClass('col-md-offset-3');
                mainContent.removeClass('col-md-9');
                mainContent.addClass('col-md-12');
                mainContent.css('padding-left', '65px');

                clickFun = undefined;
                $(this).css('background-color', '');
            }
        });

    });

</script>
