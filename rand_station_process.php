<?php
require_once '../api/include/conf/const.php';
require_once '../api/include/model/my_function.php';
require_once '../api/include/model/cteam_function.php';

$link = connect_db();

$stations_data = get_station_table($link);
$number_stations = count($stations_data);
$rand_number = mt_rand(1, $number_stations) - 1;
var_dump($stations_data);
var_dump($number_stations);
var_dump($rand_number);
var_dump($stations_data[$rand_number]);
var_dump($stations_data[$rand_number]['station_name']);
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