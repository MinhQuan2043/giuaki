<?php
include 'config.php';
$MaSV = $_GET['MaSV'];
$sql = "SELECT * FROM SinhVien WHERE MaSV='$MaSV'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "DELETE FROM SinhVien WHERE MaSV='$MaSV'";
    $conn->query($sql);
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xóa sinh viên</title>
    <style>
        /* CSS chung */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            text-align: center;
            padding: 20px;
        }

        h2 {
            color: #d9534f;
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

        /* Container xóa */
        .delete-container {
            width: 50%;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin: auto;
            text-align: left;
        }

        .delete-container p {
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

        .buttons input[type="submit"] {
            padding: 10px 15px;
            background:rgb(82, 46, 45);
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }

        .buttons input[type="submit"]:hover {
            background: #c9302c;
        }

        .buttons a {
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

    <h2>XÓA THÔNG TIN SINH VIÊN</h2>
    <div class="delete-container">
        <p><strong>Họ Tên:</strong> <?= $row['HoTen'] ?></p>
        <p><strong>Giới Tính:</strong> <?= ($row['GioiTinh'] == 1) ? "Nam" : "Nữ"; ?></p>
        <p><strong>Ngày Sinh:</strong> <?= date("d-m-Y", strtotime($row['NgaySinh'])); ?></p>
        <p><img src="uploads/<?= $row['Hinh']; ?>" width="150"></p>
        <p><strong>Mã Ngành:</strong> <?= $row['MaNganh']; ?></p>

        <form method="POST" class="buttons">
            <input type="submit" value="Xóa">
            <a href="index.php">Quay lại</a>
        </form>
    </div>
</body>
</html>
