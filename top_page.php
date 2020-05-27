<?php
//トップページ
// コントローラ
require_once './include/conf/const.php';
require_once './include/model/my_function.php';
require_once './include/model/cteam_function.php';

$link = connect_db();

session_start();

if(isset($_SESSION['user_id']) === TRUE) {
    if($_SESSION['user_id'] === 'admin'){
        $user_name = 'admin';
    }else{
        $user_id = $_SESSION['user_id'];
        $user_name = get_user_name($link, $user_id);
    }
}else{
    $user_name = '';
}

$errors = receive_errors();

close_db($link);

include_once './include/view/top_page.php';