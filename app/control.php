<?
require_once('./database.php');
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
if (isset($_POST['pubkey'])) {
    // check if enckey is alloc
    $rs = $db->prepare("SELECT enckey FROM user");
    $rs->execute();
    $all_done = true;
    while ($row = $rs->fetch()) {
        if ($row[0] === "") {
            $all_done = false;
            break;
        }
    }
    if ($all_done) {
        http_response_code(403);
        echo 'enckey is allocated';
        exit;
    }
    // update key
    $sql = "UPDATE user SET pubkey=:pubkey WHERE username=:username";
    $rs = $db->prepare($sql);
    $rs->bindValue(':pubkey', htmlspecialchars($_POST['pubkey'], ENT_QUOTES, 'UTF-8'), PDO::PARAM_STR);
    $rs->bindValue(':username', intval($_SESSION['username']), PDO::PARAM_INT);
    $rs->execute();
    echo 'ok';
    // check all key is upload
    $rs = $db->prepare("SELECT pubkey FROM user");
    $rs->execute();
    $all_done = true;
    $member_count = 0;
    $all_key = array();
    while ($row = $rs->fetch()) {
        $member_count += 1;
        if ($row[0] === "") {
            $all_done = false;
            break;
        }
        array_push($all_key, $row[0]);
    }
    if ($all_done) {
        $member = range(0, $member_count - 1);
        $chain_len = 1;
        while ($chain_len !== $member_count) {
            shuffle($member);
            $chain_len = 1;
            $now = $member[0];
            while ($now) {
                $now = $member[$now];
                $chain_len += 1;
            }
        }
        // lock db to ignore racecondition!
        $db->beginTransaction();
        for ($i = 0; $i < $member_count; $i++) {
            $sql = "UPDATE user SET enckey=:enckey WHERE username=:username";
            $rs = $db->prepare($sql);
            $rs->bindValue(':enckey', $all_key[$i], PDO::PARAM_STR);
            $rs->bindValue(':username', $member[$i] + 1, PDO::PARAM_INT);
            $rs->execute();
        }
        $db->commit();
    }
    exit;
}
if (isset($_POST['encwish'])) {
    $sql = "UPDATE user SET encwish=:encwish WHERE username=:username";
    $rs = $db->prepare($sql);
    $rs->bindValue(':encwish', htmlspecialchars($_POST['encwish'], ENT_QUOTES, 'UTF-8'), PDO::PARAM_STR);
    $rs->bindValue(':username', intval($_SESSION['username']), PDO::PARAM_INT);
    $rs->execute();
    echo 'ok';
    exit;
}
if (isset($_POST['confirm'])) {
    $sql = "UPDATE user SET confirm=:confirm WHERE username=:username";
    $rs = $db->prepare($sql);
    $rs->bindValue(':confirm', intval($_POST['confirm']), PDO::PARAM_INT);
    $rs->bindValue(':username', intval($_SESSION['username']), PDO::PARAM_INT);
    $rs->execute();
    echo 'ok';
    exit;
}
