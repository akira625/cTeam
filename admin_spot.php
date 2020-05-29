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
$change_station = '';

$sql_kind = get_post('sql_kind');

if($sql_kind === 'insert'){
    
    //ポスト確認の時点で正規表現使って確認する！
    //preg_replace($正規表現パターン, $置換後の文字列, $置換対象)
    $spot_name = get_post('spot_name');
    
    $near_station = get_post('near_station');
    $station_id = $near_station;
    
    $lat = get_post('lat');
    
    $lng = get_post('lng');
    
    $postal_code = get_post('postal_code');
    
    $prefecture = get_post('prefecture');
    
    $city = get_post('city');
    
    $detail_address = get_post('detail_address');
    
    $comment = get_post('comment');
    
    $status = get_post('status');

    $tags = get_post('tags');
    
    $genre = get_post('genre');

    //
    //エラーチェック
    //
    
    if($spot_name === ''){
        $errors[] = 'スポット名を入力してください。';
    }

    if($station_id === ''){
        $errors[] = '最寄り駅を選択してください。';
    }
    
    if($comment === ''){
        $errors[] = 'コメントを入力してください。';
    }
    
    if($postal_code === ''){
        $errors[] = '郵便番号を入力してください。';
    }
    
    if($prefecture === ''){
        $errors[] = '都道府県を入力してください。';
    }
    
    if($city === ''){
        $errors[] = '市区町村を入力してください。';
    }
    
    if($detail_address === ''){
        $errors[] = '番地以下を入力してください。';
    }
    
    if($tags === []){
        $errors[] = 'タグを選択してください。';
    }
    
    if($genre === ''){
        $errors[] = 'ジャンルを選択してください。';
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

if($sql_kind === 'update_comment'){
    
    $update_comment = get_post('update_comment');
    $change_station = get_post('change_station');
    $spot_id = get_post('spot_id');
    
    if(is_blank($update_comment) === TRUE){
        $errors[] = 'コメントを入力してください';
    }
}

if($sql_kind === 'update_tags'){
    $update_tags = get_post('update_tags');
    $change_station = get_post('change_station');
    $spot_id = get_post('spot_id');
    
    if($update_tags === []){
        $errors[] = 'タグを選択してください。';
    }

}

if($sql_kind === 'update_genre'){
    $update_genre = get_post('update_genre');
    $change_station = get_post('change_station');
    $spot_id = get_post('spot_id');
    
        
    if($update_genre === ''){
        $errors[] = 'ジャンルを選択してください。';
    }
}

if($sql_kind === 'update_status'){
    $status = get_post('status');
    $change_station = get_post('change_station');
    $spot_id = get_post('spot_id');

    if(is_blank($status) === TRUE){
        $errors[] = 'ステータスを入力してください。';
    }else if($status !== '1' && $status !== '0'){
        $errors[] = '不正な処理です。';
    }
}

if($sql_kind === 'delete'){
    $delete = get_post('delete');
    $change_station = get_post('change_station');
    $spot_id = get_post('spot_id');
    
    if(is_blank($delete) !== TRUE && $delete !== '削除'){
        $errors[] = '不正な処理です。';
    }
}

if($sql_kind === 'change_station'){
    $change_station = get_post('change_station');
}

// コネクション取得
$link= get_db_connect();

$all_tags = select_all_tags($link);
$all_genres = select_all_genres($link);
$stations = select_stations($link);

   //ポスト確認とエラーチェックはリクエストメソッドの前に終わらせておく！！！
if(is_post() === TRUE && count($errors) === 0){
        
    $log = timestamp();
        
    if($sql_kind === 'insert'){
        
        start_transaction($link);
        
        if(insert_spotsLocation($link, $station_id, $lat, $lng, $postal_code, $prefecture, $city, $detail_address) === TRUE){
            $spot_id = mysqli_insert_id($link);
            if(insert_spotsInfo($link, $spot_id, $spot_name, $status, $filename, $genre, $comment) === TRUE){
                foreach($tags as $tag){
                    if(insert_tags($link, $tag, $spot_id) === TRUE){
                        $message = 'スポットを追加しました。';
                    }else{
                        $errors[] = '追加失敗.tag_spot_table';
                    }
                }
            }else{
              $errors[] = '追加失敗.spot_info_table';
            }
        }else{
            $errors[] = '追加失敗.spot_location_table';
        }
        
    }
    
    if($sql_kind === 'update_comment'){
        if(update_comment($link, $spot_id, $update_comment) === TRUE){
            $message = 'コメントを変更しました。';
        }else{
            $errors[] = 'UPDATE処理失敗'.$sql;
        }
        $spots = select_spots_whereStation($link, $change_station);
    }
    
    if($sql_kind === 'update_tags'){
        $spot_tags = array_column(select_tags($link, $spot_id), 'tag_id');
        if($update_tags !== $spot_tags){
            foreach($update_tags as $update_tag){
                if(update_tags1($link, $spot_tags, $update_tag, $spot_id) !== FALSE){
                    foreach($spot_tags as $spot_tag){
                        if(update_tags2($link, $spot_tag, $update_tags, $spot_id) !== FALSE){
                            $message = 'タグを変更しました。';
                        }else{
                            $errors[] = 'UPDATE処理失敗:delete';
                        }
                    }
                }else{
                    $errors[] = 'UPDATE処理失敗:delete';
                }
            }
        }else{
            $errors[] = 'タグが変更されていません';
        }
        $spots = select_spots_whereStation($link, $change_station);
    }

    if($sql_kind === 'update_genre'){
        if(update_genre($link, $spot_id, $update_genre) === TRUE){
         $message = 'ジャンルを変更しました。';
        }else{
            $errors[] = 'UPDATE処理失敗';
        }
        $spots = select_spots_whereStation($link, $change_station);
    }

    
    if($sql_kind === 'update_status'){
        if(update_status($link, $spot_id,$status) === TRUE){
         $message = 'ステータスを変更しました。';
        }else{
            $errors[] = 'UPDATE処理失敗';
        }
        $spots = select_spots_whereStation($link, $change_station);
    }
    
    if($sql_kind === 'delete'){
        if(delete_spot($link, $spot_id) === TRUE){
            $message = 'データを削除しました。';
        }else{
            $errors[] = 'delete処理失敗';
        }
        $spots = select_spots_whereStation($link, $change_station);
    }
    
    close_transaction($link, $errors);
    
    if($sql_kind === 'change_station'){
        if($change_station === 'all'){
            $spots = select_spots($link);
        }else{
            $spots = select_spots_whereStation($link, $change_station);
        }
    }
    
}   

// var_dump($errors);

close_db_connect($link);

include_once './include/view/admin_spot.php';
// include_once '../include/view/goods_management.php';
