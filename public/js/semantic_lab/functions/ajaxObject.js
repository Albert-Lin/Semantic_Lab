/**
 * Created by AlbertLin on 2017/2/9.
 */

function ajaxCSRFHeader(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').prop('content')
		}
	});
}

function AjaxObject(blade, action, passData){

	this.ajax = undefined;

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
					var message = {
						title: '',
						content: ''
					};

					if(xhrError.status === 404){
						message.title = '404';
						message.content = 'Adding new currency fail.\r\n' +
							'Please contact programmer.\r\n' +
							'(code:curr_ins_404)';
					}
					else if(xhrError.status === 442){
						message.title = 'Sorry';
						message.content = 'Adding new currency fail.\r\n' +
							'Please make sure all required fields are filled out correctly.\r\n' +
							'(code:curr_ins_442)';
					}
					else if(xhrError.status == 500){
						message.title = '500';
						message.content = 'Adding new currency fail.\r\n' +
							'Please contact programmer.\r\n' +
							'(code:curr_ins_500)';
					}
					messageBox(message);
				}
			}
		}
	}
}
