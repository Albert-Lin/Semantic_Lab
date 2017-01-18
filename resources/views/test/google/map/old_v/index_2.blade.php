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
		</style>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src=" https://cdnjs.cloudflare.com/ajax/libs/xls/0.7.4-a/xls.js"></script>
		<script type="text/javascript">
			
		// GLOBAL VARIABLE

		// CLASS
			
			// PHONE
			/**
			 * Class of Phone
			 * @returns {Phone}
			 */
			function Phone(){
				this.id;
				this.recordList;
				this.phoneNumber;
				this.color;

				/**
				 * Initilization of Phone object
				 * @param {Number} id
				 * @param {Array} recordList
				 * @param {Number} phoneNumber
				 */
				this.initialization = function(id, recordList, phoneNumber){
					this.id = id;
					this.recordList = recordList;
					this.phoneNumber = phoneNumber;
					this.color = randomColor();
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
				this.timeStamp;
				this.locationLat;
				this.locationlng;
				this.type;

				/**
				 * Initilization of Record object
				 * @param {Number} id
				 * @param {String} phoneNumber
				 * @param {String} startTime
				 * @param {String} lat
				 * @param {String} lng
				 */
				this.initialization = function(id, phoneNumber, startTime, lat, lng){
					this.id = id;
					this.phoneNumber = phoneNumber;
					this.startTime = setTime("", "-", startTime, ":");
					this.locationLat = lat;
					this.locationlng = lng;
					this.timeStamp = getTimeStamp(this.startTime);
					this.type = "phone";
				};

				/**
				 * The static function for order Record objects by startTime
				 * @param {Array} recordList
				 * @returns {Array|Record.orderByStartTime.newList}
				 */
				this.orderByStartTime = function(recordList){
					var newList = [];
					for(var i = 0; i < recordList.length; i++){
						newList.push(recordList[i]);
					}
					newList.sort(function(a, b){
							var time0 = a.timeStamp,
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
					return newList;
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
					if(dateArray.length === 3 && timeArray === 3){
						return new Date(dateArray[0], dateArray[1], dateArray[2], timeArray[0], timeArray[1], timeArray[2]);
					}
					else if(dateArray.length === 3 && timeArray < 3){
						return new Date(dateArray[0], dateArray[1], dateArray[2], 0, 0, 0);
					}
					else if(dateArray.length < 3 && timeArray === 3){
						return new Date(0, 0, 0, timeArray[0], timeArray[1], timeArray[2]);
					}
					else if(dateArray.length < 3 && timeArray < 3){
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
				this.addMarker = function(record, color){
					var orderMarker = new google.maps.Marker({
						position: new google.maps.LatLng(record.locationLat, record.locationlng),
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
							text: record.id.split("_")[1],
							color: "#000",
							fontSize: "18px"
						}
					});

					var mainMarker = new google.maps.Marker({
						position: new google.maps.LatLng(record.locationLat, record.locationlng),
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
					addMarkerEvent(record, mainMarker);

					this.markerList.push(orderMarker);
					this.markerList.push(mainMarker);
				};

				/**
				 * The function for remove all the Marker objects on the Google Map
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
						showMarkerInfo(record, type);
					});

					// others event:
				};



				// Actions for Map:
				this.showMarkerInfo = function(record, type){
					if(type === "table"){
						$("#tbody tr").each(function(){
							$(this).attr('class', '');
							$(this).attr('style', 'color:#FFF;');
						});

						$("#"+record.id).attr('class', 'danger');
						$("#"+record.id).attr('style', 'color:#000;');
					}
				};

			}




		// FUNCTION
			var a = new Phone();

		</script>

		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4KGAZ9H0TBoWEN0c6R5u60Nt7s5cijwo&signed_in=true&callback=initMap" async defer>	</script>

	</head>

	<body></body>

</html>
