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

    // Truy vấn và lấy thông tin người dùng từ bảng users
    $userId = $order_result['userId'];
    $user_query = "SELECT fullname, address, phone_number FROM users WHERE id = $userId";
    $user_result = mysqli_fetch_assoc(mysqli_query($conn, $user_query));

    // Truy vấn và lấy danh sách sản phẩm trong đơn đặt hàng
    $product_query = "SELECT * FROM order_details WHERE orderId = $orderId";
    $product_result = mysqli_query($conn, $product_query);
    $result = [];

    if (mysqli_num_rows($product_result) > 0) {
        while ($row = mysqli_fetch_assoc($product_result)) {
            $productId = $row['productId'];

            // Truy vấn và lấy thông tin chi tiết của từng sản phẩm
            $product_info_query = "SELECT * FROM products WHERE id = $productId";
            $product_info_result = mysqli_fetch_assoc(mysqli_query($conn, $product_info_query));

            $row['productName'] = $product_info_result['name'];
            $row['productImage'] = $product_info_result['image'];
            $row['productPrice'] = $product_info_result['originalPrice'];

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
            <p>Tên khách hàng : <span><?= $user_result['fullname'] ?></span></p>
            <p>Địa chỉ : <span><?= $user_result['address'] ?></span></p>
            <p>Số điện thoại : <span><?= $user_result['phone_number'] ?></span></p>
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
                foreach ($result as $value) { ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= $value['productName'] ?></td>
                        <td><img class="image-cart" src="uploads/<?= $value['productImage'] ?>" alt=""></td>
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