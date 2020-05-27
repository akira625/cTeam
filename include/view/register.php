<!DOCTYPE html>
<html lang="ja">
<head>
   <meta charset="UTF-8">
   <title>ユーザー登録</title> 
</head>
<link type = "text/css" rel = "stylesheet" href = "common.css">
<body>
    <header>
        <div class = "header-box">
            <a href = "./top.php">
                <img class = "logo" src="./header-img/logo.png">
            </a>
            <a href = "./cart.php" class = "cart"></a>
        </div>
    </header>
    <div class = "content">
        <div class = "register">
            <?php if($message !== ''){?>
                <p class= "success-msg"><?php print h($message);?></p>
            <?php }?>
            <?php if(count($errors) !== 0){?>
                <?php foreach($errors as $error){?>
                    <li class="err-msg"><?php print h($error);?></li>
                <?php }?>
            <?php }?>
            <form action = "./register.php" method = "post">
                <div>
                    <input type="text" name="new_user" placeholder="ユーザー名">
                </div>
                <div>
                    <input type="password" name="new_pass" placeholder="パスワード">
                </div>
                <input type = "submit" value = "ユーザーを新規作成する">
                <div class = "login-link">
                    <a href="./login.php">ログインページへ移動する</a>
                </div>
            </form> 
        </div>
    </div>
</body>
</html>