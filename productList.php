<?php
include_once 'lib/session.php';
include_once 'classes/product.php';
include_once 'classes/categories.php';

$list = product::getProductsByCateId((isset($_GET['page']) ? $_GET['page'] : 1), (isset($_GET['cateId']) ? $_GET['cateId'] : 2));
$pageCount = product::getCountPagingClient((isset($_GET['cateId']) ? $_GET['cateId'] : 2));


$categoriesList = categories::getAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'inc/metadata_cdnLib.php' ?>
    <title>Danh sách sản phẩm</title>
</head>

<body>
    <?php include 'inc/header.php' ?>
    <section class="banner"></section>
    <div class="container-intro-section black-background">
        <h1 class="text-center text-light">Danh sách sản phẩm</h1>

        <div class="category" style="margin-left: 200px;">
            <span class="text-light" style="margin-bottom: 20px;
    display: inline-block;">Danh mục:</span> <select onchange="location = this.value;">
                <?php
                foreach ($categoriesList as $key => $value) {
                    if ($value['id'] == $_GET['cateId']) { ?>
                        <option selected value="productList.php?cateId=<?= $value['id'] ?>"><?= $value['name'] ?></option>
                    <?php } else { ?>
                        <option value="productList.php?cateId=<?= $value['id'] ?>"><?= $value['name'] ?></option>
                    <?php } ?>
                <?php }
                ?>
            </select>
        </div>
    </div>

    <div class="container">
        <?php if ($list) {
            foreach ($list as $key => $value) { ?>
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
        } else { ?>
            <h3>Không có sản phẩm nào...</h3>
        <?php  }
        ?>
    </div>
    <div class="pagination">
        <a href="productList.php?page=<?= (isset($_GET['page'])) ? (($_GET['page'] <= 1) ? 1 : $_GET['page'] - 1) : 1 ?>&cateId=<?= (isset($_GET['cateId'])) ? $_GET['cateId'] : 2 ?>">&laquo;</a>
        <?php
        for ($i = 1; $i <= $pageCount; $i++) {
            if (isset($_GET['page'])) {
                if ($i == $_GET['page']) { ?>
                    <a class="active" href="productList.php?page=<?= $i ?>&cateId=<?= (isset($_GET['cateId'])) ? $_GET['cateId'] : 2 ?>"><?= $i ?></a>
                <?php } else { ?>
                    <a href="productList.php?page=<?= $i ?>&cateId=<?= (isset($_GET['cateId'])) ? $_GET['cateId'] : 2 ?>"><?= $i ?></a>
                <?php  }
            } else { ?>
                <a href="productList.php?page=<?= $i ?>&cateId=<?= (isset($_GET['cateId'])) ? $_GET['cateId'] : 2 ?>"><?= $i ?></a>
            <?php  } ?>
        <?php }
        ?>
        <a href="productList.php?page=<?= (isset($_GET['page'])) ? $_GET['page'] + 1 : 2 ?>&cateId=<?= (isset($_GET['cateId'])) ? $_GET['cateId'] : 2 ?>">&raquo;</a>
    </div>
</body>
<?php
include 'inc/footer.php'
?>

</html>