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
            <?php if (isset($_SESSION['user_id']) === TRUE){?>
                <a class = "menu" href = "./logout.php">ログアウト</a>
            <?php }?>
            <a href = "../cTeam/login.php">

                <img class = "walk" src="../cTeam/header-img/walk.png">
            </a>
            <?php if (isset($_SESSION['user_id']) === TRUE){?>
                <p class = "menu">ユーザー名:<?php print h($user_name); ?></p>
            <?php }?>
            </a>
        </div>
    </header>
    <?php foreach ($errors as $error){ ?>
        <p><?php print h($error); ?></p>
    <?php } ?>
    <div class="start content">
        <div class="start-box">
            <div class='btn_box'>
                
                    <div class="btn_position1">
                        <div class="btn-square-soft-purple">
                            <form action="../cTeam/Tag_set_process.php" method="post">
                                <input type="submit" class="btn btn5" value="なつかしい">
                                <input type="hidden" name="tag_id" value="5">
                            </form>
                        </div>
                    </div>
                    <div class="btn_position2">
                        <div class="btn-square-soft-red">
                            <form action="../cTeam/Tag_set_process.php" method="post">
                                <input type="submit" class="btn btn2" value="おいしい">
                                <input type="hidden" name="tag_id" value="2">
                            </form>
                        </div>
                        <div class="btn-circle">
                            <form action="../cTeam/Tag_set_process.php" method="post">
                                <input type="submit" class="btn btn6" value="ウェエエエエエエエエイ">
                                <input type="hidden" name="tag_id" value="6">
                            </form>
                        </div>
                        <div class="btn-square-soft-orange">
                            <form action="../cTeam/Tag_set_process.php" method="post">
                                <input type="submit" class="btn btn3" value="たのしい">
                                <input type="hidden" name="tag_id" value="3">
                            </form>
                        </div>
                    </div>
                    <div class="btn_position3">
                        
                        <div class="btn-square-soft-pink">
                            <form action="../cTeam/Tag_set_process.php" method="post">
                                <input type="submit" class="btn btn1" value="かわいい">
                                <input type="hidden" name="tag_id" value="1">
                            </form>
                        </div>
                        <div class="btn-square-soft-blue">
                            <form action="../cTeam/Tag_set_process.php" method="post">
                                <input type="submit" class="btn btn4" value="きれい">
                                <input type="hidden" name="tag_id" value="4">
                            </form>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <a href="../cTeam/login.php" class="for-admin">スポット追加はこちら</a>
</body>
</html>