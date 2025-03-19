<?php
session_start();
include 'config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $maSV = $_POST['MaSV'];
    $result = mysqli_query($conn, "SELECT * FROM SinhVien WHERE MaSV='$maSV'");
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['MaSV'] = $maSV;
        header("Location: index.php");
    } else {
        $error = "Mã sinh viên không tồn tại!";
    }
}

echo "Đăng nhập<br><br>";
if (isset($error)) {
    echo $error . "<br>";
}
echo "<form method='POST'>";
echo "Mã SV: <input type='text' name='MaSV' required><br>";
echo "<input type='submit' value='Đăng nhập'><br>";
echo "</form>";
echo "<a href='register.php'>Đăng ký ngay</a><br>";
echo "<a href='home.php'>Trở về trang chủ</a>";
?>