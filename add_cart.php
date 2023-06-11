<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    // Nếu người dùng chưa đăng nhập, hiển thị thông báo và chuyển hướng đến trang đăng nhập
    echo "<script>alert('Vui lòng đăng nhập.');</script>";
    header('Location: login.php');
    exit;
}

// Tiếp tục xử lý thêm sản phẩm vào giỏ hàng nếu người dùng đã đăng nhập

// Kiểm tra nếu giỏ hàng không tồn tại, tạo giỏ hàng mới
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Lấy thông tin sản phẩm từ request
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $productId = $_GET['id'];

    // Include file kết nối CSDL
    include 'util/connectDB.php';

    // Kiểm tra kết nối CSDL
    if (!$conn) {
        die("Kết nối CSDL thất bại: " . mysqli_connect_error());
    }

    // Lấy thông tin sản phẩm từ CSDL
    $sql = "SELECT * FROM products WHERE id = $productId";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);

        // Kiểm tra số lượng hàng tồn kho
        if ($product['qty'] <= 0) {
            // Nếu số lượng hàng tồn kho không đủ, hiển thị thông báo và chuyển hướng về trang danh sách sản phẩm
            echo "<script>alert('Không đủ số lượng hàng còn.');</script>";
            echo "<script>window.location.href = document.referrer;</script>";
            exit;
        }

        // Thêm sản phẩm vào giỏ hàng
        if (array_key_exists($productId, $_SESSION['cart'])) {
            // Nếu sản phẩm đã tồn tại trong giỏ hàng, tăng số lượng lên 1
            $_SESSION['cart'][$productId]['quantity']++;
        } else {
            // Nếu sản phẩm chưa tồn tại trong giỏ hàng, thêm sản phẩm mới vào
            $_SESSION['cart'][$productId] = array(
                'quantity' => 1,
            );
        }

        // Đóng kết nối CSDL
        mysqli_close($conn);

        // Hiển thị thông báo thêm sản phẩm vào giỏ hàng
        $productName = $product['name'];
        echo "<script>alert('Thêm sản phẩm $productName vào giỏ hàng thành công.');</script>";
        echo "<script>window.location.href = document.referrer;</script>";
        exit;
    } else {
        // Nếu không tìm thấy sản phẩm, hiển thị thông báo lỗi và chuyển hướng về trang trước đó
        echo "<script>alert('Không tìm thấy sản phẩm.');</script>";
        echo "<script>window.location.href = document.referrer;</script>";
        exit;
    }
}
