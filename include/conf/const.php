<?php

define('TAX', 1.05);  // 消費税

define('DB_HOST',   'localhost'); // データベースのホスト名又はIPアドレス
define('DB_USER',   'codecamp34613');  // MySQLのユーザ名
define('DB_PASSWORD', 'codecamp34613');    // MySQLのパスワード
define('DB_NAME',   'codecamp34613');    // データベース名


define('HTML_CHARACTER_SET', 'UTF-8');  // HTML文字エンコーディング
define('DB_CHARACTER_SET',   'UTF8');   // DB文字エンコーディング

define('API_KEY', getenv('API_KEY')) ;