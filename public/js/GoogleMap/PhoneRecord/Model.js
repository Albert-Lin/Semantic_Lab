/**
 * Created by Albert Lin on 2017/2/22.
 */


// FUNCTIONS FOR GET/SET DATA FROM/INTO DB, ENTITY INSTANCE AND JSON DATA

function loadJsonData(jsonDataFile, funObject){

    $.getJSON(jsonDataFile, function(data){
        funObject.fun(data);
    });
}

function dataPreprocess(){
    var colorUnit = (313/phones.length);
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
}

function getMillSecRange(){
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
}

function setLatLngMap(){
    for(var i = 0; i < phones.length; i++){
        var phoneNum = phones[i].getPropValue('監察號碼');
        var recordArray = phones[i].getPropValue('紀錄');
        for(var j = 0; j < recordArray.length; j++){
            var index = phoneNum+"_"+j;
            var latlng = recordArray[j]['緯度']+"_"+recordArray[j]['經度'];
            latlngMap[latlng].push(index);
        }
    }
}

function googleMapSetUp(){
    var lat = phones[0].getElementValue('紀錄', 0)['緯度'];
    var lng = phones[0].getElementValue('紀錄', 0)['經度'];
    googleMap = new GoogleMap();
    googleMap.initilization('mainContent', lat, lng);
}