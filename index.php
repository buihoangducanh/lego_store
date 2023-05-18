<?php
include_once 'lib/session.php';
include_once 'classes/product.php';

$list = mysqli_fetch_all(product::getFeaturedProducts(), MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require 'inc/metadata_cdnLib.php' ?>

    <title>Trang chủ</title>

</head>

<body>
    <?php
    require 'inc/header.php'
    ?>
    <div class="banner">
        <img src="images/banner2.jpg" alt="">
    </div>
    <div class="featuredProducts black-background">
        <h2 class="mx-auto fw-bolder" style="padding: 50px 0px;">BÁN CHẠY NHẤT</h2>
    </div>
    <main class="container " style="padding-right: 0; padding-left:0 ;">
        <?php
        foreach ($list as $key => $value) { ?>
            <div class="card d-flex flex-column justify-content-between">
                <div class="imgBx">
                    <a href="detail.php?id=<?= $value['id'] ?>"><img src="admin/uploads/<?= $value['image'] ?>" alt=""></a>
                </div>
                <div class="content d-flex flex-column justify-content-between">
                    <div class="productName ">
                        <a href="detail.php?id=<?= $value['id'] ?>">
                            <h5><?= $value['name'] ?></h5>
                        </a>
                    </div>
                    <div>
                        Đã bán: <?= $value['soldCount'] ?>
                    </div>
                    <div class="original-price">
                        <?php
                        if ($value['promotionPrice'] < $value['originalPrice']) { ?>
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
        <?php }
        ?>
    </main>
</body>


</html>
<?php
require 'inc/footer.php'
?>