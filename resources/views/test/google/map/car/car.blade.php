<?php
/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/2/10
 * Time: 上午 11:29
 */
?>
        <!doctype html>
<html>
<head>
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        .nav-pills{
            background-color: #EEE;
        }
        #csvBlock, #dataResourceBlock, #carNumberBlock, #timeBlock, #optionalBlock, #phoneListBlock, #submitBlock, #dbBlock{
            margin:10px;
        }
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map, #info{
            height: 100%;
            width: 100%;
        }
        .tab-content{
            height: calc(100% - 100px);
            width: 100%;
        }
        #markerInfo {
            height: 70%;
            width: 95%;
            margin: 20px;
            padding: 0;
            overflow-x: hidden;
            overflow-y: auto;
        }
        #carImageInfo{
            height: 30%;
            width: 95%;
            margin: 20px;
            padding: 0;
            border-color: #ffffff;
            border-style: dotted;
            text-align: center;
            align-content: center;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            background-color: #3C4858;
            /*background-color: #FFF;*/
            color: #FFF;
        }

        .blackFont{
            color: #000000;
        }

        #mapBlock{
            height: 100%;
            width: 70%;
            margin: 0;
            padding: 0;
        }
        #infoBlock{
            height: 100%;
            width: 30%;
            margin: 0;
            padding: 0;
        }
        .block, #xls_file, #markerButton{
            float:left;
        }

        .phoneColor{
            font-size: 20px;
        }

        img {
            max-width: 100%;
            max-height: 100%;
        }

    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src=" https://cdnjs.cloudflare.com/ajax/libs/xls/0.7.4-a/xls.js"></script>
    <script type="text/javascript">

		// GLOBAL VARIABLE:
		var type;
		var carMap = [];
		var carList = [];
		var map;
		var iconBase = 'http://semantic_lab/image/';
		//			var icons = [];
		var phonePath = [];
		var method = "none";
		var showingCarList = [];
		var pathList = [];
		var markerList = [];
		var nextList = [];

		// CLASS:
		function Record(){
			this.id;
			var carNumber;
			var startTime;
			var locationLat;
			var locationLon;
			var command;
			var imageURL;
			var timeStamp;

			this.setRecord = function(cN, sT, lat, lon, com, img){
				carNumber = cN;
				startTime = sT;
				locationLat = lat;
				locationLon = lon;
				command = com;
				imageURL = img;
				timeStamp = (new Date(Date.parse(sT+":00"))).getTime();
			};

			this.getCarNumber = function (){
				return carNumber;
			};

			this.getStartTime = function(){
				return startTime;
			};

			this.getLocationLat = function(){
				return locationLat;
			};

			this.getLocationLon = function(){
				return locationLon;
			};

			this.getCommand = function(){
				return command;
            };

            this.getImageURL = function(){
				return imageURL;
            };

            this.getTimestamp = function(){
            	return timeStamp;
            };
		}

		function CarNumber(cN){
			var carNumber = cN;
			var recordList = [];
			this.color;

			this.pushRecord = function(record){
				recordList.push(record);
				this.color = randomRGB();
			};

			this.getCarNumber = function(){
				return carNumber;
			};

			this.getRecordList = function(){
				var newRecordList = [];

				var sDate = $('#sDate').val();
				var sTime = $('#sTime').val();
				var eDate = $('#eDate').val();
				var eTime = $('#eTime').val();
				var startDT = (new Date(Date.parse(sDate+" "+sTime)).getTime());
				var endDT = (new Date(Date.parse(eDate+" "+eTime)).getTime());
				console.log(startDT+" / "+endDT);
				if(isNaN(startDT) === false && isNaN(endDT) === false){console.log('A');
					for(var i = 0;i < recordList.length; i++){
						var recordTime = recordList[i].getTimestamp();
						console.log(recordTime);
						if(startDT <= recordTime && recordTime <= endDT ){
							newRecordList.push(recordList[i]);
						}
					}
                }
				else if(isNaN(startDT) === false && isNaN(endDT) === true){console.log('B');
					for(var i = 0;i < recordList.length; i++){
						var recordTime = recordList[i].getTimestamp();
						if(startDT <= recordTime){
							newRecordList.push(recordList[i]);
						}
					}
				}
				else if(isNaN(startDT) === true && isNaN(endDT) === false){console.log('C');
					for(var i = 0;i < recordList.length; i++){
						var recordTime = recordList[i].getTimestamp();
						if(recordTime <= endDT ){
							newRecordList.push(recordList[i]);
						}
					}
				}
				else if(isNaN(startDT) === true && isNaN(endDT) === true){console.log('D');
					newRecordList = recordList;
				}


				return newRecordList;
			};

			var randomRGB = function(){
				var r = Math.round((Math.random()*1000)%255);
				var g = Math.round((Math.random()*1000)%255);
				var b = Math.round((Math.random()*1000)%255);
				return "rgb("+r+", "+g+", "+b+")";
			};
		}

		function Icon(url){
			this.url = 'https://lh4.ggpht.com/V4-FZDGtlPhd7tjY4aCQcWLG_Cmc8c-t7Q-yrQbwSn8tAqBGGxvfrNSCX8tUoDoWAA=w300';
			this.scaledSize = new google.maps.Size(60, 60);
			this.origin = new google.maps.Point(0, 0);
//			this.anchor = new google.maps.Point(0, 30);
		}

		// FUNCTION:

		function delay(time){
			var start = new Date().getTime();
			while(true){
				var end = new Date().getTime();
				var nowTime = end-start;
				if(nowTime > time){
					break;
				}
			}
		}

		function sleep(milliseconds) {
			var start = new Date().getTime();
			for (var i = 0; i < 1e7; i++) {
				if ((new Date().getTime() - start) > milliseconds){
					break;
				}
			}
		}

		function fullDrawing(carIndex, index, recordList, color, time){

			if(nextList[carIndex] === true){
				window.setTimeout(function() {
					addRecordMarker(index, recordList, color);
					var index2 = index+1;
					addRecordPhonePath(index2, recordList, color);

					if(index2 < recordList.length){
						fullDrawing(carIndex, index2, recordList, color, time);
					}
					else{
						nextList[carIndex+1] = true;
					}
				}, time);
			}
			else if(nextList[carIndex] === false){
				window.setTimeout(function() {
					fullDrawing(carIndex, index, recordList, color, time);
				}, time);
			}

		}

		function main(){
//				setIcons();
			resourceEvent();
			$("#markerButton").click(function(){

				initialization();
				var carNumber = $('#carNumber').val();

				for(var i = 0; i < showingCarList.length; i++){
					if(i === 0){
						nextList.push(true);
					}
					else{
						nextList.push(true);
					}
				}
				var delay = 1000;
				if(showingCarList.length > 1){
					delay = 1000;
				}

				for(var i = 0; i < showingCarList.length; i++){
					var recordList = showingCarList[i].getRecordList(); console.log(recordList);
					var carRGB = showingCarList[i].color;
					fullDrawing(i, 0, recordList, carRGB, delay);
				}
			});
		}

		function CSV(){
			// set the event linstener:
			$(function() {
				oFileIn = document.getElementById('xls_file');
				if(oFileIn.addEventListener) {
					oFileIn.addEventListener('change', pickFileEvent, false);
				}
			});

			// event listener:
			function pickFileEvent(oEvent) {
				// Get The File From The Input
				var oFile = oEvent.target.files[0];
				var sFilename = oFile.name;
				// Create A File Reader HTML5
				var reader = new FileReader();

				// Ready The Event For When A File Gets Selected
				reader.onload = function(e) {
					var data = e.target.result;
					var cfb = XLS.CFB.read(data, {type: 'binary'});
					var wb = XLS.parse_xlscfb(cfb);
					// Loop Over Each Sheet
					wb.SheetNames.forEach(function(sheetName) {
						if(sheetName === "車辨記錄"){
							var oJS = XLS.utils.sheet_to_row_object_array(wb.Sheets[sheetName], {'date_format':'dd/mm/yyyy hh:mm'});
							for(var i = 0; i < oJS.length; i++){

								var carNumber = oJS[i].車號;
								var record = new Record();
								var car;
								record.setRecord(carNumber, oJS[i].時間, oJS[i].緯度, oJS[i].經度, oJS[i].備註, oJS[i].圖檔連結);
								if(carMap[carNumber] === undefined){
									car = new CarNumber(carNumber);
									record.id = carNumber+"_0";
									car.pushRecord(record);
									carList.push(car);
									carMap[carNumber] = carList.length-1;
								}
								else{
									var listIndex = carMap[carNumber];
									car = carList[listIndex];
									record.id = carNumber+"_"+car.getRecordList().length;
									car.pushRecord(record);
								}
							}
							console.log(carList);
						}
					});
					googleMap();
					initTable();
//					settingEvent();
				};

				// Tell JS To Start Reading The File.. You could delay this if desired
				reader.readAsBinaryString(oFile);
			}
		}




		function googleMap() {
			map = new google.maps.Map(document.getElementById('map'), {
				zoom: 9,
				center: new google.maps.LatLng(carList[0].getRecordList()[0].getLocationLat() , carList[0].getRecordList()[0].getLocationLon()),
				mapTypeId: 'roadmap'
			});
		}

		function addMarker(record, color) {
			var markerOrder = new google.maps.Marker({
				position: record.position,
//				icon: {
//					path: google.maps.SymbolPath.CIRCLE,
//					scale: 8,
//					fillColor: "#FFF",
//					fillOpacity: 0.8,
//					strokeWeight: 0,
//					labelOrigin: new google.maps.Point(0, 0)
//				},
                icon: new Icon(),
				map: map,
				label:{
					text: record.id.split("_")[1],
					color: "#000",
					fontSize: "18px"
				}
			});

			var marker = new google.maps.Marker({
				position: record.position,
				icon: {
					path: google.maps.SymbolPath.CIRCLE,
					scale: 16,
					fillColor: color,
					fillOpacity: 0.7,
					strokeColor: color,
					strokeWeight: 1,
					labelOrigin: new google.maps.Point(0, 2)
				},
				map: map,
				label:{
					text: record.getCarNumber(),
					color: color,
					fontSize: "16px"
				}
			});
			addMarkerEvent(record, marker, "table");
			markerList.push(markerOrder);
			markerList.push(marker);
//        showMarkerInfo(record);
			addTableInfo(record);
		}

		function initialization(){
			removeAllPath();
			removeAllMarker();
			addShowingPhone();
			initTable();
			nextList = [];
		}

		// Sets the map on all markers in the array.
		function setMapOnAll(map) {
			for (var i = 0; i < markerList.length; i++) {
				markerList[i].setMap(map);
			}
		}

		function removeAllMarker(){
			setMapOnAll(null);
			markerList = [];
			showingCarList = [];
		}

		function addMarkerEvent(record, marker, type){
			// for onClick:
			marker.addListener('click', function(){
				showMarkerInfo(record, type);
			});
		}

		function showMarkerInfo(record, type){
			if(type === "simple"){
				$("#markerInfo").html(function(){
					return "Phone Number: "+record.getCarNumber()+"<br>"+
						"Start Time: "+record.getStartTime()+"<br>"+
						"Lat: "+record.getLocationLat()+"<br>"+
						"Lon: "+record.getLocationLon()+"<br>";
				});
			}
			else if(type === "table"){
				$("#tbody tr").each(function(){
					$(this).attr('class', '');
					$(this).attr('style', 'color:#FFF;');
				});

				$("#"+record.id).attr('class', 'danger');
				$("#"+record.id).attr('style', 'color:#000;');
				$('#carImageInfo').html('<img src="'+record.getImageURL()+'" alt="">');
			}
		}

		function addMapInfo(record){
			record.position = new google.maps.LatLng(record.getLocationLat(), record.getLocationLon());
			record.type = 'phone';
		}

		function addRecordMarker(index, recordList, color){
			if(index < recordList.length){
				addMapInfo(recordList[index], color);
				addMarker(recordList[index], color);
			}
			else{
				alert("There is no more record to add.");
			}
		}

		function addShowingPhone(){
//			if(method === "single"){
//				$('input[type=radio][name=phone]:checked').each(function() {
//					showingCarList[0] = carList[this.value];
//				});
//			}
//			else if(method === "multiple"){
//				$('input[type=checkbox][name=phone]:checked').each(function() {
//					showingCarList.push(carList[this.value]);
//				});
//			}

            if($('#carNumber').val() === undefined || $('#carNumber').val() === '' || $('#carNumber').val() === null){
				showingCarList = carList;
            }
            else{
				for(var i = 0; i < carList.length; i++){
					if(carList[i].getCarNumber() === $('#carNumber').val()){
						showingCarList.push(carList[i]);
                    }
                }
            }

		}


		function addRecordPhonePath(index, recordList, color){
			if(index > 1 && index <= recordList.length){
				var newPath = [];
				newPath.push(addPathInfo(recordList[index-2]));
				newPath.push(addPathInfo(recordList[index-1]));
				addPhonePath(newPath, color);
			}
		}

		function addPathInfo(record){
			var lat = parseFloat(record.getLocationLat());
			var lon = parseFloat(record.getLocationLon());
			var path = {lat: lat, lng: lon};
			return path;
		}

		function addPhonePath(phonePath, color){
			var path = new google.maps.Polyline({
				path: phonePath,
				geodesic: true,
				strokeColor: color,
				strokeOpacity: 1.0,
				strokeWeight: 3
			});
			path.setMap(map);
			pathList.push(path);
		}

		function setMapOnAllPath(map) {
			for (var i = 0; i < pathList.length; i++) {
				pathList[i].setMap(map);
			}
		}

		function removeAllPath(){
			setMapOnAllPath(null);
			pathList = [];
		}


		function initTable(){
			$("#markerInfo").html(function(){
				return '<table class="table">\n\
										<thead><tr> <th>車號</th> <th>時間</th> <th>緯度</th> <th>經度</th> </tr></thead>\n\
										<tbody id="tbody"></tbody>\n\
									</table>';
			});
		}


		function addTableInfo(record){
			$("#tbody").html(function(){
				return $("#tbody").html()+'<tr id="'+record.id+'">\n\
										<td>'+record.getCarNumber()+'</td>\n\
										<td>'+record.getStartTime()+'</td>\n\
										<td>'+record.getLocationLat()+'</td>\n\
										<td>'+record.getLocationLon()+'</td>\n\
									</tr>';
			});
		}


