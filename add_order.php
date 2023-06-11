<?php
session_start(); // Bắt đầu session
include 'util/connectDB.php'; // Kết nối CSDL

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    // Nếu người dùng chưa đăng nhập, hiển thị thông báo và chuyển hướng đến trang đăng nhập
    echo "<script>alert('Vui lòng đăng nhập.');</script>";
    header('Location: login.php');
    exit;
}


$user_id = $_SESSION['user_id'];

// Lấy thông tin người dùng từ CSDL
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$userInfo = mysqli_fetch_assoc($result);

// Tạo đơn hàng mới
$totalQty = 0;
$totalPrice = 0;

$cart =  $_SESSION['cart'];
// Tính toán tổng số lượng và tổng giá tiền
foreach ($cart as $productId => $info) {
    $result = mysqli_query($conn, "SELECT * FROM products WHERE id = '$productId'");
    $productInfo = mysqli_fetch_assoc($result);
    $qty = $info['quantity'];
    $totalQty += $qty;
    $totalPrice += $productInfo['promotionPrice'] * $qty;
}

$status = "Processing";
// Thêm thông tin đơn hàng vào bảng "orders"
$insertOrderQuery = "INSERT INTO orders (userId, total, createdDate, status) 
                     VALUES ('$user_id', '$totalPrice', NOW(), '$status')";
mysqli_query($conn, $insertOrderQuery);
$order_id = mysqli_insert_id($conn); // Lấy ID của đơn hàng vừa được tạo

// Thêm thông tin chi tiết đơn hàng vào bảng "order_details"
foreach ($cart as $productId => $info) {
    $result = mysqli_query($conn, "SELECT * FROM products WHERE id = '$productId'");
    $productInfo = mysqli_fetch_assoc($result);
    $qty = $info['quantity'];
    $productPrice = $productInfo['promotionPrice'];
    $productName = $productInfo['name'];
    $productImage = $productInfo['image'];

    $insertOrderDetailQuery = "INSERT INTO order_details (orderId, productId, qty, productPrice, productName, productImage) 
                               VALUES ('$order_id', '$productId', '$qty', '$productPrice', '$productName', '$productImage')";
    mysqli_query($conn, $insertOrderDetailQuery);
}

// Xóa giỏ hàng sau khi đã đặt hàng thành công
unset($_SESSION['cart']);

// Hiển thị thông báo thành công và chuyển hướng người dùng đến trang order.php
echo "<script>
    alert('Đặt hàng thành công!');
     window.location.href = 'order.php';
</script>";

exit();
