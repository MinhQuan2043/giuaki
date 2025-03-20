<?php
include 'config.php';
$MaSV = $_GET['MaSV'];
$sql = "SELECT * FROM SinhVien WHERE MaSV='$MaSV'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông tin sinh viên</title>
    <style>
        /* CSS chung */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            text-align: center;
            padding: 20px;
        }

        h2 {
            color: #333;
        }

        /* Menu */
        .menu {
            background: #007bff;
            padding: 10px;
            margin-bottom: 20px;
        }

        .menu a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            font-weight: bold;
        }

        .menu a:hover {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }

        /* Thông tin sinh viên */
        .info-container {
            width: 50%;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin: auto;
            text-align: left;
        }

        .info-container p {
            font-size: 18px;
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }

        img {
            display: block;
            margin: 10px auto;
            border-radius: 5px;
        }

        /* Nút */
        .buttons {
            margin-top: 15px;
        }

        .buttons a {
            display: inline-block;
            padding: 10px 15px;
            text-decoration: none;
            color: white;
            background: #007bff;
            border-radius: 5px;
            transition: 0.3s;
        }

        .buttons a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="menu">
        <a href="index.php">Sinh Viên</a> | <a href="#">Học Phần</a> | <a href="#">Đăng Ký</a> | <a href="#">Đăng Nhập</a>
    </div>

    <h2>Thông tin chi tiết</h2>
    <div class="info-container">
        <p><strong>Họ Tên:</strong> <?= $row['HoTen'] ?></p>
        <p><strong>Giới Tính:</strong> <?= ($row['GioiTinh'] == 1) ? "Nam" : "Nữ"; ?></p>
        <p><strong>Ngày Sinh:</strong> <?= date("d-m-Y", strtotime($row['NgaySinh'])); ?></p>
        <p><img src="uploads/<?= $row['Hinh']; ?>" width="150"></p>
        <p><strong>Mã Ngành:</strong> <?= $row['MaNganh']; ?></p>
    </div>

    <div class="buttons">
        <a href="edit.php?MaSV=<?= $row['MaSV']; ?>">Chỉnh sửa</a>
        <a href="index.php">Quay lại danh sách</a>
    </div>
</body>
</html>
