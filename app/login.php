<?php
if (isset($_POST['username'])) {
	require_once('database.php');
	$rs = $db->prepare("SELECT * FROM user");
	$rs->execute();
	while ($row = $rs->fetch()) {
		if (password_verify($_POST['username'], $row['username']) && password_verify($_POST['password'], $row['password'])) {
			$_SESSION['id'] = $row['id'];
			header('Location: index.php');
			exit;
		}
	}
	echo 'error';
}
?>

<html>

<head>
	<title>CHWISH: 願望交換平台</title>
	<link rel="icon" href="./img/close.svg" sizes="any" type="image/svg+xml">
	<link href="https://fonts.googleapis.com/css?family=Press+Start+2P" rel="stylesheet">
	<link href="./css/style.css" rel="stylesheet">
	<link href="https://unpkg.com/nes.css@2.2.1/css/nes.min.css" rel="stylesheet" />
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jsencrypt/2.3.1/jsencrypt.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/js-polyfills/0.1.42/polyfill.min.js"></script>
	<script src="./js/chwish.js"></script>
</head>

<body>
	<div id="nescss">
		<div class="container">
			<main class="main-content">
				<form method="post" class="nes-container with-title">
					<H3 class="title">Login</H3>
					<div class="nes-field is-inline">
						<label for="inline_field">Username</label>
						<input type="text" id="inline_field" class="nes-input is-success" name="username" required>
					</div>
					<div class="nes-field is-inline">
						<label for="inline_field">Password</label>
						<input type="password" id="inline_field" class="nes-input is-warning" name="password" required>
					</div>
					<div class="shiftdown" style="">
						<input type="submit" class="nes-btn is-success" style="float:right;" value="Login">
						<a href="register.php" class="nes-btn is-error" style="float:left;">Register</a>
						<div style="clear:both"></div>
					</div>
				</form>
			</main>
		</div>
	</div>
</body>

</html>