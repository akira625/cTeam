<?php
//トップページ
// コントローラ
require_once './include/conf/const.php';
require_once './include/model/my_function.php';
require_once './include/model/cteam_function.php';

session_start();
$errors = receive_errors();

include_once './include/view/top_page.php';