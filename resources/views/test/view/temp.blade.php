<?php
/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/1/19
 * Time: 下午 01:03
 */
?>

@extends('test.view.view_layout.main_layout')

@section('title', $title)

<!-- FOR yield function -->
@section('cont0')

    <p>This message is from temp.blade.php. For @ yield function, there is no default content.</p>

@endsection

<!-- FOR section function -->
@section('cont1-1')

    <p>This message is from temp.blade.php. For @ section function, there is default message which can be overwrite.<br><br>
        The original message in main_layout.blade.php is : 'This content is set default in "main_layout.blade.php"'.</p>

@endsection

@section('cont1-2')

    <p>This message is from temp.blade.php. For @ section function, using keyword @ parent can keep the default content in included blade file, just like:</p>
    <br> <br>
    <p> @parent </p>

@endsection
