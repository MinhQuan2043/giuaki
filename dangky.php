<?php
session_start();
include 'config.php'; // Kết nối CSDL

// Xử lý xóa từng học phần
if (isset($_GET['delete'])) {
    $maHP = $_GET['delete'];
    unset($_SESSION['hocphan'][$maHP]);
}

// Xử lý xóa toàn bộ học phần
if (isset($_GET['clear'])) {
    $_SESSION['hocphan'] = [];
}

// Xử lý lưu đăng ký vào CSDL
$thongBao = "";
if (isset($_POST['save']) && !empty($_SESSION['hocphan'])) {
    $maSinhVien = "SV001"; // Giả sử mã SV, bạn có thể lấy từ session đăng nhập
    
    foreach ($_SESSION['hocphan'] as $hp) {
        $maHP = $hp['MaHP'];
        $sql = "INSERT INTO DangKy (MaSV, MaHP) VALUES ('$maSinhVien', '$maHP')";
        $conn->query($sql);
    }
    
    $thongBao = "Đăng ký học phần thành công!";
    $_SESSION['hocphan'] = []; // Xóa giỏ hàng sau khi lưu
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Ký Học Phần</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; text-align: center; }
        .menu { background: #222; padding: 10px; margin-bottom: 20px; }
        .menu a { color: white; text-decoration: none; padding: 10px 15px; font-weight: bold; }
        .menu a:hover { background: rgba(97, 11, 11, 0.79); border-radius: 5px; }
        table { width: 80%; margin: auto; border-collapse: collapse; background: white; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background: #333; color: white; }
        .btn { background: #dc3545; color: white; padding: 5px 10px; border: none; cursor: pointer; border-radius: 5px; text-decoration: none; display: inline-block; }
        .btn:hover { background: #c82333; }
        .clear-btn { background:rgb(138, 174, 213); }
        .clear-btn:hover { background: #0056b3; }
        .save-btn { background: #28a745; }
        .save-btn:hover { background: #218838; }
        .thongbao { background: #d4edda; color: #155724; padding: 10px; margin: 20px auto; width: 60%; border-radius: 5px; border: 1px solid #c3e6cb; display: <?= empty($thongBao) ? 'none' : 'block' ?>; }
    </style>
</head>
<body>
    <div class="menu">
        <a href="index.php">Sinh Viên</a> | <a href="hocphan.php">Học Phần</a> | <a href="dangky.php">Đăng Ký</a> | <a href="login.php">Đăng Nhập</a>
    </div>

    <h2>ĐĂNG KÝ HỌC PHẦN</h2>

    <!-- Hiển thị thông báo -->
    <?php if (!empty($thongBao)) { ?>
        <div class="thongbao">
            <?= $thongBao ?>
        </div>
    <?php } ?>

    <?php if (!empty($_SESSION['hocphan'])) { ?>
        <table>
            <tr>
                <th>Mã Học Phần</th>
                <th>Tên Học Phần</th>
                <th>Số Tín Chỉ</th>
                <th>Hành Động</th>
            </tr>
            <?php 
            $totalTinChi = 0;
            foreach ($_SESSION['hocphan'] as $hp) { 
                $totalTinChi += $hp['SoTinChi'];
            ?>
            <tr>
                <td><?= $hp['MaHP'] ?></td>
                <td><?= $hp['TenHP'] ?></td>
                <td><?= $hp['SoTinChi'] ?></td>
                <td><a href="?delete=<?= $hp['MaHP'] ?>" class="btn">Xóa</a></td>
            </tr>
            <?php } ?>
        </table>
        <p><strong>Số học phần: </strong> <?= count($_SESSION['hocphan']) ?></p>
        <p><strong>Tổng số tín chỉ: </strong> <?= $totalTinChi ?></p>

        <!-- Nút xóa và lưu -->
        <a href="?clear=true" class="btn clear-btn">Xóa Đăng Ký</a>
        <form method="POST" style="display:inline;">
            <button type="submit" name="save" class="btn save-btn">Lưu Đăng Ký</button>
        </form>
    <?php } else { ?>
        <p><strong>Chưa có học phần nào được đăng ký!</strong></p>
    <?php } ?>
</body>
</html>
