<?php
include 'config.php';
$MaSV = $_GET['MaSV'];
$sql = "SELECT * FROM SinhVien WHERE MaSV='$MaSV'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hoten = $_POST['HoTen'];
    $gioitinh = $_POST['GioiTinh'];
    $ngaysinh = $_POST['NgaySinh'];
    $manganh = $_POST['MaNganh'];
    
    // Xử lý upload ảnh mới (nếu có)
    if ($_FILES['Hinh']['name']) {
        $hinh = $_FILES['Hinh']['name'];
        $target = "uploads/" . basename($hinh);
        
        // Kiểm tra và tạo thư mục nếu chưa có
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        if (move_uploaded_file($_FILES['Hinh']['tmp_name'], $target)) {
            $sql = "UPDATE SinhVien SET HoTen='$hoten', GioiTinh='$gioitinh', NgaySinh='$ngaysinh', Hinh='$hinh', MaNganh='$manganh' WHERE MaSV='$MaSV'";
        }
    } else {
        $sql = "UPDATE SinhVien SET HoTen='$hoten', GioiTinh='$gioitinh', NgaySinh='$ngaysinh', MaNganh='$manganh' WHERE MaSV='$MaSV'";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa sinh viên</title>
    <style>
        /* Định dạng chung */
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

        /* Form chỉnh sửa */
        .form-container {
            width: 40%;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin: auto;
        }

        label {
            font-weight: bold;
            display: block;
            text-align: left;
            margin-bottom: 5px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            transition: all 0.3s;
        }

        input:focus, select:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            outline: none;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        img {
            margin-top: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="menu">
        <a href="index.php">Sinh Viên</a> | <a href="#">Học Phần</a> | <a href="#">Đăng Ký</a> | <a href="#">Đăng Nhập</a>
    </div>

    <h2>Hiệu chỉnh thông tin sinh viên</h2>
    <div class="form-container">
        <form method="POST" enctype="multipart/form-data">
            <label>Họ Tên:</label>
            <input type="text" name="HoTen" value="<?= $row['HoTen'] ?>" required>

            <label>Giới Tính:</label>
            <select name="GioiTinh">
                <option value="1" <?= $row['GioiTinh'] == 1 ? "selected" : "" ?>>Nam</option>
                <option value="0" <?= $row['GioiTinh'] == 0 ? "selected" : "" ?>>Nữ</option>
            </select>

            <label>Ngày Sinh:</label>
            <input type="date" name="NgaySinh" value="<?= $row['NgaySinh'] ?>" required>

            <label>Ảnh hiện tại:</label>
            <img src="uploads/<?= $row['Hinh']; ?>" width="150"><br>
            <label>Cập nhật ảnh mới:</label>
            <input type="file" name="Hinh">

            <label>Ngành:</label>
            <input type="text" name="MaNganh" value="<?= $row['MaNganh'] ?>" required>

            <input type="submit" value="Lưu">
        </form>
    </div>
</body>
</html>