//        addPhoneList has to be check
        /*
		function settingEvent(){
			addPhoneList("radio");
			$('input[type=radio][name=method]').change(function() {
				if (this.value === 'single') {
					addPhoneList("radio");
					method = "single";
				}
				else if (this.value === 'multiple') {
					addPhoneList("checkbox");
					method = "multiple";
				}
			});
		}
		*/

		function resourceEvent(){
			$('input[type=radio][name=resource]').change(function() {
				if (this.value === 'csv') {
					$('#resourceBlock').html('<!--CSV FILE:-->\n\
                  <div id="csvBlock">LOAD CSV:<br>\n\
                    <input id="xls_file" type="file"  class="file">\n\
                  </div>\n\
                  <br>');
					type = "csv";
					CSV();
				}
				else if (this.value === 'db') {
					$('#resourceBlock').html('<!--LOAD FROM DB-->\n\
                <div id="dbBlock">\n\
                  <button id="markerButton" type="button" class="btn btn-info">Load Data</buton>\n\
                </div>\n\
                <br><br>');
					type = "db";
//					// 【===================================================】
//					// NOT YET
//					// 【===================================================】
				}
			});
		}

		function addPhoneList(type){
			$("#carList").html(function(){
				var list = "";
				for(var i = 0; i < carList.length; i++){
					list += '<tr> \n\
											<td><input type="'+type+'" value="'+i+'" name="phone"></td>\n\
											<td>'+carList[i].getCarNumber()+'</td>\n\
											<td style="color:'+carList[i].color+';" class="phoneColor">&#9632;</td>\n\
										</tr>';
				}
				return list;
			});
		}

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4KGAZ9H0TBoWEN0c6R5u60Nt7s5cijwo&signed_in=true&callback=initMap" async defer></script>
</head>
<body onload="main()">

