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
		outsOpacity: 0.55,
		outsLabelX: 0,
		outsLabelY: 2,
		outsLabelSize: '16px'
	};
	this.triangleMarkerInfo = {
		insScale: 12,
		insColor: '#FFFFFF',
		insOpacity: 0.0,
		insLabelX: 0,
		insLabelY: 2,
		insLabelColor: '#000000',
		insLabelSize: '16px',
		outsScale: 10,
		outsOpacity: 0.55,
		outsLabelX: 0,
		outsLabelY: 6,
		outsLabelSize: '16px'
	};
	this.markerList = [];
	this.infoContentList = [];
	this.infoWindowList = [];

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

	this.resetCenterLatLng = function(googleLatLng){
		this.map.setCenter(googleLatLng);
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
		return {
			position: new google.maps.LatLng(lat, lng),
			icon: {
				path: symbolPath,
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
	 *  we push both of them into markerList
	 * @param type
	 * @param lat
	 * @param lng
	 * @param insLabel
	 * @param outsColor
	 * @param outsLabel
	 * @param trIndex
	 */
	this.addShapeMarker = function(type, lat, lng, insLabel, outsColor, outsLabel, trIndex){
		var info = this.circleMarkerInfo;
		var googleShape = google.maps.SymbolPath.CIRCLE;
		var insideMarker;
		var outsideMarker;
		var outMarker;
		var inMarker;
		if(type === 'triangle'){
			info = this.triangleMarkerInfo;
			googleShape = google.maps.SymbolPath.FORWARD_OPEN_ARROW;
		}

		insideMarker = this.shapeMarker(googleShape, lat, lng,
			info.insScale, info.insColor, info.insOpacity,
			info.insLabelX, info.insLabelY, this.map, insLabel,
			info.insLabelColor, info.insLabelSize);

		outsideMarker = this.shapeMarker(googleShape, lat, lng,
			info.outsScale, outsColor, info.outsOpacity,
			info.outsLabelX, info.outsLabelY, this.map, outsLabel,
			outsColor, info.outsLabelSize);

		this.markerList.push({
			insideMarker: insideMarker,
			outsideMarker: outsideMarker,
			trIndex: trIndex
		});
	};

	this.addImageMarker = function(){};

	this.drawMarkers = function(indexArray, eventParams, eventFun, infoWindow){
		for(var i = 0; i < indexArray.length; i++){
			var index = indexArray[i];
			var outsideMarker = new google.maps.Marker(this.markerList[index].outsideMarker);
			var insideMarker = new google.maps.Marker(this.markerList[index].insideMarker);
			this.resetCenterLatLng(this.markerList[index].outsideMarker.position);
			// if(typeof infoWindow !== 'undefined'){
			// 	this.infoWindowList.push(new google.maps.InfoWindow(this.infoContentList[index]));
			// 	this.addMarkerEvent('click', outsideMarker, eventParams, eventFun, index);
			// }
			// else{
			// 	this.addMarkerEvent('click', outsideMarker, eventParams, eventFun);
			// }

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
				googleMap.infoWindowList[infoWindowIndex].open(googleMap.map, marker);
			}
		});
	};



}