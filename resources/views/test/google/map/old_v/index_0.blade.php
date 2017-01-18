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

		<style>
			/* Always set the map height explicitly to define the size of the div
			 * element that contains the map. */
			#map {
							height: 95%;
							width: 70%;
			}
			/* Optional: Makes the sample page fill the window. */
			html, body {
							height: 100%;
							width: 100%;
							margin: 0;
							padding: 0;
			}
		</style>
		<script src=" https://cdnjs.cloudflare.com/ajax/libs/xls/0.7.4-a/xls.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script type="text/javascript">
			// 01. load json data
							// csv && PHP connecting MySql
			// 02. data preprocessing
			// 03. visualization
							// create(setting) marker
							// load map
							// load marker
			// * marker event


			// GLOBAL VARIABLE:
			var phoneMap = [];
			var phoneList = [];
			var map;
			var recordIndex = 0;
			var iconBase = 'http://semantic_lab/image/';
			var icons = [];
			var phonePath = [];
			
			// CLASS:
			function Record(){
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

				this.pushRecord = function(record){
					recordList.push(record);
				};

				this.getPhoneNumber = function(){
					return phoneNumber;
				};

				this.getRecordList = function(){
					return recordList;
				};
			}

			function Icon(url){
				this.url = url;
				this.scaledSize = new google.maps.Size(30, 30);
				this.origin = new google.maps.Point(0, 0);
				this.anchor = new google.maps.Point(15, 15);
			}

			// FUNCTION:
			
			function setIcons(){
				// set icon object:
				icons.push(new Icon(iconBase+'phone.png'));				
			}
			
			function main(type){
				setIcons();
				$("#makerButton").click(function(){
					addRecordMarker();
					addRecordPhonePath();
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
										phone.pushRecord(record);
										phoneList.push(phone);
										phoneMap[phoneNumber] = phoneList.length-1;
									}
									else{
										var listIndex = phoneMap[phoneNumber];
										phone = phoneList[listIndex];
										phone.pushRecord(record);
									}
								}
							}
						});
						googleMap();
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

			function addMarker(record) {
				var marker = new google.maps.Marker({
					position: record.position,
					icon: icons[0],
					map: map,
					label: record.getPhoneNumber()
				});
			}

			function addMapInfo(record){
				record.position = new google.maps.LatLng(record.getLocationLat(), record.getLocationLon());
				record.type = 'phone';
			}

			function addRecordMarker(){
				var recordList = phoneList[0].getRecordList();
				if(recordIndex < recordList.length){
					addMapInfo(recordList[recordIndex]);
					addMarker(recordList[recordIndex]);
					recordIndex++;
				}
				else{
					alert("There is no more record to add.");
				}
			}


			function addRecordPhonePath(){
				var recordList = phoneList[0].getRecordList();
				if(recordIndex > 1 && recordIndex <= recordList.length){
					var newPath = [];
					newPath.push(addPathInfo(recordList[recordIndex-2]));
					newPath.push(addPathInfo(recordList[recordIndex-1]));
					addPhonePath(newPath);
				}
			}

			function addPathInfo(record){
				var lat = parseFloat(record.getLocationLat());
				var lon = parseFloat(record.getLocationLon());
				var path = {lat: lat, lng: lon};
				return path;
			}

			function addPhonePath(phonePath){
				var path = new google.maps.Polyline({
					path: phonePath,
					geodesic: true,
					strokeColor: '#FF0000',
					strokeOpacity: 1.0,
					strokeWeight: 3
				});
				path.setMap(map);
			}


		</script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4KGAZ9H0TBoWEN0c6R5u60Nt7s5cijwo&signed_in=true&callback=initMap" async defer>
		</script>
	</head>
	<body onload="main('csv')">
		<input id="xls_file" type="file"  />
		<input id="makerButton" type="button" value="ADD NEW RECORD">
		<div id="map"></div>
		<div id="info">
			<a href="https://developers.google.com/maps/documentation/javascript/?hl=zh-tw">API</a>
		</div>
	</body>
</html>


