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
	
	$friend_arr = json_decode(file_get_contents('friends/'.$_SESSION['username']), true);

	$new_message_arr = array_slice(scandir('new_message/'.$_SESSION['username']), 2);
	$friend_arr = array_diff($friend_arr, $new_message_arr);

	$friend = '';
	$new_message = '';
	foreach($friend_arr as $f)
		$friend .= $f.' ';
	foreach($new_message_arr as $f)
		$new_message .= $f.' ';
?>

<html>
<head>
	<title>CN Project</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<script>
		$(document).ready(function() {
			var friends = "<?php echo $friend;?>".slice(0, -1).split(" ");
			var new_message = "<?php echo $new_message;?>".slice(0, -1).split(" ");
			if(friends[0] === "" && new_message[0] === ""){
				$('body').append("<p>You don't have any friends!</p>");
			}
			else{
				if(new_message[0] !== ""){
					for (var i in new_message){
						console.log(new_message[i]);
						$('#friends').append('<li><b>'+new_message[i]+'</b></li>');
					}
				}
				if(friends[0] !== ""){
					for (var i in friends){
						console.log(friends[i]);
						$('#friends').append('<li>'+friends[i]+'</li>');
					}
				}
			}
		
		});

	</script>
</head>
<body>
	<h2><?php echo $user;?></h2>
	<p id='response' style="color:red"><?php echo $msg;?></p>
	<form action='chat.php' method='POST'>
		<input type='text' name='to_user'>
		<button type='submit'>chat</button>
	</form>
	<h3>Recent messages</h3>
	<ul id='friends'></ul>
</body>
</html>
