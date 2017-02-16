/**
 * Created by AlbertLin on 2017/2/16.
 */

function Record(){

	this.subject;
	this.object;
	this.startTime;
	this.startTimeSec;
	this.callingSec;
	this.type;
	this.orientation;
	this.transText;
	this.station;
	this.lat;
	this.lng;

	this.init = function(object){
		this.subject = object.監察號碼;
		this.object = object.非監察號碼;
		this.startTime = object.通話起始日期;
		this.startTimeSec = (new Date(Date.parse(this.startTime))).getTime();
		this.callingSec = object.通話秒數;
		this.type = object.通話類別;
		this.orientation = object.通話方向;
		this.transText = object.譯文;
		this.station = object.監察號碼起始基地台_地址;
		this.lat = object.緯度;
		this.lng = object.經度;
	};

	this.sortData = function(recordArray, propName, invers){
		var newRecord;
		if(typeof invers === 'undefined'){
			// small -> large
			newRecord = recordArray.slice().sort(function(a, b){
				return a[propName] - b[propName];
				if(a[propName] < b[propName]){
					return -1;
				}
				if(a[propName] > b[propName]){
					return 1;
				}
				return 0;
			});
		}
		else{
			// large -> small
			newRecord = recordArray.slice().sort(function(a, b){
				if(b[propName] < a[propName]){
					return -1;
				}
				if(b[propName] > a[propName]){
					return 1;
				}
				return 0;
			});
		}

		return newRecord;
	};

}