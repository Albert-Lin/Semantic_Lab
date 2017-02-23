/**
 * Created by Albert Lin on 2017/2/22.
 */


// FUNCTIONS FOR THE MAIN PROCESS OF WHOLE PROJECT

// 01. LOAD JSON FILE:
var rowDataProcess = {
    params: {},
    fun: function(data, phones){
        for(var i = 0; i < data.length; i++){
            phones.push(data[i]);
        }
        console.log(phones);
    }
};
var googleMap;
var phones = [];
var phoneMap = [];
var showPhones = [];
var nonEmptyMap = [];
var latlngMap = [];
var minMillSec;
var maxMillSec;

function setUp(){
	var millsecInfo;
	var defLat;
	var defLng;

    // MODEL
    $.getJSON("../../js/test/data.json", function(data){
        for(var i = 0; i < data.length; i++){
            phones.push(new Entity(data[i]));
        }

        phones = dataPreprocess(phones);

        millsecInfo = getMillSecRange(phones, minMillSec, maxMillSec);
        minMillSec = millsecInfo.minMillSec;
        maxMillSec = millsecInfo.maxMillSec;

        setTimeInput(minMillSec, maxMillSec);
        setRangeBound(minMillSec, maxMillSec);
        latlngMap = setLatLngMap(phones, latlngMap);
        // VIEW
        setCheckBoxTB(phones, ['監察號碼', 'color'], 'phoneNumTB');
        defLat = phones[0].getElementValue('紀錄', 0)['緯度'];
        defLng = phones[0].getElementValue('紀錄', 0)['經度'];
        googleMapSetUp(defLat, defLng);
    });

}

function setShowingEntity(groupData, selectList){
    var trs = '';
    var orderIndex = 0;
    var groupInfo = getGroupInfo();
    showPhones = [];
	nonEmptyMap = [];
	groupInfo.condictions = setGroupConditions(groupData.startTime, groupData.stopTime, groupData.timeUnit, {propName: '紀錄', subPropName: 'millSec'});

	for(var i = 0; i < phones.length; i++){
	    var phone = phones[i];
	    var phoneNum = phone.getPropValue('監察號碼');
		var nonEmpty = false;
		var groupList = [];
	    if(selectList.indexOf(phoneNum) !== -1){
			phone.groupList = [];
			nonEmpty = phone.groupElements(groupInfo.conditions, groupInfo.fun);
			groupList = phone.groupList;
        }
		nonEmptyMap.push(nonEmpty);
		showPhones.push(groupList);
    }

    for(var i = 0; i < phones.length; i++){
	    if(nonEmptyMap[i] === true){
	        var phone = phones[i];
	        for(var j = 0; j < showPhones[i].length; j++){
	            var recordIndexGroup = showPhones[i][j];
	            if(recordIndexGroup.length > 0){
	                for(var k = 0; k < recordIndexGroup.length; k++){
	                    var recordIndex = recordIndexGroup[k];
	                    var record = phone.getElementValue('紀錄', recordIndex);
	                    var tr = setRecordTR({
	                        tr: {
								phone: phoneNum,
								recordIndex: recordIndex,
								orderIndex: orderIndex,
                                unitId: j
                            },
                            td: {
	                            0: phoneNum,
                                1: record['非監察號碼'],
                                2: record['通話起始日期']
                            }
                        });
						orderIndex++;
						trs += tr;
                    }
                }
            }
        }
    }

    return trs;
}

function setGoogleMap(trInfoList, timeUnit){
    var phone;
    var phoneNum;
    var phoneColor;
    var phoneLabelColor;
    var lastPhoneIndex = undefined;
    var hiddenPropArray = ['origIndex', 'millSec'];

    for(var i = 0; i < trInfoList.length; i++){
        var phoneIndex = phoneMap[trInfoList[i].phone];
        var record;
        var recordStartTime;
		var infoWinContent;
		var infoWinEvents = [
            {
                action: 'closeclick',
                params: {
                    orderId: trInfoList[i].orderIndex
                },
                fun: function(googleMap, params){
                    var infoWindow = googleMap.infoWindowList[params.orderId];
                    var infoWinContent = googleMap.infoWindowContentList[params.orderId].content;
					infoWindow.setContent(infoWinContent);
					clearRecordTRBGColor();
				}
            },
            {
				action: 'content_changed',
				params: {
					message: 'Showing all information of records which has same position.'
				},
				fun: function(googleMap, params){
					console.log(params.message);
				}
            }
        ];
        var markerEventInfo;

        if(phoneIndex !== lastPhoneIndex){
            phone = phones[phoneIndex];
            phoneNum = trInfoList[i].phone;
            phoneColor = phone.getPropValue('color');
            phoneLabelColor = phone.getPropValue('labelColor');
        }
        record = phone.getElementValue('紀錄', trInfoList[i].recordIndex);
		if(timeUnit === '600000' || timeUnit === '3600000'){
			recordStartTime = getDateInfo(record['millSec'],undefined, undefined, undefined, true, true, undefined);
		}
		else if(timeUnit === '86400000'){
			recordStartTime = getDateInfo(record['millSec'],undefined, true, true, undefined, undefined, undefined);
		}

		// add InfoWindow object && content
		infoWinContent = getInfoWindowContent(record, hiddenPropArray, phoneColor);
		googleMap.addInfoWindow(trInfoList[i].orderIndex, infoWinContent, infoWinEvents);

        // add Marker && PolyLine
		markerEventInfo = {
			params: {
				orderId: trInfoList[i].orderIndex,
				color: phoneColor
			},
			fun: markerClickEvent
		};
        if(trInfoList[i].recordIndex === 0){
			googleMap.addShapeMarker('triangle', record['緯度'], record['經度'],
				recordStartTime, phone.getPropValue('color'), record['非監察號碼'],
				phoneLabelColor, trInfoList[i].orderIndex, markerEventInfo, true);
        }
        else{
			var lastRecord = phone.getElementValue('紀錄', (trInfoList[i].recordIndex-1));
			var end = { lat: parseFloat(record['緯度']), lng:  parseFloat(record['經度']) };
			var start = { lat: parseFloat(lastRecord['緯度']), lng:  parseFloat(lastRecord['經度']) };
			var polyLineId = phone.getPropValue('監察號碼')+"_"+trInfoList[i].recordIndex;
			// add polyline
			googleMap.addPolyline(polyLineId, start, end, phoneColor);

			// add Marker
			googleMap.addShapeMarker('circle', record['緯度'], record['經度'],
				recordStartTime, phone.getPropValue('color'), record['非監察號碼'],
				phoneLabelColor, trInfoList[i].orderIndex, markerEventInfo, true);
        }
    }
}

function clearGoogleMap(){
	googleMap.clearAll();
}

function clearMarkerPolyline(){
	googleMap.clearMarkers([], true);
	googleMap.clearPolylines(-1, true);
}

function getPhoneColor(phoneNum){
    var index = phoneMap[phoneNum];
    return phones[index].getPropValue('color');
}

function getUnitBound(index){
	return {
		lowerBound: groupInfo.condictions[index].lowerBound,
		upperBound: groupInfo.condictions[index].upperBound
	}
}

function getPhoneIndex(phoneNum){
	return phoneMap[phoneNum];
}

function getShowPhoneUnit(phoneIndex, unitIndex){
	return showPhones[phoneIndex][unitIndex];
}

$(function(){
	setFunButClickEvent();

	setCheckAllClickEvent();

	setSubmitBtnClickEvent();

	setSortBtnClickEvent();

    setUnitBarChangeEvent();

	setAnimationBtnClickEvent();

});