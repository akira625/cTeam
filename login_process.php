<?php
require_once './include/conf/const.php';
require_once './include/model/functions.php';

if (is_post() === false) {
   // POSTでなければログインページへリダイレクト
   redirect_to('login.php');
   exit;
}
// セッション開始
session_start();

$user_name = get_post('user_name');
$password = get_post('password'); // パスワード


// データベース接続
$link = get_db_connect();

$sql = "SELECT 
            user_id
        FROM
            users_table
        WHERE
            user_name = '{$user_name}' AND password = '{$password}'";
            var_dump($sql);
$user = get_as_row($link, $sql);

close_db_connect($link);

// メールアドレスとパスワードが一致していればuser_idを取得できる
if (isset($user['user_id']) === TRUE) {
    $_SESSION['user_id'] = $user['user_id'];
    if($user['user_id'] === '1'){
        redirect_to('admin_spot.php'); 
    }
    // redirect_to('top.php');
}

$_SESSION['login_error'] = 'ユーザー名あるいはパスワードが違います。';
redirect_to('login.php');

