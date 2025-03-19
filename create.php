<?php
session_start();
include 'config.php';
if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}

// Kiểm tra quyền: chỉ user có MaSV = 999999999 được truy cập
if ($_SESSION['MaSV'] !== '999999999') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $maSV = $_POST['MaSV'];
    $hoTen = $_POST['HoTen'];
    $gioiTinh = $_POST['GioiTinh'];
    $ngaySinh = $_POST['NgaySinh'];
    $maNganh = $_POST['MaNganh'];

    $hinh = '';
    if ($_FILES['Hinh']['error'] === UPLOAD_ERR_OK) {
        $targetDir = './Content/images/';
        $hinh = $targetDir . basename($_FILES['Hinh']['name']);
        if (move_uploaded_file($_FILES['Hinh']['tmp_name'], $hinh)) {
            $sql = "INSERT INTO SinhVien(MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) 
                    VALUES('$maSV', '$hoTen', '$gioiTinh', '$ngaySinh', '$hinh', '$maNganh')";
            if (mysqli_query($conn, $sql)) {
                header("Location: index.php");
            } else {
                echo "Lỗi: " . mysqli_error($conn);
            }
        } else {
            echo "Lỗi khi di chuyển file ảnh!";
        }
    } else {
        echo "Lỗi upload file: " . $_FILES['Hinh']['error'];
    }
}

echo "Thêm sinh viên<br><br>";
echo "<form method='POST' enctype='multipart/form-data'>";
echo "Mã SV: <input type='text' name='MaSV' required><br>";
echo "Họ tên: <input type='text' name='HoTen' required><br>";
echo "Giới tính: <input type='text' name='GioiTinh' required><br>";
echo "Ngày sinh: <input type='date' name='NgaySinh' required><br>";
echo "Hình: <input type='file' name='Hinh'><br>";
echo "Mã ngành: <input type='text' name='MaNganh' required><br>";
echo "<input type='submit' value='Thêm'> ";
echo "<a href='index.php'>Quay lại</a>";
echo "</form>";
?>