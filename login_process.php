<?php
<<<<<<< HEAD
session_start();

=======
ob_start(); // 出力バッファリングを開始
session_start();

// DB接続
include('functions.php');
$pdo = connect_to_db();

// エラーレポートを有効にする
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

>>>>>>> 9c27de4 (編集・削除機能／いいね・コメント機能)
// POSTデータを取得
if (!isset($_POST['identifier']) || !isset($_POST['password'])) {
    echo "ログインデータが不足しています。";
    exit();
}

$identifier = $_POST['identifier'];
$password = $_POST['password'];

<<<<<<< HEAD
// DB接続情報
$dbn ='mysql:dbname=gs_d15_06;charset=utf8mb4;port=3306;host=localhost';
$user = 'root';
$pwd = '';

// データベース接続
try {
    $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
    echo json_encode(["db error" => "{$e->getMessage()}"]);
    exit();
}

=======
>>>>>>> 9c27de4 (編集・削除機能／いいね・コメント機能)
// 認証関数
function authenticate($identifier, $password, $pdo) {
    // SQLクエリを準備
    $sql = 'SELECT * FROM sns_regist_table WHERE (user_id = :identifier OR mail = :identifier) AND password = :password';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':identifier', $identifier, PDO::PARAM_STR);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);
    $stmt->execute();

    // 結果を取得
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user_id'] = $user['user_id'];
        return true;
    } else {
        return false;
    }
}

// 認証処理
<<<<<<< HEAD
if (authenticate($identifier, $password, $pdo)) {
    echo "ログイン成功: ユーザーID " . $_SESSION['user_id']; // ここでデバッグ情報を表示
    header("Location: user_page.php");
=======
$user = authenticate($identifier, $password, $pdo);
if ($user) {
    echo "ログイン成功: ユーザーID " . $_SESSION['user_id']; // ここでデバッグ情報を表示
    if ($user['user_id'] === 'admin') {
        header("Location: regist_confirm.php");
    } else {
        header("Location: user_page.php");
    }
>>>>>>> 9c27de4 (編集・削除機能／いいね・コメント機能)
    exit();
} else {
    echo "ログインに失敗しました。";
}
?>
<<<<<<< HEAD
=======
?>
>>>>>>> 9c27de4 (編集・削除機能／いいね・コメント機能)
