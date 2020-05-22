<?php

define('TAX', 1.05);  // 消費税

define('DB_HOST',   'localhost'); // データベースのホスト名又はIPアドレス
<<<<<<< HEAD
define('DB_USER',   'codecamp34625');  // MySQLのユーザ名
define('DB_PASSWORD', 'codecamp34625');    // MySQLのパスワード
define('DB_NAME',   'codecamp34625');    // データベース名
=======
define('DB_USER',   'codecamp34612');  // MySQLのユーザ名
define('DB_PASSWORD', 'codecamp34612');    // MySQLのパスワード
define('DB_NAME',   'codecamp34612');    // データベース名
>>>>>>> 0bcb6b16fa7f65134147a283ccd0d376ae9884bd

define('HTML_CHARACTER_SET', 'UTF-8');  // HTML文字エンコーディング
define('DB_CHARACTER_SET',   'UTF8');   // DB文字エンコーディング

define('API_KEY', getenv('API_KEY')) ;