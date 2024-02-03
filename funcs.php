<?php
//XSS対応（ echoする場所で使用！）
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

//DB接続関数：db_conn() 
//※関数を作成し、内容をreturnさせる。
//※ DBname等、今回の授業に合わせる。


//SQLエラー関数：sql_error($stmt)
function sql_error($stmt)
{
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit('SQLError:' . $error[2]);
}


//リダイレクト関数: redirect($file_name)

function db_conn()
{
    try {
        $db_name = 'gs_db3';    //データベース名
        $db_id   = 'root';      //アカウント名
        $db_pw   = '';      //パスワード：XAMPPはパスワード無しに修正してください。
        $db_host = 'localhost'; //DBホスト
        $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
        return $pdo;
    } catch (PDOException $e) {
        exit('DB Connection Error:' . $e->getMessage());
    }
}

function redirect($file_name)

{
    header("Location: $file_name");
    exit();
}

// ログインチェク処理 loginCheck()　ログインしないと入れないページにしたい時
function loginCheck()
{
    if (!isset($_SESSION['chk_ssid'])  ||  $_SESSION['chk_ssid']  !==  session_id()) {
        exit('LOGIN ERROR');
    } else {
        // ログイン済み処理
        session_regenerate_id(true);
        $_SESSION['chk_ssid'] = session_id();
    }
}