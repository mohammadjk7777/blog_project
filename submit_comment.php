<?php
session_start();
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    
    $post_id = mysqli_real_escape_string($conn, $_POST['post_id']);
    $user_id = $_SESSION['user_id'];
    $comment_text = mysqli_real_escape_string($conn, $_POST['comment_text']);

    if (!empty(trim($comment_text))) {
        $sql = "INSERT INTO comments (post_id, user_id, comment_text) VALUES ('$post_id', '$user_id', '$comment_text')";
        mysqli_query($conn, $sql);
    }
    
    header("Location: post_single.php?id=" . $post_id);
} else {
    header("Location: index.php");
}
?>