<!DOCTYPE html>
<html lang="ja">
<head>
   <meta charset="UTF-8">
   <title>スポット追加ページ</title> 
</head>
<link type = "text/css" rel = "stylesheet" href = "common.css">
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
        <?php if($message !== ''){?>
            <p class="success"><?php print h($message); ?></p>
        <?php }?>
        <ul>
            <?php if(count($errors) !== 0){?>
                <?php foreach($errors as $error){?>
                    <li class="errors"><?php print h($error);?></li>
                <?php }?>
            <?php }?>
        </ul>
        <div class="wrapper">
            <h1>スポット追加ページ</h1>
            <p>あなたのお気に入りのスポットを追加してみましょう！</p>
            <p>管理者の承認後、アプリ内のマップに反映されます。</p>
        </div>
        <div class="wrapper">
            <form method="post" action = "user_spot.php" enctype = "multipart/form-data" class="add">
            <input type = "hidden" name = "sql_kind" value = "insert">
                <div class="userInsert">
                    <label>スポット名:</label>
                    <span class="userInsert-form">
                        <input type = "text" name = "spot_name">
                    </span>
                </div>
                <div class="userInsert">
                    <label>最寄り駅:</label>
                    <span class="userInsert-form">
                        <select name='near_station'>
                            <option value=''>選択してください</option>
                            <?php foreach($stations as $station){?>
                                <option value='<?php print h($station['station_id']);?>'>
                                    <?php print h($station['station_name']);?>
                                </option>
                            <?php }?>
                        </select>
                    </span>
                </div>
                <div class="userInsert">
                    <label>郵便番号:</label>
                    <span class="userInsert-form">
                        <input id="postal_code" name="postal_code" type="text" placeholder="1040052">
                    </span>
                    <span class="userInsert-form">
                        <input type="button" id="insert_address" value="住所を自動で入力する">
                    </span>
                </div>
                <div class="userInsert">
                    <label>都道府県:</label>
                    <span class="userInsert-form">
                        <input id="prefecture" name="prefecture" type="text" placeholder="東京都">
                    </span>
                </div>
                <div class="userInsert">
                    <label>市区町村:</label>
                    <span class="userInsert-form">
                        <input id = "city" name = "city" type = "text" placeholder="中央区">
                    </span>
                </div>
                <div class="userInsert">
                    <label>番地以下:</label>
                    <span class="userInsert-form">
                        <input name = "detail_address" id="detail_address" type = "text" placeholder="月島3-26-4">
                    </span>
                    <span class="userInsert-form">
                        <input type="button" id="search" name="search" id="search" value="住所から緯度・経度を検索"></input>
                    </span>
                </div>
                <div class="userInsert">
                    <label>緯度:</label>
                    <span class="userInsert-form">
                        <input type = "text" name = "lat" id="lat">
                    </span>
                </div>
                <div class="userInsert">
                    <label>経度:</label>
                    <span class="userInsert-form">
                        <input type = "text" name = "lng" id="lng">
                    </span>
                </div>
                <div class="userInsert">
                    <label>コメント:</label>
                    <span class="userInsert-form">
                        <textarea name='comment' class='comment'></textarea>
                    </span>
                </div>
                <div class="userInsert">
                    <label>タグ(複数選択可):</label>
                    <span class="userInsert-form">
                        <?php foreach($tags_name as $key => $value){?>
                        <input type="checkbox" name="tags[]" value="<?php print h($key);?>">
                                <?php print h($value);?>
                        <?php }?>
                    </span>
                </div>
                <div class="userInsert">
                    <label>ジャンル:</label>
                    <span class="userInsert-form">
                        <select name='genre'>
                            <option value=''>選択してください</option>
                            <?php foreach($genres_name as $key => $value){?>
                                <option value='<?php print h($key);?>'>
                                    <?php print h($value);?>
                                </option>
                            <?php }?>
                        </select>
                    </span>
                </div>
                <div class="userInsert">
                    <label>画像追加:</label>
                    <span class="userInsert-form">
                        <input type = "file" name = "image">
                    </span>
                </div>
                <div class="userInsert last-userInsert">
                    <span class="userInsert-form">
                        <input type = "submit" name = "submit" value = "スポット追加">
                    </span>
                </div>
                <!--hiddenでformごとにvalueをつけ、$sql_kindがどのvalueかで場合分けする-->
            </form>
        </div>
        <div class="wrapper">
            <h1>登録済みスポット一覧</h1>
            <table class="user_spot_table">
                <tr>
                    <th class="spot_img">スポット画像</th>
                    <th class="table_spot_name">スポット名</th>
                    <th>最寄り駅</th>
                    <th class="table_comment">コメント</th>
                    <th>タグ</th>
                    <th>ジャンル</th>
                </tr>
                <?php foreach($spots as $spot) {?>
                    <?php if($spot['status'] === '1'){?>
                    <tr class="user_spot_view">
                        <td>
                            <img src="<?php print h('./spot_picture/'.$spot['image']); ?>">
                        </td>
                        <td><?php print h($spot['spot_name']); ?></td>
                        <td><?php print h($spot['station_name']); ?></td>
                        <td><?php print h($spot['comment']); ?></td>
                        <?php
                            $link = get_db_connect();
                            $spot_tags = select_tags($link, $spot['spot_id']);
                            close_db_connect($link);
                        ?>
                        <td>
                            <ul>
                                <?php foreach($spot_tags as $spot_tag){?>
                                    <li><?php print h($tags_name[$spot_tag['tag_id']]); ?></li>
                                <?php }?>
                            </ul>
                        </td>
                        <td><?php print h($genres_name[$spot['genre']]); ?></td>
                    </tr>
                    <?php }?>
                <?php } ?>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
    <script>

    // 郵便番号から住所を取得
    // 引数にする関数には()つけない
    $('#insert_address').click(setPrefecture);
    function setPrefecture() {
    var postal_code = $('#postal_code').val();

    // ここでpostal_codeのバリデーションを行ってください

    $.ajax({
      type : 'get',
      url : 'https://maps.googleapis.com/maps/api/geocode/json',
      crossDomain : true,
      dataType : 'json',
      data : {
        //keyをここに書く
        key : '<?php echo API_KEY; ?>',
        address : postal_code,
        language : 'ja',
        sensor : false
      },
      success : function(resp){
        if(resp.status === "OK"){
          // APIのレスポンスから住所情報を取得
          var obj = resp.results[0].address_components;
          if (obj.length < 5) {
            alert('正しい郵便番号を入力してください');
            return false;
          }
          //$('#country').val(obj[4]['long_name']); // 国
          $('#prefecture').val(obj[3]['long_name']); // 都道府県
          $('#city').val(obj[2]['long_name']);  // 市区町村
          $('#detail_address').val(obj[1]['long_name']); // 番地
        }else{
            console.log(resp);
          alert('住所情報が取得できませんでした');
          return false;
        }
      }
    });
  }
    
    function init(){
        // ジオコーダーの生成
        var geocoder = new google.maps.Geocoder();
        document.getElementById('search')
          .addEventListener(
            'click',
            function(e){
                //buttonのデフォルトの「submit」という機能を停止
                e.preventDefault();
              　geocoder.geocode(
                // 第一引数にジオコーディングのオプションを設定
                {
                //addressに入れた住所を渡す
                  address: document.getElementById('prefecture').value +
                            document.getElementById('city').value +
                            document.getElementById('detail_address').value
                },
                // 第二引数に結果取得時の動作を設定(resultに返ってきた結果、statusに成功か失敗か)
                function(results, status){
                  // 失敗時の処理
                  if(status !== 'OK'){
                    alert('ジオコーディングに失敗しました。結果: ' + status);
                    return;
                  }
                  
                  // 成功した場合、resultsの0番目に結果が取得される。
                  if(!results[0]){
                      //成功していても結果になにも入っていない場合
                    alert('結果が取得できませんでした');
                    return;
                  }
                  
                  // マップの中心を移動(panToは指定の位置にマップの中心をスクロールするメソッド)
                  // var latlng = results[0].geometry.location;
                　//
                　
                  document.getElementById('lat').value = results[0].geometry.location.lat();
                  document.getElementById('lng').value = results[0].geometry.location.lng();
                }
              );
            }
          );
      }
      
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=<?php echo API_KEY; ?>&callback=init" async defer></script>
</body>
</html>