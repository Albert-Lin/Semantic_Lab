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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4KGAZ9H0TBoWEN0c6R5u60Nt7s5cijwo&callback=setUp" async defer></script>
    <script src="http://semanticlab.com/js/test/Google_Map/GoogleMap.js"></script>

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
            background-color: #4b6d85;
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
                    background-color: #4b6d85;
                    color: #ffffff;
                    border-top-right-radius: 25px;
                    border-bottom-right-radius: 25px;
                }
                .optBody{
                    padding: 10px;
                    font-size: 16px;
                    color: #122b40;
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

    </style>

</head>
<script>

	var lastContent = undefined;
	var clickFun = undefined;
	var phoneObjects = [];
	var showPhones = [];
	var googleMap = {};

	function setUp(){
        $.getJSON( "../../js/test/Debugdata.json", function( data ) {
            var phoneNumList = '';
            var colorUnit = (313/data.length);
            for(var i = 0; i < data.length; i++){
                var phoneNum = data[i].監察號碼;
                var color = colorUnit*i;
                var tr = '<tr> ' +
                    '<td><input type="checkbox" class="listItem" value="'+phoneNum+'"></td>' +
                    '<td>'+phoneNum+'</td> <td style="background-color: hsla('+color+', 100%, 75%, 1);"></td>' +
                    '</tr>';
                phoneNumList += tr;

                data[i].color = 'hsla('+color+', 100%, 75%, 1)';
                phoneObjects.push(data[i]);
            }
            $('#phoneNumTB').html(phoneNumList);

            googleMap = new GoogleMap();
            googleMap.initilization('mainContent', phoneObjects[0].紀錄[0].緯度, phoneObjects[0].紀錄[0].經度);
        });
    }

	$(function(){

		$('.funBtn').on('click', function(event){
			var clickId = event.target.id;
			var clickContent = $(this).attr('contentId');

			var mainContent = $('#mainContent');
			if(clickFun !== clickId){
				mainContent.removeClass('col-md-12');
				mainContent.addClass('col-md-offset-3');
				mainContent.addClass('col-md-9');
				mainContent.css('padding-left', '');

				$('#'+clickFun).css('background-color', '');
				$(this).css('background-color', '#9d9d9d');
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
//                mainContent.css('margin-left', '65px');

				clickFun = undefined;
				$(this).css('background-color', '');
			}
		});

		$('#checkAll').on('click', function(){
			var all = $(this).prop('checked');
			$('.listItem').each(function(){
				if(all === true){
					if($(this).prop('checked') === false){
						$(this).click();
					}
				}
				else if(all === false){
					if($(this).prop('checked') === true){
						$(this).click();
					}
				}
			});
		});

		$('#submitBtn').on('click', function(){
			googleMap.resetCenter('24.2501232', '120.7317551');
        });

        $('.listItem').on('click', function(){
            var checked = $(this).prop('checked');
            if(checked === true){
                var allChecked = true;
                $('.listItem').each(function(){
                    if($(this).prop('checked') === false){
                        allChecked = false;
                    }
                });
                if(allChecked === true){
                    $('#checkAll').prop('checked', true);
                }
            }
            else if(checked === false){
                $('#checkAll').prop('checked', '');
            }
        });
	});


</script>

<body>

<div class="row box0 h100">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box0 h100">

        <div id="funContentBlock" class="row box0 h100">
            <div id="funContent" class="col-md-3 h100 box0">
                <div id="setFunBlock" class="funCont h100">
                    <div class="funHead">設定</div>
                    <div class="funBody">
                        <div class="optBlock">
                            <div class="row box0">
                                <div class="optHead col-md-8">分析時間</div>
                            </div>
                            <div class="optBody form-horizontal box0">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">開始</label>
                                    <div class="col-md-9"><input id="startTime" class="form-control input-sm" type="datetime-local" required/></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">結束</label>
                                    <div class="col-md-9"><input id="stopTime" class="form-control input-sm" type="datetime-local" required/></div>
                                </div>
                            </div>
                            <div id="timeValid" class="optValid">* 請輸入正確的分析時間</div>
                        </div>
                        <div class="optBlock">
                            <div class="row box0">
                                <div class="optHead col-md-8">分析單位</div>
                            </div>
                            <div class="optBody form">
                                <label class="radio-inline"><input type="radio" class="unit" name="unit" value="10">10分鐘</label>
                                <label class="radio-inline"><input type="radio" class="unit" name="unit" value="60">1小時</label>
                                <label class="radio-inline"><input type="radio" class="unit" name="unit" value="1440">1天</label>
                            </div>
                            <div id="unitValid" class="optValid">* 請選擇分析單位</div>
                        </div>
                        <div class="optBlock">
                            <div class="row box0">
                                <div class="optHead col-md-8">監察號碼</div>
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
                        </div>
                        <div class="optBlock">
                            <div class="optBody">
                                <div id="submitBtn" class="btn">送出</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="infoFunBlock" class="funCont h100">
                    <div class="funHead">清單檢視</div>
                    <div class="funBody"></div>
                </div>
            </div>
        </div>

        <div id="mainContentBlock" class="row box0 h100">
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
