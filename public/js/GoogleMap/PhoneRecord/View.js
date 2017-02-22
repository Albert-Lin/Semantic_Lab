/**
 * Created by Albert Lin on 2017/2/22.
 */


// FUNCTIONS FOR GET/SET THE DATA FROM/INTO HTML DOM (ALSO GOOGLE MAP)

var lastContent = undefined;
var clickFun = undefined;

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

function setRangeBound(lowerMillSec, upperMillSec){
    var lBoundTime = new Date(lowerMillSec+(8*3600000)).toISOString().replace(/\..*Z/gi, '');
    var uBoundTime = new Date(upperMillSec+(8*3600000)).toISOString().replace(/\..*Z/gi, '');
    $('#lowerBound').html(lBoundTime.replace(/T/gi, ' '));
    $('#upperBound').html(uBoundTime.replace(/T/gi, ' '));
}

function setCheckAllClickEvent(){
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
}

function phoneItemCheckbox(){
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

function setPhoneListTB(){
    var tableContent;
    for(var i = 0; i < phones.length; i++){
        var phoneNum = phones[i].getPropValue('監察號碼');
        var phoneColor = phones[i].getPropValue('color');
        var tr = '<tr>'+
            '<td><input type="checkbox" class="listItem" value="'+phoneNum+'"></td>'+
            '<td>'+phoneNum+'</td>'+
            '<td style="background-color: '+phoneColor+';"></td>'+
            '</tr>';
        tableContent += tr;
    }
    $('#phoneNumTB').html(tableContent);
    phoneItemCheckbox();
}

function setSubmitBtnClickEvent(){
    var submit = true;
    var timeInput = getTimeInputValue();
    var startTime = (new Date(Date.parse( timeInput.startTimeVal ))).getTime()-(8*3600000);
    var stopTime = (new Date(Date.parse( timeInput.stopTimeVal ))).getTime()-(8*3600000);
    var timeUnit = $('input[name=unit]:checked').val();
    setRangeBound(startTime, stopTime);

    if(isNaN(startTime) && isNaN(stopTime)){
        $('#timeValid').css('display', 'block');
        submit = false;
    }

    if(timeUnit === undefined){
        $('#unitValid').css('display', 'block');
        submit = false;
    }

    if(submit === true){

    }
}