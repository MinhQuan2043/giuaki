<?php
$servername = "localhost"; // hoặc "127.0.0.1"
$username = "root"; 
$password = ""; // Nếu bạn chưa đặt mật khẩu cho root thì để trống
$database = "test1"; 
$port = 3306; // 

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $database, $port);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
} else {
    echo "Kết nối thành công!";
}
?>