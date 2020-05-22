<?php
require_once './include/conf/const.php';
require_once './include/model/my_function.php';
require_once './include/model/cteam_function.php';

$link = connect_db();

$stations_data = get_station_table($link);
$number_stations = count($stations_data);
$rand_station_number = mt_rand(1, $number_stations) - 1;

var_dump($stations_data[$rand_station_number]);
var_dump($stations_data[$rand_station_number]['station_name']);
$station_id = $stations_data[$rand_station_number]['station_id'];
$spot_data = get_spot_table($link, $station_id);
$number_spots = count($spot_data);
$rand_spot_number = mt_rand(1, $number_spots) - 1;

var_dump($spot_data);
var_dump($number_spots);
var_dump($rand_spot_number);
var_dump($spot_data[$rand_spot_number]['lat']);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table>
        <tr>
            <th>駅ID</th>
            <th>駅名</th>
            <th>緯度</th>
            <th>経度</th>
            <th>住所</th>
            <th>テスト</th>
        </tr>
    <?php foreach($stations_data as $station){ ?>
        <tr>
            <td><?php print h($station['station_id']); ?></td>
            <td><?php print h($station['station_name']); ?></td>
            <td><?php print h($station['lat']); ?></td>
            <td><?php print h($station['lng']); ?></td>
            <td><?php print h($station['address']); ?></td>
            <td><?php var_dump($station); ?></td>
        </tr>
    <?php } ?>
    </table>
    
    
</body>
</html>