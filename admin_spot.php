<?php
//DELETE FROM ec_goods_table; ALTER TABLE ec_goods_table AUTO_INCREMENT=1;

require_once './conf/const.php';
require_once './model/functions.php';

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
    $spot_name = get_post('spot_name');
    
    $near_station = get_post('near_station');
    $station_id = $near_station;
    
    $lat = get_post('lat');
    
    $lng = get_post('lng');
    
    $address = get_post('address');
    
    $comment = get_post('comment');
    
    $status = get_post('status');
    
    //
    //エラーチェック
    //
    
    if(get_post('submit')){
            if($spot_name === ''){
            $errors[] = 'スポット名を入力してください。';
        }
    
        if($station_id === ''){
            $errors[] = '最寄り駅を選択してください。';
        }
        
        if($comment === ''){
            $errors[] = 'コメントを選択してください。';
        }
        
        if($address === ''){
            $errors[] = '住所を選択してください。';
        }
        
        if($status === ''){
            $errors[] = 'ステータスを入力してください。';
        }else if($status !== '1' && $status !== '0'){
            $errors[] = '不正な処理です。';
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
    
    
    
        if (is_uploaded('image') === TRUE) {
            $extension = get_file_type('image');
            if($extension === 'error'){
              $errors[] = '画像ファイルはjpegもしくはpngファイルにしてください。';
            }
          
            // エラーがなければアップロード処理
            if(count($errors) === 0){
                $filename = make_filename($extension);
                if (move_uploaded('image', $filename) !== TRUE) {
                  $errors[] = 'ファイルアップロードに失敗しました';
                }
            }
    
        } else {
          $errors[] = 'ファイルを選択してください';
        }
    }
}
if($sql_kind === 'update_comment'){
    
    $update_comment = get_post('update_comment');
    
    $spot_id = get_post('spot_id');
    
    if(is_blank($update_comment) === TRUE){
        $errors[] = 'コメントを入力してください';
    }
}

if($sql_kind === 'update_status'){
    $status = get_post('status');
    $spot_id = get_post('spot_id');

    if(is_blank($status) === TRUE){
        $errors[] = 'ステータスを入力してください。';
    }else if($status !== '1' && $status !== '0'){
        $errors[] = '不正な処理です。';
    }
}

if($sql_kind === 'delete'){
    $delete = get_post('delete');
    $spot_id = get_post('spot_id');
    
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
            if(insert_spots($link, $spot_name, $station_id, $lat, $lng, $address,$comment,$status,$filename) === TRUE){
                $message = 'スポットを追加しました。';
            }else{
                $errors[] = '追加失敗.spot_table';
            }
        }
    }
    
    if($sql_kind === 'update_comment'){
        if(update_comment($link, $spot_id,$update_comment) === TRUE){
            $message = 'コメントを変更しました。';
        }else{
            $errors[] = 'UPDATE処理失敗'.$sql;
        }
    }
    
    if($sql_kind === 'update_status'){
        if(update_status($link, $spot_id,$status) === TRUE){
         $message = 'ステータスを変更しました。';
        }else{
            $errors[] = 'UPDATE処理失敗';
        }
    }
    
    if($sql_kind === 'delete'){
        if(delete_spot($link, $spot_id) === TRUE){
            $message = 'データを削除しました。';
        }else{
            $errors[] = 'delete処理失敗';
        }
    }
    
    close_transaction($link, $errors);
}   

$spots = select_spots($link);;
// var_dump($errors);

close_db_connect($link);

include_once './view/admin_spot.php';
// include_once '../include/view/goods_management.php';
