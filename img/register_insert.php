<?php

//1. POSTデータ取得
$namename   = $_POST['namename'];
$idid  = $_POST['idid'];
$password    = $_POST['password'];

$hashed_pw = password_hash($password, PASSWORD_DEFAULT); //


//2. DB接続します
//*** function化する！  *****************
require_once('funcs.php');
$pdo = db_conn();


//３．データ登録SQL作成
$stmt = $pdo->prepare(
    'INSERT INTO
                        gs_kadai_user_table(
                            id, u_name, u_id, u_pw, life_flg, indate
                            )
                        VALUES (
                            NULL, :namename, :idid, :hashed_pw, 0, sysdate() 
                            );'
);



// 数値の場合 PDO::PARAM_INT
// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':namename', $namename, PDO::PARAM_STR);
$stmt->bindValue(':idid', $idid, PDO::PARAM_STR);
$stmt->bindValue(':hashed_pw', $hashed_pw, PDO::PARAM_STR); //PARAM_INTなので注意
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
