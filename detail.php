<?php
session_start();
require 'util/connectDB.php'; // Kết nối đến cơ sở dữ liệu

// Lấy giá trị của $id từ URL hoặc bất kỳ nguồn dữ liệu nào khác
$id = $_GET['id'];

// Truy vấn lấy chi tiết sản phẩm theo id
$sql = "SELECT * FROM products WHERE id = '$id' AND status = 1";
$result = mysqli_query($conn, $sql);

// Kiểm tra kết quả truy vấn
if (mysqli_num_rows($result) == 1) {
    $result = mysqli_fetch_assoc($result);
} else {
    // Xử lý tương ứng nếu sản phẩm không tồn tại (ví dụ: chuyển hướng về trang 404)
    header("Location: 404.php");
    exit();
}

// Đóng kết nối đến cơ sở dữ liệu
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'inc/metadata_cdnLib.php' ?>

<head>
    <title><?= $result['name'] ?></title>
</head>

<body>
    <?php include 'inc/header.php' ?>
    <div class="banner">
        <img src="images/banner2.jpg" alt="">
    </div>
    <div class="featuredProducts black-background">
        <h2 class="mx-auto fw-bolder" style="padding: 50px 0px; margin-bottom: 40px;">Chi tiết sản phẩm</h2>
    </div>
    <div class="container-single" style="margin-top: 100px;">
        <div class="image-product">
            <img src="admin/uploads/<?= $result['image'] ?>" alt="">
        </div>
        <div class="info">
            <div class="name">
                <h2><?= $result['name'] ?></h2>
            </div>
            <div class="price-single">
                Giá bán: <b><?= number_format($result['promotionPrice'], 0, '', ',') ?>VND</b>
            </div>
            <?php
            if ($result['promotionPrice'] < $result['originalPrice']) { ?>
                <div>
                    Gía gốc: <del><?= number_format($result['originalPrice'], 0, '', ',') ?>VND</del>
                </div>
            <?php }
            ?>
            <div class="des">
                <p>Đã bán: <?= $result['soldCount'] ?></p>
                <?= $result['des'] ?>
            </div>
            <div class="add-cart-single">
                <a href="add_cart.php?id=<?= $result['id'] ?>">Thêm vào giỏ</a>
            </div>
        </div>
    </div>
    <?php include 'inc/footer.php' ?>
</body>

</html>