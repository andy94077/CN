<?php
	ob_start();
   	session_start();
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	
	if(!$_SESSION['valid'])
		header('Location: index.php');
	
	if($_FILES['file']['size'] > 2e7){
		http_response_code(413);
		echo 'File size must be no more than 20MB.';
		return;
	}
	
	if(strcmp($_POST['from_user'], $_POST['to_user']) < 0){
		$file_dir = 'upload_files/'.$_POST['from_user'].'_'.$_POST['to_user'];
		$chat_file_path = 'chat/'.$_POST['from_user'].'_'.$_POST['to_user'];
	}
	else{
		$file_dir = 'upload_files/'.$_POST['to_user'].'_'.$_POST['from_user'];
		$chat_file_path = 'chat/'.$_POST['to_user'].'_'.$_POST['from_user'];
	}

	if(!file_exists($file_dir)){
		mkdir($file_dir);
		chmod($file_dir, 0755);
	}

	$name = $file_dir.'/'.hash('sha256', $_FILES['file']['tmp_name']).time();
	move_uploaded_file($_FILES['file']['tmp_name'], $name);
	chmod($name, 0644);
	file_put_contents($chat_file_path, $_POST['from_user'].' '.bin2hex("<a href=.$filedir/$name download=".basename($_FILES['file']['name']).'>'.$_FILES['file']['name'].'</a>')."\n", FILE_APPEND);
	echo '';
?>

