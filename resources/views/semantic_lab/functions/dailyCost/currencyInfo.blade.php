<?php
/**
 * Created by PhpStorm.
 * User: Albert Lin
 * Date: 2017/2/9
 * Time: 上午 01:23
 */
?>

@extends('semantic_lab.personal')

@section('contentBody')

    <style>
        #currencyInfoBlock{
            overflow-x: hidden;
            overflow-y: auto;
            display: flex;
            align-items: center;
        }
    </style>
    <div id="currencyInfoBlock" Class="row  h100">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="row">
                <div id="currencyInfo" class="col-md-offset-1 col-md-10 layoutBox">
                    <div class="boxHeader">New Currency:</div>
                    <form class="boxBody form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-md-2">URI</label>
                            <div class="col-md-7"><input id="cURI" type="url" class="form-control input-lg" value="http://dbpedia.org/resource/"></div>
                            <div id="eCURI" class="fcol-md-3 inputError"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">rdf:type</label>
                            <div class="col-md-7"><input id="cType" type="url" class="form-control input-lg" value="http://dbpedia.org/ontology/"></div>
                            <div id="eCType" class="fcol-md-3 inputError"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">rdfs:label</label>
                            <div class="col-md-7"><input id="cLabel" type="text" class="form-control input-lg" value="@en"></div>
                            <div id="eCLabel" class="fcol-md-3 inputError"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-2"><div id="currencyInsertBtn" class="btn btn-info form-control"> ADD </div></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            @include('semantic_lab.templates.sparql.sparql_search_form')
        </div>
    </div>
    @include('semantic_lab.templates.sparql.sparql_result_form')
    <script>
        $(function(){
        	$('#currencyInsertBtn').on('click', function(){
				var passData = {
                    domainURI: $('#domainURI').val(),
					uri: $('#cURI').val(),
					type: $('#cType').val(),
					label: $('#cLabel').val(),
					inputIds: ["cURI", "cType", "cLabel"],
					inputDefValues: ["http://dbpedia.org/resource/", "http://dbpedia.org/ontology/", "@en"],
					errorIds: ["eCURI", "eCType", "eCLabel"]
				};
				var ajaxObject = new AjaxObject('currencyInfo', 'insert', passData);
                var regexCheck = formRegexChek(passData.inputIds, passData.inputDefValues, passData.errorIds);
				// 01. form validation
                if(regexCheck === true){
					// 02. insert data by ajax
                    ajaxObject.ajaxCSRFHeader();
					$.ajax(ajaxObject.ajax);
                }
            });

        });
    </script>

@endsection