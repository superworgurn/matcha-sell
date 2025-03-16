<?php
$servername = "localhost"; // หรือ IP address ของ MySQL server ของคุณ
$username = "root" // ชื่อผู้ใช้ฐานข้อมูลของคุณ
$password = ""; // รหัสผ่านฐานข้อมูลของคุณ
$dbname = "datasell"; // ชื่อฐานข้อมูลที่คุณต้องการเชื่อมต่อ

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}
echo "เชื่อมต่อฐานข้อมูลสำเร็จ";

// คุณสามารถดำเนินการกับฐานข้อมูลได้ที่นี่

$conn->close(); // ปิดการเชื่อมต่อเมื่อใช้งานเสร็จ
?>