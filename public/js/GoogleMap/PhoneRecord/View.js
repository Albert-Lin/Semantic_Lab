/**
 * Created by Albert Lin on 2017/2/22.
 */


// FUNCTIONS FOR GET/SET THE DATA FROM/INTO HTML DOM (ALSO GOOGLE MAP)

var lastContent = undefined;
var clickFun = undefined;
var drawAllMarkers = true; // should replace into animation, that will be more cleared
var cleared = false;
var animationProcess;

// FUNCTION BTN
function setFunButClickEvent(){
    $('.funBtn').on('click', function(event){
        var clickId = event.target.id;
        var clickContent = $(this).attr('contentId');

        var mainContent = $('#mainContent');
        if(clickFun !== clickId){
            mainContent.removeClass('col-md-12');
            mainContent.addClass('col-md-offset-4');
            mainContent.addClass('col-md-8');
            mainContent.css('padding-left', '');

            $('#'+clickFun).css('background-color', '');
            $(this).css('background-color', '#9d9d9d');
            clickFun = clickId;

            $('#'+lastContent).css('display', '');
            $('#'+clickContent).css('display', 'block');
            lastContent = clickContent;
        }
        else{
            mainContent.removeClass('col-md-offset-4');
            mainContent.removeClass('col-md-8');
            mainContent.addClass('col-md-12');
            mainContent.css('padding-left', '65px');

            clickFun = undefined;
            $(this).css('background-color', '');
        }
    });
}


// FUNCTION CONTENT 0
function setTimeInput(startMillSec, stopMillSec){
    $('#startTime').val(new Date(startMillSec+(8*3600000)).toISOString().replace(/\..*Z/gi, ''));
    $('#stopTime').val(new Date(stopMillSec+(8*3600000)).toISOString().replace(/\..*Z/gi, ''));
}

function getTimeInputValue(){
    return {
        startTimeVal: $('#startTime').val(),
        stopTimeVal: $('#stopTime').val()
    };
}

function getTimeInputMillSec(){
    var timeInput = getTimeInputValue();
    var startTime = (new Date(Date.parse( timeInput.startTimeVal ))).getTime()-(8*3600000);
    var stopTime = (new Date(Date.parse( timeInput.stopTimeVal ))).getTime()-(8*3600000);
    return {
        startTimeVal: startTime,
        stopTimeVal: stopTime
    };
}

function setCheckAllClickEvent(){
    $('#checkAll').on('click', function(){
        var checked = $(this).prop('checked');
        $('.listItem').each(function(){
            if(checked === true){
                if($(this).prop('checked') === false){
                    $(this).click();
                }
            }
            else if(checked === false){
                if($(this).prop('checked') === true){
                    $(this).click();
                }
            }
        });
	});
}

function checkBoxItemClickEvent(){
	$('.listItem').on('click', function(){
		var checked = $(this).prop('checked');
		if(checked === true){
			var allChecked = true;
			$('.listItem').each(function(){
				if($(this).prop('checked') === false){
					allChecked = false;
				}
			});
			if(allChecked === true){
				$('#checkAll').prop('checked', true);
			}
		}
		else if(checked === false){
			$('#checkAll').prop('checked', '');
		}
	});
}

function setCheckBoxTB(entityArray, propNameArray, domId){
	var tableContent = '';
	for(var i = 0; i < entityArray.length; i++) {
		var entity = entityArray[i];
		var tr = '<tr>';
		tr += '<td><input type="checkbox" class="listItem" value="' + entity.getPropValue(propNameArray[0]) + '"></td>';
		for (var j = 0; j < propNameArray.length; j++) {
			if(propNameArray[j] === 'color'){
                tr += '<td style="background-color:'+entity.getPropValue('color')+'"></td>';
			}
			else{
                tr += '<td>' + entity.getPropValue(propNameArray[j]) + '</td>';
			}
		}
		tr += '</tr>';
		tableContent += tr;
	}
	$('#'+domId).html(tableContent);
	checkBoxItemClickEvent();
}

