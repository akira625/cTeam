<?php
//sample
//関数の内容
//引数：
//返り値：
// function test() {
    
// }

//リクエストメソッドがPOSTか判別する関数
//引数：なし
//返り値：POST,GETなど
function get_request_method() {
    return $_SERVER['REQUEST_METHOD'];
}

//POSTかどうか確認関数
//引数：なし
//返り値：論理型
function is_post() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
}

//POSTされたvalueを受け取る関数
//引数：受け取るname
//返り値：受け取った値もしくは空白
function receive_post($value) {
    if(isset($_POST["$value"]) === TRUE){
        return trim($_POST["$value"]); 
    }
    return '';
}

//クッキー変数の存在確認関数
//引数：クッキー変数のキー
//返り値：論理型
function is_cookie($key) {
    if (isset($_COOKIE["$key"]) === TRUE) {
        return TRUE;
    }
    return FALSE;
}

//Cookieのvalueを受け取る関数
//引数：受け取りたいcookie名
//返り値：受け取った値もしくは空白
function receive_cookie($value) {
    if(isset($_COOKIE["$value"]) === TRUE){
        return $_COOKIE["$value"]; 
    }
    return '';
}

//セッション変数の存在確認関数
//引数：セッション変数のキー
//返り値：論理型
function is_session($key) {
    if (isset($_SESSION["$key"]) === TRUE) {
        return TRUE;
    }
    return FALSE;
}

//SESSIONのvalueを受け取る関数
//引数：受け取りたいsession名
//返り値：受け取った値もしくは空白
function receive_session($value) {
    if(isset($_SESSION["$value"]) === TRUE){
        return $_SESSION["$value"]; 
    }
    return '';
}

//SESSIONのvalueを配列で受け取る関数
//引数：受け取りたいsession名
//返り値：受け取った値もしくは空配列
function receive_errors() {
    $errors = receive_session('errors');
    if($errors === ''){
        return [];
    }
    unset($_SESSION['errors']);
    return $errors;
}

//SESSIONのvalueを配列で受け取る関数
//引数：受け取りたいsession名
//返り値：受け取った値もしくは空配列
function receive_success() {
    $success = receive_session('success'); 
    if($success === ''){
        return [];
    }    
    unset($_SESSION['success']);
    return $success;
}

//パターンの検索関数
//引数：検索したい文字列と元の文字列
//返り値：論理型
function is_valid_format($pattern, $string) {
    return preg_match($pattern, $string) === 1;
}

//ファイルのアップロードを確認しファイルを指定フォルダにアップロード
//引数：$_FILESで渡される名前、指定したいフォルダ名[picture/]の形式
//返り値：$item_picture_path
function upload_file($name, $directory) {
    $status = FALSE;
    //ファイルがアップロードされていたら
    if (is_uploaded_file($_FILES["$name"]['tmp_name'])) {
        //画像タイプ取得
        $type = exif_imagetype($_FILES["$name"]['tmp_name']);
        //画像タイプのチェックと拡張子の設定
        if ($type === IMAGETYPE_JPEG) {
            $extension = 'jpg';
        } else if ($type === IMAGETYPE_PNG ){
            $extension = 'png';
        } else {
            $_SESSION['errors'][] = '画像ファイルはjpegもしくはpngファイルにしてください。';
            return $status;
        }
        //ランダムな文字列を生成
        $random_string = substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, 20);
        //  ファイル名を作成
        $item_picture_path = $random_string . '.' . $extension;
        // 同名ファイルが存在しなくなるまでファイル名を生成
        while (is_file($item_picture_path) === TRUE) {
            $random_string = substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, 20);
            $item_picture_path = $random_string . '.' . $extension;
        }
        if (move_uploaded_file($_FILES["$name"]['tmp_name'], $directory . $item_picture_path) !== TRUE) {
            $_SESSION['errors'][] = 'ファイルアップロードに失敗しました';
            return $status;
        }
    } else {
        $_SESSION['errors'][] = 'ファイルを選択してください';
        return $status;
    }
    return $item_picture_path;
}


