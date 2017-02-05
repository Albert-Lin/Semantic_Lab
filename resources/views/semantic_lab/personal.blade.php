<?php
/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/2/3
 * Time: 下午 02:54
 */
?>

@extends('semantic_lab.templates.functional_layout')

@section('title', $data['title'])

@section('list-group-item')
    <style>
        #funBody>.list-group>.list-group-item{
            background-color: transparent;
            border: 0;
            border-left: 10px;
            line-height: 40px;
            color: #ffffff;
            font-size: 16px;
        }
        #funBody>.list-group>.btn{
            text-align: left;
            border-radius: 0;
        }
        #funBody>.list-group>.btn:hover{
            background-color: #ff7766;
        }
    </style>
    @if(isset($data['funs']))
        @foreach($data['funs'] as $key => $item)
            <div id="{{ $item['id'] }}" class="btn list-group-item">{{ $item['funName'] }}</div>
        @endforeach
    @endif
@endsection
