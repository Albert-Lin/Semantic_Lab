/**
 * Created by Albert Lin on 2017/2/22.
 */


// FUNCTIONS FOR THE MAIN PROCESS OF WHOLE PROJECT

// 01. LOAD JSON FILE:
var rowDataProcess = {
    params: {},
    fun: function(data){
        for(var i = 0; i < data.length; i++){
            phones.push(data[i]);
        }
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
    // MODEL
    loadJsonData("../../js/test/data.json", rowDataProcess);
    dataPreprocess();
    getMillSecRange();
    setLatLngMap();
    // VIEW
    setPhoneListTB();
    googleMapSetUp();
}

$(function(){
    setTimeInput(minMillSec, maxMillSec);
    setRangeBound(minMillSec, maxMillSec);



});