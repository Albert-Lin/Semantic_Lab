/**
 * Created by AlbertLin on 2017/2/9.
 */


// for AJAX:
//=========================================================
function messageBox(message){

	if(message.title === 'Redirect'){
		window.location = message.content;
	}
	else if(message.title === 'Success' && message.fun !== undefined){
		if(message.funParams !== undefined){
			message.fun(message.funParams);
		}
		else{
			message.fun();
		}
	}
	else{
		showMessageBox(message);
	}
}

function showMessageBox(message){
	// show all kinds of messages:
	$('#messageHeader').html(message.title);
	$('#messageBody').html(message.content);
	if(message.footer !== undefined) {
		$('#messageFooter').html(message.footer);
	}
	$('#messageModalBtn').click();
}

function resetForm(passData){
	var inputIds = passData.inputIds;
	var inputDefValues = passData.inputDefValues;
	var errorIds = passData.errorIds;
	for(var i = 0; i < inputIds.length; i++){
		$('#'+inputIds[i]).val(inputDefValues[i]);
		$('#'+errorIds[i]).html('');
	}
}


function formRegexChek(inputId, inputDefault, errorId){
	var checkResult = true;
	for(var i = 0; i < inputId.length; i++){
		$('#'+errorId[i]).html("");
	}

	for(var i = 0; i < inputId.length; i++){
		if($('#'+inputId[i]).val() === undefined ||
			$('#'+inputId[i]).val().length <= 0 ||
			$('#'+inputId[i]).val() === inputDefault[i]){

			$('#'+errorId[i]).html("Required");
			checkResult = false;
		}
	}

	if(checkResult === true){
		for(var i = 0; i < inputId.length; i++){

			if($('#'+inputId[i]).prop('type') === 'url'){
				if($('#'+inputId[i]).val().match(/^http:\/\/.*/) === null){
					$('#'+errorId[i]).html("Should be URL format");
					checkResult = false;
				}
			}
			else if($('#'+inputId[i]).prop('type') === 'email'){
				if($('#'+inputId[i]).val().match(/[0-9a-zA-Z]*@[0-9a-zA-Z]*\./) === null){
					$('#'+errorId[i]).html("Should be email format");
					checkResult = false;
				}
			}
			else if($('#'+inputId[i]).prop('type') === 'number'){
				if($('#'+inputId[i]).val().match(/[0-9]*/) === null){
					$('#'+errorId[i]).html("Should be number format");
					checkResult = false;
				}
			}
		}
	}

	return checkResult;
}

