<?php
require_once '../api/include/conf/const.php';
require_once '../api/include/model/my_function.php';
require_once '../api/include/model/cteam_function.php';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="view_spot.css">
    <title>スポット表示</title>
</head>
<body>
    <div id="main">
        <div id="left">
            <div id="spot_name_box">
                <h1 class="spot_name">東京駅</h1>
            </div>
            <div id="map_box"></div>
        </div>
        <div id="right">
            <div id="spot_info_box">
                <div class="spot_picture"></div>
                <div class="spot_info_comment_box">
                    <p class="spot_info"></p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=<?php echo API_KEY; ?>&callback=init" async defer></script>
    <script>
        function init(){
            var tokyo = {
                lat: 35.6812362, //緯度
                lng: 139.7649361 //経度
            };
            var midtown_hibiya = {
                lat: 35.6736004, //緯度
                lng: 139.756956 //経度
            };
            var kitte = {
                lat: 35.6797978,
                lng: 139.7626837
            };
            //locationに今示したい場所を代入
            var location = tokyo;
            var location2 = midtown_hibiya;
            var location3 = kitte;
            //map_boxのdivを表示しますよ
            var map_box = $("#map_box")[0];
            var map = new google.maps.Map(
                map_box, // 第１引数は上で取得したマップ表示対象のdiv要素。
                {
                    // 第２引数で各種オプションを設定
                    center: location, 
                    zoom: 15, // 地図の拡大のレベルを15に。（1 - 18くらい）
                    disableDefaultUI: true, // 各種UI(航空写真、ストリートビューなど)をOFFに
                    zoomControl: true, // 拡大縮小だけできるように
                    clickableIcons: false, // クリック関連の機能をoffに。
                    // streetview: true
                }
            );
            var marker = new google.maps.Marker({
                map: map,
                position: location,
            });
            var infoWindow = new google.maps.InfoWindow({
                // position: shinagawa,
                content: '<a href="">東京駅</a>'
            });
            infoWindow.open(map, marker); 
            // $('marker').click(function(e){
            //     // ここにメッセージと画像を表示させる処理
            //     $('.spot_info').html('東京駅');
            // });
            marker.addListener('click', function(e){
                // ここにメッセージと画像を表示させる処理
                // $('.spot_info').html('東京駅');
            });
            //追加マーカーは関数化？
            var marker2 = new google.maps.Marker({
                map: map,
                position: location2,
                // title: '東京ミッドタウン日比谷', // マウスオーバー時に表示。
                icon: {
                    url: './icon/icon.png',
                    scaledSize: new google.maps.Size(40, 60)
                }
                // animation: google.maps.Animation.BOUNCE
            });
            var infoWindow = new google.maps.InfoWindow({
                content: '<a href="">東京ミッドタウン</a>'
            });
            infoWindow.open(map, marker2); 
            marker2.addListener('click', function(e){
                // ここにメッセージと画像を表示させる処理
                $('.spot_picture').html('<img class="pic_size" src="spot_picture/800px-Tokyo_Midtown.2.jpeg" alt="東京ミッドタウン" title="東京ミッドタウン">');
                $('.spot_info').html('東京ミッドタウン');
            });
            
            var marker3 = new google.maps.Marker({
                map: map,
                position: location3,
                // title: 'KITTE', // マウスオーバー時に表示。
                icon: {
                    url: './icon/icon.png',
                    scaledSize: new google.maps.Size(40, 60)
                }
                // animation: google.maps.Animation.BOUNCE
            });
            var infoWindow = new google.maps.InfoWindow({
                content: '<a href="">KITTE</a>'
            });
            infoWindow.open(map, marker3); 
            marker3.addListener('click', function(e){
                // ここにメッセージと画像を表示させる処理
                $('.spot_picture').html('<img class="pic_size" src="spot_picture/4472_1_1400x1100.jpg" alt="KITTE" title="KITTE">');
                $('.spot_info').html('KITTE');
            });
        }
    </script>
</body>
</html>