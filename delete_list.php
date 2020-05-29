<?php
require_once './include/conf/const.php';
require_once './include/conf/cteam_const.php';
require_once './include/model/my_function.php';
require_once './include/model/cteam_function.php';

session_start();

unset($_SESSION['selected_spot']);

redirect('view_list.php');