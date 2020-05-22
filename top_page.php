<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>トップページ</title>
    <style>
        
    </style>
</head>
<link type = "text/css" rel = "stylesheet" href = "common.css">
<body>
    <header>
        <div class = "header-box">
            <a href = "./top_page.php">
                <img class = "logo" src="./header-img/logo.png">
            </a>
            <a href = "./top_page.php">
                <img class = "walk" src="./header-img/walk.png">
            </a>
        </div>
    </header>
    <div class="start content">
        <form action="view_spot.php" method="post" class="start-box">
        <img class = "frame" src="./header-img/frame.png">
        <input type="submit" class="btn-square-so-pop" value="駅を決める">
        </form>
        <br>
        <a href="login.php" class="for-admin">管理者ページリンク</a>
    </div>
</body>
</html>