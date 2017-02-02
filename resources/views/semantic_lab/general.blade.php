<?php
/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/2/2
 * Time: 下午 04:44
 */
?>

@extends('semantic_lab.templates.htmlBlade')
@extends('semantic_lab.templates.blank_layout')

@section('title', $title)


@section('css')
    @parent
@endsection


@section('js')
    @parent
@endsection


@section('body')

    @section('logoText')
        Semantic Lab
    @endsection

    @section('infoBlock')
        <div class="row">
            <div class="col-md-4 col-sm-4">INFO-01......(more)</div>
            <div class="col-md-4 col-sm-4">INFO-02......(more)</div>
            <div class="col-md-4 col-sm-4">INFO-03......(more)</div>
        </div>
    @endsection

@endsection
