<?php
include_once 'lib/session.php';
Session::checkSession('client');
include_once 'classes/cart.php';
include_once 'classes/orderDetails.php';

$cart = new cart();
$orderDetails = new orderDetails();

$totalQty = $cart->getTotalQtyByUserId();
$result = $orderDetails->getOrderDetails($_GET['orderId']);
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
            <p>Tên khách hàng : <span>Nguyễn Văn Nam</span></p>
            <p>Địa chỉ : <span>ABC</span></p>
            <p>Số điện thoại : <span>ABC</span></p>
            <p>Tổng giá trị đơn hàng : <span>100000</span>VND</p>

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
                <?php $count = 1;
                foreach ($result as $key => $value) { ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= $value['productName'] ?></td>
                        <td><img class="image-cart" src="admin/uploads/<?= $value['productImage'] ?>" alt=""></td>
                        <td><?= number_format($value['productPrice'], 0, '', ',') ?>VND</td>
                        <td><?= $value['qty'] ?></td>
                    </tr>
                <?php }
                ?>
            </table>

        </div>
    </div>
    </div>
</body>
<?php
include 'inc/footer.php'
?>

</html>