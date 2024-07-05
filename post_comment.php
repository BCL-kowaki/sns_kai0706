<?php
session_start();
<<<<<<< HEAD

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
$comment_content = $_POST['comment_content'];
$post_id = $_POST['post_id']; // 投稿IDを取得
$timestamp = date("Y-m-d H:i:s");

$filepath = 'data/comments.csv';

$write_data = "{$post_id},{$comment_content},{$timestamp},{$user[0]}";

$file = fopen($filepath, 'a');
flock($file, LOCK_EX);

fwrite($file, $write_data . "\n");

flock($file, LOCK_UN);
fclose($file);

header("Location: timeline.php");
=======
include('functions.php');
$pdo = connect_to_db();

// エラーレポートを有効にする
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'] ?? '';
    $comment_text = $_POST['comment_text'] ?? '';
    $user_id = $_SESSION['user_id'] ?? ''; // ユーザーIDをセッションから取得
    $text_img = ''; // 初期化
    
    // コメント画像のアップロード処理
    if (!empty($_FILES['text_img']['name'])) {
        $target_dir = "data/uploads/";
        $fileType = strtolower(pathinfo($_FILES['text_img']['name'], PATHINFO_EXTENSION));
        $new_file_name = uniqid() . '.' . $fileType;
        $target_file = $target_dir . $new_file_name;
        if (move_uploaded_file($_FILES['text_img']['tmp_name'], $target_file)) {
            $text_img = $new_file_name;
        }
    }

    if ($post_id && $comment_text && $user_id) {
        // プロフィール画像と名前を取得
        $sql_user = 'SELECT profile_img, name FROM sns_regist_table WHERE user_id = :user_id';
        $stmt_user = $pdo->prepare($sql_user);
        $stmt_user->bindValue(':user_id', $user_id, PDO::PARAM_STR);
        $stmt_user->execute();
        $user = $stmt_user->fetch(PDO::FETCH_ASSOC);

        $profile_img = $user['profile_img'] ?? '';
        $name = $user['name'] ?? '';

        // コメントをデータベースに挿入
        $sql_insert = 'INSERT INTO sns_comment_table (post_id, user_id, profile_img, name, text, text_img, created_at) 
        VALUES (:post_id, :user_id, :profile_img, :name, :text, :text_img, NOW())';
        $stmt_insert = $pdo->prepare($sql_insert);
        $stmt_insert->bindValue(':post_id', $post_id, PDO::PARAM_STR);
        $stmt_insert->bindValue(':user_id', $user_id, PDO::PARAM_STR);
        $stmt_insert->bindValue(':profile_img', $profile_img, PDO::PARAM_STR);
        $stmt_insert->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt_insert->bindValue(':text', $comment_text, PDO::PARAM_STR);
        $stmt_insert->bindValue(':text_img', $text_img, PDO::PARAM_STR);
        $stmt_insert->execute();
    }

    // 投稿画面にリダイレクト
    header('Location: timeline.php');
    exit;
}
>>>>>>> 9c27de4 (編集・削除機能／いいね・コメント機能)
?>
