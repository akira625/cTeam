<?php
require_once './include/conf/const.php';
require_once './include/model/my_function.php';
require_once './include/model/cteam_function.php';

$link = connect_db();
$station_id = 4;

$spot_data = get_spot_table($link, $station_id);

$spot_data_json = json_encode($spot_data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);

echo $spot_data_json;
var_dump($spot_data_json);
close_db($link);