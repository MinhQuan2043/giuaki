<?php
include 'config.php';
$sql = "SELECT * FROM SinhVien";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách sinh viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            text-align: center;
        }
        .menu {
            background: #333;
            padding: 15px;
        }
        .menu a {
            color: white;
            margin: 15px;
            text-decoration: none;
            font-weight: bold;
        }
        .menu a:hover {
            color: #ffcc00;
        }
        h2 {
            margin-top: 20px;
            color: #333;
        }
        .add-btn {
            display: inline-block;
            background: #28a745;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .add-btn:hover {
            background: #218838;
        }
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        th {
            background: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        tr:hover {
            background: #f1f1f1;
        }
        img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="menu">
        <a href="index.php">Trang chủ</a> | 
        <a href="index.php">Sinh viên</a> | 
        <a href="hocphan.php">Học phần</a> | 
        <a href="dangky.php">Đăng ký</a> | 
        <a href="login.php">Đăng nhập</a>
    </div>

    <h2>TRANG SINH VIÊN</h2>
    <a href="create.php" class="add-btn">+ Add Student</a>
    
    <table>
        <tr>
            <th>Mã SV</th>
            <th>Họ Tên</th>
            <th>Giới Tính</th>
            <th>Ngày Sinh</th>
            <th>Hình</th>
            <th>Ngành</th>
            <th>Hành động</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['MaSV'] ?></td>
                <td><?= $row['HoTen'] ?></td>
                <td><?= ($row['GioiTinh'] == 1) ? "Nam" : "Nữ"; ?></td>
                <td><?= date("d-m-Y", strtotime($row['NgaySinh'])); ?></td>
                <td><img src="uploads/<?= $row['Hinh']; ?>"></td>
                <td><?= $row['MaNganh']; ?></td>
                <td>
                    <a href="edit.php?MaSV=<?= $row['MaSV']; ?>">Edit</a> |
                    <a href="detail.php?MaSV=<?= $row['MaSV']; ?>">Detail</a> |
                    <a href="delete.php?MaSV=<?= $row['MaSV']; ?>" onclick="return confirm('Bạn có chắc muốn xóa?')">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
<?php $conn->close(); ?>
