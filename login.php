<?php
session_start();
include 'config.php'; // Kết nối CSDL

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSV = trim($_POST['MaSV']);
    
    // Kiểm tra MSSV trong database
    $sql = "SELECT * FROM SinhVien WHERE MaSV = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $MaSV);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $_SESSION['MaSV'] = $MaSV;
        header("Location: index.php");
        exit();
    } else {
        $error = "❌ Mã số sinh viên không đúng!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; text-align: center; }
        .menu { background: #222; padding: 10px; margin-bottom: 20px; }
        .menu a { color: white; text-decoration: none; padding: 10px 15px; font-weight: bold; }
        .menu a:hover { background: rgba(255, 255, 255, 0.2); border-radius: 5px; }
        .container { width: 30%; background: white; padding: 20px; margin: auto; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); }
        input[type="text"] { width: 90%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; }
        .btn { background: #007bff; color: white; padding: 10px 15px; border: none; cursor: pointer; border-radius: 5px; }
        .btn:hover { background:rgb(1, 14, 27); }
        .error { color: red; font-weight: bold; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="menu">
        <a href="index.php">Sinh Viên</a> | <a href="hocphan.php">Học Phần</a> | <a href="#">Đăng Ký</a> | <a href="login.php">Đăng Nhập</a>
    </div>

    <div class="container">
        <h2>ĐĂNG NHẬP</h2>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form method="POST">
            <label>Mã SV</label><br>
            <input type="text" name="MaSV" required><br>
            <input type="submit" value="Đăng Nhập" class="btn">
        </form>
        <a href="index.php">Back to List</a>
    </div>
</body>
</html>