<?php
require_once '../api/include/conf/const.php';
require_once '../api/include/model/my_function.php';
require_once '../api/include/model/cteam_function.php';

$link = connect_db();

$stations_data = get_station_table($link);


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
    
    <tr>
        <th>駅ID</th>
        <th>駅名</th>
        <th>緯度</th>
        <th>経度</th>
        <th>住所</th>
    </tr>
    <?php foreach($stations_data as $station){ ?>
    <tr>
        <td><?php print h($station['station_id']); ?></td>
        <td><?php print h($station['station_name']); ?></td>
        <td><?php print h($station['lat']); ?></td>
        <td><?php print h($station['lng']); ?></td>
        <td><?php print h($station['address']); ?></td>
    </tr>
    <?php } ?>
    
</body>
</html>