<?php
require_once 'config.php';
$error = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับค่าจาก form
    $username = trim($_POST['username']);
    $fname = trim($_POST['fname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // ตรวจสอบว่าข้อมูลครบหรือไม่
    if (empty($username) || empty($fname) || empty($email) || empty($password) || empty($cpassword)) {
        $error[] = "กรุณากรอกข้อมูลให้ครบทุกช่อง";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "อีเมลไม่ถูกต้อง";
    } elseif ($password !== $cpassword) {
        $error[] = "รหัสผ่านไม่ตรงกัน";
    } else {
        // ตรวจสอบว่ามี username หรือ email นี้แล้วหรือยัง
        $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username, $email]);

        if ($stmt->rowCount() > 0) {
            $error[] = "ชื่อผู้ใช้หรืออีเมลนี้ถูกใช้ไปแล้ว";
        }
    }


    if (empty($error)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(username, full_name, email, password, role) 
                VALUES (?, ?, ?, ?, 'member')";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username, $fname, $email, $hashedPassword]);

        header("Location: login.php?register=success");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Register</title>
</head>
<style>
    body {
        background: linear-gradient(to bottom, #e0f7fa, #ffffff);
        font-family: 'Sarabun', sans-serif;
        color: #333333;
    }

    .container {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 35px;
        max-width: 600px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #0277bd;
    }

    label {
        color: #01579b;
        font-weight: 600;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #81d4fa;
        padding: 10px;
    }

    .form-control:focus {
        border-color: #0288d1;
        box-shadow: 0 0 5px rgba(2, 136, 209, 0.5);
    }

    .btn-primary {
        background-color: #0288d1;
        border-color: #0288d1;
        font-weight: 600;
    }

    .btn-primary:hover {
        background-color: #03a9f4;
        border-color: #03a9f4;
    }

    a.btn-link {
        color: #01579b;
        font-weight: 500;
    }

    a.btn-link:hover {
        text-decoration: underline;
        color: #0288d1;
    }
</style>

<body>

    <div class="container mt-5">
        <h2> Register </h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($error as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <div>
                <label for="username" class="form-label">User</label>
                <input type="text" name="username" class="form-control" id="username" placeholder="ชื่่อผู้ใช้"
                    <?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>required>
            </div>
            <div>
                <label for="fname" class="form-label">Full Name</label>
                <input type="text" name="fname" class="form-control" id="fname" placeholder="ชื่อ - นามสกุล"
                    <?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>required>
            </div>
            <div>
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="อีเมล"
                    <?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>required>
            </div>
            <div>
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="รหัสผ่าน"
                    required>
            </div>
            <div>
                <label for="cpassword" class="form-label">Confirm Password</label>
                <input type="password" name="cpassword" class="form-control" id="cpassword" placeholder="ยืนยันรหัสผ่าน"
                    required>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Register</button>
                <a href="login.php" class="btn btn-link">Login</a>
            </div>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>