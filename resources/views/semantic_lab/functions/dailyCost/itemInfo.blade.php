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
                            <div id="eIURI" class="col-md-3 inputError"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">rdf:type</label>
                            <div class="col-md-7"><input id="iType" type="url" class="form-control input-lg" value="http://dbpedia.org/ontology/" required></div>
                            <div id="eIType" class="col-md-3 inputError"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">rdfs:label</label>
                            <div class="col-md-7"><input id="iLabel" type="text" class="form-control input-lg" value="@zh" required></div>
                            <div id="eILabel" class="col-md-3 inputError"></div>
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

        $(function(){
            $('#itemInsertBtn').on('click', function(){
                var passData = {
                    domainURI: $('#domainURI').val(),
                    uri: $('#iURI').val(),
                    type: $('#iType').val(),
                    label: $('#iLabel').val(),
                    inputIds: ["iURI", "iType", "iLabel"],
                    inputDefValues: [$('#domainURI').val(), "http://dbpedia.org/ontology/", "@zh"],
                    errorIds: ["eIURI", "eIType", "eILabel"]
                };
                var ajaxObject = new AjaxObject('itemInfo', 'insert', passData);
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
