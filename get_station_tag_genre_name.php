<?php

require_once './include/conf/const.php';
require_once './include/model/my_function.php';
require_once './include/model/cteam_function.php';

$link = connect_db();

$station_id = receive_post('station_id');

$station_info = get_station_table($link, $station_id);
// var_dump($station_info);
$station_name = $station_info[0]['station_name'];
close_db($link);

$station_name_json = json_encode($station_name, JSON_UNESCAPED_UNICODE | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
// var_dump($station_name_json);

print $station_name_json;