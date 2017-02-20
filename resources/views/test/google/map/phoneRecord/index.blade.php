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
    <title>通聯地圖</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4KGAZ9H0TBoWEN0c6R5u60Nt7s5cijwo&callback=setUp" async defer></script>
    <script src="http://semanticlab.com/js/Utility/GoogleMap.js"></script>
    <script src="http://semanticlab.com/js/Utility/Entity.js"></script>
    <script src="http://semanticlab.com/js/Utility/PublicFun.js"></script>

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
        #regexSearchBtn{
            background-color: #ffffff;
            border-radius: 50px;
            display: table;
            margin: 0 auto;
            border-color: #2a88bd;
            width: 50%;
            height: 50%;
        }
        #regexSearchBtn:hover{
            background-color: #98cbe8;
        }

        #phoneList{
            font-size: small;
        }

        .sortBtn{
            height: 5px;
            width: 5px;
            font-size: 5px;
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

    </style>

</head>
<script>

	var lastContent = undefined;
	var clickFun = undefined;
	var phones = [];
	var phoneMap = [];
	var showPhones = [];
	var nonEmptyMap = [];
	var googleMap = {};
    var groupInfo = {
    	condictions: [],
        fun: function(condiction, entity){
    		var group = [];
    		var recordArray = entity.getPropValue(condiction.propName);
    		for(var i = 0; i < recordArray.length; i++){
    			var phoneCallStart = recordArray[i][condiction.subPropName];
    			if(condiction.lowerBound < phoneCallStart &&
                    phoneCallStart <= condiction.upperBound){
    				group.push(recordArray[i].origIndex);
                }
            }
            return group;
        }
    };
    var recordInfo = {
    	setMillSec: {
    	    params: {
    	    	propName: '紀錄',
    	    	subPropName: '通話起始日期'
            },
            fun: function(pramas, entity){
    	    	var recordArray = entity.getPropValue(pramas.propName);
    	    	for(var i = 0; i < recordArray.length; i++){
    	    		var startTime = recordArray[i][pramas.subPropName];
    	    		var millSec = (new Date(Date.parse(startTime))).getTime();
					recordArray[i].millSec = millSec;
                }
            }
        }
	};

	function setUp(){
        $.getJSON( "../../js/test/data.json", function( data ) {
            var phoneNumList = '';
            var colorUnit = (313/data.length);
            for(var i = 0; i < data.length; i++){
                var phoneNum = data[i].監察號碼;
                var color = colorUnit*i;
                var tr = '<tr> ' +
                    '<td><input type="checkbox" class="listItem" value="'+phoneNum+'"></td>' +
                    '<td>'+phoneNum+'</td> <td style="background-color: hsla('+color+', 100%, 70%, 1);"></td>' +
                    '</tr>';
                phoneNumList += tr;

                data[i].color = 'hsla('+color+', 100%, 45%, 1)';
                phones.push(new Entity(data[i]));
                phoneMap[phoneNum] = i;
                phones[i].specialFun(recordInfo.setMillSec.params, recordInfo.setMillSec.fun);
            }
            $('#phoneNumTB').html(phoneNumList);

            googleMap = new GoogleMap();
			var defLat = phones[0].getElementValue('紀錄', 0)['緯度'];
			var defLng = phones[0].getElementValue('紀錄', 0)['經度'];
            googleMap.initilization('mainContent', defLat, defLng);
        });
    }

    function groupByTime(startTime, stopTime, unit, propName, subPropName){
		var numGroup = Math.floor(Math.abs(parseInt(stopTime)-parseInt(startTime))/unit); //+parseInt(unit)
		var group = [];
		for(var i = 0; i < numGroup; i++){
			var condition = {
				lowerBound: startTime + i*unit,
				upperBound: startTime + (i+1)*unit,
				propName: propName,
				subPropName: subPropName
            };
			if(i === (numGroup-1)){
				condition.upperBound = stopTime;
            }
			group.push(condition);
        }
        return group;
    }

    function drawGoogleMapMarker(){

    	var trOrderList = [];
		var lastPhoneIndex;
		var phone;
		var phoneColor;

		$('#recordTB tr').each(function(){

			if($(this).css('display') !== 'none'){
				var phoneIndex = phoneMap[$(this).attr('phone')];
				var recordIndex;
				var orderIndex;
				var record;
				var recordStartTime;
				var timeUnit = $('input[name=unit]:checked').val();
				if(phoneIndex !== lastPhoneIndex) {
					phone = phones[phoneIndex];
					phoneColor = phone.getPropValue('color');
				}
                recordIndex = $(this).attr('recordIndex');
                orderIndex = $(this).attr('orderIndex');
                record = phone.getElementValue('紀錄', recordIndex);

                if(timeUnit === '600000' || timeUnit === '3600000'){
					recordStartTime = getDateInfo(record['millSec'],undefined, undefined, undefined, true, true, undefined);
                }
                else if(timeUnit === '86400000'){
					recordStartTime = getDateInfo(record['millSec'],undefined, true, true, undefined, undefined, undefined);
                }

                if(recordIndex === '0'){
                	googleMap.addShapeMarker('triangle', record['緯度'], record['經度'], recordStartTime, phone.getPropValue('color'), record['非監察號碼'], orderIndex);
                }
                else{
					googleMap.addShapeMarker('circle', record['緯度'], record['經度'], recordStartTime, phone.getPropValue('color'), record['非監察號碼'], orderIndex);
                }

				trOrderList.push(orderIndex);
			}
		});

		for(var i = 0; i <= groupInfo.condictions.length; i++){
			setTimeout(function(index){

				if(index !== groupInfo.condictions.length){
					var recordList = [];
					$('#recordTB tr[unitId='+index+']').each(function(){
						recordList.push($(this).attr('orderIndex'));
					});
					googleMap.drawMarkers(recordList);
					$('#unitBar').prop('value', index);
					$('#unitBar').change();
                }
                else{
					$('#unitBar').prop('value', '-1');
					$('#unitBar').change();
				}

            }, (i*1000), i);
        }
    }

	$(function(){
		var currentTime = new Date(new Date().getTime()+(8*3600000)).toISOString().replace(/\..*Z/gi, '');
		$('#startTime').val(currentTime);
		$('#stopTime').val(currentTime);
        $('#lowerBound').html(currentTime.replace(/T/gi, ' '));
        $('#upperBound').html(currentTime.replace(/T/gi, ' '));

		$('.funBtn').on('click', function(event){
			var clickId = event.target.id;
			var clickContent = $(this).attr('contentId');

			var mainContent = $('#mainContent');
			if(clickFun !== clickId){
				mainContent.removeClass('col-md-12');
				mainContent.addClass('col-md-offset-4');
				mainContent.addClass('col-md-8');
				mainContent.css('padding-left', '');

				$('#'+clickFun).css('background-color', '');
				$(this).css('background-color', '#9d9d9d');
				clickFun = clickId;

				$('#'+lastContent).css('display', '');
				$('#'+clickContent).css('display', 'block');
				lastContent = clickContent;
			}
			else{
				mainContent.removeClass('col-md-offset-4');
				mainContent.removeClass('col-md-8');
				mainContent.addClass('col-md-12');
				mainContent.css('padding-left', '65px');

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

		$('#submitBtn').on('click', function(){
            var showing = true;
			var searchStartTime = (new Date(Date.parse($('#startTime').val()))).getTime();//-(8*3600000)
			var searchStopTime = (new Date(Date.parse($('#stopTime').val()))).getTime();//-(8*3600000)
            $('#lowerBound').html($('#startTime').val().replace(/T/gi, ' '));
            $('#upperBound').html($('#stopTime').val().replace(/T/gi, ' '));
            var timeUnit = $('input[name=unit]:checked').val();

			if(isNaN(searchStartTime) && isNaN(searchStopTime)){
				$('#timeValid').css('display', 'block');
				showing = false;
            }

            if(timeUnit === undefined){
				$('#unitValid').css('display', 'block');
				showing = false;
            }

            if(showing === true){
				showPhones = [];
				nonEmptyMap = [];
				groupInfo.condictions = [];
				groupInfo.condictions = groupByTime(searchStartTime, searchStopTime, timeUnit, '紀錄', 'millSec');
				var selected = false;
				$('.listItem').each(function(){
                    if($(this).prop('checked') == true){
                        var phoneIndex = phoneMap[$(this).val()];
                        var nonEmpty;
						phones[phoneIndex].groupList = [];
						nonEmpty = phones[phoneIndex].groupElements(groupInfo.condictions, groupInfo.fun);
                        nonEmptyMap.push(nonEmpty);
                        showPhones.push(phones[phoneIndex].groupList);
                        selected = true;
                    }
                    else{
                        showPhones.push([]);
                    }
				});

				if(selected === false){
					showPhones = [];
                    $('#listValid').css('display', 'block');
                }
                else{
					var trs = '';
					var index = 0;
					$('.optValid').css('display', '');
                    $('#unitBar').prop('max', (groupInfo.condictions.length-1));
					for(var i = 0; i < showPhones.length; i++){
						if(nonEmptyMap[i] === true){
							var phone = phones[i];
							var phoneNum = phone.getPropValue('監察號碼');
							for(var j = 0; j < showPhones[i].length; j++){
							    if(showPhones[i][j].length > 0){

							        for(var k = 0; k < showPhones[i][j].length; k++){
							        	var recordIndex = showPhones[i][j][k];
                                        var record = phone.getElementValue('紀錄', recordIndex);
							            var tr = '<tr phone="'+phoneNum+'" recordIndex="'+recordIndex+'" orderIndex="'+index+'" unitId="'+j+'">';
                                        tr += '<td>'+phoneNum+'</td>' +
	    									'<td>'+record['非監察號碼']+'</td>' +
		    								'<td>'+record['通話起始日期']+'</td>';
                                        tr += '</tr>';
                                        trs += tr;
                                        index++;
                                    }

                                }
							}
                        }
                    }

                    $('#recordTB').html(trs);
                    $('#funBtn1').click();

					drawGoogleMapMarker();

                }
            }

		});

		$('.sortBtn').on('click', function(){
			var current = $(this).html();
			$('.sortBtn').each(function(){
				$(this).html('▲');
            });

			if(current === '▲'){
				$(this).html('▼');
            }
            console.log($(this).attr('propNAme'));
        });

		$('#unitBar').on('change', function(){
		    var index = $(this).val();
		    if(index > -1){
                var lBoundTime = new Date(groupInfo.condictions[index].lowerBound).toISOString().replace(/\..*Z/gi, '');
                var uBoundTime = new Date(groupInfo.condictions[index].upperBound).toISOString().replace(/\..*Z/gi, '');
                $('#lowerBound').html(lBoundTime.replace(/T/gi, ' '));
                $('#upperBound').html(uBoundTime.replace(/T/gi, ' '));

                $('#recordTB tr').each(function(){
                    if($(this).attr('unitId') !== index){
                        $(this).css('display', 'none');
                    }
                    else{
                        $(this).css('display', '');
                    }
                });
            }
            else{
                $('#lowerBound').html($('#startTime').val().replace(/T/gi, ' '));
                $('#upperBound').html($('#stopTime').val().replace(/T/gi, ' '));

                $('#recordTB tr').each(function(){
                    $(this).css('display', '');
                });
            }
        });

	});


</script>

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
                                <input id="regexSearch" class="box0 col-md-10 is-empty" />
                                <div class="col-md-2">
                                    <div id="regexSearchBtn" class="btn glyphicon glyphicon-search "></div>
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
