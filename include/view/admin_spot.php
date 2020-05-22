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
            <label>
                住所:<input type = "text" name = "address" id="address">
                <button id="search" name="search" id="search">緯度・経度を検索</button><br>
            </label>
            <label>緯度:<input type = "text" name = "lat" id="lat"></label><br>
            <label>経度:<input type = "text" name = "lng" id="lng"></label><br>
            <label>コメント:
                <br><textarea name='comment' class='comment'></textarea>
            </label><br>
            <input type = "file" name = "image"><br>
            <input type = "radio" name = "status" value = '1'>公開
            <input type = "radio" name = "status" value = '0'>非公開<br>
            <!--hiddenでformごとにvalueをつけ、$sql_kindがどのvalueかで場合分けする-->
            <input type = "hidden" name = "sql_kind" value = "insert">
            <input type = "submit" name = "submit" value = "スポット追加">
        </form>
    </div>
    <ul>
    <?php if(count($errors) !== 0){?>
        <?php foreach($errors as $error){?>
            <li class="err-msg"><?php print h($error);?></li>
        <?php }?>
    <?php }?>
    </ul>
    <h2>登録済みスポット情報変更</h2>
    <p>スポット一覧</p>
    <table>
        <tr>
            <th>スポット画像</th>
            <th>スポット名</th>
            <th>最寄り駅</th>
            <th>住所</th>
            <th>緯度</th>
            <th>経度</th>
            <th>コメント</th>
            <th>ステータス</th>
            <th>操作</th>
        </tr>
    
    <?php foreach($spots as $spot) {?>
        <?php if($spot['status'] === '1'){?>
        <tr>
        <?php }else{?>
        <tr class='status_false'>
            <?php }?>
            <td><img src="<?php print h('./img/'.$spot['image']); ?>"></td>
            <td><?php print h($spot['spot_name']); ?></td>
            <td><?php print h($spot['station_name']); ?></td>
            <td><?php print h($spot['address']); ?></td>
            <td><?php print h($spot['lat']); ?></td>
            <td><?php print h($spot['lng']); ?></td>
            <td>
                <form method = "post">
                    <textarea name='update_comment' class='update_comment'>
                        <?php print h($spot['comment']); ?>
                    </textarea>
                    <input type = "submit" value="変更">
                    <input type="hidden" name="spot_id" value=<?php print h($spot['spot_id']);?>>
                    <input type="hidden" name="sql_kind" value="update_comment">
                </form>
            </td>
            
            <!--tdの中にform-->
            <td>
                <form method = "post">
                    <?php if($spot['status'] === '1'){?>
                        <input type = "submit" name = "update_status" value = "公開→非公開">
                        <input type = "hidden" name = "status" value = '0'>
                    <?php }else{?>
                        <input type = "submit" name = "update_status" value = "非公開→公開">
                        <input type = "hidden" name = "status" value = '1'>
                    <?php }?>
                    <!--type="hidden"にid入れれば、inputをbuttonにして冗長に書く必要なくなる！-->
                    <input type = "hidden" name = "spot_id" value = <?php print $spot['spot_id'];?>>
                    <input type = "hidden" name = "sql_kind" value = "update_status">
                </form>
            </td>
            <td>
                <form method = "post">
                    <input type = "submit" name="delete" value="削除する">
                    <input type = "hidden" name = "spot_id" value = <?php print h($spot['spot_id']);?>>
                    <input type = "hidden" name = "sql_kind" value = "delete">
                </form>
            </td>
        </tr>
    <?php } ?>
    </table>
    <script>
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
                  address: document.getElementById('address').value
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