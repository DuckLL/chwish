<?
require_once('./database.php');
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}
$rs = $db->prepare("SELECT * FROM user");
$rs->execute();
$member_count = 0;
$key_count = 0;
$msg_count = 0;
$confirm_count = 0;
$all_msg = array();
while ($row = $rs->fetch()) {
    $member_count += 1;
    if ($row['pubkey'] != "") {
        $key_count += 1;
    }
    if ($row['encwish'] != "") {
        $msg_count += 1;
    }
    if ($row['confirm']) {
        $confirm_count += 1;
    }
    if ($row['id'] == $_SESSION['id']) {
        $pubkey = $row['pubkey'];
        $enckey = $row['enckey'];
    }
    array_push($all_msg, $row['encwish']);
}
shuffle($all_msg);
$progress = 1;
if ($member_count == $key_count) {
    $progress += 1;
}
if ($member_count == $msg_count) {
    $progress += 1;
}
if ($member_count == $confirm_count) {
    $progress += 1;
}
?>
<html>

<head>
    <title>CHWISH: 願望交換系統</title>
    <link rel="icon" href="./img/close.svg" sizes="any" type="image/svg+xml">
    <link href="https://fonts.googleapis.com/css?family=Press+Start+2P" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
    <link href="https://unpkg.com/nes.css@2.2.1/css/nes.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsencrypt/2.3.1/jsencrypt.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
    <script src="./js/chwish.js"></script>
</head>

<body>
    <div id="nescss">
        <header class="">
            <div class="container">
                <div class="nav-brand">
                    <h1 style="width:400px;"><i class="logo treasure"></i>
                        <a href="index.php" style="display: inline-block; color:black;">CHWISH</a>
                    </h1>
                    <p id="description">Public Key Wish Exchange Platform</p>
                </div>
                <div style="padding-bottom:10px;width:40%;">
                    <?php echo '👤' . strval($member_count) . ' 🔑' . strval($key_count) . ' 🎁', strval($msg_count) . ' 👌' . strval($confirm_count) ?>
                    <a href="logout.php" class="nes-btn is-error">Logout</a>
                </div>
            </div>
        </header>
        <div class="container">
            <main class="main-content">
                <section class="nes-container with-title showcase">
                    <H3 class="title">Gift Rule</H3>
                    <div class="lists">
                        <ul class="nes-list is-circle">
                            <li>均價XXX，上限XXX</li>
                            <li>根據期望優先順序寫三個物品</li>
                        </ul>
                    </div>
                </section>
                <section class="nes-container with-title showcase">
                    <H3 class="title">Game Rule</H3>
                    <div class="lists">
                        <ul class="nes-list is-circle">
                            <li>第一階段：生成keypair，保存好prikey，送出pubkey</li>
                            <li>第二階段：獲得enckey，加密你的願望送出</li>
                            <li>第三階段：用prikey找出屬於你的任務</li>
                            <li>第四階段：確認你的任務沒有問題</li>
                        </ul>
                    </div>
                </section>
                <section class="nes-container with-title showcase">
                    <H3 class="title">Now Stage: <?php echo $progress; ?></H3>
                    <progress class="nes-progress is-primary" value="<?php echo $progress; ?>" max="4"></progress>
                </section>
                <section class="nes-container with-title showcase">
                    <H3 class="title">1st Stage</H3>
                    <label for="textarea_field">Public Key</label>
                    <textarea name="pubkey" id="pubkey" class="nes-textarea" rows="5" disabled><?php echo $pubkey; ?></textarea>
                    <label for="textarea_field">Private Key</label>
                    <textarea id="privkey" class="nes-textarea" rows="5"></textarea>
                    <div class="shiftdown">
                        <button id="generate" class="nes-btn is-error">Generate Key</button>
                        <button id="copyprikey" class="nes-btn is-warning">Copy Private Key</button>
                        <button id="submitpubkey" class="nes-btn is-success">Submit Public Key</button>
                    </div>
                </section>
                <section class="nes-container with-title showcase">
                    <H3 class="title">2nd Stage</H3>
                    <label for="textarea_field">Encrypt Key</label>
                    <textarea id="enckey" class="nes-textarea" rows="5" disabled><?php echo $enckey; ?></textarea>
                    <label for="textarea_field">Your Wish</label>
                    <textarea id="wish" class="nes-textarea" rows="5" maxlength="80">1.
2.
3.</textarea>
                    <div class="shiftdown">
                        <button id="encrypt" class="nes-btn is-primary">Encrypt</button>
                    </div>
                    <label for="textarea_field">Encrypted Wish</label>
                    <textarea id="encwish" class="nes-textarea" rows="5" disabled></textarea>
                    <div class="shiftdown">
                        <button id="submitwish" class="nes-btn is-success">Submit</button>
                    </div>
                </section>
                <section class="nes-container with-title showcase">
                    <H3 class="title">3rd Stage</H3>
                    <label for="textarea_field">Decrypt Key</label>
                    <textarea id="deckey" class="nes-textarea" rows="5"></textarea>
                    <label for="textarea_field">Try Message</label>
                    <textarea id="msg" class="nes-textarea" rows="5" disabled></textarea>
                    <div class="shiftdown">
                        <?php
                        if ($member_count == $msg_count) {
                            foreach ($all_msg as $msg) {
                                echo '<i value="' . $msg . '" class="nes-icon is-large treasure"></i>';
                            }
                        }
                        ?>
                    </div>
                    <div class="shiftdown">
                        <button id="decrypt" class="nes-btn is-primary">Decrypt</button>
                    </div>
                    <label for="textarea_field">Decrypted Wish</label>
                    <textarea id="decwish" class="nes-textarea" rows="5"></textarea>
                    <div class="shiftdown">
                        <button id="comfirmwish" class="nes-btn is-success">Comfirm Wish</button>
                    </div>
                </section>
            </main>
            <footer>
                <p><span>©2019</span> <a href="https://duckll.tw/" target="_blank" rel="noopener">DuckLL</a></p>
                <div>Icons made by <a href="https://www.flaticon.com/authors/smashicons" title="Smashicons">Smashicons</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div>
            </footer>
        </div>
    </div>
</body>

</html>