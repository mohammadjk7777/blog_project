<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}   

$current_user_id = $_SESSION['user_id'];

if (isset($_GET['delete_id'])) {
    $post_id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    mysqli_query($conn, "DELETE FROM posts WHERE id = '$post_id' AND user_id = '$current_user_id'");
    header("Location: user_posts.php?msg=deleted");
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>نوشته‌های من</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .user-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; background: #fff; padding: 15px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; }
        th, td { padding: 12px; text-align: center; border-bottom: 1px solid #eee; }
        th { background: #f4f7f6; color: #555; }
        .btn-edit { color: #3498db; text-decoration: none; font-weight: bold; margin-left: 10px; }
        .btn-delete { color: #e74c3c; text-decoration: none; font-weight: bold; }
    </style>
    
</head>
<body>



    <div class="container" style="margin-top: 30px;">
        
        <div class="user-header">
            <h2 style="margin:0;">📝 نوشته‌های منتشر شده توسط شما</h2>
            <a href="index.php" class="btn-home-icon-small" title="برگشت به سایت اصلی" style="text-decoration: none; font-size: 1.5rem;">🏠</a>

        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>عنوان مطلب</th>
                        <th>تاریخ انتشار</th>
                        <th>دسته بندی</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT posts.*, categories.name as cat_name 
                            FROM posts 
                            LEFT JOIN categories ON posts.category_id = categories.id 
                            WHERE posts.user_id = '$current_user_id' 
                            ORDER BY created_at DESC";
                    
                    $result = mysqli_query($conn, $sql);
                    
                    if (mysqli_num_rows($result) > 0):
                        while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><a href="post_single.php?id=<?php echo $row['id']; ?>" style="text-decoration:none; color:#333;"><?php echo $row['title']; ?></a></td>
                                <td><?php echo date('Y/m/d', strtotime($row['created_at'])); ?></td>
                                <td><span class="badge"><?php echo $row['cat_name'] ?? 'بدون دسته'; ?></span></td>
                                <td>
                                    <a href="edit_post.php?id=<?php echo $row['id']; ?>" class="btn-edit">✏️ ویرایش</a>
                                    <a href="user_posts.php?delete_id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('آیا از حذف این مطلب مطمئن هستید؟')">🗑 حذف</a>
                                </td>
                            </tr>
                        <?php endwhile;
                    else: ?>
                        <tr>
                            <td colspan="4" style="padding: 30px; color: #999;">شما هنوز هیچ مطلبی منتشر نکرده‌اید.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



</body>
</html>