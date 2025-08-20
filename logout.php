<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ออกจากระบบ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Sarabun', sans-serif;
        }
        .logout-card {
            background: #fff;
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
            max-width: 400px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }
        .logout-card h2 {
            color: #d84315;
            margin-bottom: 1rem;
        }
        .logout-card p {
            color: #555;
        }
    </style>
    <meta http-equiv="refresh" content="3;url=login.php">
</head>
<body>
    <div class="logout-card">
        <h2>👋 ออกจากระบบสำเร็จ</h2>
        <p>คุณได้ออกจากระบบเรียบร้อยแล้ว</p>
        <p class="small text-muted">กำลังพาไปที่หน้าเข้าสู่ระบบภายใน <strong>3 วินาที</strong>...</p>
        <a href="login.php" class="btn btn-primary mt-3">ไปที่หน้าเข้าสู่ระบบทันที</a>
    </div>
</body>
</html>
