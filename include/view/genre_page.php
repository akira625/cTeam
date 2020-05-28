<?php
require_once '../conf/const.php';
require_once '../model/my_function.php';

session_start();
$link = connect_db();

if(isset($_SESSION['user_id']) === TRUE) {
    if($_SESSION['user_id'] === 'admin'){
        $user_name = 'admin';
    }else{
        $user_id = $_SESSION['user_id'];
        $user_name = get_user_name($link, $user_id);
    }
}else{
    $user_name = '';
}

$errors = receive_errors();

close_db($link);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../common.css">
    <link rel="stylesheet" href="../../genre_page.css">
    <title>ジャンルページ</title>
</head>
<body>
    <header>
        <div class = "header-box">
            <a href = "../../top_page.php">
                <img class = "logo" src="../../header-img/logo.png">
            </a>
            <?php if (isset($_SESSION['user_id']) === TRUE){?>
                <a class = "menu" href = "../../logout.php">ログアウト</a>
            <?php }?>
            <a href = "./login.php">
                <img class = "walk" src="../../header-img/walk.png">
            </a>
            <?php if (isset($_SESSION['user_id']) === TRUE){?>
                <p class = "menu">ユーザー名:<?php print h($user_name); ?></p>
            <?php }?>
            </a>
        </div>
    </header>
    <div class="genre-content">
        <div id="main">
            <div id="top">
                <div id="eat2" class="genre">
                    <form action="../../Genre_set_process.php" method="post">
                        <input  type="submit" value="食べる"  id="eat" class="button-eat" >
                        <input type="hidden" name="genre_id" value="1">
                    </form>
                </div>
                <div id="shopping2" class="genre">
                    <form action="../../Genre_set_process.php" method="post">
                        <input type="submit" value="買う" id="shopping" class="button-shopping">
                        <input type="hidden" name="genre_id" value="2">
                    </form>
                </div>
                <div id="play2" class="genre">
                    <form action="../../Genre_set_process.php" method="post">
                        <input type="submit" value="遊ぶ" id="play" class="button-play">
                        <input type="hidden" name="genre_id" value="3">
                    </form>
                </div>
            </div>
            <div id="bottom">
                <div id="mind2" class="genre">
                    <form action="../../Genre_set_process.php" method="post">
                        <input type="submit" value="癒し" id="mind" class="button-mind">
                        <input type="hidden" name="genre_id" value="4">
                    </form>
                </div>
                <div id="learn2" class="genre">
                    <form action="../../Genre_set_process.php" method="post">
                        <input type="submit" value="学ぶ・知る" id="learn" class="button-learn">
                        <input type="hidden" name="genre_id" value="5">
                    </form>
                </div>
                <div id="nothing2" class="genre">
                    <form action="../../Genre_set_process.php" method="post">
                        <input type="submit" value="ランダム" id="nothing" class="button-nothing">
                        <input type="hidden" name="genre_id" value="6">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>