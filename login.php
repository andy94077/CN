<?php
	ob_start();
   	session_start();
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	//error_reporting(-1);	

<<<<<<< HEAD
	if(file_exists('passwd')){
		$dict = json_decode(file_get_contents('passwd'), true);
	}
=======
	if(file_exists('passwd'))
		$dict = json_decode(file_get_contents('passwd'), true);
>>>>>>> 4314fe92e1f9a5dc39b6ca20c449fd3160b92e4b
	else
		$dict = array();

	if ($_POST['type'] === 'login'){
		if(!empty($dict) && array_key_exists($_POST['username'], $dict) && password_verify($_POST['password'], $dict[$_POST['username']])) {
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
			$dict[$_POST['username']] = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 5]);//, array('time_cost' => 20));
			file_put_contents('passwd', json_encode($dict));
<<<<<<< HEAD
			mkdir('new_message/'.$_POST['username']);
			file_put_contents('friends/'.$_POST['username'], json_encode(array()));
=======
>>>>>>> 4314fe92e1f9a5dc39b6ca20c449fd3160b92e4b
			echo 'Signed up!';
		}
	}

?>

