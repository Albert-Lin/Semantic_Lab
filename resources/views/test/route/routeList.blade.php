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
		<!-- Bootstrap Core CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src=" https://cdnjs.cloudflare.com/ajax/libs/xls/0.7.4-a/xls.js"></script>
    </head>
    <body>
				<div class="btn-group-vertical">
				<?php
						for($i = 0; $i < count($routeList); $i++){
								if($i%2 == 0){
										echo '<a class="btn btn-primary" href="../../'.$routeList[$i].'">'.$routeList[$i].'</a>';
								}
								else if($i%2 === 1){
										echo '<a class="btn btn-info" href="../../'.$routeList[$i].'">'.$routeList[$i].'</a>';
								}
						}
				?>
				</div>
    </body>
</html>
