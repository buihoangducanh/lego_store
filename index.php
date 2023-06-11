<?php
session_start();
require 'util/connectDB.php'; // Kết nối đến cơ sở dữ liệu

// Truy vấn lấy danh sách sản phẩm bán chạy nhất
$sql = "SELECT *
        FROM products
        WHERE products.status = 1
        ORDER BY products.soldCount DESC
        LIMIT 8";

$result = mysqli_query($conn, $sql);

// Kiểm tra kết quả truy vấn
if (mysqli_num_rows($result) > 0) {
    $list = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $list = array(); // Khởi tạo danh sách rỗng nếu không có kết quả
}

// Đóng kết nối đến cơ sở dữ liệu
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require 'inc/metadata_cdnLib.php' ?>
    <title>Trang chủ</title>
</head>

<body>
    <?php require 'inc/header.php' ?>
    <div class="banner">
        <img src="images/banner2.jpg" alt="">
    </div>
    <div class="featuredProducts black-background">
        <h2 class="mx-auto fw-bolder" style="padding: 50px 0px;">BÁN CHẠY NHẤT</h2>
    </div>
    <main class="container" style="padding-right: 0; padding-left:0 ;">
        <?php foreach ($list as $key => $value) { ?>
            <div class="card d-flex flex-column justify-content-between">
                <div class="imgBx">
                    <a href="detail.php?id=<?= $value['id'] ?>"><img src="admin/uploads/<?= $value['image'] ?>" alt=""></a>
                </div>
                <div class="content d-flex flex-column justify-content-between">
                    <div class="productName">
                        <a href="detail.php?id=<?= $value['id'] ?>">
                            <h5><?= $value['name'] ?></h5>
                        </a>
                    </div>
                    <div>
                        Đã bán: <?= $value['soldCount'] ?>
                    </div>
                    <div class="original-price">
                        <?php if ($value['promotionPrice'] < $value['originalPrice']) { ?>
                            Giá gốc: <del><?= number_format($value['originalPrice'], 0, '', ',') ?>VND</del>
                        <?php } else { ?>
                            <p>.</p>
                        <?php } ?>
                    </div>
                    <div class="price">
                        Giá bán: <?= number_format($value['promotionPrice'], 0, '', ',') ?>VND
                    </div>
                    <div class="action">
                        <a class="add-cart" href="add_cart.php?id=<?= $value['id'] ?>">Thêm vào giỏ</a>
                        <a class="detail" href="detail.php?id=<?= $value['id'] ?>">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </main>
    <?php require 'inc/footer.php' ?>
</body>

</html>