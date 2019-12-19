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

	if ($_POST['from_user'] != $_SESSION['username'] || !array_key_exists($_POST['to_user'], $dict))
		return;

	if($_FILES['file']['error'] == UPLOAD_ERR_NO_FILE){
		http_response_code(422);
		echo 'The file does not exist.';
		return;
	}
	if(empty($_FILES['file']) || $_FILES['file']['error'] == UPLOAD_ERR_INI_SIZE || $_FILES['file']['error'] == UPLOAD_ERR_FORM_SIZE || $_FILES['file']['size'] > 11000000){
		http_response_code(413);
		echo 'File size must be no more than 11 MB.';
		return;
	}
	if(strcmp($_POST['from_user'], $_POST['to_user']) < 0){
		$file_dir = 'upload_files/'.$_POST['from_user'].'|'.$_POST['to_user'];
		$chat_file_path = 'chat/'.$_POST['from_user'].'|'.$_POST['to_user'];
	}
	else{
		$file_dir = 'upload_files/'.$_POST['to_user'].'|'.$_POST['from_user'];
		$chat_file_path = 'chat/'.$_POST['to_user'].'|'.$_POST['from_user'];
	}

	if(!file_exists($file_dir)){
		mkdir($file_dir);
		chmod($file_dir, 0711);
	}

	$name = $file_dir.'/'.hash('sha256', $_FILES['file']['tmp_name']).time();
	move_uploaded_file($_FILES['file']['tmp_name'], $name);
	chmod($name, 0644);
	file_put_contents($chat_file_path, $_POST['from_user'].' '.bin2hex("<a href=.$filedir/$name download=".basename($_FILES['file']['name']).'>'.$_FILES['file']['name'].'</a>')."\n", FILE_APPEND);
	echo '';
?>

