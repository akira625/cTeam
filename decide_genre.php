<?php
require_once './include/conf/const.php';
require_once './include/model/my_function.php';
require_once './include/model/cteam_function.php';

$errors=[];
$link = connect_db();
session_start();

if(isset($_POST["genre"]) === TRUE){

        $genre = trim($_POST["genre"]);
        $_SESSION["genre"] = $genre;
        header('Location: rand_station_process.php');
        exit;
}

include_once '';