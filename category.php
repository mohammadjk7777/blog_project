<?php
session_start();
include 'includes/db.php';

$is_logged_in = isset($_SESSION['user_id']);
$user_role = $is_logged_in ? $_SESSION['role'] : '';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$cat_id = mysqli_real_escape_string($conn, $_GET['id']);

$cat_query = mysqli_query($conn, "SELECT name FROM categories WHERE id = '$cat_id'");
$cat_data = mysqli_fetch_assoc($cat_query);

if (!$cat_data) {
    die("دسته‌بندی یافت نشد!");
}

$post_query = "SELECT posts.*, users.username FROM posts 
               JOIN users ON posts.user_id = users.id 
               WHERE posts.category_id = '$cat_id' 
               ORDER BY posts.created_at DESC";
$post_result = mysqli_query($conn, $post_query);
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>دسته بندی: <?php echo $cat_data['name']; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="main-wrapper-sticky">
<header>
    <div class="logo">
        <?php 
            $page = basename($_SERVER['PHP_SELF'], ".php");
            if($page == 'category') echo "📁 گروه: " . $cat_data['name'];
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

                <?php else: ?>
                <li><a href="register.php" class="btn-reg">ثبت‌نام</a></li>
                <li><a href="login.php" class="btn-login">ورود</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

    <div class="container" style="margin-top: 30px;">
        <div class="grid-layout">
            <main class="content" style="grid-column: span 3;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                    <h3 style="margin:0;">📚 نوشته‌های گروه «<?php echo $cat_data['name']; ?>»</h3>
                    <a href="index.php" style="text-decoration:none; color:var(--orange-gold); font-size:0.9rem;">بازگشت به همه نوشته‌ها ←</a>
                </div>

                <?php if (mysqli_num_rows($post_result) > 0): ?>
                    <?php while($post = mysqli_fetch_assoc($post_result)): ?>
                        <div class="card">
                            <div style="display:flex; justify-content:space-between;">
                                <span class="badge">توسط: <?php echo $post['username']; ?></span>
                                <span style="color:var(--gray-text); font-size:0.8rem;">📅 <?php echo date('Y/m/d', strtotime($post['created_at'])); ?></span>
                            </div>
                            <h2 style="margin: 15px 0; font-size: 1.4rem;"><?php echo $post['title']; ?></h2>
                            <p style="color: #555;"><?php echo mb_substr(strip_tags($post['content']), 0, 180) . "..."; ?></p>
                            <a href="post_single.php?id=<?php echo $post['id']; ?>" style="display:inline-block; margin-top:15px; color: var(--orange-gold); text-decoration: none; font-weight:bold;">ادامه مطالعه ←</a>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="card" style="text-align: center; padding: 50px;">
                        <p style="color: #888;">در این دسته‌بندی هنوز مطلبی منتشر نشده است. 🏜️</p>
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </div>
</div>

<footer >
    طراحی و اجرا توسط <b>محمد جعفر کریمی</b> ❤️ 2026 🚀
</footer>
</body>
</html>