<?php
require_once './include/conf/const.php';
require_once './include/model/my_function.php';
require_once './include/model/cteam_function.php';

session_start();
$link = connect_db();

// $stations_data = get_station_table($link);
// $number_stations = count($stations_data);
// $rand_station_number = mt_rand(1, $number_stations) - 1;
// $station_id = $stations_data[$rand_station_number]['station_id'];

$tag_id = receive_session('tag_id');
// $tag_id = 2;
$genre_id = receive_session('genre_id');
// $genre_id = 5;
if ($tag_id = 6) {
    $tag_id = mt_rand(1, 5);
    $genre_id = mt_rand(1,5);
}
var_dump($tag_id);
var_dump($genre_id);


$spot_data = get_spot_table($link, $tag_id, $genre_id);
close_db($link);
$number_spots = count($spot_data);
$rand_spot_number = mt_rand(1, $number_spots) - 1;

include_once 'include/view/view_spot.php';

// $link = connect_db();

// $stations_data = get_station_table($link);
// $number_stations = count($stations_data);
// $rand_station_number = mt_rand(1, $number_stations) - 1;
// $station_id = $stations_data[$rand_station_number]['station_id'];

// $spot_data = get_spot_table($link, $station_id);
// close_db($link);
// $number_spots = count($spot_data);
// $rand_spot_number = mt_rand(1, $number_spots) - 1;