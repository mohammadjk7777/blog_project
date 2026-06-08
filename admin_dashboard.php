<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("<div style='text-align:center; margin-top:50px; font-family:Tahoma;'><h2>دسترسی غیرمجاز! ⛔</h2><a href='index.php'>برگشت به خانه</a></div>");
}

if (isset($_GET['delete_post'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete_post']);
    mysqli_query($conn, "DELETE FROM posts WHERE id = '$id'");
    header("Location: admin_dashboard.php?tab=posts");
}

if (isset($_GET['delete_user'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete_user']);
    if ($id != $_SESSION['user_id']) { 
        mysqli_query($conn, "DELETE FROM users WHERE id = '$id'");
    }
    header("Location: admin_dashboard.php?tab=users");
}

$tab = $_GET['tab'] ?? 'posts'; 
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>پنل مدیریت | داشبورد</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .admin-nav { display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        .tab-btn { padding: 10px 20px; text-decoration: none; color: #666; border-radius: 8px; transition: 0.3s; background: #f9f9f9; }
        .tab-btn.active { background: #34495e; color: white; }
        .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 12px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-bottom: 4px solid #f1c40f; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 12px; overflow: hidden; }
        th, td { padding: 15px; text-align: center; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; }
        .action-btns a { margin: 0 5px; text-decoration: none; font-weight: bold; font-size: 0.8rem; }
        .btn-edit { color: #3498db; }
        .btn-del { color: #e74c3c; }
    </style>
</head>
<body>

<div class="main-wrapper-sticky">


    <div class="container" style="margin-top: 30px;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; background: white; padding: 15px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            <h2 style="margin: 0;">🛠 مدیریت کل وبلاگ</h2>
            <a href="index.php" class="btn-home-icon-small" title="برگشت به سایت اصلی" style="text-decoration: none; font-size: 1.5rem;">🏠</a>
        </div>

        <div class="admin-nav">
            <a href="?tab=posts" class="tab-btn <?php echo $tab == 'posts' ? 'active' : ''; ?>">📝 مدیریت نوشته‌ها</a>
            <a href="?tab=users" class="tab-btn <?php echo $tab == 'users' ? 'active' : ''; ?>">👥 مدیریت کاربران</a>
        </div>

        <div class="card" style="padding: 20px;">
            <?php if ($tab == 'posts'): ?>
                <div style="display:flex; justify-content:space-between; margin-bottom:15px; align-items:center;">
                    <h3>لیست نوشته‌ها</h3>
                    <a href="add_post.php" class="btn-modern-add">+ مطلب جدید</a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>عنوان</th>
                            <th>نویسنده</th>
                            <th>تاریخ</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $posts = mysqli_query($conn, "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY created_at DESC");
                        while ($p = mysqli_fetch_assoc($posts)): ?>
                            <tr>
                                <td><?php echo $p['title']; ?></td>
                                <td><span class="badge"><?php echo $p['username']; ?></span></td>
                                <td><?php echo date('Y/m/d', strtotime($p['created_at'])); ?></td>
                                <td class="action-btns">
                                    <a href="edit_post.php?id=<?php echo $p['id']; ?>" class="btn-edit">✏️ ویرایش</a>
                                    <a href="admin_dashboard.php?delete_post=<?php echo $p['id']; ?>" class="btn-del" onclick="return confirm('حذف شود؟')">🗑 حذف</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

            <?php else: ?>
                <div style="display:flex; justify-content:space-between; margin-bottom:15px; align-items:center;">
                    <h3>لیست کاربران</h3>
                    <a href="add_user.php" class="btn-modern-add" style="background:#2ecc71;">+ افزودن کاربر</a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>نام کاربری</th>
                            <th>رمز عبور</th>
                            <th>نقش</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $users = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
                        while ($u = mysqli_fetch_assoc($users)): ?>
                            <tr>
                                <td><?php echo $u['username']; ?></td>
                                <td style="color:#7f8c8d; font-size:0.8rem;"><?php echo $u['password']; ?></td>
                                <td><?php echo ($u['role'] == 'admin') ? '🔴 مدیر' : '🔵 کاربر'; ?></td>
                                <td class="action-btns">
                                    <a href="edit_user.php?id=<?php echo $u['id']; ?>" class="btn-edit">✏️ ویرایش</a>
                                    <?php if ($u['id'] != $_SESSION['user_id']): ?>
                                        <a href="admin_dashboard.php?delete_user=<?php echo $u['id']; ?>" class="btn-del" onclick="return confirm('کاربر حذف شود؟')">🗑 حذف</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>


</body>
</html>