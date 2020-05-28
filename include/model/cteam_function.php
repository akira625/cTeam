<?php
//sample
//関数の内容
//引数：
//返り値：
// function test() {
    
// }

//スポットマーカーの設置
//引数：
//返り値：
// function test() {
    
// }

//駅情報を取得関数
//引数：$link
//返り値：配列データ
function get_station_table($link, $station_id) {
    $sql = "SELECT 
                station_id, station_name,
                lat, lng, address
            FROM station_table
            WHERE station_id = {$station_id}";
    $station_data = get_as_array($link, $sql);
    return $station_data;
    
}

//駅名を取得関数
//引数：$link,$spot_id
//返り値：配列データ
function get_station_name($link, $spot_id) {
    $sql = "SELECT station_table.station_name　
            FROM spot_location_table 
            JOIN station_table
            ON　spot_location_table.station_id = station_table.station_id
            WHERE spot_location_table.spot_id = {$spot_id}";
    $station_name = get_as_array($link, $sql);
    return $station_name;
    
}

//スポット情報を取得関数
//引数：$link
//返り値：配列データ
function get_spot_table($link, $tag_id, $genre_id) {
    $sql = "SELECT 
                spot_location_table.spot_id, spot_location_table.station_id, spot_location_table.lat, spot_location_table.lng, 
                spot_location_table.postal_code, spot_location_table.prefecture, spot_location_table.city, spot_location_table.detail_address, 
                spot_info_table.spot_name, spot_info_table.comment, spot_info_table.image, spot_info_table.genre, spot_info_table.status, 
                spot_info_table.created, spot_info_table.updated, tag_spot_table.tag_id, tag_table.tag_name, genre_table.genre_name
            FROM spot_location_table
            JOIN spot_info_table
                ON spot_location_table.spot_id = spot_info_table.spot_id
            JOIN tag_spot_table
                ON spot_info_table.spot_id = tag_spot_table.spot_id
            JOIN tag_table
                ON tag_table.tag_id = tag_spot_table.tag_id
            JOIN genre_table
                ON spot_info_table.genre = genre_table.genre_id
            WHERE tag_spot_table.tag_id = {$tag_id}
            AND spot_info_table.genre = {$genre_id}";
    $spot_data = get_as_array($link, $sql);
    return $spot_data;
}

//タグ名を取得関数
//引数：$link,$spot_id
//返り値：配列データ
function get_tag_name_by_si($link, $spot_id) {
    $sql = "SELECT tag_table.tag_name
            FROM tag_table
            JOIN tag_spot_table
            ON tag_table.tag_id = tag_spot_table.tag_id
            WHERE tag_spot_table.spot_id = {$spot_id}";
    $tag_name = get_as_array($link, $sql);
    return $tag_name;
}

//タグ名を取得関数
//引数：$link,$spot_id
//返り値：配列データ
function get_tag_name_by_ti($link, $tag_id) {
    $sql = "SELECT tag_name
            FROM tag_table
            WHERE tag_id = {$tag_id}";
    $tag_name = get_as_array($link, $sql);
    return $tag_name;
}
//ジャンル名を取得関数
//引数：$link,$genre_id
//返り値：配列データ
function get_genre_name_by_gi($link, $genre_id) {
    $sql = "SELECT genre_name
            FROM genre_table
            WHERE genre_id = {$genre_id}";
    $genre_name = get_as_array($link, $sql);
    return $genre_name;
}


//ジャンル名を取得関数
//引数：$link,$spot_id
//返り値：配列データ
function get_genre_name($link, $genre_id) {
    $sql = "SELECT station_table.station_name　
            FROM spot_location_table 
            JOIN station_table
            ON　spot_location_table.station_id = station_table.station_id
            WHERE spot_location_table.spot_id = {$spot_id}";
    $genre_name = get_as_array($link, $sql);
    return $genre_name;
}

//駅・タグ・ジャンル名を取得関数
//引数：$link,$spot_id
//返り値：配列データ
function get_station_tag_genre_name($link, $spot_id) {
    $sql = "SELECT 
                spot_location_table.spot_id, station_table.station_name,
                tag_table.tag_name, genre_table.genre_name
            FROM spot_location_table
            JOIN spot_info_table
                ON spot_location_table.spot_id = spot_info_table.spot_id
            JOIN tag_spot_table
                ON spot_info_table.spot_id = tag_spot_table.spot_id
            JOIN tag_table
                ON tag_table.tag_id = tag_spot_table.tag_id
            JOIN genre_table
                ON spot_info_table.genre = genre_table.genre_id
            WHERE spot_location_table.spot_id = {$spot_id}";
    $genre_name = get_as_array($link, $sql);
    return $genre_name;
}
