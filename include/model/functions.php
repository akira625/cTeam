<?php

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);
}

function get_db_connect() {
    // コネクション取得
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($link === false) {
        die('error: ' . mysqli_connect_error());
    }
    // 文字コードセット
    mysqli_set_charset($link, DB_CHARACTER_SET);
    return $link;
}

function close_db_connect($link) {
    // 接続を閉じる
    mysqli_close($link);
}

function get_as_array($link, $sql){
    // 返却用配列
    $data = [];

    // クエリを実行する
    if ($result = mysqli_query($link, $sql)) {
        // １件ずつ取り出す
        while ($row = mysqli_fetch_array($result)) {
            $data[] = $row;
        }
        // 結果セットを開放
        mysqli_free_result($result);
    }
    return $data;
}

function get_as_assoc($link, $sql) {

    // 返却用配列
    $data = [];

    // クエリを実行する
    if ($result = mysqli_query($link, $sql)) {
        // １件ずつ取り出す
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        // 結果セットを開放
        mysqli_free_result($result);
    }
    return $data;
}

function get_as_row($link, $sql) {
    if ($result = mysqli_query($link, $sql)) {
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $row;
    }
    return [];
}

function execute_query($link, $sql){
    return mysqli_query($link, $sql);
}

function is_post(){
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function is_blank($value){
    return $value === '';
}

function is_valid_length($string, $length){
    return mb_strlen($string) <= $length;
}

function get_get($name){
    if (isset($_GET[$name]) === TRUE){
        return trim($_GET[$name]);
    }
    return '';
}
function get_post($name){
    if (isset($_POST[$name]) === TRUE){
        return $_POST[$name];
    }
    return '';
}
function redirect_to($url){
    header('Location: '. $url);
    exit;
}


///自作////////////////////////////////////////////////////////


function is_uploaded($key){
    return is_uploaded_file($_FILES[$key]['tmp_name']);
}

function move_uploaded($key, $filename){
    return move_uploaded_file($_FILES[$key]['tmp_name'], './spot_picture/' . $filename);
}

function get_file_type($key){
    // 画像タイプ取得
    $type =  exif_imagetype($_FILES[$key]['tmp_name']);
    $extension = '';
    // 画像タイプのチェックと拡張子の設定
    if ($type === IMAGETYPE_JPEG){
    $extension = 'jpg';
    } else if ($type === IMAGETYPE_PNG ){
    $extension = 'png';
    } else {
    $extension = 'error';
    }
    return  $extension;
}

function make_filename($extension){
     //  ランダムな文字列を生成
    $random_string = make_random();
    //  ファイル名を作成
    $filename = $random_string . '.' . $extension;
    // 同名ファイルが存在しなくなるまでファイル名を生成
    while (is_file('./spot_picture/' . $filename) === TRUE) {
        $random_string = make_random();
        $filename = $random_string . '.' . $extension;
    }
    return $filename;
}

function make_random(){
    return substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, 20);
}

function timestamp(){
    return date('Y-m-d H:i:s');
}

function insert_register($link, $new_user, $new_pass, $gender, $birthdate){
    $log = timestamp();
    $sql = "INSERT 
                users_table(user_name, password, gender, birthdate, created, updated)
            VALUES
                ('{$new_user}','{$new_pass}','{$gender}','{$birthdate}','{$log}','{$log}')
            ";
    return execute_query($link, $sql);
}


///spot管理関連//////////////////////////////////////////////

function insert_spotsLocation($link, $station_id, $lat, $lng, 
                              $postal_code, $prefecture, $city, $detail_address){
    $log = timestamp();
    $sql = "INSERT INTO 
                spot_location_table
                (station_id, lat, lng, 
                postal_code, prefecture, city, detail_address)
            VALUES
                ({$station_id} ,{$lat}, {$lng},
                '{$postal_code}','{$prefecture}','{$city}','{$detail_address}')
                ";
                // return $sql;
    return execute_query($link, $sql);
}

function insert_spotsInfo($link, $spot_id, $spot_name, $status, 
                          $filename, $genre, $comment){
    $log = timestamp();
    $sql = "INSERT INTO 
                spot_info_table
                (spot_id, spot_name, status,
                image, comment, genre, created, updated)
            VALUES
                ('{$spot_id}','{$spot_name}', '{$status}',
                 '{$filename}', '{$comment}', '{$genre}', '{$log}','{$log}')
                ";
    return execute_query($link, $sql);
}

function insert_tags($link, $tag, $spot_id){
        $sql = "INSERT INTO 
                    tag_spot_table
                    (tag_id, spot_id)
                VALUES
                    ('{$tag}', '{$spot_id}')
                ";
        return execute_query($link, $sql);
    
}

function update_comment($link, $spot_id,$update_comment){
    $log = timestamp();
    $sql = "UPDATE
                spot_info_table 
            SET
                comment = '{$update_comment}',updated = '{$log}'
            WHERE
                spot_id = '{$spot_id}';";
    return execute_query($link, $sql);
}

function update_genre($link, $spot_id, $update_genre){
    $log = timestamp();
    $sql = "UPDATE
                spot_info_table
            SET
                genre = '{$update_genre}',updated = '{$log}'
            WHERE
                spot_id = '{$spot_id}'
            ";
    return execute_query($link, $sql);
}

