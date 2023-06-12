<?php
session_start();
?>

<?php
include 'util/connectDB.php';

// Xử lý trang hiện tại và số sản phẩm trên mỗi trang
$perPage = 8;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $perPage;

// Lấy danh mục từ cơ sở dữ liệu
$query = "SELECT * FROM categories where status = 1";
$result = mysqli_query($conn, $query);
$categoriesList = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Lấy danh sách sản phẩm theo danh mục và phân trang
$cateId = isset($_GET['cateId']) ? $_GET['cateId'] : 2;

// Xử lý tìm kiếm
$search = isset($_GET['search']) ? $_GET['search'] : '';
if (!empty($search)) {
    $search = mysqli_real_escape_string($conn, $search);
    $sql = "SELECT * FROM products WHERE cateId = '$cateId' AND status = 1 AND name LIKE '%$search%' LIMIT $offset, $perPage";
} else {
    $sql = "SELECT * FROM products WHERE cateId = '$cateId' AND status = 1 LIMIT $offset, $perPage";
}
$result = mysqli_query($conn, $sql);
$list = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Đếm số lượng sản phẩm để tính toán số trang
if (!empty($search)) {
    $sqlCount = "SELECT COUNT(*) AS total FROM products WHERE cateId = '$cateId' AND status = 1 AND name LIKE '%$search%'";
} else {
    $sqlCount = "SELECT COUNT(*) AS total FROM products WHERE cateId = '$cateId' AND status = 1";
}
$resultCount = mysqli_query($conn, $sqlCount);
$rowCount = mysqli_fetch_assoc($resultCount);
$totalProducts = $rowCount['total'];
$pageCount = ceil($totalProducts / $perPage);

mysqli_free_result($result);
mysqli_free_result($resultCount);
mysqli_close($conn);
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
        <h1 class="text-center text-light ">Danh sách sản phẩm</h1>

        <div class="category " style="margin-left: 200px;">
            <span class="text-light" style="margin-bottom: 20px; display: inline-block;">Danh mục:</span>
            <select onchange="location = this.value;">
                <?php
                foreach ($categoriesList as $key => $value) {
                    if ($value['id'] == $cateId) {
                        echo '<option selected value="productList.php?cateId=' . $value['id'] . '">' . $value['name'] . '</option>';
                    } else {
                        echo '<option value="productList.php?cateId=' . $value['id'] . '">' . $value['name'] . '</option>';
                    }
                }
                ?>
            </select>

        </div>
        <div class="search w-50 " style="margin-left: 200px;">
            <form class="" action="" method="GET">
                <input type="hidden" name="cateId" value="<?= $cateId ?>">
                <input type="text" name="search" placeholder="Tìm kiếm sản phẩm" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
                <button class="btn btn-dark p-2 mb-4" type="submit">Tìm kiếm</button>
            </form>
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
                            if ($value['promotionPrice'] < $value['originalPrice']) {
                                echo 'Giá gốc: <del>' . number_format($value['originalPrice'], 0, '', ',') . 'VND</del>';
                            } else {
                                echo '<p>.</p>';
                            }
                            ?>
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
        <?php } ?>
    </div>
    <div class="pagination">
        <?php if ($page > 1) { ?>
            <a href="productList.php?page=<?= ($page <= 1) ? 1 : $page - 1 ?>&cateId=<?= $cateId ?>&search=<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">&laquo;</a>
        <?php } ?>
        <?php for ($i = 1; $i <= $pageCount; $i++) {
            if ($i == $page) { ?>
                <a class="active" href="productList.php?page=<?= $i ?>&cateId=<?= $cateId ?>&search=<?= isset($_GET['search']) ? $_GET['search'] : '' ?>"><?= $i ?></a>
            <?php } else { ?>
                <a href="productList.php?page=<?= $i ?>&cateId=<?= $cateId ?>&search=<?= isset($_GET['search']) ? $_GET['search'] : '' ?>"><?= $i ?></a>
        <?php }
        } ?>
        <?php if ($page < $pageCount) { ?>
            <a href="productList.php?page=<?= $page + 1 ?>&cateId=<?= $cateId ?>&search=<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">&raquo;</a>
        <?php } ?>
    </div>
</body>

<?php include 'inc/footer.php' ?>

</html>