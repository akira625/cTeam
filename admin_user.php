<?php

$message = '';
$errors = [];

require_once './conf/const.php';
require_once './model/functions.php';

session_start();
if(isset($_SESSION['user_id']) === TRUE) {
    $user_id = $_SESSION['user_id'];
}else{
    redirect_to('login.php');
    exit;
}

// コネクション取得
$link= get_db_connect();

$datas = select_user($link);

if(is_post() === TRUE && count($errors) === 0){
    
    if(delete_user($link, $user_id) === TRUE){
        $message = 'データを削除しました。';
    }else{
        $errors[] = 'delete処理失敗';
    }
    
}   
    
close_db_connect($link);
// var_dump($errors);

include_once './view/admin_user.php';
