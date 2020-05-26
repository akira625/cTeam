<?php
//   require_once("./phpQuery-onefile.php");
//   $html = file_get_contents("https://ja.wikipedia.org/wiki/Category:%E6%9D%B1%E4%BA%AC%E9%83%BD%E3%81%AE%E5%95%86%E6%A5%AD%E6%96%BD%E8%A8%AD");
//   echo phpQuery::newDocument($html)->find("li")->text();
require_once("./simple_html_dom.php");
$url = "https://ja.wikipedia.org/wiki/Category:%E6%9D%B1%E4%BA%AC%E9%83%BD%E3%81%AE%E5%95%86%E6%A5%AD%E6%96%BD%E8%A8%AD";
// HTMLファイルを読み込みオブジェクト化します
$html = file_get_html($url);
 
// bodyタグを取得し、text部分を取り出します
for($i = 51; $i < 230; $i++) {
    print_r($html->find("li",$i)->plaintext);
}
