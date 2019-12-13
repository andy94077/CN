<?php
	ob_start();
   	session_start();
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	//error_reporting(-1);	

	if(file_exists('passwd'))
		$dict = json_decode(file_get_contents('passwd', 'r'), true);
	else
		$dict = array();

	if ($_POST['type'] == 'login'){
		if(array_key_exists($_POST['username'], $dict) && $_POST['password'] == $dict[$_POST['username']]) {
			$_SESSION['valid'] = true;
			$_SESSION['timeout'] = time();
			$_SESSION['username'] = $_POST['username'];

			echo 'success';
		}
		else
			echo 'Wrong username or password';
	}
	else if(empty($_POST['username']))
		echo 'Username cannot be empty';
	else if(array_key_exists($_POST['username'], $dict))
		echo 'Username has already existed';
	else{
		preg_match('/\W+/', $_POST['username'], $output);
		if(!empty($output))
			echo 'Username must consist of A-Z, a-z, 0-9, and _.';
		else{
			$dict[$_POST['username']] = $_POST['password'];
			echo 'Signed up!';
		}
	}

	file_put_contents('passwd', json_encode($dict))
?>

