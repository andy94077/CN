<?php
	ob_start();
   	session_start();
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	
	if(!$_SESSION['valid'])
		header('Location: index.php');
	
	if(file_exists('passwd'))
		$dict = json_decode(file_get_contents('passwd'), true);
	else
		$dict = array();

	if ($_POST['from_user'] !== $_SESSION['username'] || !array_key_exists($_POST['to_user'], $dict))
		return;

	if(strcmp($_POST['from_user'], $_POST['to_user']) < 0)
		$chat_file_path = 'chat/'.$_POST['from_user'].'|'.$_POST['to_user'];
	else
		$chat_file_path = 'chat/'.$_POST['to_user'].'|'.$_POST['from_user'];
<<<<<<< HEAD

	file_put_contents($chat_file_path, $_POST['from_user'].' '.bin2hex(htmlspecialchars($_POST['message']))."\n", FILE_APPEND);

	file_put_contents('new_message/'.$_POST['to_user'].'/'.$_POST['from_user'], '');
=======

	file_put_contents($chat_file_path, $_POST['from_user'].' '.bin2hex(htmlspecialchars($_POST['message']))."\n", FILE_APPEND);
>>>>>>> 4314fe92e1f9a5dc39b6ca20c449fd3160b92e4b
	echo '';
?>
