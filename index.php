<?php
session_start();
include 'config.php';
if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}

// Kiểm tra quyền admin
$isAdmin = ($_SESSION['MaSV'] === '999999999');

$result = mysqli_query($conn, "SELECT * FROM SinhVien");

echo "<h1>Danh sách sinh viên</h1>";
echo "<a href='logout.php'>Đăng xuất</a><br><br>";

if ($isAdmin) {
    echo "<a href='create.php'>Thêm sinh viên</a><br><br>";
}

echo "<table border='1'>";
echo "<tr>";
echo "<th>Mã SV</th>";
echo "<th>Họ tên</th>";
echo "<th>Giới tính</th>";
echo "<th>Ngày sinh</th>";
echo "<th>Hình</th>";
echo "<th>Mã ngành</th>";
echo "<th>Hành động</th>";
echo "</tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['MaSV'] . "</td>";
    echo "<td>" . $row['HoTen'] . "</td>";
    echo "<td>" . $row['GioiTinh'] . "</td>";
    echo "<td>" . $row['NgaySinh'] . "</td>";
    echo "<td>";
    if ($row['Hinh'] && file_exists($row['Hinh'])) {
        echo "<img src='" . $row['Hinh'] . "' width='40' height='40'>";
    } else {
        echo "Không có hình";
    }
    echo "</td>";
    echo "<td>" . $row['MaNganh'] . "</td>";
    echo "<td>";
    if ($isAdmin) {
        echo "<a href='edit.php?id=" . $row['MaSV'] . "'>Sửa</a> ";
        echo "<a href='delete.php?id=" . $row['MaSV'] . "' onclick=\"return confirm('Xóa sinh viên này?')\">Xóa</a> ";
    }
    echo "<a href='detail.php?id=" . $row['MaSV'] . "'>Chi tiết</a>";
    echo "</td>";
    echo "</tr>";
}

echo "</table>";
?>