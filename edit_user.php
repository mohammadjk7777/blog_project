<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { die("دسترسی غیرمجاز!"); }

$id = mysqli_real_escape_string($conn, $_GET['id']);
$user_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = '$id'"));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = $_POST['role'];
    
if (!empty($_POST['password'])) {
    $pass = mysqli_real_escape_string($conn, $_POST['password']); // ذخیره مستقیم رمز
    mysqli_query($conn, "UPDATE users SET email='$email', role='$role', password='$pass' WHERE id='$id'");
} else {
    mysqli_query($conn, "UPDATE users SET email='$email', role='$role' WHERE id='$id'");
}
    header("Location: admin_dashboard.php?tab=users&msg=updated");
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ویرایش کاربر</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .card-header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="main-wrapper-sticky">

    <div class="container" style="max-width: 500px; margin-top: 50px;">
        <div class="card">
            <div class="card-header-flex">
                <h3 style="margin:0;">✏️ ویرایش کاربر: <?php echo $user_data['username']; ?></h3>
                <a href="index.php" class="btn-home-icon-small" title="برگشت به صفحه اصلی" style="text-decoration: none;">🏠</a>
            </div>

            <form action="" method="POST">
                <label>ایمیل</label>
                <input type="email" name="email" value="<?php echo $user_data['email']; ?>" style="width:100%; margin-bottom:15px; padding:10px; border-radius:8px; border:1px solid #ddd;">
                
                <label>تغییر رمز (اگر نمی‌خواهید تغییر دهید خالی بگذارید)</label>
                <input type="password" name="password" placeholder="رمز عبور جدید..." style="width:100%; margin-bottom:15px; padding:10px; border-radius:8px; border:1px solid #ddd;">
                
                <label>نقش کاربری</label>
                <select name="role" style="width:100%; margin-bottom:20px; padding:10px; border-radius:8px; border:1px solid #ddd; background:white; color:black; appearance:auto;">
                    <option value="user" <?php if($user_data['role'] == 'user') echo 'selected'; ?>>کاربر عادی</option>
                    <option value="admin" <?php if($user_data['role'] == 'admin') echo 'selected'; ?>>مدیر</option>
                </select>
                
                <button type="submit" class="btn-modern-admin" style="width:100%; border:none; padding:12px; cursor:pointer; font-weight:bold;">به‌روزرسانی کاربر</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>