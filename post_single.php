<?php
session_start();
include 'includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$post_id = mysqli_real_escape_string($conn, $_GET['id']);

$sql = "SELECT posts.*, users.username, categories.name as cat_name 
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        LEFT JOIN categories ON posts.category_id = categories.id 
        WHERE posts.id = '$post_id'";

$result = mysqli_query($conn, $sql);
$post = mysqli_fetch_assoc($result);

if (!$post) {
    die("پست مورد نظر پیدا نشد!");
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title><?php echo $post['title']; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="main-wrapper-sticky">
    <header>
        <div class="logo">مشاهده نوشته</div>
        <nav>
            <ul>
               
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="add_post.php" class="btn-modern-add">+ مطلب جدید</a></li>
                    <li><a href="index.php" class="btn-modern-logout">بازکشت</a></li>

                <?php else: ?>
                    <li><a href="login.php" class="btn-login">ورود</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <div class="container" style="max-width: 900px; margin-top: 30px;">
        
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                <div>
                    <span class="badge" style="background: var(--orange-gold); color: #000;"><?php echo $post['cat_name'] ?? 'بدون دسته'; ?></span>
                    <h1 style="margin-top: 10px; color: var(--dark-blue);"><?php echo $post['title']; ?></h1>
                    <small style="color: #888;">نویسنده: <?php echo $post['username']; ?> | تاریخ: <?php echo date('Y/m/d', strtotime($post['created_at'])); ?></small>
                </div>
            </div>

            <div class="post-content" style="line-height: 1.8; text-align: justify; font-size: 1.1rem; color: #333;">
                <?php echo nl2br($post['content']); ?>
            </div>
        </div>

        <div class="card" style="margin-top: 30px;">
            <h3>💬 نظرات کاربران</h3>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <form action="submit_comment.php" method="POST" style="margin-top: 20px; border-bottom: 1px solid #eee; padding-bottom: 20px;">
                    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                    <textarea name="comment_text" placeholder="نظر خود را بنویسید..." required style="width:100%; padding:15px; border-radius:10px; border:1px solid #ddd; font-family:Vazirmatn; min-height:100px;"></textarea>
                    <button type="submit" class="btn-modern-add" style="border:none; margin-top:10px; cursor:pointer; width:150px;">ارسال نظر</button>
                </form>
            <?php else: ?>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-top: 15px;">
                    <p style="margin: 0;">برای ثبت نظر باید ابتدا <a href="login.php" style="color: var(--orange-gold); font-weight: bold;">وارد حساب خود</a> شوید.</p>
                </div>
            <?php endif; ?>

            <div style="margin-top: 25px;">
                <?php
                $comments_query = "SELECT comments.*, users.username FROM comments 
                                   JOIN users ON comments.user_id = users.id 
                                   WHERE post_id = '$post_id' ORDER BY created_at DESC";
                $comments_res = mysqli_query($conn, $comments_query);

                if (mysqli_num_rows($comments_res) > 0):
                    while ($comm = mysqli_fetch_assoc($comments_res)): ?>
                        <div style="background: #fff; border: 1px solid #f1f1f1; padding: 15px; border-radius: 10px; margin-bottom: 15px;">
                            <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                                <strong style="color: var(--dark-blue);"><?php echo $comm['username']; ?> می‌گوید:</strong>
                                <small style="color: #999;"><?php echo date('H:i - Y/m/d', strtotime($comm['created_at'])); ?></small>
                            </div>
                            <p style="color: #555; margin: 0;"><?php echo nl2br($comm['comment_text']); ?></p>
                        </div>
                    <?php endwhile;
                else: ?>
                    <p style="color: #999; text-align: center;">اولین کسی باشید که برای این پست نظر می‌گذارد!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<footer>
    طراحی و اجرا توسط <b>محمد جعفر کریمی</b> ❤️ 2026 🚀
</footer>

</body>
</html>