//DB接続関数
//引数：なし
//返り値：MySQLサーバーへの接続オブジェクト
function connect_db() {
    //コネクション取得
    if(!$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)){
        die('error' . mysqli_connect_error());
    }
    // 文字コードセット
    mysqli_set_charset($link, DB_CHARACTER_SET);
    return $link;
}

//DB切断関数
//引数：mysqli() で開いた返り値のリンクID
//返り値：論理型
function close_db($link) {
    mysqli_close($link);
}

//sqlを実行する関数
//引数：リンクIDとSQL文
//返り値：論理値
function do_sql($link, $sql) {
    $result = mysqli_query($link, $sql);
    if ($result === FALSE) {
        var_dump('SQL失敗' . $sql);
    }
    return $result;
}

//sqlを実行し配列で取得関数
//引数：リンクIDとSQL文
//返り値：配列$data
function get_as_array($link, $sql) {
    // 返却用配列
    $data = [];
    // クエリを実行する
    if ($result = mysqli_query($link, $sql)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        mysqli_free_result($result);
    }
    return $data;
}

//sqlを実行し行で取得関数
//引数：リンクIDとSQL文
//返り値：行
function get_as_row($link, $sql) {
    if ($result = mysqli_query($link, $sql)) {
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
    }
    return $row;
}

//user_idからユーザ名を取得するSQL
//引数：リンクIDとユーザーID
//返り値：ユーザ名
function get_user_name($link, $user_id) {
    
    $sql = "SELECT user_name FROM user_table
            WHERE user_id = {$user_id}";
    $user_name_data = get_as_row($link, $sql);
    return $user_name_data['user_name'];
}

//user_idからアイテム一覧を取得するSQL
//引数：リンクIDとユーザーID
//返り値：アイテム一覧の配列
function get_admin_item_list($link, $user_id) {
    $item_data = [];
    //商品一覧を取得SQL
    $sql = "SELECT item_information_table.item_id, item_information_table.name, 
                   item_information_table.price, item_information_table.item_picture_path, 
                   item_information_table.publication_status, stock_table.stock_quantity
            FROM item_information_table
            JOIN stock_table
                ON item_information_table.item_id = stock_table.item_id";
    //SQLを実行し商品一覧を配列で取得
    $item_data = get_as_array($link, $sql);
    return $item_data;
}

//指定user_idのカートの中身を配列で取得
//引数：リンクIDとユーザーID
//返り値：配列
function get_user_cart($link, $user_id) {
    // 返却用配列
    $data = [];
    $sql = "SELECT item_information_table.item_id, 
                   item_information_table.name, 
                   item_information_table.price, 
                   item_information_table.item_picture_path, 
                   cart_table.amount,
                   cart_table.amount * item_information_table.price AS sum_price
            FROM cart_table
            JOIN item_information_table
                ON cart_table.item_id = item_information_table.item_id
            JOIN user_table
                ON user_table.user_id =cart_table.user_id
            WHERE user_table.user_id = {$user_id}";
    // クエリを実行する
    if ($result = mysqli_query($link, $sql)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        mysqli_free_result($result);
    }
    return $data;
}

//stock_tableから購入分の在庫を減らすSQLを実行
//引数：リンクID、現在の数、購入希望の数、日付、指定するアイテムID
//返り値：論理型
function update_stock_table($link, $now_amount, $want_amount, $date, $item_id) {
    $new_amount = $now_amount - $want_amount;
    $sql = "UPDATE stock_table
            SET 
                stock_quantity = {$new_amount}, 
                updated_date = '{$date}'
            WHERE stock_table.item_id = {$item_id}";
    //SQLを実行
    return do_sql($link, $sql);
}


//特殊文字をHTMLエンティティ化関数
//引数：エンティティ化したい文字列
//返り値：エンティティ化した文字列
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);
}

//指定のページへリダイレクト関数
//引数：Location 定義ずみにより
//返り値：なし
function redirect($my_const) {
    header("Location: {$my_const}");
    exit;
}