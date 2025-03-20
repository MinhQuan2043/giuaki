<?php
session_start();
include 'config.php';

// Kết nối database
include 'config.php';

// Khởi tạo session nếu chưa có
if (!isset($_SESSION['hocphan'])) {
    $_SESSION['hocphan'] = [];
}

// Biến thông báo
$thongBao = "";
if (isset($_POST['MaHP'])) {
    $maHP = $_POST['MaHP'];
    $tenHP = $_POST['TenHP'];
    $soTinChi = $_POST['SoTinChi'];

    // Kiểm tra nếu sinh viên đã đăng ký học phần này hay chưa
    if (!array_key_exists($maHP, $_SESSION['hocphan'])) {
        // Kiểm tra số lượng còn lại trong bảng HocPhan
        $checkSQL = "SELECT SoLuong FROM HocPhan WHERE MaHP = ?";
        $stmt = $conn->prepare($checkSQL);
        $stmt->bind_param("s", $maHP);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row && $row['SoLuong'] > 0) {
            // Cập nhật số lượng học phần (giảm đi 1)
            $updateSQL = "UPDATE HocPhan SET SoLuong = SoLuong - 1 WHERE MaHP = ?";
            $stmt = $conn->prepare($updateSQL);
            $stmt->bind_param("s", $maHP);
            $stmt->execute();

            // Thêm vào session đăng ký học phần
            $_SESSION['hocphan'][$maHP] = [
                'MaHP' => $maHP,
                'TenHP' => $tenHP,
                'SoTinChi' => $soTinChi
            ];
            $thongBao = "Bạn đã đăng ký học phần <strong>$tenHP</strong> thành công!";
        } else {
            $thongBao = "Học phần <strong>$tenHP</strong> đã hết chỗ!";
        }
    } else {
        $thongBao = "Bạn đã đăng ký học phần <strong>$tenHP</strong> trước đó, không thể đăng ký lại!";
    }
}



// Lấy danh sách học phần từ database
$sql = "SELECT * FROM HocPhan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách học phần</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; text-align: center; }
        .menu { background: #222; padding: 10px; margin-bottom: 20px; }
        .menu a { color: white; text-decoration: none; padding: 10px 15px; font-weight: bold; }
        .menu a:hover { background: rgba(255, 255, 255, 0.2); border-radius: 5px; }
        table { width: 80%; margin: auto; border-collapse: collapse; background: white; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background: #333; color: white; }
        .btn { background: #28a745; color: white; padding: 5px 10px; border: none; cursor: pointer; border-radius: 5px; }
        .btn:hover { background: #218838; }
        .thongbao { background: #d4edda; color: #155724; padding: 10px; margin: 20px auto; width: 60%; border-radius: 5px; border: 1px solid #c3e6cb; display: <?= empty($thongBao) ? 'none' : 'block' ?>; }
    </style>
</head>
<body>
    <div class="menu">
        <a href="index.php">Sinh Viên</a> | <a href="hocphan.php">Học Phần</a> | <a href="dangky.php">Đăng Ký</a> | <a href="login.php">Đăng Nhập</a>
    </div>

    <h2>DANH SÁCH HỌC PHẦN</h2>

    <!-- Hiển thị thông báo -->
    <?php if (!empty($thongBao)) { ?>
        <div class="thongbao">
            <?= $thongBao ?>
        </div>
    <?php } ?>

    <table>
    <tr>
        <th>Mã Học Phần</th>
        <th>Tên Học Phần</th>
        <th>Số Tín Chỉ</th>
        <th>Số Lượng Còn</th> <!-- Cột mới -->
        <th>Đăng Ký</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?= $row['MaHP'] ?></td>
        <td><?= $row['TenHP'] ?></td>
        <td><?= $row['SoTinChi'] ?></td>
        <td><?= $row['SoLuong'] ?></td> <!-- Hiển thị số lượng còn -->
        <td>
            <?php if ($row['SoLuong'] > 0) { ?>
                <form method="POST">
                    <input type="hidden" name="MaHP" value="<?= $row['MaHP'] ?>">
                    <input type="hidden" name="TenHP" value="<?= $row['TenHP'] ?>">
                    <input type="hidden" name="SoTinChi" value="<?= $row['SoTinChi'] ?>">
                    <button type="submit" class="btn">Đăng Ký</button>
                </form>
            <?php } else { ?>
                <span style="color: red;">Hết chỗ</span>
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
