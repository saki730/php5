<?php

//1. POSTデータ取得
$name   = $_POST['name'];
$email  = $_POST['email'];
$age    = $_POST['age'];
$content = $_POST['content'];
$image= '';

if (isset($_FILES["image"])) {
    //画像の名前をリネーム処理
    //一時保存されている画像をimgフォルダに移動させる。
    $upload_file =$_FILES['image']['tmp_name'];
    
      //送られてきた名前を確認する。
    $extension =pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
    $new_name=uniqid() . '.' . $extension;
    $image_path = 'img/' . $new_name;

    //一時保存ファイルをimgフォルダに移動される（保存する）
    if (move_uploaded_file($upload_file, $image_path)){
        $image =$image_path;
    }

    //保存する。
}


//2. DB接続します
//*** function化する！  *****************
try {
    $db_name = 'gs_db3'; //データベース名
    $db_id   = 'root'; //アカウント名
    $db_pw   = ''; //パスワード：MAMPは'root'
    $db_host = 'localhost'; //DBホスト
    $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw); //データベースに接続できた場合は値をPDOに入れないといけない
} catch (PDOException $e) {
    exit('DB Connection Error:' . $e->getMessage());
}


//３．データ登録SQL作成
$stmt = $pdo->prepare(
    'INSERT INTO
                        gs_an_table(
                            name, email, age, comfort, indate, image
                            )
                        VALUES (
                            :name, :email, :age, :comfort, sysdate(), :image
                            );'
);



// 数値の場合 PDO::PARAM_INT
// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':age', $age, PDO::PARAM_INT); //PARAM_INTなので注意
$stmt->bindValue(':comfort', $content, PDO::PARAM_STR);
$stmt->bindValue(':image', $image, PDO::PARAM_STR);
$status = $stmt->execute(); //実行


//４．データ登録処理後
if ($status === false) {
    //*** function化する！******\
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    //*** function化する！*****************
    header('Location: index.php');
    exit();
}
