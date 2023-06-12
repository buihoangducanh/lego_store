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
$query = "UPDATE orders SET status = 'Complete', receivedDate = '$currentDate' WHERE id = $orderId";
$result = mysqli_query($conn, $query);

// Lấy thông tin sản phẩm từ bảng order_details
$query = "SELECT productId, qty FROM order_details WHERE orderId = $orderId";
$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $productId = $row['productId'];
        $qty = $row['qty'];

        // Cập nhật số lượng sản phẩm đã bán (soldCount) trong bảng products
        $updateQuery = "UPDATE products SET soldCount = soldCount + $qty WHERE id = $productId";
        mysqli_query($conn, $updateQuery);
    }
}


if ($result) {
    echo '<script>alert("Đã xác nhận đã nhận hàng thành công!");</script>';
    echo '<script>window.location.href = "order.php";</script>';
} else {
    echo '<script>alert("Có lỗi xảy ra. Vui lòng thử lại!");</script>';
    echo '<script>window.location.href = "order.php";</script>';
}
