<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //รับค่าจาก form 
    $username = trim($_POST['username']);
    $fname = trim($_POST['fname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];


    //นำข้อมูลบันทึกลงฐานข้อมูล
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users(username,full_name,email,password,role) VALUES (?,?,?,?,'admin')";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username, $fname, $email, $hashedPassword]);


}


?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>register</title>
</head>
<style>
    body {
        background: linear-gradient(to bottom, #e0f7fa, #ffffff); /* ฟ้าอ่อน → ขาว */
        font-family: 'Sarabun', sans-serif;
        color: #333333; /* ตัวอักษรมืด อ่านง่าย */
    }

    .container {
        background-color: #ffffff; /* ขาวล้วน */
        border-radius: 12px;
        padding: 35px;
        max-width: 600px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15); /* เงานุ่ม */
    }

    h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #0277bd; /* ฟ้าเข้ม */
    }

    label {
        color: #01579b; /* ฟ้าเข้มกว่าเล็กน้อย */
        font-weight: 600;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #81d4fa; /* ฟ้าอ่อน */
        padding: 10px;
    }

    .form-control:focus {
        border-color: #0288d1;
        box-shadow: 0 0 5px rgba(2, 136, 209, 0.5);
    }

    .btn-primary {
        background-color: #0288d1; /* ฟ้าเข้ม */
        border-color: #0288d1;
        font-weight: 600;
    }

    .btn-primary:hover {
        background-color: #03a9f4; /* ฟ้าอ่อนเมื่อ hover */
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
        <form action="" method="post">
            <div>
                <label for="username" class="form-label">User</label>
                <input type="text" name="username" class="form-control" id="username" placeholder="ชื่่อผู้ใช้"
                    required>
            </div>
            <div>
                <label for="fname" class="form-label">Full Name</label>
                <input type="text" name="fname" class="form-control" id="fname" placeholder="ชื่อ - นามสกุล" required>
            </div>
            <div>
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="อีเมล" required>
            </div>
            <div>
                <label for="password" class="form-label">Password</label>
                <input type="text" name="password" class="form-control" id="password" placeholder="รหัสผ่าน" required>
            </div>
            <div>
                <label for="cpassword" class="form-label">Confirm Password</label>
                <input type="text" name="cpassword" class="form-control" id="cpassword" placeholder="ยืนยันรหัสผ่าน"
                    required>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Register</button>
                <a href="login.php" class="btn btn-link">Login</a>
            </div>

        </form>

    </div>

    <?php

    //comnect database ด้วย my SQL
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "online_shop";

    $dns = "mysql:host=$host;dbname=$database";

    //   $conn = new mysqli($host,$username,$password,$database,);
    
    //   if($conn -> connect_error){
    //       die(" เชื่อมต่อไม่สำเร็จ : " . $conn->connect_error);
    //   }else{
    //       echo "เชื่อมต่อสำเร็จ";
    //  }
    
    //connect database ด้วย PDO
    try {
        //$conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        $conn = new PDO($dns, $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo " PDO : เชื่อมต่อสำเร็จ ";
    } catch (PDOException $e) {
        echo " เชื่อมต่อไม่สำเร็จ: " . $e->getMessage();
    }













    ?>
















    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>