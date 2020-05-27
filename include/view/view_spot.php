<?php
require_once './include/conf/const.php';
require_once './include/model/my_function.php';
require_once './include/model/cteam_function.php';

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="view_spot.css">
    <link rel="stylesheet" href="common.css">
    <title>スポット表示</title>
</head>
<body>
    <header>
        <div class = "header-box">
            <a href = "./top_page.php">
                <img class = "logo" src="./header-img/logo.png">
            </a>
            <a href = "./top_page.php">
                <img class = "walk" src="./header-img/walk.png">
            </a>
        </div>
    </header>
    <div class="content">
        <div id="main">
            <div id="left">
                <div class="name_flame">
                    <div id="spot_name_box">
                        <h2 class="station_name"></h2>
                        <h1 class="spot_name"></h1>
                    </div>
                </div>
                <div class="test_flame">
                    <div class="test">
                        <div class="spot_picture"></div>
                    </div>
                </div>
            </div>
            <div id="right">
                <div id="spot_info_box">
                    <div id="map_box"></div>
                    <div class="spot_info_comment_box">
                        <p class="spot_info"></p>
                    </div>
                    <div class="button_box">
                        <button id="only_change_spot" class="btn-flat-logo value="<?php print h($tag_id); ?>">スポットをかえる</button>
                        <form action="top_page.php" method="post">
                            <button class="btn-flat-logo">TOPにもどる</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=<?php echo API_KEY; ?>&callback=init" async defer></script>
    <script>
        function init(){
            var random_spot = {
                lat: <?php print h($spot_data[$rand_spot_number]['lat']); ?>,
                lng: <?php print h($spot_data[$rand_spot_number]['lng']); ?>
            };
            function indicate_spot() {
                $('.spot_picture').html('<img class="pic_size" src="spot_picture/<?php print h($spot_data[$rand_spot_number]['image']); ?>" alt="<?php print h($spot_data[$rand_spot_number]['spot_name']); ?>" title="<?php print h($spot_data[$rand_spot_number]['spot_name']); ?>">');
                $('.spot_info').html('<?php print h($spot_data[$rand_spot_number]['comment']); ?>');
                $('.spot_name').html('<?php print h($spot_data[$rand_spot_number]['spot_name']); ?>');
            };
            function createMarker(lat, lng, name){
                //マーカの作成
                var new_position = new google.maps.LatLng(lat, lng);
                spot_marker = new google.maps.Marker({
                    map: map,
                    position: new_position,
                    icon: {
                            url: './icon/icon.png',
                            scaledSize: new google.maps.Size(40, 60)
                           }
                });
                infoWindow = new google.maps.InfoWindow({
                    content: '<a href="http://www.google.co.jp/search?q='+ name +'">'+ name +'</a>'
                });
                map.panTo(new_position);
                infoWindow.open(map, spot_marker); 
            }
            $(function() {
                indicate_spot();
            });
            
            $(function() {
                $('#only_change_spot').click(function(e) {
                    e.preventDefault();
                    var tag_id = $('#only_change_spot').val();
                    var genre_id = <?php print h($genre_id); ?>;
                    console.log(tag_id);
                    console.log(genre_id);
                    $.ajax( {
                        url: 'only_change_spot.php',
                        type: 'POST',
                        data: {
                            'tag_id': tag_id,
                            'genre_id': genre_id
                            },
                        dataType:'json'
                    }).done(function(data){
                        $('.spot_picture').html('<img class="pic_size" src="spot_picture/' + data.image + '" alt="' + data.spot_name + '" title="' + data.spot_name + '">');
                        $('.spot_info').html(data.comment);
                        $('.spot_name').html(data.spot_name);
                        spot_marker.setMap(null);
                        createMarker(data.lat, data.lng, data.spot_name);
                    }).fail(function(data){
                        alert('エラーです');
                        console.log(data);
                    });
                });
            });
            
            //map_boxのdivを表示しますよ
            var map_box = $("#map_box")[0];
            var map = new google.maps.Map(
                map_box, // 第１引数は上で取得したマップ表示対象のdiv要素。
                {
                    // 第２引数で各種オプションを設定
                    center: random_spot, 
                    zoom: 15.5, // 地図の拡大のレベルを15に。（1 - 18くらい）
                    disableDefaultUI: true, // 各種UI(航空写真、ストリートビューなど)をOFFに
                    zoomControl: true, // 拡大縮小だけできるように
                    clickableIcons: false, // クリック関連の機能をoffに。
                    // streetview: true
                }
            );
            // var marker = new google.maps.Marker({
            //     map: map,
            //     position: random_station,
            // });
            // var infoWindow = new google.maps.InfoWindow({
            //     // position: shinagawa,
            //     content: '<a href="http://www.google.co.jp/search?q="></a>'
            // });
            // infoWindow.open(map, marker); 
            
            //追加マーカーは関数化？
            var spot_marker = new google.maps.Marker({
                map: map,
                position: random_spot,
                // title: '東京ミッドタウン日比谷', // マウスオーバー時に表示。
                icon: {
                    url: './icon/icon.png',
                    scaledSize: new google.maps.Size(40, 60)
                }
                // animation: google.maps.Animation.BOUNCE
            });
            var infoWindow = new google.maps.InfoWindow({
                content: '<a href="http://www.google.co.jp/search?q=<?php print h($spot_data[$rand_spot_number]['spot_name']); ?>"><?php print h($spot_data[$rand_spot_number]['spot_name']); ?></a>'
            });
            infoWindow.open(map, spot_marker); 
            spot_marker.addListener('click', function(e){
                // ここにメッセージと画像を表示させる処理
                $('.spot_picture').html('<img class="pic_size" src="spot_picture/<?php print h($spot_data[$rand_spot_number]['image']); ?>" alt="<?php print h($spot_data[$rand_spot_number]['spot_name']); ?>" title="<?php print h($spot_data[$rand_spot_number]['spot_name']); ?>">');
                $('.spot_info').html('<?php print h($spot_data[$rand_spot_number]['comment']); ?>');
                $('.spot_name').html('<?php print h($spot_data[$rand_spot_number]['spot_name']); ?>');
                
            });
            
        }
    </script>
</body>
</html>