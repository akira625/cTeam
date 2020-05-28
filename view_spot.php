<?php
require_once './include/conf/const.php';
require_once './include/model/my_function.php';
require_once './include/model/cteam_function.php';

session_start();
$link = connect_db();

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


$tag_id = receive_session('tag_id');
// $tag_id = 2;
$genre_id = receive_session('genre_id');
// var_dump($tag_id);
// var_dump($genre_id);
// $genre_id = 5;
$random_flag = 0;
if ($tag_id === '6') {
    // var_dump($tag_id);
    $tag_id = mt_rand(1, 5);
    $genre_id = mt_rand(1,5);
    $random_flag = 1;
}
// var_dump($tag_id);
// var_dump($genre_id);
// var_dump($random_flag);

$spot_data = get_spot_table($link, $tag_id, $genre_id);
$number_spots = count($spot_data);
$rand_spot_number = mt_rand(1, $number_spots) - 1;

$station_id = $spot_data[$rand_spot_number]['station_id'];
$station_info = get_station_table($link, $station_id);
$station_name = $station_info[0]['station_name'];
// var_dump($station_name);

$tag_name_arrry = get_tag_name_by_ti($link, $tag_id);
$tag_name = $tag_name_arrry[0]['tag_name'];
// var_dump($tag_name);
$genre_name_array =get_genre_name_by_gi($link, $genre_id);
$genre_name = $genre_name_array[0]['genre_name'];
// var_dump($genre_name);
close_db($link);

include_once 'include/view/view_spot.php';
