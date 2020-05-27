<?php
require_once './include/conf/const.php';
require_once './include/model/functions.php';


$new_user = '';
$new_pass = '';
$message = '';
$errors = [];

if(is_post() === TRUE){
    $new_user = get_post_data('new_user');
    $new_pass = get_post_data('new_pass');
    if(is_valid_str($new_user, 6) !== TRUE){
        $errors[] = 'ユーザー名は半角英数字6文字以上で入力してください。';
    }
    
    if(is_valid_str($new_pass, 6) !== TRUE){
        $errors[] = 'パスワードは半角英数字6文字以上で入力してください。';
    }
}


// コネクション取得
$link= get_db_connect();
   
$user = get_user_id($link, $new_user);

if(isset($user['user_id']) === TRUE && $user['user_id'] !== '1'){
    $errors[] = 'そのユーザー名は既に使われています。';
}

if(is_post() === TRUE && count($errors) === 0){
    if(insert_register($link, $new_user, $new_pass) === TRUE){
        $message = "アカウント作成を完了しました。" ;
    }else{
        $errors[] = 'INSERT処理失敗'.$sql;
    }
}

close_db_connect($link);
// var_dump($errors);

include_once './include/view/register.php';