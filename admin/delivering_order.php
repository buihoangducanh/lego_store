<?php
session_start();
$role_id = $_SESSION['user_role'];
if ($role_id !== 1) {
    header("Location:../index.php");
    exit();
}
require '../util/connectDB.php'; // Kết nối đến cơ sở dữ liệu


// Kiểm tra xem orderId có được truyền vào hay không
if (isset($_GET['orderId'])) {
    // Lấy orderId từ tham số truyền vào
    $orderId = $_GET['orderId'];

    // Cập nhật trạng thái đơn hàng thành "Delivering"
    $query = "UPDATE orders SET status = 'Delivering' WHERE id = $orderId";
    $result = mysqli_query($conn, $query);

    // Kiểm tra kết quả cập nhật
    if ($result) {
        echo '<script type="text/javascript">alert("Đơn hàng đang giao hàng!"); history.back();</script>';
    } else {
        echo '<script type="text/javascript">alert("Cập nhật trạng thái đơn hàng thất bại!"); history.back();</script>';
    }
} else {
    // Nếu không có orderId được truyền vào, quay lại trang trước đó
    echo '<script type="text/javascript">history.back();</script>';
}
