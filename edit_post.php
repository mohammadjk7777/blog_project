<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$current_user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'];

$post_query = mysqli_query($conn, "SELECT * FROM posts WHERE id = '$id'");
$post = mysqli_fetch_assoc($post_query);

if (!$post) {
    die("نوشته مورد نظر یافت نشد!");
}

if ($user_role !== 'admin' && $post['user_id'] !== $current_user_id) {
    die("<div style='text-align:center; margin-top:50px; font-family:Tahoma;'><h2>شما اجازه ویرایش این مطلب را ندارید! ⛔</h2><a href='index.php'>برگشت به خانه</a></div>");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $cat_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    
    mysqli_query($conn, "UPDATE posts SET title='$title', content='$content', category_id='$cat_id' WHERE id='$id'");
    
    if ($user_role == 'admin') {
        header("Location: admin_dashboard.php?tab=posts&msg=updated");
    } else {
        header("Location: user_posts.php?msg=updated");
    }
}

$categories = mysqli_query($conn, "SELECT * FROM categories");
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ویرایش نوشته</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="main-wrapper-sticky">
    <header>
        <div class="logo">✏️ ویرایش مطلب</div>
        <nav>
            <ul>
                <?php if ($user_role == 'admin'): ?>
                    <li><a href="admin_dashboard.php" class="btn-modern-logout">برگشت به مدیریت</a></li>
                <?php else: ?>
                    <li><a href="user_posts.php" class="btn-modern-logout">برگشت به نوشته‌های من</a></li>
                <?php endif; ?>

            </ul>
        </nav>
    </header>

    <div class="container" style="max-width: 850px; margin-top: 40px;">
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                <h3 style="margin:0;">📝 ویرایش: <?php echo $post['title']; ?></h3>
                <a href="index.php" class="btn-home-icon-small" title="برگشت به سایت">🏠</a>
            </div>

            <form action="" method="POST">
                <div class="form-row" style="display:flex; gap:15px; margin-bottom:15px;">
                    <div style="flex:2;">
                        <label style="display:block; margin-bottom:5px;">عنوان نوشته</label>
                        <input type="text" name="title" value="<?php echo $post['title']; ?>" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                    </div>
                    <div style="flex:1;">
                        <label style="display:block; margin-bottom:5px;">دسته‌بندی</label>
                        <select name="category_id" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd; background:white; appearance:auto;">
                            <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                                <option value="<?php echo $cat['id']; ?>" <?php if($cat['id'] == $post['category_id']) echo 'selected'; ?>>
                                    <?php echo $cat['name']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <label style="display:block; margin-bottom:5px;">متن نوشته</label>
                <textarea name="content" rows="15" style="width:100%; padding:15px; border-radius:8px; border:1px solid #ddd; font-family:Vazirmatn; line-height:1.7;"><?php echo $post['content']; ?></textarea>
                
                <button type="submit" class="btn-modern-admin" style="width:100%; margin-top:20px; border:none; padding:12px; cursor:pointer; font-weight:bold;">✅ ذخیره تغییرات نهایی</button>
            </form>
        </div>
    </div>
</div>

<footer >
    طراحی و اجرا توسط <b>محمد جعفر کریمی</b> ❤️ 2026 🚀
</footer>

</body>
</html>