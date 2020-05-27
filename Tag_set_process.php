<?php
require_once './include/conf/const.php';
require_once './include/conf/cteam_const.php';
require_once './include/model/my_function.php';
require_once './include/model/cteam_function.php';

session_start();

//POSTでなければ戻す
if (get_request_method() !== 'POST') {
    $_SESSION['errors'][] = 'POST送信ではありません、タグを選択してください。';
    redirect(C_TEAM_TOP_PAGE);
}


// 初期化
$tag_id = '';
// POST受け取り
$tag_id = receive_post('tag_id');
var_dump($tag_id);

// エラーチェック
if($tag_id === ''){
    $_SESSION['errors'][] = 'タグを選んでください。';
    redirect(C_TEAM_TOP_PAGE);
}

$errors = receive_errors();
// エラーがなければセッションにIDを代入
if(count($errors) === 0){
    $_SESSION['tag_id'] = $tag_id;
}

redirect(C_TEAM_GENRE_PAGE);
