<?php
require_once './include/conf/const.php';
require_once './include/model/functions.php';


$message     = '';     
$errors     = [];     // エラーメッセージ
$filename = '';
$status = 0;
$tags_name = [
'1' => 'かわいい',
'2' => 'おいしい',
'3' => 'たのしい',
'4' => 'きれい',
'5' => 'なつかしい'
];
$genres_name = [
'1' => '食べる',
'2' => '買う',
'3' => '遊ぶ',
'4' => '癒し',
'5' => '学ぶ・知る'
];

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
        $errors[] = 'ジャンルを入力してください。';
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

// コネクション取得
$link= get_db_connect();

session_start();

if(isset($_SESSION['user_id']) === TRUE) {
    if($_SESSION['user_id'] === 'admin'){
        $user_name = 'admin';
    }else{
        $user_id = $_SESSION['user_id'];
        $user_name = get_user_name($link, $user_id)['user_name'];
    }
}else{
    $user_name = '';
}
   
$stations = select_stations($link);

   //ポスト確認とエラーチェックはリクエストメソッドの前に終わらせておく！！！
if(is_post() === TRUE && count($errors) === 0){
        
    $log = timestamp();
        
    if($sql_kind === 'insert'){
        
        start_transaction($link);
        
        // var_dump(insert_spotsLocation($link, $station_id, $lat, $lng, $postal_code, $prefecture, $city, $detail_address));
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
    
    close_transaction($link, $errors);
}   

$spots = select_spots($link);

close_db_connect($link);

include_once './include/view/user_spot.php';
// include_once '../include/view/goods_management.php';
