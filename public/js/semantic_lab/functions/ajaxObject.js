/**
 * Created by AlbertLin on 2017/2/9.
 */

function AjaxObject(blade, action, passData){

	this.ajax = undefined;

	this.ajaxCSRFHeader = function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').prop('content')
            }
        });
    };

	if(blade === 'general'){
	    if(action === 'register'){
	        this.ajax = insertAjax();
	        this.ajax.url = passData.domainURI+'register';
	        this.ajax.data = {
                userName: passData.userName,
                pass: passData.pass,
                mail: passData.mail
            };
	        this.ajax.success = passData.successFun;
	        this.ajax.error = passData.errorFun;
        }
        else if(action === 'autoSearch'){
	        this.ajax = insertAjax();
	        this.ajax.url = passData.domainURI+'login/autoSearch/cookie';
	        this.ajax.data = {
                input: passData.input,
                cookieName: passData.cookieName
            };
	        this.ajax.success = passData.successFun;
	        this.ajax.error = passData.errorFun;

        }
    }
	else if(blade === 'currencyInfo'){
		if(action === 'insert'){
            this.ajax = insertAjax();
            this.ajax.url = passData.domainURI+'dailyCost/currencyInfo/insert';
            this.ajax.data = {
                uri: passData.uri,
                type: passData.type,
                label: passData.label
            };
		}
	}
	else if(blade === 'itemInfo'){
	    if(action === 'insert'){
	        this.ajax = insertAjax();
	        this.ajax.url = passData.domainURI+'dailyCost/itemInfo/insert';
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
    }

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
                '(code:ajx_'+blade+'_'+action+'_404)';
        }
        else if(xhrError.status === 442){
            message.title = 'Sorry';
            message.content = 'Adding new data fail.<br>' +
                'Please make sure all required fields are filled out correctly.<br>' +
                '(code:ajx_'+blade+'_'+action+'_442)';
        }
        else if(xhrError.status == 500){
            message.title = 'Sorry';
            message.content = 'Adding new data fail.<br>' +
                'Please contact programmer.<br>' +
                '(code:ajx_'+blade+'_'+action+'_500)';
        }

        return message;
    }
}