<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<!doctype html>
<html>
    <head>
        <title> {{ $title }} </title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <style>

            html, body, .side-bar-block, .main-content{
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
            }

            html, body, .side-bar-block{
                background-color: #999;
                overflow-x: hidden;
                overflow-y: hidden;
            }

            .side-bar-block {
                font-family: monospace;
                color: #FFF;
                position: absolute;
                float: left;
            }

            .function-list{
                width: 60px;
                height: 100%;
                margin: 0;
                padding: 0;
                background-color: rgb(47, 53, 62);
            }

            .nav-pills>li, .nav-pills>li+li{
                width: 60px;
                height: 60px;
                border: 0;
                margin: 0;
                padding: 0;
                background-color: rgb(47, 53, 62);
            }

            .nav-pills > li > a {
                width: 60px;
                height: 60px;
                border: 0;
                padding: 0;
                margin: 0;
                border-radius: 0;

                text-align: center;
                vertical-align: middle;
                line-height: 60px;
            }

            .nav-pills > li > a:hover{
                background-color: rgb(47, 53, 62) !important;
                color: #259d6d;
            }

            .nav-pills > li.active > a{
                background-color: #666 !important;
                /*color: #d43f3a;*/
            }

            .nav-pills > li.active > a:visited{
                /*background-color: #F00 !important;*/
                /*color: #d43f3a;*/
            }

            .function-info-box{
                width: calc(25% - 60px);
                height: 100%;
                background-color: #666;
                overflow-x: hidden;
                overflow-y: auto;
            }

            #function-title{
                width: 100%;
                height: 60px;
                margin: 0;
                padding: 0;
                font-size: 18px;
                text-align: center;
                vertical-align: middle;
                line-height: 60px; /*as same as the height of div*/
                background-color: #444;
            }

            #server-box{
                width: 95%;
                height: 180px;
                margin: 2.5%;
                padding: 0;
            }

            #server_account, #server_password{
                z-index: 0;
            }

            #node-info-box{
                width: 95%;
                margin: 2.5%;
                padding: 0;
            }

            table{
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            }

            thead{
                font-weight: 900;
                background-color: rgb(47, 53, 62);
            }

            .main-content {
                width: calc(100% - 60px);
                background-color: #999;
                position: relative;
                float: right;
                transition: 1s;
            }

            #cypher-box{
                width: 98%;
                height: 50px;
                margin: 10px;
                padding: 0;
                font-family: monospace;
                font-size: 12px;
                background-color: #FFF;
            }

            #cypher{
                width: 98%;
                height: 100%;
                margin: 0;
                padding: 0;
                border: 0;
                resize: none;
                float: right;
                outline:0 !important;
                -webkit-appearance:none;
            }

            #svg-box{
                width: 98%;
                height: calc(96% - 70px);
                margin: 10px;
                padding: 0;
                background-color: #999;
                overflow-x: hidden;
                overflow-y: auto;
            }

            .svg-header{
                height: 60px;
                margin: 0;
                padding: 0;
                vertical-align: middle;
                line-height: 60px;
                color: #2579a9;
                font-family: monospace;
                background-color: #DDD;
            }

            .svg-header-delete{
                width: 60px;
                height: 60px;
                margin: 0;
                padding: 0;
                text-align: center;
                vertical-align: middle;
                line-height: 60px;
                float: left;
                top: 0;
                background-color: #BBB;
            }

            .svg-header-labe{
                height: 60px;
                margin: 0;
                padding: 0;
                float: left;
                background-color: #DDD;
            }

            svg{
                transition: 1s;
            }

            path.link {
                fill: none;
                stroke: #666;
                stroke-width: 1.5px;
            }

            .div-horizontal{
                float: left;
            }

            hr {
                display: block;
                margin-top: 0;
                margin-bottom: 40px;
                margin-left: 20px;
                margin-right: 20px;
                border-style: groove;
                border-width: 1px;
            }

            .function-label{
                width: 60%;
                height: 30px;
                text-align: center;
                vertical-align: middle;
                line-height: 30px;
                background-color: #d43f3a;
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            }

            .glyphicon{
                color: rgb(83, 185, 234);
            }

            .glyphicon-trash {
                font-size: 20px;
                color: #d43f3a;
            }

            .glyphicon-function{
                font-size: 20px;
                color: #259d6d;
            }


        </style>
        <!-- FOR JQUERY -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <!-- FOR BOOTSTRAP -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!-- FOR D3 -->
        <script src="http://d3js.org/d3.v3.js"></script>
        <!-- FOR Neo4J -->
        <script src="../../neo4j/lib/browser/neo4j-web.js"></script>
        <!-- FOR Utility -->
        <script src="../../js/Utility/publicFun.js"></script>
        <!-- FOR Model -->
        <script src="../../js/Model/Neo4J.js"></script>
        <!-- FOR View -->
        <script src="../../js/View/D3.js"></script>
        <!-- FOR Controller -->
        <script src="../../js/Controller/Neo4JController.js"></script>

        <script type="text/javascript">

			// GLOBAL VARIABLE:
			//===========================================================================
			var transPills = "";
			var transStatus = "close";
			var D3LinkedGraphs = [];

			// FUNCTION:
			//===========================================================================
            /**
             * Create a new D3 LinkedGraph with Neo4J Data
             */
			function main(){
				console.log("YA HOOOOOOO");
				// DOM:
				var account = $("#server_account").val();
				var password = $("#server_password").val();
				var cypher = $("#cypher").val();
				var svgId = "svg_"+$('svg').length;
				// View:
				var d3 = new D3();

                // Controller && Model (resource)
				var neo4JCtrl = new Neo4JController();

				D3LinkedGraphs[svgId] = true;
				neo4JCtrl.D3Vis(account, password, cypher, d3.linkedGraph);
			}

            // JS Event functions not for DOM
			/**
             * The reason that current function can not used in D3 class,
             * is because that every time new a object of D3
             * will duplicate register this function.
			 * @param svgId
			 */
			function D3SvgDelete(svgId){
				D3LinkedGraphs[svgId] = undefined;
				$(svgId).html("");
				$(svgId).remove();

				if($("svg").length === 0){
					$("#node-info-box").html("");
				}
			}


			// All JQuery Event functions for DOM
			function jQueryEvent(){
				// transStatusEvent:
                $('.nav-pills li a').click(function(){

                    if(transStatus === "close"){
                        $('.main-content').css('width', "75%");
                        $('svg').css('width', '100%');
                        transPills = this.href;
                        transStatus = "open";
                    }
                    else if(this.href !== transPills && transStatus === "open"){
                        transPills = this.href;
                    }
                    else if(this.href === transPills && transStatus === "open"){
                        $('.main-content').css('width', "calc(100% - 60px)");
                        $('svg').css('width', '100%');
                        transPills = this.href;
                        transStatus = "close";
                    }

                });

                // others:
                // ...
            }

        </script>
				
    </head>
    <body onload="jQueryEvent()">

    <div class="side-bar-block">
        <div class="function-list div-horizontal" >
            <ul class="nav nav-pills">
                <li><a data-toggle="pill"  class="tabs glyphicon glyphicon-cog glyphicon-function" value="pills0"  href="#pills0"></a></li>
                <li><a data-toggle="pill"  class="tabs glyphicon glyphicon-barcode glyphicon-function" value="pills1"  href="#pills1"></a></li>
                <li><a data-toggle="pill"  class="tabs glyphicon glyphicon-leaf glyphicon-function" value="pills2"  href="#pills2"></a></li>
            </ul>
        </div>
        <div class="function-info-box div-horizontal">
            <div id="pills0" class="pills-content tab-pane fade">
                <!--FUNCTION TITLE-->
                <div id="function-title">
                    FUNCTION TILE
                </div>
                <br>

                <!--SERVER BLOCK-->
                <div class="function-label">Server information</div>
                <div id="server-box">
                    <br>
                    <form class="form-horizontal">
                        <div class="form-group">
                            <div class="input-group col-sm-offset-1 col-sm-10">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="server_account" class="form-control info" type="text" value="neo4j" placeholder="account"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group col-sm-offset-1 col-sm-10">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input id="server_password" class="form-control info" type="text" value="123" placeholder="password" />
                            </div>
                        </div>
                    </form>
                    <div class="col-sm-offset-0 col-sm-11">
                        <button class="btn btn-info" onclick="main()">QUERY</button>
                    </div>
                </div>
                <br>

                <!--NODE INFO-->
                <div class="function-label">Information of click</div>
                <div id="node-info-box">
                    <br><br><br><br>
                </div>
                <br>

            </div>

            <div id="pills1" class="pills-content tab-pane fade"></div>

            <div id="pills2" class="pills-content tab-pane fade"></div>
        </div>
    </div>
    <div class="main-content">
        <div id="cypher-box"> <textarea id="cypher" >MATCH rdf=(s:人)-[p]-(o:車牌號碼) RETURN rdf LIMIT 15</textarea> </div>
        <div id="svg-box"></div>
    </div>

    </body>
</html>


