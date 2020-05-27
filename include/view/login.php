<!DOCTYPE html>
<html lang="ja">
<head>
   <meta charset="UTF-8">
   <title>ログインページ</title> 
</head>
<link type = "text/css" rel = "stylesheet" href = "common.css">
<body>
    <header>
        <div class = "header-box">
            <a href = "./top_page.php">
                <img class = "logo" src="./header-img/logo.png">
            </a>
            <a href = "./login.php">
                <img class = "walk" src="./header-img/walk.png">
            </a>
        </div>
    </header>
    <div class = "content">
        <div class = "login">
        <p>スポット追加にはログインが必要です。</p>
            <form action = "login_process.php" method = "post">
            <div>
                <input type="text" name="user_name" placeholder="ユーザー名">
            </div>
            <div>
                <input type="password" name="password" placeholder="パスワード">
            </div>
            <input type = "submit" value = "ログイン">
            <?php if(count($errors) !== 0){?>
                <?php foreach($errors as $error){?>
                    <li class="errors"><?php print h($error);?></li>
                <?php }?>
            <?php }?>
            <div class = "account-create">
                <a href="./register.php">ユーザーの新規作成</a>
            </div>
        </form> 
        </div>
    </div>
</body>
</html>