<?php
// トップページ
// ビュー
require_once '../cTeam/include/conf/const.php';
require_once '../cTeam/include/model/cteam_function.php';
require_once '../cTeam/include/model/my_function.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../cTeam/common.css">
    <title>トップページ</title>
</head>
<body>
    <header>
        <div class = "header-box">
            <a href = "./top_page.php">
                <img class = "logo" src="../cTeam/header-img/logo.png">
            </a>
            <a href = "./top_page.php">
                <img class = "walk" src="../cTeam/header-img/walk.png">
            </a>
        </div>
    </header>
    <?php foreach ($errors as $error){ ?>
        <p><?php print h($error); ?></p>
    <?php } ?>
    <div class="start content">
        <div class="start-box">
            <div class='btn_box'>
                <form action="../cTeam/Tag_set_process.php" method="post">
                    <div class="btn_position1">
                        <input type="submit" class="btn-square-soft-pink" value="かわいい">
                    </div>
                    <div class="btn_position2">
                        <input type="submit" class="btn-square-soft-red" value="おいしい">
                        <input type="submit" class="btn-circle" value="らんだむ">
                        <input type="submit" class="btn-square-soft-orange" value="たのしい">
                    </div>
                    <div class="btn_position3">
                        <input type="submit" class="btn-square-soft-purple" value="なつかしい">
                        <input type="submit" class="btn-square-soft-blue" value="きれい">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <a href="../cTeam/login.php" class="for-admin">管理者ページリンク</a>
</body>
</html>