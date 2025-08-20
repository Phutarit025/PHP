<?php
session_start();
require_once 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username_or_email = trim($_POST['username_or_email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username_or_email, $username_or_email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id']; // ✅ ใช้คอลัมน์ id ให้ตรงกับ DB
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: admin/index.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        $error = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #74ebd5 0%, #9face6 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            max-width: 420px;
            width: 100%;
            border-radius: 15px;
            padding: 2rem;
            background: #fff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        .form-label {
            font-weight: 600;
        }
        .btn-custom {
            width: 100%;
            font-size: 1.1rem;
            padding: 0.6rem;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <h3 class="text-center mb-4">🔐 เข้าสู่ระบบ</h3>

        <!-- Alert สมัครสมาชิกสำเร็จ -->
        <?php if (isset($_GET['register']) && $_GET['register'] === 'succes'): ?>
            <div class="alert alert-success">✅ สมัครสมาชิกสำเร็จ กรุณาเข้าสู่ระบบ</div>
        <?php endif; ?>

        <!-- Alert ข้อผิดพลาด -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label for="username_or_email" class="form-label">ชื่อผู้ใช้หรืออีเมล</label>
                <input type="text" name="username_or_email" id="username_or_email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">รหัสผ่าน</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success btn-custom">เข้าสู่ระบบ</button>
            <a href="register.php" class="btn btn-link w-100 mt-2">ยังไม่มีบัญชี? สมัครสมาชิก</a>
        </form>
    </div>
</body>

</html>
