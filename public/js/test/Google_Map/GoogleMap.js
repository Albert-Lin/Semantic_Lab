/**
 * Created by AlbertLin on 2017/2/16.
 */

function GoogleMap(){

	this.map = {};

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

	this.resetCenter = function(lat, lng){
		this.map.setCenter(new google.maps.LatLng(lat , lng));
	}
}