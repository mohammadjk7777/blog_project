<?php
include 'includes/db.php';
$message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', 'user')";

    if (mysqli_query($conn, $sql)) {
        $message = "<div style='background: #e6fffa; color: #2c7a7b; padding: 12px; border-radius: 10px; margin-bottom: 20px; text-align: center; font-size: 0.85rem; border: 1px solid #b2f5ea;'>ثبت‌نام موفق! می‌توانید وارد شوید.</div>";
    } else {
        $message = "<div style='background: #fff5f5; color: #c0392b; padding: 12px; border-radius: 10px; margin-bottom: 20px; text-align: center; font-size: 0.85rem; border: 1px solid #feb2b2;'>خطا: نام کاربری یا ایمیل تکراری است.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ثبت‌نام | وبلاگ من</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="display: flex; align-items: center; justify-content: center; min-height: 100vh; background-color: #f0f3f6; margin:0;">

<div class="form-container" style="max-width: 450px;">
    <div style="text-align: center; margin-bottom: 30px;">
        <h2 style="font-size: 1.8rem; color: var(--dark-blue); margin-bottom: 5px;">عضویت در خانواده ما ✨</h2>
        <p style="color: #7f8c8d; font-size: 0.9rem;">برای شروع، اطلاعات خود را تکمیل کنید</p>
    </div>

    <?php echo $message; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label>🆔 نام کاربری</label>
            <input type="text" name="username" placeholder="Username" required style="direction: ltr; text-align: left;">
        </div>
        <div class="form-group">
            <label>📧 ایمیل</label>
            <input type="email" name="email" placeholder="example@gmail.com" required style="direction: ltr; text-align: left;">
        </div>
        <div class="form-group">
            <label>🔑 رمز عبور</label>
            <input type="password" name="password" placeholder="********" required style="direction: ltr; text-align: left;">
        </div>
        <button type="submit" class="btn-submit" style="background: var(--accent-blue); margin-top: 10px;">تایید و ساخت حساب</button>
    </form>

    <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 30px; border-top: 1px solid #f0f0f0; padding-top: 20px;">
        <div style="font-size: 0.9rem;">
            <span style="color: #95a5a6;">قبلاً ثبت‌نام کرده‌اید؟</span>
            <a href="login.php" style="color: var(--dark-blue); text-decoration: none; margin-right: 5px; border-bottom: 2px solid var(--orange-gold);">وارد شوید</a>
        </div>
        
        <a href="index.php" class="btn-home-icon-small" title="برگشت به سایت">🏠</a>
    </div>
</div>

</body>
</html>