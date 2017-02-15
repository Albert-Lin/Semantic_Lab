<?php
/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/2/15
 * Time: 下午 02:05
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4KGAZ9H0TBoWEN0c6R5u60Nt7s5cijwo&signed_in=true&callback=initMap" async defer>	</script>
    <style>
        html, body, .h100{
            height: 100%;
        }
        #main{
            border: 0;
            margin: 0;
            padding: 0;
        }
        #mainBody, #funBlock, #contentBlock{
            border: 0;
            margin: 0;
            padding: 0;
        }
        #funBlock{
            width: 100%;
            position: absolute;
            z-index: 3;
        }
            #funBody{
                padding: 0;
                padding-left: 65px;
                background-color: #9d9d9d;
                opacity: 0.7;
                color: #2e3436;
            }
        #contentBlock{
            width: 100%;
            float: right;
        }
            #contentBody{
                background-color: #ff4444;
                font-size: 18px;
                transition: 0.8s;
                overflow-x: hidden;
                overflow-y: auto;
                position: absolute;
                z-index: 4;
                padding-left: 65px;
            }
        #funListBlock{
            width: 65px;
            background-color: #ffffff;
            position: absolute;
            z-index: 5;
        }
        .funBtn{
            height: 65px;
            width: 65px;
            font-size: 20px;
            line-height: 65px;
            vertical-align: middle;
            text-align: center;
            border: 0;
            padding: 0;
            margin: 0;
            top: 0;
            bottom: 0;
            color: #ffbb00;
        }
        .funBtn:active{
            background-color: #5e5e5e;
        }
        .funBody{
            display: none;
        }

        .contentHead{
            height: 65px;
            background-color: #5e5e5e;
            color: #fff;
            line-height: 65px;
            text-align: center;
            vertical-align: center;
            font-size: 18px;
            font-weight: 600;
            font-family: 微軟正黑體;
        }
        .contentBody{
            height: calc(100% - 65px);
            background-color: #5bc0de;
        }
        .optHead{
            height: 40px;
            background-color: #122b40;
            padding: 5px;
            line-height: 30px;
            text-align: center;
            vertical-align: center;
            color: #ffffff;
        }
    </style>

</head>
<body>

    <div id="main" class="row h100">
        <div id="mainBody" class="col-md-12 col-sm-12 col-xs-12 h100">

            <div id="funBlock" class="row h100">
                <div id="funBody" class="col-md-4 h100">
                    <div id="settingFunBody" class="funBody h100">
                        <div class="contentHead">設定</div>
                        <div class="contentBody">
                            <div class="opt">
                                <div class="row">
                                    <div class="optHead col-md-8">這是標題</div>
                                </div>
                                <div class="optBody">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="informationFunBody" class="funBody h100">
                        <div class="contentHead">清單檢視</div>
                    </div>
                </div>
            </div>
            <div id="contentBlock" class="row h100">
                <div id="contentBody" class="col-md-12 h100">

                </div>
            </div>
            <div id="funListBlock" class="h100">
                <div class="function-list div-horizontal" >
                    <div id="setting" class="funBtn glyphicon glyphicon-cog"></div>
                    <div id="information" class="funBtn glyphicon glyphicon-th-list"></div>
                </div>
            </div>
        </div>
    </div>

</body>

<script>
    var clickFun = undefined;
    var lastClickFun = undefined;
	$(function(){
		$.getJSON( "../../js/test/Debugdata.json", function( data ) {
			console.log(data);
		});

		$('.funBtn').on('click', function(event){
			var clickId = event.target.id;
			if(clickFun !== clickId){
				$('#contentBody').removeClass('col-md-12');
				$('#contentBody').addClass('col-md-offset-4');
				$('#contentBody').addClass('col-md-8');
				$('#contentBody').css('padding-left', '0');

				if(clickFun !== undefined){
					$('#'+clickFun+'FunBody').css('display', 'none');
					$('#'+clickFun).css('background-color', '#ffffff');
                }
                if(lastClickFun !== undefined){
					$('#'+lastClickFun+'FunBody').css('display', 'none');
                }
				$('#'+clickId+'FunBody').css('display', 'block');
				$('#'+clickId).css('background-color', '#9d9d9d');

				clickFun = clickId;
				lastClickFun = clickId;
				contentBodyStatus = '1';
			}
			else{
				$('#contentBody').removeClass('col-md-offset-4');
				$('#contentBody').removeClass('col-md-8');
				$('#contentBody').addClass('col-md-12');
				$('#contentBody').css('padding-left', '65px');

				if(clickFun === clickId){
					clickFun = undefined;
					$('#'+clickId).css('background-color', '#ffffff');
				}
			}
        });

	});

</script>

</html>