<div id="infoBlock" class="block" >
    <ul class="nav nav-pills nav-justified">
        <li class="active"><a data-toggle="pill" href="#setting">查詢條件</a></li>
        <li><a data-toggle="pill" href="#info">列表模式</a></li>
    </ul>
    <div class="tab-content">
        <div id="setting" class="tab-pane fade in active">

            <!--DATA RESOURCE OPTIONAL-->
            <div id="optionalBlock">
                檔案來源:<br>
                <label class="radio-inline"><input type="radio" value="csv" name="resource">CSV FILE</label>
                <label class="radio-inline"><input type="radio" value="db" name="resource">DATA WAREHOUSE</label>
            </div>

            <div id="resourceBlock">
                <br>
            </div>
            <br>

            <div id="dataResourceBlock">
                資料來源:<br>
                <div><input type="checkbox"> 全選</div>
                <div><input type="checkbox"> 路口監視器</div>
                <div><input type="checkbox"> eTag車辨</div>
                <div><input type="checkbox"> 打卡車辨</div>
            </div>
            <br>
            <br>


            <!--OPTIONAL LIST
            <div id="optionalBlock">
                OPTIONAL:<br>
                <label class="radio-inline"><input type="radio" value="single" name="method">Single Number</label>
                <label class="radio-inline"><input type="radio" value="multiple" name="method">Multi Number</label>
            </div>
            <br>
            <br>
            -->


            <!--PHONE LIST
            <div id="phoneListBlock">
                PHONE LIST:<br>
                <table class="table table-condensed">
                    <thead><tr><td>Selected</td><td>Phone Number</td><td>Color</td></thead>
                    <tbody id="phoneList">
                    </tbody>
                </table>
            </div>
            <br>
            <br>
            -->


            <!--CONDITION LIST-->
            <div id="carNumberBlock">
                查詢條件:<br><br>
                車牌號碼: <input id="carNumber" class="input-sm blackFont" type="text">
            </div>
            <div id="timeBlock">
                <div>起始時間: <input id="sDate" class="input-sm blackFont" type="date"> <input id="sTime" class="input-sm blackFont" type="time"></div>
                <div>起始時間: <input id="eDate" class="input-sm blackFont" type="date"> <input id="eTime" class="input-sm blackFont" type="time"></div>
            </div>
            <br>
            <br>

            <!--SUBMIT LIST-->
            <div id="submitBlock">
                <button id="markerButton" type="button" class="btn btn-info">送出</button>
            </div>

        </div>
        <div id="info" class="tab-pane fade">
            <div id="markerInfo"></div>
            <div id="carImageInfo"></div>
        </div>
    </div>
</div>

<div id="mapBlock" class="block" >
    <div id="map"></div>
</div>
</body>
</html>
