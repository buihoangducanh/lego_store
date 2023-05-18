<?php
include_once 'lib/session.php';
Session::checkSession('client');
include 'classes/order.php';

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
                        <th class="text-center p-2">STT</th>
                        <th class="text-center p-2">Mã đơn hàng</th>
                        <th class="text-center p-2">Ngày đặt</th>
                        <th class="text-center p-2">Ngày giao</th>
                        <th class="text-center p-2">Tình trạng</th>
                        <th class="text-center p-2">Thao tác</th>
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