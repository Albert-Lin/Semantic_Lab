/**
 * Created by Albert Lin on 2017/2/22.
 */


// FUNCTIONS FOR GET/SET DATA FROM/INTO DB, ENTITY INSTANCE AND JSON DATA

var groupInfo = {
    conditions: [],
    fun: function(conditions, entity){
        var group = [];
        var recordArray = entity.getPropValue(conditions.propInfo.propName);
        for(var i = 0; i < recordArray.length; i++){
            var startTime = recordArray[i][conditions.propInfo.subPropName];
            if(conditions.index === 0){
                if(conditions.lowerBound <= startTime &&
                startTime <= conditions.upperBound){
                    group.push(recordArray[i].origIndex);
                }
            }
			else{
				if(conditions.lowerBound < startTime &&
					startTime <= conditions.upperBound){
					group.push(recordArray[i].origIndex);
				}
			}
        }
        return group;
    }
};

// function loadJsonData(jsonDataFile, funObject, phones){
//     $.getJSON(jsonDataFile, function(data){
//         funObject.fun(data, phones);
//     });
// }

function dataPreprocess(phones){
    var colorUnit = (313/phones.length);
	var phoneMap = getPhoneMap();
    for(var i = 0; i < phones.length; i++){
        var phone = phones[i];
        var phoneNum = phone.getPropValue('監察號碼');
        var recordArray = phone.getPropValue('紀錄');
        var sortedRecord = [];
        var color = colorUnit*i;
        // set the Phone entity hash map:
        phoneMap[phoneNum] = i;
        // set color properties:
        phone.setPropValue('color', 'hsla('+color+', 100%, 70%, 1)');
        phone.setPropValue('labelColor', 'hsla('+color+', 100%, 40%, 1)');
        // set mill seconds of start time for each record:
        for(var j = 0; j < recordArray.length; j++){
            var startTime = recordArray[j]['通話起始日期'];
            var millSec = (new Date(Date.parse(startTime))).getTime();
            recordArray[j].millSec = millSec;
        }
        // sort all the records by mill seconds
        sortedRecord = sortData(recordArray, 'millSec');
        // set order index for each records
        sortedRecord = phone.setArrayElementIndex(sortedRecord);
        // reset the records back to entity
        phone.setPropValue('紀錄', sortedRecord);
    }
    return phones;
}

function getMillSecRange(phones){
    var minMillSec = 0;
    var maxMillSec = 0;
    for(var i = 0; i < phones.length; i++){
        var recordArray = phones[i].getPropValue('紀錄');
        var lastIndex = recordArray.length-1;
        if( i === 0){
            minMillSec = recordArray[0].millSec;
            maxMillSec = recordArray[lastIndex].millSec;
        }
        else{
            if(minMillSec > recordArray[0].millSec){
                minMillSec = recordArray[0].millSec;
            }
            if(maxMillSec < recordArray[lastIndex].millSec){
                maxMillSec = recordArray[lastIndex].millSec;
            }
        }
    }
    return {
        minMillSec: minMillSec,
        maxMillSec: maxMillSec
    };
}

function setLatLngMap(phones, latlngMap){
    for(var i = 0; i < phones.length; i++){
        var phoneNum = phones[i].getPropValue('監察號碼');
        var recordArray = phones[i].getPropValue('紀錄');
        for(var j = 0; j < recordArray.length; j++){
            var index = phoneNum+"_"+j;
            var latlng = recordArray[j]['緯度']+"_"+recordArray[j]['經度'];
            if(latlngMap[latlng] === undefined){
                latlngMap[latlng] = [];
            }
            latlngMap[latlng].push(index);
        }
    }
    return latlngMap;
}

function setGroupConditions(startTime, stopTime, timeUnit, info){
	var absNum = Math.abs(parseInt(stopTime)-parseInt(startTime))/timeUnit;
	var numGroup = Math.floor(absNum);
	if(absNum !== numGroup){
		numGroup++;
	}
	var group = [];
	for(var i = 0; i < numGroup; i++){
		var condition = {
			lowerBound: startTime + i*timeUnit,
			upperBound: startTime + (i+1)*timeUnit,
            index: i,
            propInfo: info
		};
		if(i === (numGroup-1)){
			condition.upperBound = stopTime;
		}
		group.push(condition);
	}
	return group;
}

function getGroupInfo(){
    return groupInfo;
}