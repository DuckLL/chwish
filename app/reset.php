<?php
require_once('./database.php');
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
if (isset($_POST['password'])) {
    if ($_POST['password'] !== $resetcode) {
        echo 'password error!';
    } else {
        $rs = $db->prepare("TRUNCATE TABLE user");
        $rs->execute();
        // kill all session
        $path = session_save_path();
        $files = glob($path . '/*'); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file))
                unlink($file); // delete file
        }
        header('Location: logout.php');
        exit;
    }
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
                    <H3 class="title">Reset</H3>
                    <div class="nes-field is-inline">
                        <label for="inline_field">Password</label>
                        <input type="text" id="inline_field" class="nes-input is-error" name="password" required>
                    </div>
                    <div class="shiftdown" style="">
                        <input type="submit" class="nes-btn is-error" style="float:right;" value="Reset">
                        <div style="clear:both"></div>
                    </div>
                </form>
            </main>
        </div>
    </div>
</body>

</html>