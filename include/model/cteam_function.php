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
function get_spot_table($link, $station_id) {
    $sql = "SELECT 
                spot_id, spot_name, station_id, status,
                lat, lng, address, address, image, comment
            FROM spot_table
            WHERE station_id = {$station_id}";
    var_dump($sql);
    $spot_data = get_as_array($link, $sql);
    return $spot_data;
}