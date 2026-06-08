<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO posts (user_id, category_id, title, content) VALUES ('$user_id', '$category_id', '$title', '$content')";
    if (mysqli_query($conn, $sql)) {
        $message = "<div style='background:#d4edda; color:#155724; padding:10px; border-radius:6px; margin-bottom:15px; border:1px solid #c3e6cb; font-size:0.85rem;'>✅ پست جدید با موفقیت منتشر شد!</div>";
    }
}

$categories_result = mysqli_query($conn, "SELECT * FROM categories");
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>افزودن مطلب جدید</title>
    <link rel="stylesheet" href="css/style.css">
    <style>

            .form-row {
            display: flex;
            gap: 15px; 
            margin-bottom: 15px;
        }
        .form-group-half {
            flex: 1;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 0.85rem; 
            color: #444;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-family: 'Vazirmatn', sans-serif;
            font-size: 0.9rem; 
        }
        textarea {
            resize: vertical;
            min-height: 150px; 
        }
        select option {
            background-color: #fff !important;
            color: #000 !important;
        }
        .btn-submit {
            width: 100%;
            padding: 10px;
            background: var(--dark-blue);
            border: none;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: bold;
        }
        .card {
            padding: 20px !important; 
        }
        h2 {
            font-size: 1.4rem !important; 
            margin-bottom: 20px !important;
        }
        @media (max-width: 600px) {
            .form-row { flex-direction: column; gap: 10px; }
        }
    </style>
</head>
<body>
<div class="main-wrapper-sticky">
    <header>
        <div class="logo" style="font-size: 1.2rem;">نوشته جدید</div>
        <nav>
            <ul style="font-size: 0.9rem;">
                <li><a href="index.php" class="btn-modern-logout">بازکشت</a></li>

            </ul>
        </nav>
    </header>

    <div class="container" style="max-width: 800px;"> <div class="grid-layout" style="display: block;"> 
            <main class="content">
                <div class="card">
                    <h2 style="border-right: 4px solid var(--orange-gold); padding-right: 12px;">📝 انتشار نوشته جدید</h2>
                    
                    <?php echo $message; ?>
                    
                    <form action="" method="POST">
                        <div class="form-row">
                            <div class="form-group-half">
                                <label>📌 عنوان مطلب</label>
                                <input type="text" name="title" required placeholder="عنوان نوشته...">
                            </div>
                            <div class="form-group-half">
                                <label>📁 انتخاب موضوع</label>
                                <select name="category_id" required style="background: white; appearance: auto;">
                                    <option value="">-- انتخاب کنید --</option>
                                    <?php while($cat = mysqli_fetch_assoc($categories_result)): ?>
                                        <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 20px;">
                            <label>📄 محتوای مطلب</label>
                            <textarea name="content" required placeholder="متن خود را اینجا بنویسید..."></textarea>
                        </div>

                        <button type="submit" class="btn-submit">
                            🚀 انتشار در وبلاگ
                        </button>
                    </form>
                </div>
            </main>
        </div>
    </div>
</div>

<footer >
    طراحی و اجرا توسط <b>محمد جعفر کریمی</b> ❤️ 2026 🚀
</footer>
</body>
</html>