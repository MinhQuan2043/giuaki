<?php
$servername = "localhost"; // Thay đổi nếu cần
$username = "username"; // Tên đăng nhập
$password = "password"; // Mật khẩu
$dbname = "test1"; // Tên cơ sở dữ liệu

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

// Lấy dữ liệu từ form
$maSV = $_POST['maSV'];
$hoTen = $_POST['hoTen'];
$ngaySinh = $_POST['ngaySinh'];
$nganh = $_POST['nganh'];
$ngayDangKy = $_POST['ngayDangKy'];
$maHP = $_POST['maHP'];

// Thêm thông tin đăng ký vào bảng DangKy
$sqlDangKy = "INSERT INTO DangKy (NgayDK, MaSV) VALUES ('$ngayDangKy', '$maSV')";
if ($conn->query($sqlDangKy) === TRUE) {
    $maDK = $conn->insert_id; // Lấy MaDK mới nhất

    // Thêm các chi tiết vào bảng ChiTietDangKy
    foreach ($maHP as $hp) {
        $sqlChiTiet = "INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES ('$maDK', '$hp')";
        $conn->query($sqlChiTiet);
    }

    echo "<p>Thông báo đăng ký thành công!</p>";
    // Hiển thị thông tin đã lưu
    echo "<h3>Thông tin đăng ký:</h3>";
    echo "Mã số sinh viên: " . $maSV . "<br>";
    echo "Họ tên: " . $hoTen . "<br>";
    echo "Ngày sinh: " . $ngaySinh . "<br>";
    echo "Ngành học: " . $nganh . "<br>";
    echo "Ngày đăng ký: " . $ngayDangKy . "<br>";
} else {
    echo "Lỗi: " . $sqlDangKy . "<br>" . $conn->error;
}

$conn->close();
?>