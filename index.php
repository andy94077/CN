
<!DOCTYPE html>
<html lang="en">

<head>
	<title>CN Project</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<!--===============================================================================================-->

	<script>
		function send(type) {
			$.post('./login.php', { type: type, username: $('#username').val(), password: $('#password').val() },
				function (response) {
					if(response === 'success\n'){
						window.location = 'homepage.php';
					}
					else if (response !== 'Signed up!\n'){
						$('#username').val('');
						$('#password').val('');
					}
					$('#response').text(response);
				}
			);
		}
	</script>
</head>

<body>

	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
					Account Login
				</span>
				<div class="login100-form validate-form p-b-33 p-t-5"><!-- action="login.php" method="post">-->
					<center><p id='response' style="color:red"></p></center>

					<div class="wrap-input100 validate-input" data-validate="Enter username">
						<input class="input100" type="text" id="username" placeholder="User name">
						<span class="focus-input100" data-placeholder="&#xe82a;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" id="password" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
					</div>

					<div class="container-login100-form-btn m-t-32">
						<button class="login100-form-btn" type='button' name='login' onclick="send('login')">Login</button>
						<button class="login100-form-btn" type='button' name='sign_up' onclick="send('sign_up')">Sign up</button>
					</div>

				</div>
			</div>
		</div>
	</div>


	<div id="dropDownSelect1"></div>

	<!--===============================================================================================-->
	<!-- <script src="vendor/jquery/jquery-3.2.1.min.js"></script> -->
	<!--===============================================================================================-->
	<!-- <script src="vendor/animsition/js/animsition.min.js"></script> -->
	<!--===============================================================================================-->
	<!-- <script src="vendor/bootstrap/js/popper.js"></script> -->
	<!-- <script src="vendor/bootstrap/js/bootstrap.min.js"></script> -->
	<!--===============================================================================================-->
	<!-- <script src="vendor/select2/select2.min.js"></script> -->
	<!--===============================================================================================-->
	<!-- <script src="vendor/daterangepicker/moment.min.js"></script> -->
	<!-- <script src="vendor/daterangepicker/daterangepicker.js"></script> -->
	<!--===============================================================================================-->
	<!-- <script src="vendor/countdowntime/countdowntime.js"></script> -->
	<!--===============================================================================================-->
	<!-- <script src="js/main.js"></script> -->

</body>

</html>
