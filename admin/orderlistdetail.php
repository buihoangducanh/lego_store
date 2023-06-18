<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    session_start();
    $role_id = $_SESSION['user_role'];
    if ($role_id !== 1) {
        header("Location:../index.php");
        exit();
    }

    require '../util/connectDB.php'; // Kết nối đến cơ sở dữ liệu

    include 'inc/metadata_libs.php';

    $orderId = $_GET['orderId'];

    // Truy vấn và lấy thông tin chi tiết đơn đặt hàng
    $order_query = "SELECT * FROM orders WHERE id = $orderId";
    $order_result = mysqli_fetch_assoc(mysqli_query($conn, $order_query));

    // Truy vấn và lấy danh sách sản phẩm trong đơn đặt hàng
    $product_query = "SELECT * FROM order_details WHERE orderId = $orderId";
    $product_result = mysqli_query($conn, $product_query);
    $result = [];

    if (mysqli_num_rows($product_result) > 0) {
        while ($row = mysqli_fetch_assoc($product_result)) {
            $result[] = $row;
        }
    }
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
            <p>Tên khách hàng : <span><?= $order_result['receiverName'] ?></span></p>
            <p>Địa chỉ : <span><?= $order_result['receiverAddress'] ?></span></p>
            <p>Số điện thoại : <span><?= $order_result['receiverPhoneNumber'] ?></span></p>
            <p>Tổng giá trị đơn hàng : <span><?= number_format($order_result['total'], 0, '', ',') ?></span> VND</p>
        </div>
        <?php
        if (count($result) > 0) { ?>
            <table class="list">
                <tr>
                    <th class="text-center p-2">STT</th>
                    <th class="text-center p-2">Tên sản phẩm</th>
                    <th class="text-center p-2">Hình ảnh</th>
                    <th class="text-center p-2">Đơn giá</th>
                    <th class="text-center p-2">Số lượng</th>
                </tr>
                <?php $count = 1;
                foreach ($result as $value) {

                    $productId = $value["productId"];
                    $query = "SELECT * FROM products WHERE id = $productId";
                    $res  = mysqli_query($conn, $query);
                    if ($res) {
                        $product = mysqli_fetch_assoc($res);
                    }

                ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= $product['name'] ?></td>
                        <td><img class="image-cart" src="uploads/<?= $product['image'] ?>" alt=""></td>
                        <td><?= number_format($value['productPrice'], 0, '', ',') ?> VND</td>
                        <td><?= $value['qty'] ?></td>
                    </tr>
                <?php } ?>
            </table>
            <?php if ($order_result['status'] == 'Processing') { ?>
                <a class="btn btn-dark mt-4" href="processed_order.php?orderId=<?= $_GET['orderId'] ?>">Xác nhận</a>
            <?php }
            ?>
        <?php } else { ?>
            <h3>Chưa có đơn hàng nào đang xử lý</h3>
        <?php } ?>
    </div>
    <?php include '../inc/footer.php' ?>
</body>

</html>