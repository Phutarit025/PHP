<?php
require_once 'config.php';
$error = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $fname = trim($_POST['fname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if (empty($username) || empty($fname) || empty($email) || empty($password) || empty($cpassword)) {
        $error[] = "กรุณากรอกข้อมูลให้ครบทุกช่อง";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "อีเมลไม่ถูกต้อง";
    } elseif ($password !== $cpassword) {
        $error[] = "รหัสผ่านไม่ตรงกัน";
    } else {
        $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username, $email]);
        if ($stmt->rowCount() > 0) {
            $error[] = "ชื่อผู้ใช้หรืออีเมลนี้ถูกใช้ไปแล้ว";
        }
    }

    if (empty($error)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users(username, full_name, email, password, role) VALUES (?, ?, ?, ?, 'member')";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username, $fname, $email, $hashedPassword]);

        header("Location: login.php?register=success");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #74ebd5 0%, #9face6 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Sarabun', sans-serif;
        }

        .register-card {
            background: #fff;
            border-radius: 15px;
            padding: 2rem;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-weight: bold;
            color: #0277bd;
        }

        .form-label i {
            margin-right: 6px;
            color: #0288d1;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px;
        }

        .btn-custom {
            width: 100%;
            padding: 10px;
            font-size: 1.1rem;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="register-card">
        <h2><i class="bi bi-person-plus-fill"></i> สมัครสมาชิก</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($error as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="mb-3">
                <label for="username" class="form-label"><i class="bi bi-person-circle"></i>ชื่อผู้ใช้</label>
                <input type="text" name="username" class="form-control" id="username"
                    value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="fname" class="form-label"><i class="bi bi-card-text"></i>ชื่อ - นามสกุล</label>
                <input type="text" name="fname" class="form-control" id="fname"
                    value="<?= isset($_POST['fname']) ? htmlspecialchars($_POST['fname']) : '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label"><i class="bi bi-envelope-fill"></i>อีเมล</label>
                <input type="email" name="email" class="form-control" id="email"
                    value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label"><i class="bi bi-lock-fill"></i>รหัสผ่าน</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>
            <div class="mb-3">
                <label for="cpassword" class="form-label"><i class="bi bi-shield-lock-fill"></i>ยืนยันรหัสผ่าน</label>
                <input type="password" name="cpassword" class="form-control" id="cpassword" required>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-custom">สมัครสมาชิก</button>
                <a href="login.php" class="btn btn-outline-secondary btn-custom">มีบัญชีแล้ว? เข้าสู่ระบบ</a>
            </div>
        </form>
    </div>
</body>

</html>
