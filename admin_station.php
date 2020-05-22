<?php
require_once './include/conf/const.php';
require_once './include/model/functions.php';

session_start();
if(isset($_SESSION['user_id']) === TRUE) {
    $user_id = $_SESSION['user_id'];
}else{
    redirect_to('login.php');
    exit;
}

$message     = '';     
$errors     = [];     // エラーメッセージ

$filename = '';

$sql_kind = get_post('sql_kind');

if($sql_kind === 'insert'){
    
    //ポスト確認の時点で正規表現使って確認する！
    //preg_replace($正規表現パターン, $置換後の文字列, $置換対象)
    $station_name = get_post('station_name');
    
    $lat = get_post('lat');
    
    $lng = get_post('lng');
    
    $address = get_post('address');
    
    //
    //エラーチェック
    //
    
    if(get_post('submit')){
            if($station_name === ''){
            $errors[] = '駅名を入力してください。';
        }
        
        if($address === ''){
            $errors[] = '住所を選択してください。';
        }
        
        if($lat === ''){
            $errors[] = '緯度を入力してください';
        }else if(lat_check($lat) !== 1){
            $errors[] = '緯度に不正な値が入力されています。';
        }
    
        if($lng === ''){
            $errors[] = '経度を入力してください';
        }else if(lng_check($lng) !== 1){
            $errors[] = '経度に不正な値が入力されています。';
        }
    }
}

if($sql_kind === 'delete'){
    $delete = get_post('delete');
    $station_id = get_post('station_id');
    
    if($delete !== '' && $delete !== '削除する'){
        $errors[] = '不正な処理です。';
    }
}

// コネクション取得
$link= get_db_connect();
   
$stations = select_stations($link);

   //ポスト確認とエラーチェックはリクエストメソッドの前に終わらせておく！！！
if(is_post() === TRUE && count($errors) === 0){
        
    $log = timestamp();
        
    if($sql_kind === 'insert'){
        
        start_transaction($link);
        
        if(get_post('submit')){
            if(insert_stations($link, $station_name, $lat, $lng, $address) === TRUE){
                $message = 'スポットを追加しました。';
            }else{
                $errors[] = '追加失敗.station_table';
            }
        }
    }
    
    if($sql_kind === 'delete'){
        if(delete_station($link, $station_id) === TRUE){
            $message = 'データを削除しました。';
        }else{
            $errors[] = 'delete処理失敗';
        }
    }
    
    close_transaction($link, $errors);
}   

$stations = select_stations($link);;
// var_dump($errors);

close_db_connect($link);

include_once './include/view/admin_station.php';
// include_once '../include/view/goods_management.php';