function update_status($link, $spot_id,$status){
    $log = timestamp();
    $sql = "UPDATE
                spot_info_table
            SET
                status = '{$status}',updated = '{$log}'
            WHERE
                spot_id = '{$spot_id}'
            ";
    return execute_query($link, $sql);
}

// function update_tags($link, $spot_tags, $update_tags, $spot_id){
//     foreach($update_tags as $update_tag){
//         if(update_tags1($link, $spot_tags, $update_tag, $spot_id) !== FALSE){
//             foreach($spot_tags as $spot_tag){
//                 return update_tags2($link, $spot_tag, $update_tags, $spot_id);
//             }
//         }
//     }
// }

function update_tags1($link, $spot_tags, $update_tag, $spot_id){
    if(in_array($update_tag, $spot_tags) === false){
        $sql = "INSERT INTO
                    tag_spot_table(tag_id, spot_id)
                VALUES
                    ({$update_tag}, {$spot_id})
                ";
        return execute_query($link, $sql);
    }
}

function update_tags2($link, $spot_tag, $update_tags, $spot_id){
    
    if(in_array($spot_tag, $update_tags) === false){
        $sql = "DELETE FROM
                    tag_spot_table
                WHERE
                    spot_id = {$spot_id}
                AND
                    tag_id = {$spot_tag}
                ";
        return execute_query($link, $sql);
    }
}

function select_spots($link){
    $sql = "SELECT
                slt.spot_id, sit.spot_name, sit.status, slt.lat, slt.lng,
                slt.postal_code, slt.prefecture, slt.city, slt.detail_address,
                sit.comment, sit.image, sit.genre, ta.station_name
            FROM
                spot_location_table AS slt
            JOIN
                station_table AS ta
            ON
                slt.station_id = ta.station_id
            JOIN
                spot_info_table AS sit
            ON
                slt.spot_id = sit.spot_id
            ";
    return get_as_assoc($link, $sql);
}

function select_tags($link, $spot_id){
    $sql = "SELECT
                tag_id
            FROM
                tag_spot_table
            WHERE
                spot_id = {$spot_id}
            ";
    return get_as_assoc($link, $sql);
}


function select_all_tags($link){
    $sql = "SELECT
                tag_id, tag_name
            FROM
                tag_table
            ";
    return get_as_assoc($link, $sql);
}

function select_all_genres($link){
    $sql = "SELECT
                genre_id, genre_name
            FROM
                genre_table
            ";
    return get_as_assoc($link, $sql);
}
// かわいい→$tags[$tag_id]にしたい

function delete_spot($link, $spot_id){
    $sql = "DELETE 
                slt, sit
            FROM
                spot_location_table AS slt
            INNER JOIN 
                spot_info_table AS sit
            ON
                slt.spot_id = sit.spot_id
            WHERE 
                slt.spot_id = '{$spot_id}'
            ";
    return execute_query($link, $sql);
}

///station関連///////////////////////////////////////////////////

function insert_stations($link, $station_name, $lat, $lng, $address){
    $log = timestamp();
    $sql = "INSERT INTO 
                station_table
                (station_name, lat, lng, address, created, updated)
            VALUES
                ('{$station_name}',{$lat}, {$lng}, '{$address}', '{$log}', '{$log}')
                ";
    return execute_query($link, $sql);
}

function select_stations($link){
    $sql = "SELECT
                station_id, station_name, lat, lng, address
            FROM
                station_table 
            ";
    return get_as_assoc($link, $sql);
}

function delete_station($link, $station_id){
    $sql = "DELETE FROM
                station_table 
            WHERE 
                station_id = '{$station_id}'
            ";
    return execute_query($link, $sql);
}

function lat_check($int){
    return preg_match('/^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?)$/',$int);
}

function lng_check($int){
    return preg_match('/^[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$/',$int);
}

///user関連///////////////////////////////////////////////////////
function select_user($link){
    $sql = "SELECT
                user_name, created_at
            FROM
                users_table
            ";
    return get_as_assoc($link, $sql);
}

function delete_user($link, $user_id){
    $sql = "DELETE FROM
                users_table 
            WHERE 
                user_id = '{$user_id}'
            ";
    return execute_query($link, $sql);
}

///トランザクション////////////////////////////////////////////////
function start_transaction($link){
    mysqli_autocommit($link,false);
}
        
function close_transaction($link, $errors){
    if (count($errors) === 0) {
        // 処理確4丁目
        mysqli_commit($link);
    } else {
        // 処理取消
        mysqli_rollback($link);
    }
}


function get_user_id($link, $new_user){
    $sql = "SELECT 
                user_id
            FROM 
                users_table
            WHERE 
                user_name = '{$new_user}'
            ";
    return get_as_row($link, $sql);
}

function get_user_name($link, $user_id){
    $sql = "SELECT 
                user_name
            FROM 
                users_table
            WHERE 
                user_id = '{$user_id}'
            ";

    return get_as_row($link, $sql);
}

function preg_match_int($int){
    return preg_match('/^([1-9][0-9]*|0)$/',$int);
}

function is_positive_num($int){
    return preg_match('/^([1-9][0-9]*)$/',$int);
}

function is_valid_str($str, $int){
    return preg_match('/^([a-zA-Z0-9]{'.$int.',})$/', $str) === 1;
}

