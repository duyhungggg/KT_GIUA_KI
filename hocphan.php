<?php
session_start();
include 'config.php';
if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}
$result = mysqli_query($conn, "SELECT * FROM HocPhan");

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['add'])) {
    $maHP = $_GET['add'];
    if (!in_array($maHP, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $maHP;
    }
    header("Location: hocphan.php");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký học phần</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: #fff;
            min-height: 100vh;
            padding: 20px;
            font-family: 'Arial', sans-serif;
        }
        .card {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }
        .table th {
            background: #2a5298;
        }
        .btn-primary {
            background: #4a90e2;
            border: none;
        }
        .btn-primary:hover { background: #357abd; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h2 class="text-center mb-4">Đăng ký học phần <i class="fas fa-book"></i></h2>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Mã HP</th>
                        <th>Tên HP</th>
                        <th>Số tín chỉ</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['MaHP']; ?></td>
                        <td><?php echo $row['TenHP']; ?></td>
                        <td><?php echo $row['SoTinChi']; ?></td>
                        <td><a href="hocphan.php?add=<?php echo $row['MaHP']; ?>" class="btn btn-primary btn-sm"><i class="fas fa-cart-plus"></i> Thêm</a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <a href="cart.php" class="btn btn-primary mt-3"><i class="fas fa-shopping-cart"></i> Xem giỏ hàng</a>
            <a href="index.php" class="btn btn-secondary mt-3"><i class="fas fa-arrow-left"></i> Quay lại</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>