<?php
include_once '../lib/session.php';
Session::checkSession('admin');
$role_id = Session::get('role_id');
if ($role_id == 1) {
    # code...
} else {
    header("Location:../index.php");
}
include '../classes/orderDetails.php';
include '../classes/order.php';

$orderDetails = new orderDetails();
$result = $orderDetails->getOrderDetails($_GET['orderId']);
$order = new order();
$order_result = $order->getById($result[0]['orderId']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'inc/metadata_libs.php'
    ?>
    <title>Chi tiết đơn đặt hàng</title>
</head>

<body>
    <?php include 'inc/admin_header.php' ?>
    <div class="title">
        <h1>Chi tiết đơn đặt hàng ID <?= $order_result['id'] ?></h1>
    </div>
    <div class="container">
        <div style="padding: 20px 10px">
            <p>Tên khách hàng : <span>Nguyễn Văn Nam</span></p>
            <p>Địa chỉ : <span>ABC</span></p>
            <p>Số điện thoại : <span>ABC</span></p>
            <p>Tổng giá trị đơn hàng : <span>100,000</span> VND</p>

        </div>
        <?php
        if ($result) { ?>
            <table class="list">
                <tr>
                    <th class="text-center p-2">STT</th>
                    <th class="text-center p-2">Tên sản phẩm</th>
                    <th class="text-center p-2">Hình ảnh</th>
                    <th class="text-center p-2">Đơn giá</th>
                    <th class="text-center p-2">Số lượng</th>
                </tr>
                <?php $count = 1;
                foreach ($result as $key => $value) { ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= $value['productName'] ?></td>
                        <td><img class="image-cart" src="uploads/<?= $value['productImage'] ?>" alt=""></td>
                        <td><?= number_format($value['productPrice'], 0, '', ',') ?> VND</td>
                        <td><?= $value['qty'] ?></td>

                    </tr>
                <?php }
                ?>
            </table>
            <?php
            if ($order_result['status'] == 'Processing') { ?>
                <a class="btn btn-dark mt-4" href="processed_order.php?orderId=<?= $_GET['orderId'] ?>">Xác nhận</a>
            <?php }
            ?>
        <?php } else { ?>
            <h3>Chưa có đơn hàng nào đang xử lý</h3>
        <?php }
        ?>
    </div>


    <?php
    include '../inc/footer.php'
    ?>
</body>

</html>