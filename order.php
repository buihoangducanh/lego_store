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

    <?php
    include 'inc/header.php'
    ?>
    <div class="banner">
        <img src="images/banner2.jpg" alt="">
    </div>
    <div class="container-intro-section" style="padding-top: unset; min-height: 40vh;">
        <h1 class="text-center">Đơn hàng</h1>

        <div class="container-single">
            <?php
            $user_id = $_SESSION['user_id'];

            $query = "SELECT * FROM users WHERE id = '$user_id'";
            $result = mysqli_query($conn, $query);
            $userInfo = mysqli_fetch_assoc($result);

            $query = "SELECT * FROM orders WHERE userId = '$user_id'";
            $result = mysqli_query($conn, $query);
            $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
            ?>

            <?php if (!empty($orders)) { ?>
                <table class="order">
                    <tr>
                        <th class="text-center p-2">STT</th>
                        <th class="text-center p-2">Mã đơn hàng</th>
                        <th class="text-center p-2">Ngày đặt</th>
                        <th class="text-center p-2">Ngày giao</th>
                        <th class="text-center p-2">Tình trạng</th>
                        <th class="text-center p-2">Thao tác</th>
                    </tr>
                    <?php
                    $count = 1;
                    foreach ($orders as $order) {
                    ?>
                        <tr>
                            <td><?= $count++ ?></td>
                            <td><?= $order['id'] ?></td>
                            <td><?= $order['createdDate'] ?></td>
                            <td>
                                <?php
                                if ($order['status'] != "Processing") {
                                    echo $order['receivedDate'];
                                } else {
                                    echo "Dự kiến 3 ngày sau khi đơn hàng đã được xử lý";
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($order['status'] == 'Delivering') {
                                ?>
                                    <a href="complete_order.php?orderId=<?= $order['id'] ?>">Đang giao (Click vào để xác nhận đã nhận)</a>
                                <?php
                                } else {
                                    echo $order['status'];
                                }
                                ?>
                            </td>
                            <td>
                                <a href="orderdetail.php?orderId=<?= $order['id'] ?>">Chi tiết</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            <?php } else { ?>
                <h3>Đơn hàng hiện đang rỗng</h3>
            <?php } ?>
        </div>
    </div>
    <?php
    include 'inc/footer.php'
    ?>
</body>

</html>