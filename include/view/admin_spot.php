<!DOCTYPE html>
<html lang="ja">
<head>
   <meta charset="UTF-8">
   <title>行き先ポン！管理ツール</title> 
</head>
<link type = "text/css" rel = "stylesheet" href = "admin.css">
<body>
    <img class = "logo" src="./header-img/logo.png">
    <h1>管理ツール</h1>
    <a href="./logout.php">ログアウト</a>
    <a href="./admin_station.php">駅管理ページ</a>
    <a href="./admin_user.php">ユーザ管理ページ</a>
    <ul>
    <?php if(count($errors) !== 0){?>
        <?php foreach($errors as $error){?>
            <li class="errors"><?php print h($error);?></li>
        <?php }?>
    <?php }?>
    </ul>
    <?php if($message !== ''){?>
        <p><?php print h($message); ?></p>
    <?php }?>
    <div class = "add">
        <h2>新規スポット追加</h2>
        <form method="post" action = "admin_spot.php" enctype = "multipart/form-data">
            <label>スポット名:<input type = "text" name = "spot_name"></label><br>
            <label>最寄り駅:
                <select name='near_station'>
                    <option value=''>選択してください</option>
                    <?php foreach($stations as $station){?>
                        <option value='<?php print h($station['station_id']);?>'>
                            <?php print h($station['station_name']);?>
                        </option>
                    <?php }?>
                </select>
            </label><br>
            <div class="address">
                <label>郵便番号:
                    <input id="postal_code" name="postal_code" type="text" placeholder="1040052"><br>
                    <input type="button" value="住所を自動で入力する" id="insert_address">
                </label><br>
                <label>都道府県:
                    <input id="prefecture" name="prefecture" type="text" placeholder="東京都">
                </label><br>
                市区町村:<input id = "city" name = "city" type = "text" placeholder="中央区"><br>
                番地以下:<input name = "detail_address" id="detail_address" type = "text" placeholder="月島3-26-4"><br>
                <button id="search" name="search" id="search">住所から緯度・経度を検索</button><br>
                <label>緯度:<input type = "text" name = "lat" id="lat"></label><br>
                <label>経度:<input type = "text" name = "lng" id="lng"></label><br>
            </div>
            <label>コメント:<br>
                <textarea name='comment' class='comment'></textarea>
            </label><br>
            <label>タグ(複数選択可):
                    <?php foreach($all_tags as $tag_name){?>
                    <input type="checkbox" name="tags[]" value="<?php print h($tag_name['tag_id']);?>">
                            <?php print h($tag_name['tag_name']);?>
                    <?php }?>
            </label><br>
            <label>ジャンル(一つだけ選択):
                <select name='genre'>
                    <option value=''>選択してください</option>
                    <?php foreach($all_genres as $genre_name){?>
                        <option value='<?php print h($genre_name['genre_id']);?>'>
                            <?php print h($genre_name['genre_name']);?>
                        </option>
                    <?php }?>
                </select>
            </label><br>
            <input type = "file" name = "image"><br>
            <input type = "radio" name = "status" value = '1'>公開
            <input type = "radio" name = "status" value = '0'>非公開<br>
            <!--hiddenでformごとにvalueをつけ、$sql_kindがどのvalueかで場合分けする-->
            <input type = "hidden" name = "sql_kind" value = "insert">
            <input type = "submit" name = "submit" value = "スポット追加">
        </form>
    </div>
    <h2>登録済みスポット情報変更</h2>
        <div class="search">
        <p>最寄り駅で検索</p>
            <form method="post">
                <select name='change_station'>
                    <option value='all'>全てを選択</option>
                    <?php foreach($stations as $station){?>
                        <option value='<?php print h($station['station_id']);?>' 
                        <?php if($change_station === $station['station_id']){print 'selected';}?>>
                            <?php print h($station['station_name']);?>
                        </option>
                    <?php }?>
                    <input type="hidden" name="sql_kind" value="change_station">
                    <input type="submit" value="表示">
                </select>
            </form>
        </div>
        <br>
    <?php if($change_station !== ''){?>
        <table>
            <tr>
                <th class="img">スポット画像</th>
                <th class="spot_name">スポット名</th>
                <th class="near_station">最寄り駅</th>
                <th class="selected_address">住所</th>
                <th class="lat">緯度</th>
                <th class="lng">経度</th>
                <th class="update_comment">コメント</th>
                <th class="tag">タグ</th>
                <th>ジャンル</th>
                <th class="status">ステータス</th>
                <th>操作</th>
            </tr>
        
        <?php foreach($spots as $spot) {?>
            <?php if($spot['status'] === '1'){?>
            <tr>
            <?php }else{?>
            <tr class='status_false'>
                <?php }?>
                <td>
                    <img src="<?php print h('./spot_picture/'.$spot['image']); ?>">
                </td>
                <td><?php print h($spot['spot_name']); ?></td>
                <td><?php print h($spot['station_name']); ?></td>
                <td><?php print h($spot['prefecture'].$spot['city'].$spot['detail_address']); ?></td>
                <td><?php print h($spot['lat']); ?></td>
                <td><?php print h($spot['lng']); ?></td>
                <td>
                    <form method = "post">
                        <textarea name='update_comment' class='update_comment'><?php print h($spot['comment']); ?>
                        </textarea>
                        <input type="submit" value="変更">
                        <input type="hidden" name="spot_id" value=<?php print h($spot['spot_id']);?>>
                        <input type="hidden" name="sql_kind" value="update_comment">
                    </form>
                </td>
                <?php
                    $link = get_db_connect();
                    //array_column ( 元の配列, 取り出したい配列のキー)
                    $spot_tags = array_column(select_tags($link, $spot['spot_id']), 'tag_id');
                    // var_dump($spot_tags);
                    close_db_connect($link);
                ?>
                <td>
                    <form method = "post">
                        <ul>
                            <?php foreach($all_tags as $tag_name){?>
                                <li>
                                    <input type="checkbox" name="update_tags[]" value="<?php print h($tag_name['tag_id']);?>"
                                    <?php if(in_array($tag_name['tag_id'], $spot_tags)){print 'checked';} ?>>
                                    <?php print h($tag_name['tag_name']);?>
                                </li>
                            <?php }?>
                        </ul>
                        <input type="hidden" name="sql_kind" value="update_tags">
                        <input type="hidden" name="spot_id" value=<?php print h($spot['spot_id']);?>>
                        <input type="submit" value="変更">
                    </form>
                </td>
                <td>
                    <form method = "post">
                        <select name='update_genre'>
                            <?php foreach($all_genres as $genre_name){?>
                                <option value='<?php print h($genre_name['genre_id']);?>'
                                <?php if($genre_name['genre_id'] === $spot['genre']){print 'selected';}?>>
                                    <?php print h($genre_name['genre_name']);?>
                                </option>
                            <?php }?>
                        </select>
                        <input type="hidden" name="sql_kind" value="update_genre">
                        <input type="hidden" name="spot_id" value=<?php print h($spot['spot_id']);?>>
                        <input type="submit" value="変更">
                    </form>
                </td>
                <td>
                    <form method = "post">
                        <?php if($spot['status'] === '1'){?>
                            <input type = "submit" name = "update_status" value = "⇒非公開">
                            <input type = "hidden" name = "status" value = '0'>
                        <?php }else{?>
                            <input type = "submit" name = "update_status" value = "⇒公開">
                            <input type = "hidden" name = "status" value = '1'>
                        <?php }?>
                        <!--type="hidden"にid入れれば、inputをbuttonにして冗長に書く必要なくなる！-->
                        <input type = "hidden" name = "spot_id" value = <?php print $spot['spot_id'];?>>
                        <input type = "hidden" name = "sql_kind" value = "update_status">
                    </form>
                </td>
                <td>
                    <form method = "post">
                        <input type = "submit" name="delete" value="削除">
                        <input type = "hidden" name = "spot_id" value = <?php print h($spot['spot_id']);?>>
                        <input type = "hidden" name = "sql_kind" value = "delete">
                    </form>
                </td>
            </tr>
        <?php } ?>
        </table>
    <?php }?>
    <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
    <script>
    
    // 郵便番号から住所を取得
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