<?php
include 'classes/product.php';

$result = product::getProductbyId($_GET['id']);

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


</body>
<?php
include 'inc/footer.php'
?>

</html>