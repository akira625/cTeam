<?php
  require_once("./phpQuery-onefile.php");
  $html = file_get_contents("https://www.google.co.jp/search?q=あいう&btnI=ec");
  echo phpQuery::newDocument($html)->find("h1")->text();
?>