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
    <title>درباره من | وبلاگ شخصی</title>
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
            <li><a href="about.php">درباره ما</a></li> <li><a href="contact.php">تماس با ما</a></li>

                
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
                    <h3 style="margin-bottom: 15px; font-size: 1rem;">🗂 دسترسی سریع</h3>
                    <a href="index.php" class="topic-btn">🏠 بازگشت به خانه</a>
                    <a href="contact.php" class="topic-btn">📞 ارسال پیام</a>
                </div>
            </aside>

            <main class="content">
                <div class="card">
                    <h2 style="border-bottom: 2px solid var(--accent-blue); padding-bottom: 10px; margin-bottom: 20px;">کمی درباره من...</h2>
                    <div style="text-align: center; margin-bottom: 20px;">
                        <img src="images/ali.jpg" style="width: 150px; border-radius: 20px; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
                    </div>
                    <p style="line-height: 2; text-align: justify;">
                    سلام من محمد جعفر کریمی هستم این وبلاگ را برای پروژه نهایی درس طراحی وب ساخته ام 
                </p>
                    <h3 style="margin: 20px 0 10px 0;">مهارت‌های من:</h3>
                    <ul style="list-style: none; display: flex; gap: 10px; flex-wrap: wrap;">
                        <li class="badge" style="padding: 8px 15px;">PHP & MySQL</li>
                        <li class="badge" style="padding: 8px 15px;">HTML5 & CSS3</li>
                        <li class="badge" style="padding: 8px 15px;">JavaScript</li>
                    </ul>
                </div>
            </main>

            <aside class="left-sidebar">
                <div class="widget">
                    <h3 style="margin-bottom: 15px; font-size: 1rem;">🎓 تحصیلات</h3>
                    <p style="font-size: 0.85rem; color: #555;">دانشجوی مهندسی کامپیوتر - درس طراحی وب</p>
                </div>
            </aside>
        </div>
    </div>
</div>
<footer >
    طراحی و اجرا توسط <b>محمد جعفر کریمی</b> ❤️ 2026 🚀
</footer>
</body>
</html>