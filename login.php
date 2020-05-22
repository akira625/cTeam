<?php
require_once './conf/const.php';
require_once './model/functions.php';

session_start();

if (isset($_SESSION['user_id']) === TRUE) {
    if($_SESSION['user_id'] === '1'){
        redirect_to('./admin_spot.php');
    }
    exit;
}

$errors = [];
if (isset($_SESSION['login_error']) === TRUE) {
    $errors[] = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}

include_once './view/login.php';
