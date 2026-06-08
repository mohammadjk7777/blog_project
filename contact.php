<?php
session_start();
include 'includes/db.php';

$is_logged_in = isset($_SESSION['user_id']);
$user_role = $is_logged_in ? $_SESSION['role'] : '';
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تماس با ما | وبلاگ شخصی</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="main-wrapper-sticky">
<header>
    <div class="logo">
        <?php 
            $page = basename($_SERVER['PHP_SELF'], ".php");
            if($page == 'index') echo "خانه";
            elseif($page == 'add_post') echo "انتشار مطلب";
            elseif($page == 'post_single') echo "مشاهده نوشته";
            elseif($page == 'category') echo "گروه بندی";
            elseif($page == 'contact') echo "تماس با ما";
            elseif($page == 'about') echo "درباره من";
            elseif($page == 'admin_dashboard') echo "مدیریت سیستم";
            else echo "پنل وبلاگ";
        ?>
    </div>
    <nav>
        <ul>
            <li><a href="index.php">خانه</a></li>
            <li><a href="about.php">درباره ما</a></li>
             <li><a href="contact.php">تماس با ما</a></li>
             <?php if ($is_logged_in): ?>
                <li><a href="add_post.php" class="btn-modern-add">+ مطلب جدید</a></li>
                
                <?php if ($user_role == 'admin'): ?>
                    <li><a href="admin_dashboard.php" class="btn-modern-admin">⚙️ مدیریت</a></li>
                <?php else: ?>
                    <li><a href="user_posts.php" class="btn-modern-admin" style="background: #3498db;">📝 نوشته‌های من</a></li>
                <?php endif; ?>

            <?php else: ?>
                <li><a href="register.php" class="btn-reg">ثبت‌نام</a></li>
                <li><a href="login.php" class="btn-login">ورود</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

    <div class="container">
        <div class="grid-layout">
            <aside class="right-sidebar">
                <div class="widget">
                    <h3 style="margin-bottom: 15px; font-size: 1rem;">📍 اطلاعات تماس</h3>
                    <p style="font-size: 0.8rem; margin-bottom: 10px;">📧 ایمیل: mohammad.jk.7777@gmail.com</p>
                </div>
            </aside>

            <main class="content">
                <div class="card">
                    <h2 style="margin-bottom: 20px; color: var(--dark-blue);">ارسال پیام مستقیم</h2>
                    <form action="" method="POST">
                        <div class="form-group">
                            <label>نام شما</label>
                            <input type="text" placeholder="نام خود را وارد کنید..." required>
                        </div>
                        <div class="form-group">
                            <label>موضوع پیام</label>
                            <input type="text" placeholder="موضوع چیست؟" required>
                        </div>
                        <div class="form-group">
                            <label>متن پیام</label>
                            <textarea style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 10px; font-family: 'Vazirmatn'; min-height: 150px;" placeholder="پیام خود را اینجا بنویسید..."></textarea>
                        </div>
                        <button type="submit" class="btn-submit" style="background: var(--accent-blue);">ارسال پیام 🚀</button>
                    </form>
                </div>
            </main>

            <aside class="left-sidebar">
                <div class="widget" style="text-align: center;">
                    <h3 style="margin-bottom: 15px; font-size: 1rem;">🕒 ساعات پاسخگویی</h3>
                    <p style="font-size: 0.8rem;">شنبه تا چهارشنبه<br>۹ صبح تا ۶ عصر</p>
                </div>
            </aside>
        </div>
    </div>
</div>
<footer>
    طراحی و اجرا توسط <b>محمد جعفر کریمی</b> ❤️ 2026 🚀
</footer>
</body>
</html>