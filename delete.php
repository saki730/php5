<?php

$id = $_GET['id'];

//2. DB接続します
//*** function化する！  *****************
require_once('funcs.php'); //funcsを呼び出してくれる
$pdo = db_conn(); 

//３．データ登録SQL作成

// DELETE FROM テーブル名 WHERE id = :id
$stmt = $pdo->prepare('DELETE FROM gs_an_table WHERE id = :id; ');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status === false) {
    //*** function化する！******\
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    //*** function化する！*****************
    header('Location: select.php');
    exit();
}