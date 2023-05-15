<?php
include_once 'lib/session.php';
Session::checkSession('client');
include 'classes/order.php';
include_once 'classes/cart.php';

$cart = new cart();
$totalQty = $cart->getTotalQtyByUserId();

$order = new order();
$result = $order->getOrderByUser();

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
    <!-- <nav>
        <label class="logo">LEGO</label>
        <ul>
            <li><a href="index.php">Trang chủ</a></li>
            <li><a href="productList.php">Sản phẩm</a></li>
            <?php
            if (isset($_SESSION['user']) && $_SESSION['user']) { ?>
                <li><a href="logout.php" id="signin">Đăng xuất</a></li>
            <?php } else { ?>
                <li><a href="register.php" id="signup">Đăng ký</a></li>
                <li><a href="login.php" id="signin">Đăng nhập</a></li>
            <?php } ?>
            <li><a href="order.php" id="order" class="active">Đơn hàng</a></li>
            <li>
                <a href="checkout.php">
                    <i class="fa fa-shopping-bag"></i>
                    <span class="sumItem">
                        <?= $totalQty['total'] ?>
                    </span>
                </a>
            </li>
        </ul>
    </nav> -->
    <?php
    include 'inc/header.php'
    ?>
    <div class="banner">
        <img src="images/banner2.jpg" alt="">
    </div>
    <div class="container-intro-section" style="padding-top: unset; min-height: 40vh;">
        <h1 class="text-center">Đơn hàng</h1>

        <div class="container-single">
            <?php if ($result) { ?>
                <table class="order">
                    <tr>
                        <th>STT</th>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt</th>
                        <th>Ngày giao</th>
                        <th>Tình trạng</th>
                        <th>Thao tác</th>
                    </tr>
                    <?php $count = 1;
                    foreach ($result as $key => $value) { ?>
                        <tr>
                            <td><?= $count++ ?></td>
                            <td><?= $value['id'] ?></td>
                            <td><?= $value['createdDate'] ?></td>
                            <td><?= ($value['status'] != "Processing") ? $value['receivedDate'] : "Dự kiến 3 ngày sau khi đơn hàng đã được xử lý" ?> <?= ($value['status'] != "Complete" && $value['status'] != "Processing") ? "(Dự kiến)" : "" ?> </td>
                            <?php
                            if ($value['status'] == 'Delivering') { ?>
                                <td>
                                    <a href="complete_order.php?orderId=<?= $value['id'] ?>">Đang giao (Click vào để xác nhận đã nhận)</a>
                                </td>
                                <td>
                                    <a href="orderdetail.php?orderId=<?= $value['id'] ?>">Chi tiết</a>
                                </td>
                            <?php } else { ?>
                                <td>
                                    <?= $value['status'] ?>
                                </td>
                                <td>
                                    <a href="orderdetail.php?orderId=<?= $value['id'] ?>">Chi tiết</a>
                                </td>
                            <?php }
                            ?>
                        </tr>
                    <?php } ?>
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