<?php
session_start();
include 'util/connectDB.php';

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    // Nếu người dùng chưa đăng nhập, hiển thị thông báo và chuyển hướng đến trang đăng nhập
    echo "<script>alert('Vui lòng đăng nhập.');</script>";
    header('Location: login.php');
    exit;
}

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$orderId = $_GET['orderId'];

// Cập nhật trạng thái đơn hàng thành "Delivered" và ngày nhận hàng thành ngày hiện tại
date_default_timezone_set('Asia/Ho_Chi_Minh');
$currentDate = date('Y-m-d H:i:s');
$query = "UPDATE orders SET status = 'Delivered', receivedDate = '$currentDate' WHERE id = $orderId";
$result = mysqli_query($conn, $query);

if ($result) {
    echo '<script>alert("Đã xác nhận đã nhận hàng thành công!");</script>';
    echo '<script>window.location.href = "order.php";</script>';
} else {
    echo '<script>alert("Có lỗi xảy ra. Vui lòng thử lại!");</script>';
    echo '<script>window.location.href = "order.php";</script>';
}
