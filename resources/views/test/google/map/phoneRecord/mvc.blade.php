<?php
/**
 * Created by PhpStorm.
 * User: Albert Lin
 * Date: 2017/2/24
 * Time: 上午 12:59
 */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>通聯地圖</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4KGAZ9H0TBoWEN0c6R5u60Nt7s5cijwo&callback=setUp" async defer></script>
    <script src="http://semanticlab.com/js/Utility/GoogleMap.js"></script>
    <script src="http://semanticlab.com/js/Utility/Entity.js"></script>
    <script src="http://semanticlab.com/js/Utility/PublicFun.js"></script>

    <script src="http://semanticlab.com/js/GoogleMap/PhoneRecord/Ctrl.js"></script>
    <script src="http://semanticlab.com/js/GoogleMap/PhoneRecord/Model.js"></script>



    <style>

        html, body{
            font-family: 微軟正黑體;
            font-size: 18px;
            font-weight: 400;
        }

        html, body, .h100{ height: 100%; }

        #funContentBlock, #mainContentBlock{ width: 100%; }

        .box0{
            border: 0;
            padding: 0;
            margin: 0;
        }

        #funContentBlock{
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

        #mainContentBlock{ float: right; }

        #mainContent{
            position: absolute;
            z-index: 4;
            background-color: #ededed;
            transition: 0.7s;
            padding-left: 65px;
        }

        #funNavBlock{
            width: 65px;
            float: left;
            position: absolute;
            z-index: 4;
            background-color: #cccccc;
        }

        .funBtn{
            width: 65px;
            height: 65px;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-color: #cccccc;
            font-size: 20px;
            color: #ffbb00;
            line-height: 65px;
            text-align: center;
            vertical-align: center;
        }
        .funBtn:hover{ background-color: #9d9d9d; }
        .funBtn:active{ background-color: #2e3436; }



        .funHead{
            height: 65px;
            background-color: #8bade5;
            color: #ffffff;
            line-height: 65px;
            text-align: center;
            vertical-align: center;
        }

        .funBody{
            height: calc(100% - 65px);
            background-color: #ffffff;
            color: #5e5e5e;
            padding-top: 15px;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .optBlock{
            padding-top: 10px;
            padding-bottom: 10px;
        }
        .optHead{
            padding: 5px;
            background-color: #8bade5;
            color: #ffffff;
            border-top-right-radius: 15px;
            border-bottom-right-radius: 15px;
        }
        .optBody{
            padding: 10px;
            font-size: 16px;
            color: #122b40;
        }
        .optBody .form-group .col-md-2{
            padding-left: 5px;
            padding-right: 5px;
        }
        .optBlock table{
            margin-top: 10px;
        }
        .optValid{
            padding: 10px;
            color: #ff4444;
            display: none;
        }
        #submitBtn{
            padding-top: 10px;
            padding-right: 40px;
            padding-bottom: 10px;
            padding-left: 40px;
            border-color: #8888ff;
            color: #8888ff;
            font-weight: 600;
            border-style: solid;
            border-radius: 20px;
            float: right;
        }
        #submitBtn:hover, #submitBtn:active{
            background-color: #8888ff;
            color: #ffffff;
        }

        .searchBlock{
            /*background-color: #aeaeae;*/
        }
        @keyframes changeBorderColor {
            from {border-bottom-color: #aeaeae;}
            to {border-bottom-color: #ff4444;}
        }
        #regexSearch{
            padding: 10px;
            border-style: solid;
            border-bottom-color: #aeaeae;
            border-bottom-width: 2px;
        }
        #regexSearch:active, #regexSearch:focus{
            outline: none;
            border-style: solid;
            border-bottom-color: #ff4444;
            border-bottom-width: 2px;
            animation-name: changeBorderColor;
            animation-duration: 0.75s;
        }
        #regexSearchBtn, #clearSearchBtn{
            background-color: #ffffff;
            border-radius: 50px;
            display: table;
            margin: 0 auto;
            border-color: #2a88bd;
            width: 50%;
            height: 50%;
        }
        #regexSearchBtn:hover, #clearSearchBtn:hover{
            background-color: #98cbe8;
        }

        #phoneList{
            font-size: small;
        }

        .sortBtn{
            height: 15px;
            width: 15px;
            font-size: 5px;
				padding: 0px;
        }


        #unitBarBlock{
            top: calc(100% - 70px);
            height: 60px;
            position: absolute;
            z-index: 5;
            padding-top: 16px;
            padding-bottom: 16px;
        }
        #upperBound{
            text-align: right;
        }
        #unitBar {
            -webkit-appearance: none; /* Hides the slider so that custom slider can be made */
            background: transparent; /* Otherwise white in Chrome */
        }
        #unitBar:focus {
            outline: none; /* Removes the blue border. You should probably do some kind of focus styling for accessibility reasons though. */
        }
        #unitBar::-ms-track {
            width: 100%;
            cursor: pointer;

            /* Hides the slider so custom styles can be added */
            background: transparent;
            border-color: transparent;
            color: transparent;
        }
        /* Special styling for WebKit/Blink */
        #unitBar::-webkit-slider-thumb {
            -webkit-appearance: none;
            border-radius: 10px;
            height: 16px;
            width: 16px;
            background: #ff4444;
            margin-top: -4px;
            cursor: pointer;
        }
        #unitBar:active::-webkit-slider-thumb{
            box-shadow: 0 0 20px 2px #ff4444;
        }
        #unitBar::-webkit-slider-runnable-track {
            width: 100%;
            height: 8px;
            cursor: pointer;
            background-color: #adadad;
            border-radius: 10px;
        }

        #palyerBlock{
            top: calc(100% - 70px);
            height: 60px;
            position: absolute;
            z-index: 5;
            padding: 15px;
        }

        #animationPlayer{
            border-style: solid;
            border-width: 2px;
            border-radius: 20px;
            border-color: #ff4444;
        }

        #animationPlayer:hover, #animationPlayer:active{
            background-color: #ff4444;
        }

        .infoWindowTB{
            box-shadow: 0 10px 20px 0 rgba(150, 150, 150, 0.5);
        }

        .infoWindow{
            overflow-x: hidden;
            word-wrap: break-word;
        }

    </style>
    <script src="http://semanticlab.com/js/GoogleMap/PhoneRecord/View.js"></script>
