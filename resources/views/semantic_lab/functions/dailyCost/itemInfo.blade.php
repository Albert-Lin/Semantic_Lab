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
        .h100{
            height: 100%;
        }
        #itemInfoBlock{
            overflow-x: hidden;
            overflow-y: auto;
        }
        #itemInsertForm{
            padding: 0;
            margin-top: 5%;
            background-color: #FFFFFF;
            box-shadow: 0 4px 10px 0 rgba(60, 32, 64, 0.5), 0 6px 40px 0 rgba(60, 32, 64, 0.49);
            font-weight: bolder;
        }
        #itemInsertForm>.itemFormTitle{
            padding-top: 20px;
            padding-right: 15px;
            padding-bottom: 20px;
            padding-left: 15px;
            background-color: #5b88de;
        }
        #itemInsertForm>.itemFormBody{
            margin: 20px;
        }
        #itemSearchResultForm{
            margin-top: 5%;
            background-color: #FFFFFF;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            display: none;
        }

    </style>
    <div id="itemInfoBlock" class="row h100">
        <div class="col-md-6 h100">
            <div class="row">
                <div id="itemInsertForm" class="col-md-offset-1 col-md-10">
                    <div class="itemFormTitle">New Item:</div>
                    <form class="itemFormBody form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-md-2">URI</label>
                            <div class="col-md-7"><input type="url" class="form-control input-lg" value="{{ $data['domainURI'] }}" ></div>
                            <div id="uriError" class="col-md-3"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">rdf:type</label>
                            <div class="col-md-7"><input type="url" class="form-control input-lg" value="http://dbpedia.org/ontology/"></div>
                            <div id="rdf:typeError" class="col-md-3"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">rdfs:label</label>
                            <div class="col-md-7"><input type="text" class="form-control input-lg" value="@(zh)"></div>
                            <div id="rdfs:labelError" class="col-md-3"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-2"><button class="btn btn-info form-control"> ADD </button></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div id="itemSearchResultForm" class="col-md-offset-1 col-md-10 h100">

                </div>
            </div>
        </div>
        <div class="col-md-6 h100">
            @include('semantic_lab.templates.sparql_search_form')
        </div>
    </div>
@endsection
