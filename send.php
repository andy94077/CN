<?php
	ob_start();
   	session_start();
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	
	if(!$_SESSION['valid'])
		header('Location: index.php');
	
	if(strcmp($_POST['from_user'], $_POST['to_user']) < 0)
		$chat_file_path = 'chat/'.$_POST['from_user'].'_'.$_POST['to_user'];
	else
		$chat_file_path = 'chat/'.$_POST['to_user'].'_'.$_POST['from_user'];

	file_put_contents($chat_file_path, $_POST['from_user'].' '.bin2hex(str_replace(array('&', '<', '>'), array('&amp;', '&lt;', '&gt;'), $_POST['message']))."\n", FILE_APPEND);
	echo '';
?>
