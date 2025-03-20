<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hoten = $_POST['HoTen'];
    $gioitinh = $_POST['GioiTinh'];
    $ngaysinh = $_POST['NgaySinh'];
    $manganh = $_POST['MaNganh'];

    // Xử lý upload ảnh
    $hinh = $_FILES['Hinh']['name'];
    $target = "uploads/" . basename($hinh);

    // Kiểm tra và tạo thư mục nếu chưa tồn tại
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    if (move_uploaded_file($_FILES['Hinh']['tmp_name'], $target)) {
        $sql = "INSERT INTO SinhVien (HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) 
                VALUES ('$hoten', '$gioitinh', '$ngaysinh', '$hinh', '$manganh')";

        if ($conn->query($sql) === TRUE) {
            header("Location: index.php");
        } else {
            echo "Lỗi: " . $conn->error;
        }
    } else {
        echo "Lỗi khi tải ảnh lên.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm sinh viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:rgb(227, 237, 237);
            text-align: center;
            padding: 20px;
        }

        h2 {
            color: #333;
        }

        .form-container {
            width: 40%;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(241, 241, 241, 0.1);
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
            border-color:rgb(33, 205, 102);
            box-shadow: 0 0 5px rgba(0, 241, 64, 0.94);
        }

        input[type="file"] {
            padding: 5px;
        }

        input[type="submit"] {
            background:rgb(1, 114, 71);
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        input[type="submit"]:hover {
            background:rgb(4, 140, 38);
        }
    </style>
</head>
<body>

    <h2>Thêm Sinh Viên</h2>
    <div class="form-container">
        <form method="POST" enctype="multipart/form-data">
            <label>Họ Tên:</label>
            <input type="text" name="HoTen" required>

            <label>Giới Tính:</label>
            <select name="GioiTinh">
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
            </select>

            <label>Ngày Sinh:</label>
            <input type="date" name="NgaySinh" required>

            <label>Ngành:</label>
            <select name="MaNganh">
                <option value="CNTT">Công nghệ thông tin</option>
                <option value="QTKD">Quản trị kinh doanh</option>
            </select>

            <label>Hình:</label>
            <input type="file" name="Hinh" required>

            <input type="submit" value="Thêm Sinh Viên">
        </form>
    </div>

</body>
</html>
