<?php
/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/2/2
 * Time: 下午 04:44
 */
?>

@extends('semantic_lab.templates.htmlBlade')

@section('title', $title)


@section('css')
    @parent
@endsection


@section('js')
    @parent
@endsection


@section('body')
    @include('semantic_lab.templates.blank_layout')
@endsection