function setSubmitBtnClickEvent(){
	$('#submitBtn').on('click', function(){
		var submit = true;
		var inputTimeMillSec = getTimeInputMillSec();
		var startTime = inputTimeMillSec.startTimeVal;
		var stopTime = inputTimeMillSec.stopTimeVal;
		var timeUnit = $('input[name=unit]:checked').val();
		var selectList = [];
		setRangeBound(startTime, stopTime);

		// time data validation
		if(isNaN(startTime) && isNaN(stopTime)){
			$('#timeValid').css('display', 'block');
			submit = false;
		}

		// time unit validation
		if(timeUnit === undefined){
			$('#unitValid').css('display', 'block');
			submit = false;
		}

		// entity data validation && get all selected entity
		submit = false;
		$('.listItem').each(function(){
			if($(this).prop('checked') === true){
				submit = true;
				selectList.push($(this).val());
			}
		});

		if(submit === false){
			$('#listValid').css('display', 'block');
		}
		else{
			// generate and get all information which are going to show in record table
			var groupData = {
				startTime: startTime,
				stopTime: stopTime,
				timeUnit: timeUnit
			};
			var trs = setShowingEntity(groupData, selectList);
			var trInfo = [];

			// input content into record table
			$('#recordTB').html(trs);
			$('#funBtn1').click(); // remove this line after testing

			// register record event
			recordEvent();

			// get all showing record information for drawing marker of Google Map
			$('#recordTB tr').each(function(){
				if($(this).css('display') !== 'none'){
					trInfo.push({
						phone: $(this).attr('phone'),
						recordIndex: $(this).attr('recordIndex'),
						orderIndex: $(this).attr('orderIndex'),
						unitId: $(this).attr('unitId')
					});
				}
			});
			clearGoogleMap();
			setGoogleMap(trInfo, $('input[name=unit]:checked').val());

			// draw markers, polylines in once (note: this is not an animation)
			drawAllMarkers_in_once();
		}
	});
}


// FUNCTION CONTENT 1
function setSortBtnClickEvent(){
    $('.sortBtn').on('click', function(){
        var current = $(this).html();
        $('.sortBtn').each(function(){
            $(this).html('▲');
        });

        if(current === '▲'){
            $(this).html('▼');
        }
        console.log($(this).attr('propNAme'));
    });
}

function setRecordTR(recordObject){console.log('???');
	var tr = '<tr';
	var td = '';

	// set properties of tr
	for(var key in recordObject.tr){
		tr += ' '+key+'="'+recordObject.tr[key]+'"';
	}

	// set content for each td
	for(var key in recordObject.td){
		td += '<td>'+recordObject.td[key]+'</td>';
	}
	tr += '>'+td+'</tr>';

	return tr;
}

function clearRecordTRBGColor(){
	$('#recordTB tr').each(function(){
		$(this).css('background-color', '');
	});
}

function recordEvent(){
	$('#phoneList tbody tr').on('click', function(){
		var orderIndex = $(this).attr('orderIndex');
		var marker = googleMap.markerList[orderIndex].outsideMarker;
		google.maps.event.trigger(marker, 'click');
	});
}


// GOOGLE MAP
function googleMapSetUp(lat, lng){
	googleMap = new GoogleMap();
	googleMap.initilization('mainContent', lat, lng);
}

function getInfoWindowContent(record, hiddenPropName, color){
	var content;
    if(typeof color === 'undefined'){
        color = '#bbbbbb';
    }
    content = '<table class="table table-striped table-bordered infoWindowTB" style="border-left: 6px solid '+color+';"><tbody>';
    for(var key in record){
        if(hiddenPropName.indexOf(key) === -1){
			content += '<tr class="row"><td class="col-md-4">'+key+'</td><td class="col-md-8 infoWindow">'+record[key]+'</td></tr>';
        }
    }

    return content;
}

function markerClickEvent(googleMap, params){
    var markerList = googleMap.markerList;
	var unitsContents = [];
	var markerOrderIndex = params.orderId;
	var markerTR = $('#recordTB tr[orderIndex='+markerOrderIndex+']');
	var unitId = markerTR.attr('unitId');
	var position = markerList[markerOrderIndex].lat+"_"+markerList[markerOrderIndex].lng;
	var unitBarValue = $('#unitBar').val();
	var maxUnit = unitBarValue;
	var windowContent = '';

	if(latlngMap[position].length > 1){
		// duplicate position marker showing on map
		// initialize
		for(var i = 0; i <= $('#unitBar').prop('max'); i++){
			unitsContents.push('');
		}

		// clear <TR> bg color
		clearRecordTRBGColor();

		// finding same marker info which has same position as clicked marker.
		if(cleared === false){
		    // 0 to current unit
			if(unitBarValue === '-1'){
				maxUnit = $('#unitBar').prop('max');
			}
			for(var i = 0; i <= maxUnit; i++){
				$('#recordTB tr[united='+i+']').each(function(){
					var markMapIndex = $(this).attr('phone')+"_"+$(this).attr('recordIndex');
					if(latlngMap[position].indexOf(markMapIndex) !== -1){
					    var trOrderId = $(this).attr('orderIndex');
					    var color = getPhoneColor($(this).attr('phone'));
						unitsContents[i] += googleMap.infoWindowContentList[trOrderId].content+"<hr>";
						$(this).css('background-color', color);
                    }
				});
			}
		}
		else{
		    // only current unit
            $('#recordTB tr[united='+unitBarValue+']').each(function(){
				var markMapIndex = $(this).attr('phone')+"_"+$(this).attr('recordIndex');
				if(latlngMap[position].indexOf(markMapIndex) !== -1){
					var trOrderId = $(this).attr('orderIndex');
					var color = getPhoneColor($(this).attr('phone'));
					unitsContents[i] += googleMap.infoWindowContentList[trOrderId].content+"<hr>";
					$(this).css('background-color', color);
				}
            });
		}

        // rest content of InfoWindow
		for(var i = 0; i < unitsContents.length; i++){
			if(unitsContents[i].length > 0){
				var unit = i+1;
				windowContent += '<h4>區間'+unit+':</h4>'+unitsContents[i];
			}
		}
		googleMap.infoWindowList[markerOrderIndex].setContent(windowContent);

	}
    else{
		markerTR.css('background-color', params.color);
    }

}

