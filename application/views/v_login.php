<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); 
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Login</title>

	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/style.css">

</head>
<body>

	<div id="container" class="col-lg-3 lytLogin">
		<h4>Please Login</h4>



		<form id="formLogin" class="form-horizontal formLogin" method="post">
			<div class ="form-group">
				<div class="col-lg-12">
					<input type="text" name="username" placeholder="Username" required class="form-control">
				</div>
			</div>

			<div class ="form-group">
				<div class="col-lg-12">
					<input type="password" name="password" placeholder="Password" required class="form-control">
				</div>
			</div>

			<div class ="form-group">
				<div class="col-lg-12">
					<input type="submit" name="submit" value="Login" class="btnLogin btn btn-primary ">
				</div>
			</div>
		</form>
	</div>
	<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("form#formLogin").submit(function(e) {
				var data=$("#formLogin").serialize();
				$.ajax({
					type:"POST",
					dataType:"JSON",
					data:data,
					url:"<?=base_url()?>index.php/home/login/",
					success:function (data) {
						if (data.msg=="good") {
						// alert("Success!");
						window.location="<?=base_url()?>";
					}else{
						alert(data.msg);
					}
				}
			});
				e.preventDefault();
			})
		})
		
	</script>

</body>
</html>
