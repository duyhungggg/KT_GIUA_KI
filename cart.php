<?php
session_start();
include 'config.php';
if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['remove'])) {
    $maHP = $_GET['remove'];
    $_SESSION['cart'] = array_diff($_SESSION['cart'], [$maHP]);
    header("Location: cart.php");
}

if (isset($_GET['clear'])) {
    $_SESSION['cart'] = [];
    header("Location: cart.php");
}

echo "Giỏ hàng học phần<br><br>";

if (!empty($_SESSION['cart'])) {
    $cart = implode("','", $_SESSION['cart']);
    $result = mysqli_query($conn, "SELECT * FROM HocPhan WHERE MaHP IN ('$cart')");

    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>Mã HP</th>";
    echo "<th>Tên HP</th>";
    echo "<th>Số tín chỉ</th>";
    echo "<th>Hành động</th>";
    echo "</tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['MaHP'] . "</td>";
        echo "<td>" . $row['TenHP'] . "</td>";
        echo "<td>" . $row['SoTinChi'] . "</td>";
        echo "<td><a href='cart.php?remove=" . $row['MaHP'] . "'>Xóa</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Giỏ hàng trống";
}

echo "<br>";
echo "<a href='cart.php?clear=1'>Xóa hết</a> ";
echo "<a href='save.php'>Lưu đăng ký</a> ";
echo "<a href='hocphan.php'>Quay lại</a>";
?>