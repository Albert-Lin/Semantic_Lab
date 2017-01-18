<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * 
 * SCROLLBAR
 * THE ORDER OF PHONE RECORD
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
			#csvBlock, #optionalBlock, #phoneListBlock, #submitBlock{
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
			}
			.block, #xls_file, #makerButton{
				float:left;
			}

			.phoneColor{
				font-size: 20px;
			}

		</style>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src=" https://cdnjs.cloudflare.com/ajax/libs/xls/0.7.4-a/xls.js"></script>
		<script type="text/javascript">

			// GLOBAL VARIABLE:
			var phoneMap = [];
			var phoneList = [];
			var map;
			var iconBase = 'http://semantic_lab/image/';
//			var icons = [];
			var phonePath = [];
			var method = "none";
			var showingPhoneList = [];
			var pathList = [];
			var markerList = [];
			var nextList = [];

			// CLASS:
			function Record(){
				this.id;
				var phoneNumber;
				var startTime;
				var locationLat;
				var locationLon;

				this.setRecord = function(pN, sT, lat, lon){
					phoneNumber = pN;
					startTime = sT;
					locationLat = lat;
					locationLon = lon;
				};

				this.getPhoneNumber = function(){
					return phoneNumber;
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
			}

			function PhoneNumber(pN){
				var phoneNumber = pN;
				var recordList = [];
				this.color;

				this.pushRecord = function(record){
					recordList.push(record);
					this.color = randomRGB();
				};

				this.getPhoneNumber = function(){
					return phoneNumber;
				};

				this.getRecordList = function(){
					return recordList;
				};

				var randomRGB = function(){
					var r = Math.round((Math.random()*1000)%255);
					var g = Math.round((Math.random()*1000)%255);
					var b = Math.round((Math.random()*1000)%255);
					return "rgb("+r+", "+g+", "+b+")";
				};
			}

			function Icon(url){
				this.url = url;
				this.scaledSize = new google.maps.Size(30, 30);
				this.origin = new google.maps.Point(0, 0);
				this.anchor = new google.maps.Point(15, 15);
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

			function fullDrawing(phoneIndex, index, recordList, color, time){

				if(nextList[phoneIndex] === true){
					window.setTimeout(function() {
						addRecordMarker(index, recordList, color);
						var index2 = index+1;
						addRecordPhonePath(index2, recordList, color);

						if(index2 < recordList.length){
							fullDrawing(phoneIndex, index2, recordList, color, time);
						}
						else{
							nextList[phoneIndex+1] = true;
						}
					}, time);
				}
				else if(nextList[phoneIndex] === false){
					window.setTimeout(function() {
						fullDrawing(phoneIndex, index, recordList, color, time);
					}, time);
				}

			}

//			function setIcons(){
//				// set icon object:
//				icons.push(new Icon(iconBase+'phone.png'));
//			}

			function main(type){
//				setIcons();
				$("#makerButton").click(function(){

					initialization();
					for(var i = 0; i < showingPhoneList.length; i++){
						if(i === 0){
							nextList.push(true);
						}
						else{
							nextList.push(false);
						}
					}
					var delay = 1000;
					if(showingPhoneList.length > 1){
						delay = 0;
					}

					for(var i = 0; i < showingPhoneList.length; i++){
						var recordList = showingPhoneList[i].getRecordList();
						var phoneRGB = showingPhoneList[i].color;
						fullDrawing(i, 0, recordList, phoneRGB, delay);
					}
				});
				if(type === "csv"){
					CSV();
				}
				else if(type === "db"){
					// 【===================================================】
					// NOT YET
					// 【===================================================】
				}
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
							if(sheetName === "通聯記錄"){
								var oJS = XLS.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);
								for(var i = 0; i < oJS.length; i++){
									var phoneNumber = oJS[i].監察號碼;
									var record = new Record();
									var phone;
									record.setRecord(phoneNumber, oJS[i].通話起始時間, oJS[i].緯度, oJS[i].經度);
									if(phoneMap[phoneNumber] === undefined){
										phone = new PhoneNumber(phoneNumber);
										record.id = phoneNumber+"_0";
										phone.pushRecord(record);
										phoneList.push(phone);
										phoneMap[phoneNumber] = phoneList.length-1;
									}
									else{
										var listIndex = phoneMap[phoneNumber];
										phone = phoneList[listIndex];
										record.id = phoneNumber+"_"+phone.getRecordList().length;
										phone.pushRecord(record);
									}
								}
							}
						});
						googleMap();
						initTable();
						settingEvent();
					};

					// Tell JS To Start Reading The File.. You could delay this if desired
					reader.readAsBinaryString(oFile);
				}
			}




			function googleMap() {
				map = new google.maps.Map(document.getElementById('map'), {
					zoom: 14,
					center: new google.maps.LatLng(phoneList[0].getRecordList()[0].getLocationLat() , phoneList[0].getRecordList()[0].getLocationLon()),
					mapTypeId: 'roadmap'
				});
			}

			function addMarker(record, color) {
				var markerOrder = new google.maps.Marker({
					position: record.position,
					icon: {
						path: google.maps.SymbolPath.CIRCLE,
						scale: 8,
						fillColor: "#FFF",
						fillOpacity: 0.8,
						strokeWeight: 0,
						labelOrigin: new google.maps.Point(0, 0)
					},
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
						text: record.getPhoneNumber(),
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
				showingPhoneList = [];
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
						return "Phone Number: "+record.getPhoneNumber()+"<br>"+
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
										<thead><tr> <th>Phone Number</th> <th>Start Time</th> <th>Lat</th> <th>Lon</th> </tr></thead>\n\
										<tbody id="tbody"></tbody>\n\
									</table>';
				});
			}

			function addTableInfo(record){
				$("#tbody").html(function(){
					return $("#tbody").html()+'<tr id="'+record.id+'">\n\
										<td>'+record.getPhoneNumber()+'</td>\n\
										<td>'+record.getStartTime()+'</td>\n\
										<td>'+record.getLocationLat()+'</td>\n\
										<td>'+record.getLocationLon()+'</td>\n\
									</tr>';
				});
			}



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

			function addPhoneList(type){
				$("#phoneList").html(function(){
					var list = "";
					for(var i = 0; i < phoneList.length; i++){
						list += '<tr> \n\
											<td><input type="'+type+'" value="'+i+'" name="phone"></td>\n\
											<td>'+phoneList[i].getPhoneNumber()+'</td>\n\
											<td style="color:'+phoneList[i].color+';" class="phoneColor">&#9632;</td>\n\
										</tr>';
					}
					return list;
				});
			}

		</script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4KGAZ9H0TBoWEN0c6R5u60Nt7s5cijwo&signed_in=true&callback=initMap" async defer>
		</script>
	</head>
	<body onload="main('csv')">

		<div id="infoBlock" class="block" >
			<ul class="nav nav-pills nav-justified">
				<li class="active"><a data-toggle="pill" href="#setting">Setting</a></li>
				<li><a data-toggle="pill" href="#info">Map Information</a></li>
			</ul>
			<div class="tab-content">
				<div id="setting" class="tab-pane fade in active">
					<!--CSV FILE:-->
					<div id="csvBlock">
						LOAD CSV:<br>
						<input id="xls_file" type="file"  class="file"></div>
					<br>
					<br>

					<!--OPTIONAL-->
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
							<thead><tr><td>Selected</td><td>Phone Number</td><td>Color</td></thead>
							<tbody id="phoneList">
							</tbody>
						</table>
					</div>
					<br>
					<br>

					<!--SUBMIT LIST-->
					<div id="submitBlock">
						<button id="makerButton" type="button" class="btn btn-info">SUBMIT</buton>
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
	</body>
</html>


