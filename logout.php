<?php
require_once './include/conf/const.php';
require_once './include/model/functions.php';

session_start();
// セッション変数を全て削除
$_SESSION = [];
$session_name = session_name();

// ユーザのCookieに保存されているセッションIDを削除
if (isset($_COOKIE[$session_name]) === true) {
  setcookie($session_name, '', time() - 3600);
}
session_destroy();
redirect_to('top_page.php');