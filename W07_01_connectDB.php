<?php

use Dba\Connection;

// เชื่อมต่อฐานข้อมูลแบบ mysqli

//$host = "localhost";  // แก้ไขจาก 'loaclhost' เป็น 'localhost'
//$username = "root";
//$password = "";
//$database = "db68_product";

// เชื่อมต่อฐานข้อมูล
//$conn = mysqli_connect($host, $username, $password, $database);

// ตรวจสอบการเชื่อมต่อ
//if (!$conn) {
//  die("Connection failed: " . mysqli_connect_error());
//} else {
//  echo "Connected successfully";
//}

// ปิดการเชื่อมต่อ
//mysqli_close($conn);
$host = "localhost";  // แก้ไขจาก 'loaclhost' เป็น 'localhost'
$username = "root";
$password = "";
$database = "db68_product";
$dns = "mysql:host=$host;dbname=$database";

try {
    // $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $conn = new PDO($dns, $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "PDO : connected successfully";
} catch (PDOException $e) {
    echo "Connection failed :" . $e->getMessage();
}








?>