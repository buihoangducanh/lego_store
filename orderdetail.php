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

// Lấy thông tin khách hàng từ CSDL
$userId = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = $userId";
$result = mysqli_query($conn, $query);
$userInfo = mysqli_fetch_assoc($result);


// lấy thông tin đơn hàng
$orderId = $_GET['orderId'];
$query = "SELECT * FROM orders WHERE id = $orderId";
$result = mysqli_query($conn, $query);
$order = mysqli_fetch_assoc($result);

// Truy vấn CSDL để lấy thông tin chi tiết đơn hàng
$query = "SELECT * FROM order_details WHERE orderId = $orderId";
$itemsList = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'inc/metadata_cdnLib.php'
    ?>
    <title>Order</title>
</head>

<body>
    <?php include 'inc/header.php' ?>
    <section class="banner"></section>
    <div class="featuredProducts">
        <h1 style="color: black; padding-top: 50px">Chi tiết đơn hàng ID <?= $_GET['orderId'] ?></h1>
    </div>
    <div style="min-height: 50vh;">
        <div style="padding: 20px 100px">
            <p>Tên khách hàng : <span><?= $userInfo['fullname'] ?></span></p>
            <p>Địa chỉ : <span><?= $userInfo['address'] ?></span></p>
            <p>Số điện thoại : <span><?= $userInfo['phone_number'] ?></span></p>
            <p>Tổng giá trị đơn hàng : <span><?= number_format($order['total'], 0, '', ',') ?></span>VND</p>

        </div>
        <div class="container-single">
            <table class="order">
                <tr>
                    <th class="text-center p-2">STT</th>
                    <th class="text-center p-2">Tên sản phẩm</th>
                    <th class="text-center p-2">Hình ảnh</th>
                    <th class="text-center p-2">Đơn giá</th>
                    <th class="text-center p-2">Số lượng</th>
                </tr>
                <?php
                $count = 1;
                while ($item = mysqli_fetch_assoc($itemsList)) { ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= $item['productName'] ?></td>
                        <td><img class="image-cart" src="admin/uploads/<?= $item['productImage'] ?>" alt=""></td>
                        <td><?= number_format($item['productPrice'], 0, '', ',') ?>VND</td>
                        <td><?= $item['qty'] ?></td>
                    </tr>
                <?php } ?>
            </table>

        </div>
        <?php if ($order['status'] == 'Processing') { ?>
            <div class="d-flex justify-content-center"><a style="padding: 20px 100px" class="btn btn-danger mt-4" href="cancel_order.php?orderId=<?= $_GET['orderId'] ?>">Huỷ đơn hàng</a></div>

        <?php } ?>
    </div>

</body>
<?php
include 'inc/footer.php'
?>

</html>