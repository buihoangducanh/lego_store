<?php
session_start();
$role_id = $_SESSION['user_role'];
if ($role_id !== 1) {
    header("Location:../index.php");
    exit();
}
require '../util/connectDB.php'; // Kết nối đến cơ sở dữ liệu

$orderId = $_GET['orderId'];

// Cập nhật trạng thái đơn đặt hàng thành 'Processed'
$query = "UPDATE orders SET status = 'Processed' WHERE id = $orderId";
$result = mysqli_query($conn, $query);

if ($result) {
    // Cập nhật ngày nhận hàng là ngày hiện tại cộng thêm 3 ngày
    // Lấy ngày giờ hiện tại
    $currentDatetime = date('Y-m-d H:i:s');

    // Cộng thêm 3 ngày vào ngày giờ hiện tại
    $futureDatetime = strtotime('+3 days', strtotime($currentDatetime));
    $futureDatetime = date('Y-m-d H:i:s', $futureDatetime);

    $query = "UPDATE orders SET receivedDate = '$futureDatetime' WHERE id = $orderId";
    $result = mysqli_query($conn, $query);
}

if ($result) {
    echo '<script type="text/javascript">alert("Thành công!"); history.back();</script>';
} else {
    echo '<script type="text/javascript">alert("Thất bại!"); history.back();</script>';
}
