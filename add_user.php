<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { die("دسترسی غیرمجاز!"); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']); 
    $role = $_POST['role'];

    mysqli_query($conn, "INSERT INTO users (username, email, password, role) VALUES ('$user', '$email', '$pass', '$role')");
    header("Location: admin_dashboard.php?tab=users&msg=added");
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>افزودن کاربر</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="main-wrapper-sticky">
    <div class="container" style="max-width: 500px; margin-top: 30px;">
        <div class="card">
            <h3>👤 افزودن کاربر جدید</h3>
            <form action="" method="POST" style="margin-top:20px;">
                <input type="text" name="username" placeholder="نام کاربری" required style="width:100%; margin-bottom:10px; padding:10px; border-radius:8px; border:1px solid #ddd;">
                <input type="email" name="email" placeholder="ایمیل" required style="width:100%; margin-bottom:10px; padding:10px; border-radius:8px; border:1px solid #ddd;">
                <input type="password" name="password" placeholder="رمز عبور" required style="width:100%; margin-bottom:10px; padding:10px; border-radius:8px; border:1px solid #ddd;">
                <select name="role" style="width:100%; margin-bottom:15px; padding:10px; border-radius:8px; border:1px solid #ddd; background:white; color:black; appearance:auto;">
                    <option value="user">کاربر عادی</option>
                    <option value="admin">مدیر (Admin)</option>
                </select>
                <button type="submit" class="btn-modern-add" style="width:100%; border:none; padding:12px; cursor:pointer;">ثبت کاربر</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>