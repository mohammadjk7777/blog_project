<?php
session_start();
include 'includes/db.php'; 

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; 

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; 
            
            header("Location: index.php");
            exit();
        } else {
            $error = "رمز عبور اشتباه است!";
        }
    } else {
        $error = "نام کاربری یافت نشد!";
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ورود | وبلاگ من</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="display: flex; align-items: center; justify-content: center; min-height: 100vh; background-color: #f0f3f6; margin:0;">

    <div class="form-container">
        <h2 style="text-align: center; margin-bottom: 5px; color: var(--dark-blue); font-size: 1.8rem;">خوش آمدید ✨</h2>
        <p style="text-align: center; color: #7f8c8d; margin-bottom: 30px; font-size: 0.9rem;">لطفاً برای دسترسی به حساب خود وارد شوید</p>

        <?php if($error): ?>
            <div style="background: #fff5f5; color: #c0392b; padding: 12px; border-radius: 10px; margin-bottom: 20px; text-align: center; font-size: 0.85rem; border: 1px solid #feb2b2;">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>نام کاربری</label>
                <input type="text" name="username" placeholder="Username" required>
            </div>

            <div class="form-group">
                <label>رمز عبور</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-submit" style="margin-top: 10px; background-color: var(--orange-gold);">ورود به حساب</button>
        </form>

        <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 30px; border-top: 1px solid #f0f0f0; padding-top: 20px;">
            <div style="font-size: 0.9rem;">
                <span style="color: #95a5a6;">عضو نیستید؟</span>
                <a href="register.php" style="color: var(--dark-blue); text-decoration: none; margin-right: 5px; border-bottom: 2px solid var(--orange-gold);">ثبت‌نام کنید</a>
            </div>
            
            <a href="index.php" class="btn-home-icon-small" title="برگشت به سایت">🏠</a>
        </div>
    </div>

</body>
</html>