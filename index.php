<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าหลัก</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f6f9;
        }
        .welcome-card {
            max-width: 600px;
            margin: 80px auto;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        .logout-btn {
            width: 100%;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">🏠 ระบบจัดการ</a>
            <div class="d-flex">
                <span class="navbar-text text-white me-3">
                    <?= htmlspecialchars($_SESSION['username']) ?> (<?= htmlspecialchars($_SESSION['role']) ?>)
                </span>
                <a href="logout.php" class="btn btn-outline-light">ออกจากระบบ</a>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container">
        <div class="card welcome-card p-4 text-center">
            <h2 class="mb-3">👋 ยินดีต้อนรับ</h2>
            <p class="lead">
                คุณได้เข้าสู่ระบบในฐานะ  
                <strong><?= htmlspecialchars($_SESSION['role']) ?></strong>
            </p>
            <a href="logout.php" class="btn btn-danger logout-btn mt-3">🚪 ออกจากระบบ</a>
        </div>
    </div>
</body>

</html>
