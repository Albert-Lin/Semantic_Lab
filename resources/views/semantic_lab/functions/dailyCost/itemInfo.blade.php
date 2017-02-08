<?php
/**
 * Created by PhpStorm.
 * User: Albert Lin
 * Date: 2017/2/6
 * Time: 下午 11:07
 */
?>

@extends('semantic_lab.personal')

@section('contentBody')
    <style>
        #itemInfoBlock{
            overflow-x: hidden;
            overflow-y: auto;
        }
        #itemInsertForm>.boxHeader{
            background-color: #5b88de;
        }
        #itemSearchResultForm{
            display: none;
        }

    </style>
    <div id="itemInfoBlock" class="row h100">
        <div class="col-md-6 h100">
            <div class="row">
                <div id="itemInsertForm" class="col-md-offset-1 col-md-10 layoutBox ">
                    <div class="boxHeader">New Item:</div>
                    <form class="boxBody form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-md-2">URI</label>
                            <div class="col-md-7"><input id="iURI" type="url" class="form-control input-lg" value="{{ $data['domainURI'] }}" required></div>
                            <div id="iUError" class="col-md-3 inputError"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">rdf:type</label>
                            <div class="col-md-7"><input id="iType" type="url" class="form-control input-lg" value="http://dbpedia.org/ontology/" required></div>
                            <div id="iTError" class="col-md-3 inputError"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">rdfs:label</label>
                            <div class="col-md-7"><input id="iLabel" type="text" class="form-control input-lg" value="@(zh)" required></div>
                            <div id="iLError" class="col-md-3 inputError"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-2"><div id="itemInsertBtn" class="btn btn-info form-control"> ADD </div></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div id="itemSearchResultForm" class="col-md-offset-1 col-md-10 layoutBox">

                </div>
            </div>
        </div>
        <div class="col-md-6 h100">
            @include('semantic_lab.templates.sparql_search_form')
        </div>
    </div>
    <script>
        $('#itemInsertBtn').click(function(){
			var formInputId = ['iURI', 'iType', 'iLabel'];
			var formInputDef = ['http://semanticlab.com/', 'http://dbpedia.org/ontology/', '@(zh)'];
			var formErrorId = ['iUError', 'iTError', 'iLError'];
			var regexCheck = formRegexChek(formInputId, formInputDef, formErrorId);
			if(regexCheck === true){
				ajaxCSRFHeader();
				$.ajax({
					url: $('#domainURI').val()+'itemInfo/insert',
                    type: 'POST',
                    data: {
						uri : $('#iURI').val(),
						type : $('#iType').val(),
						label : $('#iLabel').val(),
                    },
                    success: function(xhrResponseText){
						var message = $.parseJSON(xhrResponseText);
						if(message.title === 'Error'){
							messageBlock(message.title, message.content, '');
							$('#messageModalBtn').click();
						}
						else if(message.title === 'Redirect'){
							window.location = message.content;
						}
						else if(message.title === 'Success'){
							//clear data
							defaultFormColumn(formInputId, formInputDef, formErrorId);
							messageBlock(message.title, message.content, '');
							$('#messageModalBtn').click();
                        }
                    },
                    error: function(xhrError){
                        if(xhrError.status === 404){
                        	message = {
                        		title: "404",
                                content: "Adding items fail, please contact programmer (code:dr404)."
                            };
							messageBlock(message.title, message.content, '');
							$('#messageModalBtn').click();
                        }
                        else if(xhrError.status === 500){
							message = {
								title: "Sorry",
								content: "Adding items fail, please contact programmer (code:dr500)."
							};
							messageBlock(message.title, message.content, '');
							$('#messageModalBtn').click();
                        }
                    }
                });
            }
        });
    </script>
@endsection
