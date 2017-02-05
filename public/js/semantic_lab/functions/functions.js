/**
 * Created by Albert Lin on 2017/2/5.
 */


$(document).ready(function(){

    // Daily Cost
    $("#newDC").click(function(){
        window.location = $('#domainURI').val()+'dailyCost/newDC';
    });

    $("#vRForm").click(function(){
        window.location = $('#domainURI').val()+'dailyCost/vRForm';
    });

    $("#vRGraphic").click(function(){
        window.location = $('#domainURI').val()+'dailyCost/vRGraphic';
    });
});
