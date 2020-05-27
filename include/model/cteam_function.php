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
function get_station_table($link) {
    $sql = "SELECT 
                station_id, station_name,
                lat, lng, address
            FROM station_table";
    $station_data = get_as_array($link, $sql);
    return $station_data;
    
}

//スポット情報を取得関数
//引数：$link
//返り値：配列データ
function get_spot_table($link, $tag_id) {
    $sql = "SELECT 
                spot_location_table.spot_id, spot_location_table.station_id, spot_location_table.lat, spot_location_table.lng, 
                spot_location_table.postal_code, spot_location_table.prefecture, spot_location_table.city, spot_location_table.detail_address, 
                spot_info_table.spot_name, spot_info_table.comment, spot_info_table.image, spot_info_table.genre, spot_info_table.status, 
                spot_info_table.created, spot_info_table.updated, tag_spot_table.tag_id
            FROM spot_location_table
            JOIN spot_info_table
            ON spot_location_table.spot_id = spot_info_table.spot_id
            JOIN tag_spot_table
            ON spot_info_table.spot_id = tag_spot_table.spot_id
            WHERE tag_spot_table.tag_id = {$tag_id}";
    $spot_data = get_as_array($link, $sql);
    return $spot_data;
}