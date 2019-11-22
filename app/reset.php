<?
require_once('./database.php');
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}
if ($_GET['password'] != $resetcode) {
    echo 'password error!';
    exit;
}
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
