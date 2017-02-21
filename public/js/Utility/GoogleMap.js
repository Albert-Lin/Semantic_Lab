/**
 * Created by AlbertLin on 2017/2/16.
 */

function GoogleMap(){

	this.map = {};
	this.circleMarkerInfo = {
		insScale: 12,
		insColor: '#FFFFFF',
		insOpacity: 0.0,
		insLabelX: 0,
		insLabelY: 0,
		insLabelColor: '#000000',
		insLabelSize: '16px',
		outsScale: 24,
		outsOpacity: 0.7,
		outsLabelX: 0,
		outsLabelY: 2,
		outsLabelSize: '16px'
	};
	this.triangleMarkerInfo = {
		insScale: 12,
		insColor: '#FFFFFF',
		insOpacity: 0.0,
		insLabelX: 0,
		insLabelY: 3,
		insLabelColor: '#000000',
		insLabelSize: '16px',
		outsScale: 10,
		outsOpacity: 0.6,
		outsLabelX: 0,
		outsLabelY: 6,
		outsLabelSize: '16px'
	};
	this.markerList = [];
	this.infoContentList = [];
	this.infoWindowList = [];
	this.polylineList = [];

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
			mapTypeId: 'roadmap',
            mapTypeControl: true,
            mapTypeControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER
            },
		});
	};


	/**
	 * calling setCenter api of Google Map
	 * @param lat
	 * @param lng
	 */
	this.resetCenter = function(lat, lng){
		this.map.setCenter(new google.maps.LatLng(lat , lng));
	};


	/**
	 * this function will create a object with google.maps.Marker needed properties.
	 * @param symbolPath
	 * @param lat
	 * @param lng
	 * @param scale
	 * @param color
	 * @param opacity
	 * @param labelX
	 * @param labelY
	 * @param map
	 * @param label
	 * @param labelColor
	 * @param labelSize
	 * @returns {{position: google.maps.LatLng, icon: {path: *, scale: *, fillColor: *, fillOpacity: *, strokeWeight: number, labelOrigin: Point}, map: *, label: {text: *, color: *, fontSize: *}}}
	 */
	this.shapeMarker = function(symbolPath, lat, lng, scale, color, opacity, labelX, labelY, map, label, labelColor, labelSize){

		var anchor = new google.maps.Point(0, 0);
		if(symbolPath === google.maps.SymbolPath.FORWARD_OPEN_ARROW){
			anchor = new google.maps.Point(0, 4);
		}

		return {
			position: new google.maps.LatLng(lat, lng),
			icon: {
				path: symbolPath,
				anchor: anchor,
				scale: scale,
				fillColor: color,
				fillOpacity: opacity,
				strokeWeight: 0,
				labelOrigin: new google.maps.Point(labelX, labelY)
			},
			map: map,
			label: {
				text: label,
				color: labelColor,
				fontSize: labelSize
			}
		};
	};

	/**
	 * this function will create two shapeMarkers,
	 *  the small one is inside the big one, also,
	 *  we push both of them into markerInfoList
	 * @param type
	 * @param lat
	 * @param lng
	 * @param insLabel
	 * @param outsColor
	 * @param outsLabel
	 * @param outsLabelColor
	 * @param trIndex
	 * @param eventObject
	 */
	this.addShapeMarker = function(type, lat, lng, insLabel, outsColor, outsLabel, outsLabelColor, trIndex, eventObject){
		var info = this.circleMarkerInfo;
		var googleShape = google.maps.SymbolPath.CIRCLE;
		var insideMarker;
		var outsideMarker;
		if(type === 'triangle'){
			info = this.triangleMarkerInfo;
			googleShape = google.maps.SymbolPath.FORWARD_OPEN_ARROW;
		}

		insideMarker = new google.maps.Marker(
			this.shapeMarker(googleShape, lat, lng,
				info.insScale, info.insColor, info.insOpacity,
				info.insLabelX, info.insLabelY, null, insLabel,
				info.insLabelColor, info.insLabelSize)
		);

		outsideMarker = new google.maps.Marker(
			this.shapeMarker(googleShape, lat, lng,
				info.outsScale, outsColor, info.outsOpacity,
				info.outsLabelX, info.outsLabelY, null, outsLabel,
				outsLabelColor, info.outsLabelSize)
		);
		this.addMarkerEvent('click', outsideMarker, eventObject.params, eventObject.fun, trIndex);

		this.markerList.push({
			insideMarker: insideMarker,
			outsideMarker: outsideMarker,
            trIndex: trIndex,
			lat: lat,
			lng: lng
		});

	};


	this.addImageMarker = function(){};


	// this.drawMarkers = function(indexArray){
	// 	for(var i = 0; i < indexArray.length; i++){
	// 		var index = indexArray[i];
	// 		this.markerList[index].insideMarker.setMap(this.map);
	// 		this.markerList[index].outsideMarker.setMap(this.map);
	// 		this.resetCenter(this.markerList[index].lat, this.markerList[index].lng);
	// 	}
	// };

	this.drawMarkers = function(index, resetCenter){
		this.markerList[index].insideMarker.setMap(this.map);
		this.markerList[index].outsideMarker.setMap(this.map);
		if(typeof resetCenter !== 'undefined'){
			this.resetCenter(this.markerList[index].lat, this.markerList[index].lng);
		}
	};

	this.addInfoWindow = function(content){
		this.infoContentList.push({content: content});
	};

	this.addMarkerEvent = function(action, marker, params, fun, infoWindowIndex){
		var googleMap = this;
		marker.addListener(action, function(){
			fun(googleMap, params);

			if(typeof infoWindowIndex !== 'undefined'){
				// googleMap.infoWindowList[infoWindowIndex].open(googleMap.map, marker);
			}
		});
	};


	this.clearMarkers = function(indexArray, all){
		if(typeof all !== 'undefined'){
            for(var i = 0; i < this.markerList.length; i++){
                this.markerList[i].outsideMarker.setMap(null);
                this.markerList[i].insideMarker.setMap(null);
            }
		}
		else{
			for(var i = 0; i < indexArray.length; i++){
				var index = indexArray[i];
                this.markerList[index].outsideMarker.setMap(null);
                this.markerList[index].insideMarker.setMap(null);
			}
		}
	};




	this.polyline = function(pathInfo, color){
		return new google.maps.Polyline({
			path: pathInfo,
			geodesic: true,
			strokeColor: color,
			strokeOpacity: 1.0,
			strokeWeight: 3
		});
	};

	this.addPolyline = function(index, startLatLng, endLatLng, color){
		var pathInfo = [startLatLng, endLatLng];
		this.polylineList[index] = this.polyline(pathInfo, color);
	};

	this.drawPolyline = function(index){
		console.log(index);
		this.polylineList[index].setMap(this.map);
	};

	this.clearPolylines = function(index, all){
		if(typeof all !== 'undefined'){
			// for(var i = 0; i < this.polylineList.length; i++){
			// 	this.polylineList[i].setMap(null);
			// }
			for(var key in this.polylineList){
				this.polylineList[key].setMap(null);
			}
		}
		else{
			this.polylineList[index].setMap(null);
		}
	};

	this.clearAll = function(){
        this.clearMarkers([], true);
        this.markerList = [];
        this.infoContentList = [];
        this.infoWindowList = [];
        this.clearPolylines(-1, true);
		this.polylineList = [];
	};



}