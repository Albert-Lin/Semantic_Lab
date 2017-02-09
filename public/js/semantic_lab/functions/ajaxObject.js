/**
 * Created by AlbertLin on 2017/2/9.
 */

// function ajaxCSRFHeader(){
// 	$.ajaxSetup({
// 		headers: {
// 			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').prop('content')
// 		}
// 	});
// }

function AjaxObject(blade, action, passData){

	this.ajax = undefined;

	this.ajaxCSRFHeader = function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').prop('content')
            }
        });
    };

	if(blade === 'currencyInfo'){
		if(action === 'insert'){
			this.ajax = {
				url: passData.domainURI+'dailyCost/currencyInfo/insert',
				type: 'POST',
				data: {
					uri: passData.uri,
					type: passData.type,
					label: passData.label,
				},
				success: function(xhrResponseText){
					var message = $.parseJSON(xhrResponseText);
					if(message.title === 'Success'){
						message.fun = function(){
							resetForm(passData);
							showMessageBox(message);
						}
					}
					messageBox(message);
				},
				error: function(xhrError){
					var message = insertError(xhrError);
					messageBox(message);
				}
			};
		}
	}
	else if(blade === 'itemInfo'){
	    if(action === 'insert'){
	        this.ajax = insertAjax();
	        this.ajax.url = passData.domainURI+'dailyCost/itemInfo/insert'
            this.ajax.data = {
                uri: passData.uri,
                type: passData.type,
                label: passData.label
            };
        }
    }

    function insertAjax(){
	    return {
            url: '',
            type: 'POST',
            data: {},
            success: function(xhrResponseText){
                var message = insertSuccess(xhrResponseText);
                messageBox(message);
            },
            error: function(xhrError){
                var message = insertError(xhrError);
                messageBox(message);
            }
        };
    };

    function insertSuccess(xhrResponseText){
        var message = $.parseJSON(xhrResponseText);
        if(message.title === 'Success'){
            message.fun = function(){
                resetForm(passData);
                showMessageBox(message);
            }
        }

        return message;
    }

    function insertError(xhrError){
        var message = {
            title: '',
            content: ''
        };

        if(xhrError.status === 404){
            message.title = '404';
            message.content = 'Adding new data fail.<br>' +
                'Please contact programmer.<br>' +
                '(code:curr_ins_404)';
        }
        else if(xhrError.status === 442){
            message.title = 'Sorry';
            message.content = 'Adding new data fail.<br>' +
                'Please make sure all required fields are filled out correctly.<br>' +
                '(code:curr_ins_442)';
        }
        else if(xhrError.status == 500){
            message.title = 'Sorry';
            message.content = 'Adding new data fail.<br>' +
                'Current data already exist, please add new one.<br>' +
                '(code:curr_ins_500)';
        }

        return message;
    }
}