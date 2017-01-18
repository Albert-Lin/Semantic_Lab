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
				<title>{{ $title }}</title>
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
				<style type="text/css">
						html, body, #container{
								width: 100%;
								height: 100%;
								margin: 0px;
								padding: 0px;
								background-color: #666;
						}

						#list{
								width: 60px;
								height: 100%;
								margin: 0px;
								padding: 0px;
								background-color: #666;
								float: left;
						}
								/*
										01.
										Symbol " > " in css is a selecter which finds the left element is direct child of right element.
										e.g., .nav-pills>li means finding all <li> elements which is direct child of  < class="nav-pills" >

										02.
										Symbol " + " in css is a selecter which finds the left element is next sibling of right element.
										e.g., li+li means finding all <li> which is next sibling of another <li>
								*/
								/*
										This CSS can override the bootstrap style of <li> elements.
										We need to set both " .nav-pills>li " && " .nav-pills>li+li ",
										if only set " .nav-pills>li " all the <li> elements except first one will have margin-left with width,
										else if only set " .nav-pills>li+li " the first <li> element will not be set.
								*/
								.nav-pills>li, .nav-pills>li+li{
										width: 60px;
										height: 60px;
										border: 0px;
										margin: 0px;
										padding: 0px;
										background-color: #F00;
								}

								.nav-pills>li>a {
										width: 60px;
										height: 60px;
										border: 0px;
										padding: 0px;
										margin: 0px;
										/*
												The keypoint of this CSS is override the " border-radius " for setting the angle of pills
										*/
										border-radius: 0px;

										/*
												we can set the text or the glyphicon in the center (both vertical && horizontal) of <li> element
										*/
										text-align: center;
										vertical-align: middle;
										line-height: 60px;
								}

								/*
										03.
										" :hover " have same effect as onMouseOver usually used for <a> element
								*/
								/*
										The keypoint of this CSS is override the onMouseOver effect of <a> element
								*/
								.nav-pills > li > a:hover{
										background-color: #FFF !important;
										color: #000;
								}

								/*
										04.
										" :visited " selector is used to select visited links.
								*/
								.nav-pills > li.active > a:visited{
										background-color: #FFF !important;
										color: #c7254e;
								}

						#content{
								width: 500px;
								height: 100%;
								margin: 0px;
								padding: 0px;
								background-color: #FFF;
								float: left;
						}

						.glyphicon{
								color: #98cbe8;
								font-size: 18px;
						}
				</style>

				 <!--FOR JQUERY-->
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
				 <!--FOR BOOTSTRAP-->
				<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
				<script type="text/javascript">

				</script>
		</head>
		<body>
				<div id="container">

						<div id="list">
								<ul class="nav nav-pills">
										<li><a data-toggle="pill" href="#tab_content_0" class="tabs glyphicon glyphicon-ok"></a></li>
										<li><a data-toggle="pill" href="#tab_content_1" class="tabs glyphicon glyphicon-cloud"></a></li>
										<li><a data-toggle="pill" href="#tab_content_2" class="tabs glyphicon glyphicon-tags"></a></li>
								</ul>
						</div>
						<div id="content" class="tab-content">
								<div id="tab_content_0" class="tab-pane fade tabC"> THIS IS CONTENT OF TAB 0 </div>
								<div id="tab_content_1" class="tab-pane fade tabC"> THIS IS CONTENT OF TAB 1 </div>
								<div id="tab_content_2" class="tab-pane fade tabC"> THIS IS CONTENT OF TAB 2 </div>
						</div>

				</div>
		</body>
</html>