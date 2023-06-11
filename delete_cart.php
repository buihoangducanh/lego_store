<?php
session_start(); // Bắt đầu session
// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    // Nếu người dùng chưa đăng nhập, hiển thị thông báo và chuyển hướng đến trang đăng nhập
    echo "<script>alert('Vui lòng đăng nhập.');</script>";
    header('Location: login.php');
    exit;
}


if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Xoá sản phẩm ra khỏi giỏ hàng
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }
}

// Điều hướng trở lại trang giỏ hàng và hiển thị thông báo
$message = "Sản phẩm đã được xoá khỏi giỏ hàng.";
echo "<script>alert('$message'); window.location.href = 'checkout.php';</script>";
exit();
