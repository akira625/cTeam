<?php
require_once './include/conf/const.php';
require_once './include/model/my_function.php';
require_once './include/model/cteam_function.php';

$link = connect_db();

$tag_id = receive_post('tag_id');
// var_dump($tag_id);
$spot_data = get_spot_table($link, $tag_id);
close_db($link);
$number_spots = count($spot_data);
$rand_spot_number = mt_rand(1, $number_spots) - 1;
// var_dump($spot_data[$rand_spot_number]);

$spot_data_json = json_encode($spot_data[$rand_spot_number], JSON_UNESCAPED_UNICODE | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
// var_dump($spot_data_json);

print $spot_data_json;