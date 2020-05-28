<!DOCTYPE html>
<html lang="ja">
<head>
   <meta charset="UTF-8">
   <title>ユーザ管理ページ</title> 
</head>
<link type = "text/css" rel = "stylesheet" href = "admin.css">
<body>
<?php if($message !== ''){?>
    <p><?php print h($message,ENT_QUOTES,'UTF-8'); ?></p>
<?php }?>
    <img class = "logo" src="./header-img/logo.png">
    <h1>管理ツール</h1>
    <a href="./logout.php">ログアウト</a>
    <a href="./admin_station.php">駅管理ページ</a>
    <a href="./admin_spot.php">スポット管理ページ</a>
    <div class = "add2">
        <h2>ユーザ情報一覧</h2>
    <table>
        <tr>
            <th>ユーザ名</th>
            <th>性別</th>
            <th>誕生日</th>
            <th>登録日</th>
            <th>操作</th>
        </tr>
        <?php foreach($datas as $data) {?>
        <tr>
            <td><?php print h($data['user_name']);?></td>
            <td><?php print h($data['gender']);?></td>
            <td><?php print h($data['birthdate']);?></td>
            <td><?php print h($data['created']);?></td>
            <td>
                <form method = "post">
                    <input type = "submit" name="delete" value="削除する">
                    <input type = "hidden" name = "user_id" value = <?php print h($data['user_id']);?>>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>