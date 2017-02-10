<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>



<!doctype html>
<html>
	<head>
		<title>{{ $title }}</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<style>
			.nav-pills{
				background-color: #AAA;
			}
      
			#csvBlock, #optionalBlock, #phoneListBlock, #submitBlock, #dbBlock, #messageBlock{
				margin:10px;
			}
			/* Always set the map height explicitly to define the size of the div
			 * element that contains the map. */
			#map {
				height: 100%;
				width: 100%;
			}
			#markerInfo {
				height: 95%;
				width: 95%;
				margin: 20px;
				padding: 0;
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
				overflow-y: scroll;
				overflow-x: hidden;
			}
			.block, #xls_file, #markerButton{
				float:left;
			}

			.phoneColor{
				font-size: 20px;
			}

			.tab-content{
/*				height: 94.5%;
				width: 100%;*/
/*				overflow-y: scroll;
				overflow-x: hidden;*/
			}

		</style>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src=" https://cdnjs.cloudflare.com/ajax/libs/xls/0.7.4-a/xls.js"></script>
		<script type="text/javascript">

		// GLOBAL VARIABLE
		// for loading data:
		var googleMap = new Map();
		var phoneMap = [];
		var phoneList = [];
		var showingPhoneList = [];
		var startDrawingList = [];
		var nextList = [];
		// for user input data:
		var method;



		// CLASS
		// PHONE
		/**
		 * Class of Phone
		 * @returns {Phone}
		 */
		function Phone(){
			this.id;
			this.recordList = [];
			this.phoneNumber;
			this.color;

			/**
			 * Initilization of Phone object
			 * @param {String} id
			 * @param {String} phoneNumber
			 */
			this.initialization = function(id, phoneNumber){
				this.id = id;
				this.phoneNumber = phoneNumber;
				this.color = randomColor();
			};

			/**
			 * The function for order Record objects by startTime
			 */
			this.orderByStartTime = function(){
				this.recordList.sort(function(a, b){
						var time0 = a.timeStamp;
						var time1 = b.timeStamp;
						// Compare the 2 dates
						if(time0 < time1){
							return -1;
						}
						if(time0 > time1){
							return 1;
						}

						return 0;
				});
			};

			/**
			 * Random RGB color value for setting Phone object
			 */
			var randomColor = function(){
				var r = Math.round((Math.random()*1000)%255);
				var g = Math.round((Math.random()*1000)%255);
				var b = Math.round((Math.random()*1000)%255);
				return "rgb("+r+", "+g+", "+b+")";
			};
		}


		// RECORD
		function Record(){
			this.id;
			this.phoneNumber;
			this.startTime;
			this.originalSartTime;
			this.timeStamp;
			this.locationLat;
			this.locationLng;
			this.type;

			/**
			 * Initilization of Record object
			 * @param {String} id
			 * @param {String} phoneNumber
			 * @param {String} startTime
			 * @param {String} lat
			 * @param {String} lng
			 */
			this.initialization = function(id, phoneNumber, startTime, lat, lng){
				this.id = id;
				this.phoneNumber = phoneNumber;
				this.startTime = setTime("", "-", startTime, ":");
				this.originalSartTime = startTime;
				this.locationLat = lat;
				this.locationLng = lng;
				this.timeStamp = getTimeStamp(this.startTime);
				this.type = "phone";
			};

			/**
			 * The private function for convert String date & time into Date object
			 * @param {String} date
			 * @param {String} dateSymbol :the symbol to split date parameter into array
			 * @param {String} time
			 * @param {String} timeSymbol :the symbol to split time parameter into array
			 * @returns {Date}
			 */
			var setTime = function(date, dateSymbol, time, timeSymbol){
				var dateArray = date.split(dateSymbol);
				var timeArray = time.split(timeSymbol);
				if(dateArray.length === 3 && timeArray.length === 3){
					return new Date(dateArray[0], dateArray[1], dateArray[2], timeArray[0], timeArray[1], timeArray[2]);
				}
				else if(dateArray.length === 3 && timeArray.length < 3){
					return new Date(dateArray[0], dateArray[1], dateArray[2], 0, 0, 0);
				}
				else if(dateArray.length < 3 && timeArray.length === 3){
					return new Date(0, 0, 0, timeArray[0], timeArray[1], timeArray[2]);
				}
				else if(dateArray.length < 3 && timeArray.length < 3){
					return new Date(0, 0, 0, 0, 0, 0);
				}
			};

			/**
			 * The private function for convert Date object into timestamp
			 * @param {Date} date
			 * @returns {unresolved}
			 */
			var getTimeStamp = function(date){
				return date.getTime();
			};

		}


		// MAP
		function Map(){
			this.map;
			this.markerList = [];
			this.pathList = [];

			/**
			 * Initilization of Map object
			 * @param {String} domId
			 * @param {String|Number} lat
			 * @param {String|Number} lng
			 */
			this.initilization = function(domId, lat, lng){
				this.map = new google.maps.Map(document.getElementById(domId), {
					zoom: 14,
					center: new google.maps.LatLng(lat , lng),
					mapTypeId: 'roadmap'
				});
			};

			/**
			 * The function for create a Google Map Marker object
			 * @param {Record} record
			 * @param {String} color
			 */
			this.addMarker = function(record, recordId, color){
				var orderMarker = new google.maps.Marker({
//					draggable: true,
					position: new google.maps.LatLng(record.locationLat, record.locationLng),
					icon: {
						path: google.maps.SymbolPath.CIRCLE,
						scale: 8,
						fillColor: "#FFF",
						fillOpacity: 0.8,
						strokeWeight: 0,
						labelOrigin: new google.maps.Point(0, 0)
					},
					map: this.map,
					label:{
						text: recordId,
						color: "#000",
						fontSize: "18px"
					}
				});

				var mainMarker = new google.maps.Marker({
//					draggable: true,
					position: new google.maps.LatLng(record.locationLat, record.locationLng),
					icon: {
						path: google.maps.SymbolPath.CIRCLE,
						scale: 16,
						fillColor: color,
						fillOpacity: 0.7,
						strokeColor: color,
						strokeWeight: 1,
						labelOrigin: new google.maps.Point(0, 2)
					},
					map: this.map,
					label:{
						text: record.phoneNumber,
						color: color,
						fontSize: "16px"
					}
				});
				addMarkerEvent(record, mainMarker, "table");

				this.markerList.push(orderMarker);
				this.markerList.push(mainMarker);
			};

			/**
			 * The function which remove all the Marker objects on the Google Map
			 */
			this.removeAllMarker = function(){
				for (var i = 0; i < this.markerList.length; i++) {
					this.markerList[i].setMap(null);
				}
				this.markerList = [];
			};

			/**
			 * All eventsListener for Marker object
			 * @param {Record} record
			 * @param {google.maps.Marker} marker
			 * @param {String} type
			 */
			var addMarkerEvent = function(record, marker, type){
				// for onClick:
				marker.addListener('click', function(){
					highlightMarkerInfo(record, type);
				});

				// others event:
			};

			/**
			 * The function to create path of phone record
			 * @param {Number|String} index
			 * @param {Array} recordList
			 * @param {String} color
			 * @returns {undefined}
			 */
			this.addRecordsPath = function(index, recordList, color){
				// the path needs to between two Marker, as a result,
				// there is no path while Map object only has one Marker object
				if(index > 0 && index < recordList.length){
					var pathInfo = [];
					pathInfo.push( { lat: parseFloat(recordList[index-1].locationLat), lng: parseFloat(recordList[index-1].locationLng) } );
					pathInfo.push( { lat: parseFloat(recordList[index].locationLat), lng: parseFloat(recordList[index].locationLng) } );
					var path = this.addPolyline(pathInfo, color);
					path.setMap(this.map);
					this.pathList.push(path);
				}
			};

			/**
			 * Create a Google Map Polyline object
			 * @param {Array} pathInfo The geo info which include lat and lng of record
			 * @param {String} color
			 */
			this.addPolyline = function(pathInfo, color){
				var path = new google.maps.Polyline({
					path: pathInfo,
					geodesic: true,
					strokeColor: color,
					strokeOpacity: 1.0,
					strokeWeight: 3
				});

				return path;
			};

			/**
			 * The function which remove all Polyline objects on the Map object
			 */
			this.removeAllRecordsPath = function(){
				for (var i = 0; i < this.pathList.length; i++) {
					this.pathList[i].setMap(null);
				}
				this.pathList = [];
			};

		}



		// FUNCTION
		// HTML DOM
		/**
		 * Initiliza the head of table which shows
		 * information about all the phone record that user choose
		 */
		function initTable(){
			$("#markerInfo").html(function(){
				return '<table class="table">\n\
							<thead><tr> \n\
									<th><span class="glyphicon glyphicon-phone"></span> Phone Number</th> \n\
									<th><span class="glyphicon glyphicon-time"></span> Start Time</th> \n\
									<th><span class="glyphicon glyphicon-map-marker"></span> Lat</th> \n\
									<th><span class="glyphicon glyphicon-map-marker"></span> Lon</th> \n\
							</tr></thead>\n\
							<tbody id="tbody"></tbody>\n\
						</table>';
			});
		}

		/**
		 * The function which add the record information into table
		 * @param {Record} record
		 */
		function addTableInfo(record){
			$("#tbody").html(function(){
				return $("#tbody").html()+'<tr id="'+record.id+'">\n\
									<td>'+record.phoneNumber+'</td>\n\
									<td>'+record.originalSartTime+'</td>\n\
									<td>'+record.locationLat+'</td>\n\
									<td>'+record.locationLng+'</td>\n\
								</tr>';
			});
		}

		/**
		 * Load all event functions of Dom objects
		 */
		function settingEvent(){
			// for resource radio button:
			$('input[type=radio][name=resource]').change(function() {
					if (this.value === 'csv') {
						$('#resourceBlock').html('\
								<!--CSV FILE:-->\n\
								<div id="csvBlock">LOAD CSV:<br>\n\
									<input id="xls_file" type="file"  class="file">\n\
								</div>\n\
								<br>');
						type = "csv";
						csv();
					}
					else if (this.value === 'db') {
						$('#resourceBlock').html('\
							<!--LOAD FROM DB-->\n\
							<div id="dbBlock">\n\
								<button id="markerButton" type="button" class="btn btn-info">Load Data</buton>\n\
							</div>\n\
							<br><br>');
						type = "db";
						db();
					}
			});

			// for method radio button
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

			// for starting drawing Marker and Path object button
			$("#markerButton").click(function(){
				initDataProcess();
				drawingAllPhoneInfo();
			});
		}

    function resetPage(){
		googleMap = new Map();
		phoneMap = [];
		phoneList = [];
		showingPhoneList = [];
		startDrawingList = [];
		nextList = [];
		method = "";

		$("#phoneList").html("");

		$('input[type=radio][name=method]:checked').each(function(){
			$(this).prop('checked', false);
		});
    }

    function addWarningMessage(message){
		if(message !== null){
			$("#messageBlock").html(function(){
				return '<div class="alert alert-warning alert-dismissable fade in">\n\
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>\n\
									<strong>Warning!</strong>\n\
									'+message+'</div>';
			});
		}
		else{
			$("#messageBlock").html("");
		}
    }

		// Action:
		/**
		 * The action which will add all Phone object's information
		 * @param {String} type
		 */
		function addPhoneList(type){
			$("#phoneList").html(function(){
				var list = "";
				for(var i = 0; i < phoneList.length; i++){
					list += '<tr> \n\
								<td><input type="'+type+'" value="'+i+'" name="phone"></td>\n\
								<td>'+phoneList[i].phoneNumber+'</td>\n\
								<td style="color:'+phoneList[i].color+';" class="phoneColor">&#9632;</td>\n\
							</tr>';
				}
				return list;
			});
		}

		/**
		 * The action which will highlight the information which in table
		 * about the Marker object that user click
		 * @param {Record} record
		 * @param {String} type
		 * @returns {undefined}
		 */
		function highlightMarkerInfo(record, type){
			if(type === "table"){
				$("#tbody tr").each(function(){
					$(this).attr('class', '');
					$(this).attr('style', 'color:#FFF;');
				});

				$("#"+record.id).attr('class', 'danger');
				$("#"+record.id).attr('style', 'color:#000;');
			}
		}


		// Process functions
		/**
		 * The main process that needs to loads
		 * @returns {undefined}
		 */
		function mainProcess(){
			settingEvent();
		}

		/**
		 * Initiliza the data taht are going to drawing on Google Map object
		 * @returns {undefined}
		 */
		function initDataProcess(){
			googleMap.removeAllRecordsPath();
			googleMap.removeAllMarker();
			showingPhoneList = [];
			nextList = [];
			addShowingPhoneList();
			initTable();

			if(phoneList.length > 0){
				if(method !== "single" && method !== "multiple"){
					addWarningMessage('Please select "Single" or "Multiple" optional and get the phone number(s).');
				}
				else{
					if(method === "single" && showingPhoneList.length === 0){
						addWarningMessage('Please select the phone number that is goning to show on map.');
					}
					else if(method === "multiple" && showingPhoneList.length === 0){
						addWarningMessage('Please select the phone numbers that are goning to show on map.');
					}
					else{
						addWarningMessage(null);
					}
				}
			}
			else{
				addWarningMessage('Please load the file with phone records.');
			}
		}

		/**
		 * Get the phone number of user selected and set as showing phone
		 * @returns {undefined}
		 */
		function addShowingPhoneList(){
			if(method !== undefined){
				if(method === "single"){
					$('input[type=radio][name=phone]:checked').each(function() {
						showingPhoneList[0] = phoneList[this.value];
					});
				}
				else if(method === "multiple"){
					$('input[type=checkbox][name=phone]:checked').each(function() {
						showingPhoneList.push(phoneList[this.value]);
					});
				}

				nextList[0] = true;
				for(var i = 1; i < showingPhoneList.length; i++){
					nextList[i] = false;
				}
			}
			else{
				// SHOW THE WARNING MESSAGE
			}
		}

		/**
		 * Drawing all phones information on the Google Map object
		 * @returns {undefined}
		 */
		function drawingAllPhoneInfo(){
			var delay = 1000;
			if(showingPhoneList.length > 1){
				delay = 0;
			}

			for(var i = 0; i < showingPhoneList.length; i++){
				showingPhoneList[i].orderByStartTime();
				drawingAllRecordInfo(i, 0, delay);
			}
		}

		/**
		 * Drawing all records information on the Google Map object
		 * with setTimeout function
		 * @param {Number} phoneIndex
		 * @param {Number} recordIndex
		 * @param {Number} delayTime
		 * @returns {undefined}
		 */
		function drawingAllRecordInfo(phoneIndex, recordIndex, delayTime){
			if(nextList[phoneIndex] === true){
				window.setTimeout(function() {
					var recordList = showingPhoneList[phoneIndex].recordList;
					var color = showingPhoneList[phoneIndex].color;
					googleMap.addMarker(recordList[recordIndex], (recordIndex+1).toString(), color);
					googleMap.addRecordsPath(recordIndex, recordList, color);
					addTableInfo(recordList[recordIndex]);
					recordIndex++;

					if(recordIndex < recordList.length){
						drawingAllRecordInfo(phoneIndex, recordIndex, delayTime);
					}
					else{
						nextList[phoneIndex+1] = true;
					}

				}, delayTime);
			}
			else if(nextList[phoneIndex] === false){
				window.setTimeout(function() {
					drawingAllRecordInfo(phoneIndex, recordIndex, delayTime);
				}, delayTime);
			}
		}

		// resource function
		function csv(){
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
					wb.SheetNames.forEach(function(sheetName){
						if(sheetName === "通聯記錄"){

							resetPage();

							var oJS = XLS.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);
							for(var i = 0; i < oJS.length; i++){
								var phoneNumber = oJS[i]['監察號碼'];
								var phone;
								var record = new Record();
								if(phoneMap[phoneNumber] === undefined){
									record.initialization(phoneNumber+"_0", phoneNumber, oJS[i]['通話起始時間'], oJS[i]['緯度'], oJS[i]['經度']);
									phone = new Phone();
									phone.initialization(phoneList.length, phoneNumber);
									phone.recordList.push(record);
									phoneMap[phoneNumber] = phoneList.length;
									phoneList.push(phone);
								}
								else{
									var phoneIndex = phoneMap[phoneNumber];
									var recordIndex = phone.recordList.length;
									record.initialization(phoneNumber+"_"+recordIndex, phoneNumber, oJS[i]['通話起始時間'], oJS[i]['緯度'], oJS[i]['經度']);
									phone = phoneList[phoneIndex];
									phone.recordList.push(record);
								}
							}
						}
					});

					googleMap.initilization("map", phoneList[0].recordList[0].locationLat, phoneList[0].recordList[0].locationLng);
					initTable();
				};

				// Tell JS To Start Reading The File.. You could delay this if desired
				reader.readAsBinaryString(oFile);
			}
		}

		</script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4KGAZ9H0TBoWEN0c6R5u60Nt7s5cijwo&signed_in=true&callback=initMap" async defer>	</script>
	</head>

	<body onload="mainProcess()">
		<div id="infoBlock" class="block" >
			<ul class="nav nav-pills nav-justified">
				<li class="active"><a data-toggle="pill" href="#setting">Setting</a></li>
				<li><a data-toggle="pill" href="#info">Map Information</a></li>
			</ul>
			<div class="tab-content">
				<div id="setting" class="tab-pane fade in active">

					 <!--DATA RESOURCE OPTIONAL-->
					<div id="optionalBlock">
						DATA RESOURCE:<br>
						<label class="radio-inline"><input type="radio" value="csv" name="resource">CSV FILE</label>
						<label class="radio-inline"><input type="radio" value="db" name="resource">DATA WAREHOUSE</label>
					</div>
					<div id="resourceBlock">
						<br>
						<br>
					</div>
					<br>
					<br>

					<div id="optionalBlock">
						OPTIONAL:<br>
						<label class="radio-inline"><input type="radio" value="single" name="method">Single Number</label>
						<label class="radio-inline"><input type="radio" value="multiple" name="method">Multi Number</label>
					</div>
					<br>
					<br>


					<!--PHONE LIST-->
					<div id="phoneListBlock">
						PHONE LIST:<br>
						<table class="table table-condensed">
							<thead><tr><td><span class="glyphicon glyphicon-ok"></span></td><td>Phone Number</td><td>Color</td></thead>
							<tbody id="phoneList"></tbody>
						</table>
					</div>
					<br>
					<br>

					<!--SUBMIT LIST-->
					<div id="submitBlock">
						<button id="markerButton" type="button" class="btn btn-info">SUBMIT</button>
					</div>
					<br>
					<br>

					<div id="messageBlock">
					</div>
				</div>

				<div id="info" class="tab-pane fade">
					<div id="markerInfo"></div>
				</div>
			</div>
		</div>

		<div id="mapBlock" class="block" >
			<div id="map"></div>
		</div>
		<br>
		<br>
	</body>

</html>