</head>
<body>

<div class="row box0 h100">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box0 h100">

        <div id="funContentBlock" class="row box0 h100">
            <div id="funContent" class="col-md-4 h100 box0">
                <div id="setFunBlock" class="funCont h100">
                    <div class="funHead">設定</div>
                    <div class="funBody">
                        <div class="optBlock">
                            <div class="row box0">
                                <div class="optHead col-md-5">分析時間</div>
                            </div>
                            <div class="optBody form-horizontal box0">
                                <div class="form-group">
                                    <div class="col-md-2 control-label">開始</div>
                                    <div class="col-md-10"><input id="startTime" class="form-control input-md" type="datetime-local" value="" required/></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-2 control-label">結束</div>
                                    <div class="col-md-10"><input id="stopTime" class="form-control input-md" type="datetime-local" value="" required/></div>
                                </div>
                            </div>
                            <div id="timeValid" class="optValid">* 請輸入正確的分析時間</div>
                        </div>
                        <div class="optBlock">
                            <div class="row box0">
                                <div class="optHead col-md-5">分析單位</div>
                            </div>
                            <div class="optBody form">
                                <label class="radio-inline"><input type="radio" class="unit" name="unit" value="600000">10分鐘</label>
                                <label class="radio-inline"><input type="radio" class="unit" name="unit" value="3600000">1小時</label>
                                <label class="radio-inline"><input type="radio" class="unit" name="unit" value="86400000">1天</label>
                            </div>
                            <div id="unitValid" class="optValid">* 請選擇分析單位</div>
                        </div>
                        <div class="optBlock">
                            <div class="row box0">
                                <div class="optHead col-md-5">監察號碼</div>
                            </div>
                            <table class="table table-striped table-condensed optBody">
                                <thead>
                                <tr>
                                    <td><input id="checkAll" type="checkbox"> 全選</td>
                                    <td>號碼</td>
                                    <td>顏色</td>
                                </tr>
                                </thead>
                                <tbody id="phoneNumTB"></tbody>
                            </table>
                            <div id="listValid" class="optValid">* 請選擇至少一個監察號碼</div>
                        </div>
                        <div class="optBlock">
                            <div class="optBody row box0">
                                <div id="submitBtn" class="btn">送出</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="infoFunBlock" class="funCont h100">
                    <div class="funHead">清單檢視</div>
                    <div class="funBody">
                        <div class="optBlock searchBlock">
                            <div class="optBody row box0">
                                <input id="regexSearch" class="box0 col-md-8 is-empty" />
                                <div class="col-md-2">
                                    <div id="regexSearchBtn" class="btn glyphicon glyphicon-search "></div>
                                </div>
                                <div class="col-md-2">
                                    <div id="clearSearchBtn" class="btn glyphicon glyphicon-trash "></div>
                                </div>
                            </div>
                        </div>
                        <div class="optBlock">
                            <div class="optBody row box0">
                                <table id="phoneList" class="table-striped table-condensed col-md-12">
                                    <thead>
                                    <tr>
                                        <th>監察號碼<span class="btn sortBtn" style="float: right" propName="監察號碼">▲</span></th>
                                        <th>非察監號碼<span class="btn sortBtn" style="float: right" propName="非察監號碼">▲</span></th>
                                        <th>通話起始日期-時間<span class="btn sortBtn" style="float: right" propName="通話起始日期">▲</span></th>
                                    </tr>
                                    </thead>
                                    <tbody id="recordTB"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="mainContentBlock" class="row box0 h100">
            <div id="unitBarBlock" class="col-md-offset-4 col-md-5">
                <div class="row">
                    <div id="lowerBound" class="col-md-6"></div>
                    <div id="upperBound" class="col-md-6"></div>
                </div>
                <input id="unitBar" type="range" value="-1" min="-1" max="0">
            </div>
            <div id="palyerBlock" class="col-md-offset-9 col-md-3">
                <div class="row">
                    <div class="col-md-3">
                        <div id="animationPlayer" status="stop" class="btn"><span class="glyphicon glyphicon-play"></span></div>
                    </div>
                    <div class="col-md-3">

                    </div>

                </div>
            </div>
            <div id="mainContent" class="col-md-12 h100"></div>
        </div>

        <div id="funNavBlock" class="row box0 h100">
            <div id="funBtn0" class="funBtn glyphicon glyphicon-cog" contentId="setFunBlock"></div>
            <div id="funBtn1" class="funBtn glyphicon glyphicon-th-list" contentId="infoFunBlock"></div>
        </div>

    </div>
</div>

</body>

</html>