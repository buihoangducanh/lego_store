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


// Lấy thông tin từ session
if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
} else {
    $cart = array(); // Khởi tạo giỏ hàng nếu chưa tồn tại
}
$user_fullname = $_SESSION['user_fullname'];
$user_id = $_SESSION['user_id'];

// Lấy thông tin người dùng từ CSDL
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$userInfo = mysqli_fetch_assoc($result);

// Lấy dữ liệu từ CSDL và gán giá trị cho các biến
$list = array(); // Biến chứa danh sách sản phẩm trong giỏ hàng
$totalQty = 0; // Biến chứa tổng số lượng sản phẩm
$totalPrice = 0; // Biến chứa tổng giá tiền

// Truy vấn CSDL để lấy thông tin về các sản phẩm trong giỏ hàng
if ($cart) {
    foreach ($cart as $productId => $info) {
        // Thực hiện truy vấn để lấy thông tin sản phẩm với $productId từ CSDL
        $result = mysqli_query($conn, "SELECT * FROM products WHERE id = '$productId'");

        // Gán thông tin sản phẩm vào biến $productInfo
        $productInfo = mysqli_fetch_assoc($result);

        // Tính toán tổng số lượng và tổng giá tiền
        $qty = $info['quantity'];
        $totalQty += $qty;
        $totalPrice += $productInfo['promotionPrice'] * $qty;

        // Thêm thông tin sản phẩm vào danh sách
        $productInfo['qty'] = $qty;
        $list[] = $productInfo;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'inc/metadata_cdnLib.php' ?>
    <title>Checkout</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".qty").on("change", function() {
                var productId = $(this).attr("id");
                var newQty = parseInt($(this).val());

                if (newQty < 1) {
                    $(this).val(1);
                    newQty = 1;
                }

                $.ajax({
                    url: "update_cart.php",
                    method: "POST",
                    data: {
                        productId: productId,
                        quantity: newQty
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        $("#qtycart").text(data.totalQuantity);
                        $("#totalcart").text(data.totalPrice.toLocaleString() + "VND");
                    }
                });
            });
        });
    </script>
</head>

<body>
    <?php include 'inc/header.php' ?>
    <section class="banner"></section>
    <div class="container-intro-section black-background d-flex justify-content-center align-items-center " style="padding-bottom: 100px;">
        <h1 class="text-center text-light">Giỏ hàng</h1>
    </div>
    <div class="container-single" style="min-height: 40vh;">
        <?php
        if ($list) { ?>
            <table class="order">
                <tr>
                    <th class="text-center p-2">STT</th>
                    <th class="text-center p-2">Tên sản phẩm</th>
                    <th class="text-center p-2">Hình ảnh</th>
                    <th class="text-center p-2">Đơn giá</th>
                    <th class="text-center p-2">Số lượng</th>
                    <th class="text-center p-2">Thao tác</th>
                </tr>
                <?php
                $count = 1;
                foreach ($list as $productId => $info) { ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= $info['name'] ?></td>
                        <td><img class="image-cart" src="admin/uploads/<?= $info['image'] ?>"></td>
                        <td><?= number_format($info['promotionPrice'], 0, '', ',') ?>VND </td>
                        <td>
                            <input id="<?= $info['id'] ?>" type="number" name="qty" class="qty" value="<?= $info['qty'] ?>" min="1">
                        </td>
                        <td>
                            <a href="delete_cart.php?id=<?= $info['id'] ?>">Xóa</a>
                        </td>
                    </tr>
                <?php }
                ?>
            </table>
            <div class="orderinfo">
                <div class="buy">
                    <h3>Thông tin đơn đặt hàng</h3>
                    <div>
                        Người đặt hàng: <b><?= $user_fullname ?></b>
                    </div>
                    <div>
                        Số lượng: <b id="qtycart"><?= $totalQty ?></b>
                    </div>
                    <div>
                        Tổng tiền: <b id="totalcart"><?= number_format($totalPrice, 0, '', ',') ?>VND</b>
                    </div>
                    <div>
                        Số điện thoại: <b><?= $userInfo['phone_number'] ?></b>
                    </div>
                    <div>
                        Địa chỉ nhận hàng: <b><?= $userInfo['address'] ?></b>
                    </div>
                    <div class="buy-btn">
                        <a href="add_order.php">Tiến hành đặt hàng</a>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <h3>Giỏ hàng hiện đang rỗng</h3>
        <?php }
        ?>
    </div>
    <?php
    include 'inc/footer.php'
    ?>
</body>

</html>