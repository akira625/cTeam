<?php

require_once './include/conf/const.php';
require_once './include/model/my_function.php';
require_once './include/model/cteam_function.php';

$link = connect_db();

$spot_id = receive_post('spot_id');
$spot_id = 25;
// var_dump($spot_id);
$station_tag_genre_name = get_station_tag_genre_name($link, $spot_id);
// var_dump($station_tag_genre_name);
close_db($link);

$station_tag_genre_name_json = json_encode($station_tag_genre_name[0], JSON_UNESCAPED_UNICODE | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
// var_dump($station_name_json);

print $station_tag_genre_name_json;