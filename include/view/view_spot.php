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
            <?php if (isset($_SESSION['user_id']) === TRUE){?>
                <a class = "menu" href = "./logout.php">ログアウト</a>
            <?php }?>
            <a href = "./login.php">
                <img class = "walk" src="../cTeam/header-img/walk.png">
            </a>
            <?php if (isset($_SESSION['user_id']) === TRUE){?>
                <p class = "menu">ユーザー名:<?php print h($user_name); ?></p>
            <?php }?>
            </a>
        </div>
    </header>
    <div class="content">
        <div id="main">
            <div id="left">
                <div class="name_flame">
                    <div id="spot_name_box">
                        <h1 class="spot_name" style="padding-left: 6px;"></h1>
                        <h2 class="station_name" style="padding-left: 6px;">最寄駅：<?php print h($station_name); ?></h2>
                        <p><span class="tag_name" style="padding-left: 6px;"><?php print h($tag_name); ?></span> × <span class="genre_name"><?php print h($genre_name); ?></span></p>
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
                        <button id="only_change_spot" class="btn-flat-logo1" value="<?php print h($tag_id); ?>">スポットをかえる</button>
                        <button id="list" class="btn-flat-logo1">今までのスポットを表示</button>
                        <form action="top_page.php" method="post">
                            <button class="btn-flat-logo2">TOPにもどる</button>
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
            var check_tag = <?php print h($tag_id); ?>;
            if(check_tag === 1){
                $('header').addClass('cute');
            } else if(check_tag === 2){
                $('header').addClass('delicious');
            } else if(check_tag === 3){
                $('header').addClass('enjoy');
            } else if(check_tag === 4){
                $('header').addClass('beautiful');
            } else if(check_tag === 5){
                $('header').addClass('nostalgic');
            }
            
            var random_spot = {
                lat: <?php print h($spot_data[$rand_spot_number]['lat']); ?>,
                lng: <?php print h($spot_data[$rand_spot_number]['lng']); ?>
            };
            function indicate_spot() {
                $('.spot_picture').html('<img class="pic_size" src="spot_picture/<?php print h($spot_data[$rand_spot_number]['image']); ?>" alt="<?php print h($spot_data[$rand_spot_number]['spot_name']); ?>" title="<?php print h($spot_data[$rand_spot_number]['spot_name']); ?>">');
                $('.spot_info').html('<?php print h($spot_data[$rand_spot_number]['comment']); ?>');
                $('.spot_name').html('<?php print h($spot_data[$rand_spot_number]['spot_name']); ?>');
                $('.station_name').html('最寄駅：<?php print h($station_name); ?>');
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
            function getRandomInt(max) {
                return Math.floor(Math.random() * Math.floor(max)) + 1;
            };
            $(function() {
                indicate_spot();
            });
            
            $(function() {
                $('#only_change_spot').click(function(e) {
                    var random_tag_flag = <?php print h($random_tag_flag); ?>;
                    var random_genre_flag = <?php print h($random_genre_flag); ?>;
                    if(random_tag_flag === 1 && random_genre_flag === 0){
                        var tag_id = getRandomInt(5);
                        var genre_id = getRandomInt(5);
                        console.log(tag_id);
                        console.log(genre_id);
                        console.log(random_genre_flag);
                    } else if(random_tag_flag === 0 && random_genre_flag === 1){
                        var tag_id = <?php print h($tag_id); ?>;
                        var genre_id = getRandomInt(5);
                        var tag_name = '<?php print h($tag_name); ?>';
                        console.log(tag_id);
                        console.log(genre_id);
                        console.log(tag_name);
                    } else {
                        var tag_id = $('#only_change_spot').val();
                        var genre_id = <?php print h($genre_id); ?>;
                        var tag_name = '<?php print h($tag_name); ?>';
                        console.log(tag_id);
                        console.log(genre_id);
                    }
                    e.preventDefault();
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
                        var spot_id = data.spot_id;
                        $.ajax( {
                            url: 'get_station_tag_genre_name.php',
                            type: 'POST',
                            data: {
                                'spot_id': spot_id
                                },
                            dataType:'json'
                        }).done(function(station_tag_genre_name){
                            $('.station_name').html('最寄駅：' + station_tag_genre_name.station_name);
                            if(random_genre_flag === 1){
                                $('.genre_name').html(station_tag_genre_name.genre_name);
                                $('.tag_name').html(tag_name);
                                console.log(random_tag_flag);
                            } else if (random_tag_flag === 1){
                                $('.genre_name').html(station_tag_genre_name.genre_name);
                                $('.tag_name').html(station_tag_genre_name.tag_name);
                                check_tag = station_tag_genre_name.tag_id;
                                console.log(random_tag_flag);
                            }else {
                                $('.genre_name').html(station_tag_genre_name.genre_name);
                                $('.tag_name').html(tag_name);
                                console.log(check_tag);
                                console.log(random_tag_flag);
                            }
                            if(random_tag_flag === 0 && random_genre_flag === 0){
                                check_tag = tag_id;
                                console.log(random_tag_flag);
                                $('header').removeClass();
                                if(check_tag === '1'){
                                    $('header').addClass('cute');
                                } else if(check_tag === '2'){
                                    $('header').addClass('delicious');
                                } else if(check_tag === '3'){
                                    $('header').addClass('enjoy');
                                } else if(check_tag === '4'){
                                    $('header').addClass('beautiful');
                                } else if(check_tag === '5'){
                                    $('header').addClass('nostalgic');
                                }
                            } else if(random_tag_flag === 1 && random_genre_flag === 0){
                                console.log(random_tag_flag);
                                $('header').removeClass();
                                if(check_tag === '1'){
                                    $('header').addClass('cute');
                                } else if(check_tag === '2'){
                                    $('header').addClass('delicious');
                                } else if(check_tag === '3'){
                                    $('header').addClass('enjoy');
                                } else if(check_tag === '4'){
                                    $('header').addClass('beautiful');
                                } else if(check_tag === '5'){
                                    $('header').addClass('nostalgic');
                                }
                            }
                            spot_marker.setMap(null);
                            createMarker(data.lat, data.lng, data.spot_name);
                        }).fail(function(station_name){
                            alert('json取得エラー(station_tag_genre_name)です');
                            console.log(station_name);
                        })
                    }).fail(function(data){
                        alert('json取得エラーです');
                        console.log(data);
                    });
                });
                $('#only_change_spot').click(function(e) {
                    
                }
                
                
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