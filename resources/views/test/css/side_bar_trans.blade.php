<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
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
    </head>
		<style>
				
				html, body, .side-bar-block, .main-content{
						width: 100%;
						height: 100%;
						margin: 0px;
						padding: 0px;
				}		
				
				.side-bar-block {
						position: absolute;
						float: left;
				}

				.main-content {
						width: 95%;
						background-color: #448;
						position: relative;
						float: right;
						transition: 1s;
				}
				
				.function-list{
						width: 5%;
						height: 100%;
						background-color: #444;
				}
				
				.function-info-box{
						width: 15%;
						height: 100%;
						background-color: rgb(255, 60, 60);
				}
				
				.div-horizontal{
						float: left;
				}
		</style>
		<!-- FOR JQUERY -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script type="text/javascript">
				
				var transStatus = "close";
				
				function transStatusEvent(){
						$('.function-list').click(function(){
								if(transStatus === "close"){
										$('.main-content').css('width', "80%");
										transStatus = "open";
								}
								else
								{
										$('.main-content').css('width', "95%");
										transStatus = "close";
								}
						});
				}
		</script>
    <body onload="transStatusEvent()">
						
		<div class="side-bar-block">
				<div class="function-list div-horizontal" ></div>
				<div class="function-info-box div-horizontal">
						<ul class="list-group">
							<li class="list-group-item">First item</li>
							<li class="list-group-item">Second item</li>
							<li class="list-group-item">Third item</li>
						</ul>
						<input type="text" value="XXXXXXX">
				</div>
		</div>
		<div class="main-content"></div>

    </body>
</html>


