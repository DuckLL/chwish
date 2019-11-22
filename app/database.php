<?php
require_once('config.php');
session_start();
header("Content-type: text/html; charset=utf-8");
try {
	$db = new PDO($dsn, $user, $password);
	$db->exec("set names utf8");
} catch (PDOException $e) {
	die($e->getMessage());
}
