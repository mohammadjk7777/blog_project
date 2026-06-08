<?php
session_start();
include 'includes/db.php';

// گرفتن ۶ پست آخر
$post_query = "SELECT posts.*, users.username, categories.name AS cat_name 
               FROM posts 
               JOIN users ON posts.user_id = users.id 
               LEFT JOIN categories ON posts.category_id = categories.id 
               ORDER BY posts.created_at DESC LIMIT 6";
$post_result = mysqli_query($conn, $post_query);

$is_logged_in = isset($_SESSION['user_id']);
$user_role = $is_logged_in ? $_SESSION['role'] : '';
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>وبلاگ پیشرفته من</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="main-wrapper-sticky">
<header>
    <div class="logo">
        <?php 
            $page = basename($_SERVER['PHP_SELF'], ".php");
            if($page == 'index') echo "🏠 خانه";
            elseif($page == 'admin_dashboard') echo "⚙️ مدیریت";
            elseif($page == 'user_posts') echo "📝 پنل کاربری";
            else echo "وبلاگ محمد";
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

                <li><a href="logout.php" class="btn-modern-logout">خروج از حساب کاربری</a></li>

                
            <?php else: ?>
                <li><a href="register.php" class="btn-reg">ثبت‌نام</a></li>
                <li><a href="login.php" class="btn-login">ورود</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<div class="container">
    <div class="welcome-box">
        <div class="welcome-text">
            <h2 style="font-size: 2rem; margin-bottom: 10px;">سلام دنیا! خوش آمدید 🚀</h2>
            <p style="color: var(--gray-text);">اینجا مکانی برای اشتراک‌گذاری ایده‌های برنامه‌نویسی و طراحی است.</p>
        </div>
        <img src="images/ali.jpg" alt="Admin" class="profile-img">
    </div>

    <div class="grid-layout">
        <aside class="right-sidebar">
            <div class="widget">
                <h3 style="margin-bottom: 15px;">🗂 دسته بندی‌ها</h3>
                <?php
                $cat_query = "SELECT * FROM categories";
                $cat_res = mysqli_query($conn, $cat_query);
                while($c = mysqli_fetch_assoc($cat_res)): ?>
                    <a href="category.php?id=<?php echo $c['id']; ?>" class="topic-btn"><?php echo $c['name']; ?></a>
                <?php endwhile; ?>
            </div>
        </aside>

        <main class="content">
            <h3 style="margin-bottom: 20px;">📝 آخرین نوشته‌ها</h3>
            <?php if (mysqli_num_rows($post_result) > 0): ?>
                <?php while($post = mysqli_fetch_assoc($post_result)): ?>
                    <div class="card">
                        <div style="display:flex; justify-content:space-between;">
                            <span class="badge">توسط: <?php echo $post['username']; ?></span>
                            <span style="color:var(--orange-gold); font-size:0.8rem;">📁 <?php echo $post['cat_name'] ?? 'بدون موضوع'; ?></span>
                        </div>
                        <h2 style="margin: 15px 0; font-size: 1.4rem;"><?php echo $post['title']; ?></h2>
                        <p style="color: #555;"><?php echo mb_substr(strip_tags($post['content']), 0, 150) . "..."; ?></p>
                        <a href="post_single.php?id=<?php echo $post['id']; ?>" style="display:inline-block; margin-top:15px; color: var(--orange-gold); text-decoration: none; font-weight:bold;">ادامه مطالعه ←</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="card"><p>هنوز مطلبی منتشر نشده است.</p></div>
            <?php endif; ?>
        </main>

        <aside class="left-sidebar">
            <div class="widget">
                <h3 style="margin-bottom: 15px;">👤 وضعیت حساب</h3>
                <?php if ($is_logged_in): ?>
                    <p>سلام <b><?php echo $_SESSION['username']; ?></b></p>
                    <p style="font-size: 0.8rem; color: gray; margin-top:5px;">نقش شما: <?php echo ($user_role == 'admin' ? '🔴 مدیر سیستم' : '🔵 کاربر عادی'); ?></p>
                    <?php if ($user_role != 'admin'): ?>
                        <hr style="margin:10px 0; border:0; border-top:1px solid #eee;">
                        <a href="user_posts.php" style="font-size: 0.85rem; color: #3498db; text-decoration:none;">مدیریت نوشته‌های من ←</a>
                    <?php endif; ?>
                <?php else: ?>
                    <p style="font-size: 0.9rem;">شما به عنوان مهمان وارد شده‌اید.</p>
                <?php endif; ?>
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