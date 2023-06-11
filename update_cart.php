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

// Kiểm tra xem yêu cầu có phải là POST và có dữ liệu được gửi lên hay không
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['productId']) && isset($_POST['quantity'])) {
    $productId = $_POST['productId'];
    $quantity = $_POST['quantity'];

    // Cập nhật số lượng trong giỏ hàng
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] = $quantity;
    }

    // Tính toán lại tổng số lượng và tổng giá tiền
    $cart = $_SESSION['cart'];
    $totalQuantity = 0;
    $totalPrice = 0;
    foreach ($cart as $productId => $info) {
        $result = mysqli_query($conn, "SELECT promotionPrice FROM products WHERE id = '$productId'");
        $productInfo = mysqli_fetch_assoc($result);
        $totalQuantity += $info['quantity'];
        $totalPrice += $productInfo['promotionPrice'] * $info['quantity'];
    }

    // Trả về phản hồi dưới dạng JSON chứa thông tin cập nhật
    $response = array(
        'totalQuantity' => $totalQuantity,
        'totalPrice' => $totalPrice
    );
    echo json_encode($response);
} else {
    // Trả về phản hồi lỗi nếu yêu cầu không hợp lệ
    http_response_code(400);
    echo "Invalid request";
}
