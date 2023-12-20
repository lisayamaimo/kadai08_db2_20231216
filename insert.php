<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <style>
.birthday-message {
    color: #ffffff; /* 文字色 */
    background: linear-gradient(135deg, #fca5f1 0%, #b3ffff 100%); /* グラデーション背景 */
    padding: 20px;
    border-radius: 10px;
    font-family: 'Comic Sans MS', cursive, sans-serif; /* フォント */
    text-align: center;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* 影の効果 */
    position: relative;
    overflow: hidden; /* 背景の装飾のため */
}

    </style>
    <!-- <style>
.birthday-message {
    color: #ffffff; /* 文字色 */
    background: linear-gradient(135deg, #fca5f1 0%, #b3ffff 100%); /* グラデーション背景 */
    padding: 20px;
    border-radius: 10px;
    font-family: 'Comic Sans MS', cursive, sans-serif; /* フォント */
    text-align: center;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* 影の効果 */
    position: relative;
    overflow: hidden; /* 背景の装飾のため */
}
.birthday-message::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    right: -50%;
    bottom: -50%;
    background: radial-gradient(circle, transparent 20%, #fff 21%, #fff 22%, transparent 23%, transparent),
                radial-gradient(circle, transparent 20%, #fff 21%, #fff 22%, transparent 23%, transparent) 50px 50px;
    background-size: 100px 100px;
    z-index: 0;
    animation: float 3s ease-in-out infinite;
}
@keyframes float {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-20px);
    }
}
    </style> -->
</head>
<body>

<?php
//1. POSTデータ取得
$name = $_POST['name'];
$birthday = $_POST['birthday'];
$comment = $_POST['comment'];

//2. DB接続します
try {
    //ID:'root', Password: xamppは 空白 ''
    // $pdo = new PDO('mysql:dbname=gs_231220kadai;charset=utf8;host=localhost', 'root', '');
    $pdo = new PDO('mysql:dbname=gs_231220kadai;charset=utf8;host=127.0.0.1', 'root', '');
} catch (PDOException $e) {
    exit('DBConnectError:' . $e->getMessage());
}
//３．データ登録SQL作成

// 1. SQL文を用意
$stmt = $pdo->prepare("
    INSERT INTO
        gs_231220kadai(name, birthday, comment)
    VALUES (
        :name, :birthday, :comment
        )");

//  2. バインド変数を用意
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':birthday', $birthday, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);

// //  3. 実行
$status = $stmt->execute();

//４．データ登録処理後
if($status === false) {
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit('ErrorMessage:' . $error[2]);
} else {
    //５．index.phpへリダイレクト
    // 成功した場合
    // echo 'test';
    // header('Location: index.php');
    echo '<div class="birthday-message">
        書き込みありがとうございます！<br>
        みんなの欲しいもの一覧は<a href="./select.php">コチラ💁</a>
        </div>';
}
?>