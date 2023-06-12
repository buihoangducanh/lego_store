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
// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . mysqli_connect_error());
}

// Xử lý huỷ đơn hàng
// Xử lý huỷ đơn hàng
if (isset($_GET['orderId'])) {
    $orderId = $_GET['orderId'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    // Lấy ngày giờ hiện tại
    $cancelledDate = date('Y-m-d H:i:s');

    // Truy vấn để cập nhật trạng thái đơn hàng thành "Cancel" và lưu ngày giờ hủy
    $sql = "UPDATE orders SET status = 'Cancelled', cancelled_date = '$cancelledDate' WHERE id = $orderId";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Huỷ đơn hàng thành công!');</script>";
        echo '<script>window.location.href = "index.php";</script>';
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}


// Đóng kết nối
mysqli_close($conn);