function drawAllMarkers_in_once(){
	drawAllMarkers = false;
	$('#recordTB tr').each(function(){
		$(this).css('display', '');
		if(drawAllMarkers === false){
			if($(this).attr('recordIndex') !== '0' && $(this).attr('orderIndex') !== '0'){
				googleMap.drawPolyline($(this).attr('phone')+"_"+$(this).attr('recordIndex'));
			}
			googleMap.drawMarkers($(this).attr('orderIndex'));
		}
	});
}


// RANGE SLIDER
function setRangeBound(lowerMillSec, upperMillSec){
	var lBoundTime = new Date(lowerMillSec+(8*3600000)).toISOString().replace(/\..*Z/gi, '');
	var uBoundTime = new Date(upperMillSec+(8*3600000)).toISOString().replace(/\..*Z/gi, '');
	$('#lowerBound').html(lBoundTime.replace(/T/gi, ' '));
	$('#upperBound').html(uBoundTime.replace(/T/gi, ' '));
}

function setUnitBarChangeEvent(){
	$('#unitBar').on('change', function(){
		var unitIndex = $(this).val();
		if(unitIndex > -1){
			var bound = getUnitBound();
            setRangeBound(bound.lowerBound, bound.upperBound);

            // clear all markers
            if(drawAllMarkers === false){
                cleared = true;
                clearMarkerPolyline();
            }

            $('#recordTB tr').each(function(){
                if($(this).attr('unitId') !== index){
                    $(this).css('display', 'none');
                }
                else{
                    $(this).css('display', '');
                    var phoneNum = $(this).attr('phone');
                    var orderIndex = $(this).attr('orderIndex');
                    var currentRecordIndex = $(this).attr('recordIndex');

                    if(drawAllMarkers === false){
						var phoneIndex = getPhoneIndex(phoneNum);
						var showUnit = getShowPhoneUnit(phoneIndex, unitIndex);
                        var indexOfUnit = showUnit.indexOf(parseInt(currentRecordIndex));
						if(indexOfUnit !== -1 && indexOfUnit !== 0 &&
							currentRecordIndex !== '0' && orderIndex !== '0'){
                            googleMap.drawPolyline(phoneNum+"_"+currentRecordIndex);
						}
					}
					else{
                        if(orderIndex !== '0' && currentRecordIndex !== '0'){
                            googleMap.drawPolyline(phoneNum+"_"+currentRecordIndex);
                        }
					}
                    googleMap.drawMarkers(orderIndex);
				}
			});
		}
		else{
            var inputTimeMillSec = getTimeInputMillSec();
            setRangeBound(inputTimeMillSec.startTimeVal, inputTimeMillSec.stopTimeVal);
            cleared = false;
            drawAllMarkers_in_once();
		}
	});
}

function setAnimationBtnClickEvent(){
    $('#animationPlayer').on('click', function(){
		cleared = false;
		if($('#animationPlayer').attr('status') === 'stop'){
			var nextUnitId = parseInt($('#unitBar').val())+1;
			drawAllMarkers = true;
			if(nextUnitId.toString() === '0'){
				clearMarkerPolyline();
			}
			animationProcess = drawSingleUnit(nextUnitId, drawSingleUnit, 1000, true);
			$('#animationPlayer').attr('status', 'play');
			$('#animationPlayer').html('<span class="glyphicon glyphicon-pause"></span>');
        }
        else{
			clearTimeout(animationProcess);
			drawAllMarkers = false;
			$('#animationPlayer').attr('status', 'stop');
			$('#animationPlayer').html('<span class="glyphicon glyphicon-play"></span>');
        }
    });
}

function drawSingleUnit(unitId, callback, breakTime, resetCenter){
    var unitNum = parseInt($('#unitBar').prop('max'))+1;
	animationProcess = setTimeout(function(){
		if(unitId !== unitNum) {
			$("#unitBar").val(unitId);
			$("#unitBar").change();
			unitId++;
			callback(unitId, callback, breakTime, resetCenter);
		}
		else{
			$('#unitBar').prop('value', '-1');
			$('#unitBar').change();
			drawAllMarkers = false;
			$('#animationPlayer').attr('status', 'stop');
			$('#animationPlayer').html('<span class="glyphicon glyphicon-play"></span>');
		}
    }, breakTime);
}