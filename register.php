<?php
include 'config.php';
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
            $check = mysqli_query($conn, "SELECT * FROM SinhVien WHERE MaSV='$maSV'");
            if (mysqli_num_rows($check) > 0) {
                $error = "Mã sinh viên đã tồn tại!";
            } else {
                $sql = "INSERT INTO SinhVien(MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) 
                        VALUES('$maSV', '$hoTen', '$gioiTinh', '$ngaySinh', '$hinh', '$maNganh')";
                if (mysqli_query($conn, $sql)) {
                    $success = "Đăng ký thành công! Bạn có thể đăng nhập ngay.";
                } else {
                    $error = "Lỗi: " . mysqli_error($conn);
                }
            }
        } else {
            $error = "Lỗi khi di chuyển file ảnh! Kiểm tra quyền thư mục Content/images/";
        }
    } else {
        $error = "Lỗi upload file: " . $_FILES['Hinh']['error'];
    }
}

echo "Đăng ký tài khoản<br><br>";
if (isset($success)) {
    echo $success . "<br>";
}
if (isset($error)) {
    echo $error . "<br>";
}
echo "<form method='POST' enctype='multipart/form-data'>";
echo "Mã SV: <input type='text' name='MaSV' required><br>";
echo "Họ tên: <input type='text' name='HoTen' required><br>";
echo "Giới tính: <input type='text' name='GioiTinh' required><br>";
echo "Ngày sinh: <input type='date' name='NgaySinh' required><br>";
echo "Hình: <input type='file' name='Hinh'><br>";
echo "Mã ngành: <input type='text' name='MaNganh' required><br>";
echo "<input type='submit' value='Đăng ký'><br>";
echo "</form>";
echo "<a href='login.php'>Đăng nhập ngay</a>";
?>