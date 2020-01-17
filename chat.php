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
	if(!array_key_exists($_POST['to_user'], $dict)){
		$_SESSION['to_user_DNE'] = true;
		header('Location: homepage.php');
		return;
	}

	if(file_exists('friends/'.$_SESSION['username']))
		$friend = json_decode(file_get_contents('friends/'.$_SESSION['username']), true);
	else
		$friend = array();
	
	if(!in_array($_POST['to_user'], $friend, true)){
		array_push($friend, $_POST['to_user']);
		file_put_contents('friends/'.$_SESSION['username'], json_encode($friend));
	}
?>
<html>
<head>
	<title>CN Project</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<script>
		function press_enter(event){
			if (event.keyCode === 13) {
				event.preventDefault();
				$("#send").click();
			}
		}
		var sent = true;
		function send() {
			sent = false;
			$.post('send.php', { from_user: "<?php echo $_SESSION['username']?>", to_user: "<?php echo $_POST['to_user'];?>", message: $('#message').val()}, 
				function(response){
					sent = true;
				}
			);
			$('#message').val('');
		}

		var pos = 0;
		function get_msg(){
			if(sent === false)
				return;
			sent = false;
			$.post('server.php', { from_user: "<?php echo $_SESSION['username']?>", to_user: "<?php echo $_POST['to_user'];?>", pos: pos},
				function(response){
					sent = true;
					if(response === undefined || response === '')
						return;
					var json = JSON.parse(response);
					var lines = json.message.split("\n");
					for (var i = 0; i<lines.length - 1; i++){
						var user = lines[i].slice(0, lines[i].indexOf(' '));
						var msg = decodeURIComponent(lines[i].slice(lines[i].indexOf(' ')+1).replace(/[0-9a-f]{2}/g, '%$&'));
						//console.log(msg);
						$('#history').append('<li>'+user+': '+msg+'</li>');
					}
					pos = json.pos;
				}
			);
			
		}

		setInterval(get_msg, 1000);

		function upload(files){
			if(files === undefined)
				return;
			console.log(files);
			sent = false;
			for (var i = 0; i< files.length; i++){
				let form = new FormData();
				form.append('from_user', "<?php echo $_SESSION['username']?>");
				form.append('to_user', "<?php echo $_POST['to_user']?>");
				form.append('file', files[i]);

				$.ajax({
					url:'upload.php',
					type: 'POST',
					contentType: false,
					processData: false, 
					data: form,
					success: function(response){
						sent = true;
					},
					error: function(response){
						alert(response.responseText);
						sent = true;
					}
				});
			}
		}

	</script>
</head>

<body>
	<h2><?php echo 'Chat with '.$_POST['to_user']; ?></h2>
	<button onclick="window.location.assign('homepage.php')">back</button>
	<ul id='history'></ul>
	<input type='text' name='message' id='message' onkeyup="press_enter(event)">
	<button id='send' onclick="send()">send</button>
	<input type='file' id='uploader' onchange="upload(this.files)" multiple/>
</body>
</html>
