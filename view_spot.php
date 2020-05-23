<?php
require_once './include/conf/const.php';
require_once './include/model/my_function.php';
require_once './include/model/cteam_function.php';

$link = connect_db();

$stations_data = get_station_table($link);
$number_stations = count($stations_data);
$rand_station_number = mt_rand(1, $number_stations) - 1;
$station_id = $stations_data[$rand_station_number]['station_id'];

$spot_data = get_spot_table($link, $station_id);
$number_spots = count($spot_data);
$rand_spot_number = mt_rand(1, $number_spots) - 1;

close_db($link);
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
                <div id="spot_name_box">
                    <h1 class="station_name"><?php print h($stations_data[$rand_station_number]['station_name']); ?></h1>
                    <h2 class="spot_name"></h2>
                </div>
                <div id="map_box"></div>
            </div>
            <div id="right">
                <div id="spot_info_box">
                    <div class="spot_picture"></div>
                    <div class="spot_info_comment_box">
                        <p class="spot_info"></p>
                    </div>
                    <div class="button_box">
                        <form action="view_spot.php" method="post">
                            <input type="submit" value="駅から選び直す">
                        </form>
                        <button id="only_change_spot" value="<?php print h($stations_data[$rand_station_number]['station_id']); ?>">スポットだけ選び直す</button>
                        <form action="top_page.php" method="post">
                            <input type="submit" value="TOPに戻る">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=<?php echo API_KEY; ?>&callback=init" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <script>
        function init(){
            var random_station = {
                lat: <?php print h($stations_data[$rand_station_number]['lat']); ?>,
                lng: <?php print h($stations_data[$rand_station_number]['lng']); ?>
            };
            var random_spot = {
                lat: <?php print h($spot_data[$rand_spot_number]['lat']); ?>,
                lng: <?php print h($spot_data[$rand_spot_number]['lng']); ?>
            };
            function indicate_spot() {
                $('.spot_picture').html('<img class="pic_size" src="spot_picture/<?php print h($spot_data[$rand_spot_number]['image']); ?>" alt="KITTE" title="KITTE">');
                $('.spot_info').html('<?php print h($spot_data[$rand_spot_number]['comment']); ?>');
                $('.spot_name').html('<?php print h($spot_data[$rand_spot_number]['spot_name']); ?>');
            };
            $(function() {
                indicate_spot();
            });
            
            $(function() {
                $('#only_change_spot').click(function(e) {
                    e.preventDefault();
                    var station_id = $('#only_change_spot').val();
                    console.log(station_id);
                    $.ajax( {
                        url: 'only_change_spot.php',
                        data: station_id,
                        dataType:'json'
                    }).done(function(data){
                        var rand_spot_number = Math.floor( Math.random() * data.length ) - 1;
                        $('.spot_picture').html('<img class="pic_size" src="spot_picture/" alt="" title="">');
                        $('.spot_info').html(data[rand_spot_number].comment);
                        $('.spot_name').html(data[rand_spot_number].spot_name);
                    }).fail(function(){
                        alert('エラーです');
                    });
                });
            });
            
            //map_boxのdivを表示しますよ
            var map_box = $("#map_box")[0];
            var map = new google.maps.Map(
                map_box, // 第１引数は上で取得したマップ表示対象のdiv要素。
                {
                    // 第２引数で各種オプションを設定
                    center: random_station, 
                    zoom: 15.5, // 地図の拡大のレベルを15に。（1 - 18くらい）
                    disableDefaultUI: true, // 各種UI(航空写真、ストリートビューなど)をOFFに
                    zoomControl: true, // 拡大縮小だけできるように
                    clickableIcons: false, // クリック関連の機能をoffに。
                    // streetview: true
                }
            );
            var marker = new google.maps.Marker({
                map: map,
                position: random_station,
            });
            var infoWindow = new google.maps.InfoWindow({
                // position: shinagawa,
                content: '<a href="http://www.google.co.jp/search?q=<?php print h($stations_data[$rand_station_number]['station_name']); ?>"><?php print h($stations_data[$rand_station_number]['station_name']); ?></a>'
            });
            infoWindow.open(map, marker); 
            //追加マーカーは関数化？
            var spot1 = new google.maps.Marker({
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
            infoWindow.open(map, spot1); 
            spot1.addListener('click', function(e){
                // ここにメッセージと画像を表示させる処理
                $('.spot_picture').html('<img class="pic_size" src="spot_picture/<?php print h($spot_data[$rand_spot_number]['image']); ?>" alt="KITTE" title="KITTE">');
                $('.spot_info').html('<?php print h($spot_data[$rand_spot_number]['comment']); ?>');
                $('.spot_name').html('<?php print h($spot_data[$rand_spot_number]['spot_name']); ?>');
                
            });
            
        }
    </script>
</body>
</html>