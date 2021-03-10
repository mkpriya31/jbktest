<?php 
	session_start();
	$title="Admin Panel - Java By Kiran";
	if(isset($_SESSION['username'])&&($_SESSION['username']!='')){
		header('location:dashboard');
	}/*&&($_SESSION['user_role']=='1')elseif(isset($_SESSION['user_role'])&&$_SESSION['user_role']=='2'){
		header('location:subject');
	}elseif(isset($_SESSION['user_role'])&&$_SESSION['user_role']=='3'){
		header('location:question');
	}*/
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/admin-style.css" rel="stylesheet">
	<link rel="shortcut icon" href="../img/favicon.ico">
	<title><?=$title?></title>
</head>
<body>
	<div class="container">
        <div class="login-form">
            <div class="main-div">
                <div class="panel">
                    <h1>JBK TEST</h1>
					<h2>Admin Panel</h2>
                    <p>Please enter your email and password</p>
                </div>
                <form role="form" action="login-submit" method="post" id="login-form">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" id="username" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                    </div>
                    <div class="forgot">
                        <a href="reset.html">Forgot password?</a>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
                <div id="error" style="margin-top: 30px; display: none;"></div>
            </div>
        </div>		
	</div>
<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/bootstrap.min.js"></script>	
</body>
</html>

<script type="text/javascript">
	$( document ).ready(function() {
	    $('#error').hide();
	});
	$('#login-form').submit(function(e){
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			type: "POST",
			dataType: "json",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			success: function(response){
				if(response.type == 'success'){
					$('#error').html('');
					$('#error').hide();
					/*if(response.action=='3'){
                      window.location = "question";					  
					}else if(response.action=='2'){
					  window.location = "users";
					}else{*/
					  window.location = "dashboard";
					//}
				}
				else{
					$('#error').html(response.action);
					$('#error').show();
				}
				return true;
			},
			error: function(){}
		});
	});
</script>