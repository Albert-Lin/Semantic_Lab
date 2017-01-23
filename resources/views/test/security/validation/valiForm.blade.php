<?php
/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/1/23
 * Time: 上午 10:29
 */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- FOR CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>

    <!-- FOR BOOTSTRAP -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- FOR JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- FOR BOOTSTRAP -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script type="text/javascript">

		$( document ).ready(function() {
			$('#submit').click(function(){

                var domainName = $("#domainName").val();
                var username = $("#username").val();
                var password = $("#password").val();
                var email = $("#email").val();

                // before using ajax to post data, we need to set CSRF value in post header:
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: domainName+"test/security/valiProcess",
                    type: "POST",
                    data: {
                        username: username,
                        password: password,
                        email: email
                    },
                    success: function(xhrResponseText){
                        $("#valiResult").html(xhrResponseText);
						$("#userError").html('');
						$("#passError").html('');
						$("#emailError").html('');
                    },
                    error: function(xhrError){

                    	// if the XHR error is about validation fails, the status might be 422
                    	if(xhrError.status === 422) {
							var errorMessage = jQuery.parseJSON(xhrError.responseText);
							$("#valiResult").html('');
							if(errorMessage.username !== undefined){
								$("#userError").html('<div class="alert alert-danger">'+errorMessage.username[0] + '</div>');
                            }
                            else{
								$("#userError").html('');
                            }

							if(errorMessage.password !== undefined){
								console.log(errorMessage.password[0]);
								$("#passError").html('<div class="alert alert-danger">'+errorMessage.password[0] + '</div>');
							}
							else{
								$("#passError").html('');
							}

							if(errorMessage.email !== undefined){
								$("#emailError").html('<div class="alert alert-danger">'+errorMessage.email[0] + '</div>');
							}
							else{
								$("#emailError").html('');
							}
						}
                    }
                });

			});
		});


    </script>

</head>
<body>

<br>
<div id="formContainer" class="row">
    <div id="valiForm" class="col-md-8 col-md-offset-2">
        <form class="form-horizontal">
            <input id="domainName" type="hidden" value="{{ $domainName }}">
            <div class="form-group">
                <label class="control-label col-md-offset-1 col-md-2">Account:</label>
                <div class="col-md-6">
                    <input id="username"class="form-control input-lg" type="text"/>
                </div>
                <div id="userError" class="col-md-3"></div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-offset-1 col-md-2">Password:</label>
                <div class="col-md-6">
                    <input id="password"class="form-control input-lg" type="password"/>
                </div>
                <div id="passError" class="col-md-3"></div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-offset-1 col-md-2">Email:</label>
                <div class="col-md-6">
                    <input id="email"class="form-control input-lg" type="email"/>
                </div>
                <div id="emailError" class="col-md-3"></div>
            </div>

            <div class="form-group">
                <div class="col-md-4 col-md-offset-3">
                    <div id="submit" class="btn btn-info">REGISTER</div>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="resultContainer" class="row">
    <div id="valiResult" class="col-md-offset-4 col-md-6"></div>
</div>


</body>
</html>
