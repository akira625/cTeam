<?php
require_once './include/conf/const.php';
require_once './include/conf/cteam_const.php';
require_once './include/model/my_function.php';
require_once './include/model/cteam_function.php';

session_start();

//POSTでなければ戻す
if (get_request_method() !== 'POST') {
    $_SESSION['errors'][] = 'POST送信ではありません、ジャンルを選択してください。';
    redirect(C_TEAM_TOP_PAGE);
}


// 初期化
$genre_id = '';
// POST受け取り
$genre_id = receive_post('genre_id');
var_dump($genre_id);

// エラーチェック
if($genre_id === ''){
    $_SESSION['errors'][] = 'ジャンルを選んでください。';
    redirect(C_TEAM_TOP_PAGE);
}

$errors = receive_errors();
// エラーがなければセッションにIDを代入
if(count($errors) === 0){
    $_SESSION["genre_id"] = $genre_id;
    var_dump($_SESSION["genre_id"]);
}

redirect(C_TEAM_VIEW_SPOT);
