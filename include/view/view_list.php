<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>リスト表示</title>
    <style>
        .pic_size {
            width: 300px;
            height: 300px;
        }
    </style>
</head>
<body>
    <form action="delete_list.php" method="post">
        <button id="delete_list" class="btn-flat-logo1">履歴を消す</button>
    </form>
    
    <table>
        <tr>
            <th>写真</th>
            <th>スポット名</th>
            <th>最寄駅</th>
            <th>コメント</th>
        </tr>
    <?php foreach($spot_data as $spot){ ?>
        <tr>
            <td>
                <img class="pic_size" src="<?php print h('./spot_picture/'.$spot['image']); ?>">
            </td>
            <td><?php print h($spot['spot_name']); ?></td>
            <td><?php print h($spot['station_name']); ?></td>
            <td><?php print h($spot['comment']); ?></td>
        </tr>
    <?php } ?>
    </table>
</body>
</html>