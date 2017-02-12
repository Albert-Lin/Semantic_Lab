<?php
/**
 * Created by PhpStorm.
 * User: Albert Lin
 * Date: 2017/2/4
 * Time: 下午 11:59
 */
?>

<style>
    #simple-nav:before{
        width: 100%;
        height: 60px;
        background-color: #2e3436;
        opacity: 0.8;
        position: absolute;
        z-index: -1;
    }
    #simple-nav{
        border-width: 0;
        border-radius: 0;
        margin: 0;
        background-color: transparent;
        font-size: 18px;
        color: #ffffff;
    }
    .navbar{
        min-height: 60px;
        height: 60px;
    }
    #nav-logo-text{
        height: 60px;
        margin: 0;
        color: #ff7766;
        line-height: 30px;
    }
    #nav-right, #nav-left{
        margin: 0;
    }
    #nav-left{
        height: 60px;
        padding-top: 5px;
    }
        #nav-left>li>a{
            color: #ffffff;
        }
        #nav-right>li>a{
            color: #ffffff;
            line-height: 30px;
        }
            .nav>li>a:focus, .nav>li>a:hover{
                color: #ffffff;
                background-color: transparent;
            }
    .navbar-toggle{
        margin-top: 15px;
        padding: 0;
    }
</style>
<nav id="simple-nav" class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <div type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapse-content">
                <div class="glyphicon glyphicon-menu-hamburger"></div>
            </div>
            <div id="nav-logo-text" class="navbar-brand">{{ $data['nav']['navLogoText'] }}</div>
        </div>

        <div id="collapse-content" class="collapse navbar-collapse">
            <ul id="nav-left" class="nav navbar-nav">
                <li><div id="funBtn" class="btn btn-lg glyphicon glyphicon-menu-hamburger"></div></li>
                @foreach($data['nav']['navLeftFuns'] as $key => $item)
                    <li><a href="{{ $item['URL'] }}">{{ $item['funName'] }}</a></li>
                @endforeach
            </ul>
            <ul id="nav-right" class="nav navbar-nav navbar-right">
                <li><a>{{ $data['nav']['userName'] }}</a></li>
                <li><a id="nav-logout" href="{{ $data['nav']['logoutURI'] }}"> Log out <div class="glyphicon glyphicon-log-out"></div></a></li>
            </ul>
        </div>

    </div>
</nav>
