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


	if (!file_exists($chat_file_path)){
		echo '';
		return;
	}
	

	$f = fopen($chat_file_path, 'rb');
	fseek($f, 0, SEEK_END);
	$tail = ftell($f);
	
	if($tail == $_POST['pos'])
		http_response_code(304);
	else{
		fseek($f, $_POST['pos'], SEEK_SET);
		$data = fread($f, $tail - $_POST['pos']);
		$json = array('pos' => $tail, 'message' => $data);
		echo json_encode($json);
	}
?>
