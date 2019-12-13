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
	}
?>
<html>
<head>
	<title>CN Project</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<script>
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
						console.log(msg);
						$('#history').append('<li>'+user+': '+msg+'</li>');
					}
					pos = json.pos;
				}
			);
			
		}

		setInterval(get_msg, 1000);

		function upload(file){
			if(file === undefined)
				return;
			sent = false;
			let form = new FormData();
			form.append('from_user', "<?php echo $_SESSION['username']?>");
			form.append('to_user', "<?php echo $_POST['to_user']?>");
			form.append('file', file);

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
					alert(response);
				}
			});
			
		}

	</script>
</head>

<body>
	<button onclick="window.location.assign('homepage.php')">back</button>
	<ul id='history'></ul>
	<input type='text' name='message' id='message'>
	<button onclick="send()">send</button>
	<input type='file' id='uploader' onchange="upload(this.files[0])"/>
</body>
</html>
