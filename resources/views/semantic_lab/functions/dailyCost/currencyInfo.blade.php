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
        }

    </style>
    <div class="currencyInfoBlock" Class="row h100">

        <div class="col-md-6 col-sm-6 col-sx-12 h100">
            <div class="row">
                <div id="currencyInfo" class="col-md-offset-1 col-md-10 layoutBox">
                    <div class="boxHeader">New Currency:</div>

                    <div id="sparqlEditor" class="boxBody">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="control-label col-md-2"></label>
                                <div class="col-md-7"><input id="cURI" type="url" class="form-control input-lg" value="{{ $data['domainURI'] }}"></div>
                                <div id="cUError" class="fcol-md-3 inputError"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2"></label>
                                <div class="col-md-7"><input id="cType" type="url" class="form-control input-lg" value="http://dbpedia/ontology/"></div>
                                <div id="cTError" class="fcol-md-3 inputError"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2"></label>
                                <div class="col-md-7"><input id="cLabel" type="url" class="form-control input-lg" value="@zh"></div>
                                <div id="cLError" class="fcol-md-3 inputError"></div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-2"><div id="currencyInsertBtn" class="btn btn-info form-control"> ADD </div></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-md-6 col-sm-6 col-sx-12 h100">
            @include('semantic_lab.templates.sparql_search_form');
        </div>

    </div>

@endsection