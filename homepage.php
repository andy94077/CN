<?php
	ob_start();
   	session_start();
	if(!$_SESSION['valid'])
		header('Location: index.php');
	
	$user = 'Hello ' . $_SESSION['username'];
	$msg = array_key_exists('to_user_DNE', $_SESSION) ? 'The user does not exist.':'';
	unset($_SESSION['to_user_DNE']);

	if(file_exists('passwd'))
		$dict = json_decode(file_get_contents('passwd'), true);
	else
		$dict = array();
?>

<html>
<head>
	<title>CN Project</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<h2><?php echo $user;?></h2>
	<p id='response' style="color:red"><?php echo $msg;?></p>
	<form action='chat.php' method='POST'>
		<input type='text' name='to_user'>
		<button type='submit'>chat</button>
	</form>
</body>
</html>
