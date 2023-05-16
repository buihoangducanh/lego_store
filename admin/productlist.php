<?php
include '../lib/session.php';
include '../classes/product.php';
Session::checkSession('admin');
$role_id = Session::get('role_id');
if ($role_id == 1) {
    # code...
} else {
    header("Location:../index.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product = new product();
    if (isset($_POST['block'])) {
        $result = $product->block($_POST['id']);
        if ($result) {
            echo '<script type="text/javascript">alert("Khóa sản phẩm thành công!");</script>';
        } else {
            echo '<script type="text/javascript">alert("Khóa sản phẩm thất bại!");</script>';
        }
    } else if (isset($_POST['active'])) {
        $result = $product->active($_POST['id']);
        if ($result) {
            echo '<script type="text/javascript">alert("Kích hoạt sản phẩm thành công!");</script>';
        } else {
            echo '<script type="text/javascript">alert("Kích hoạt sản phẩm thất bại!");</script>';
        }
    } else {
        echo '<script type="text/javascript">alert("Có lỗi xảy ra!");</script>';
        die();
    }
}

$product = new product();
$list = $product->getAllAdmin((isset($_GET['page']) ? $_GET['page'] : 1));
$pageCount = $product->getCountPaging();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'inc/metadata_libs.php'
    ?>
    <title>Danh sách sản phẩm</title>
</head>

<body>
    <?php
    include 'inc/admin_header.php'
    ?>

    <div class="title">
        <h1>Danh sách sản phẩm</h1>
    </div>
    <div class="addNew">
        <a class="btn btn-dark ml-5" href="add_product.php">Thêm mới</a>
    </div>
    <div class="container">
        <?php $count = 1;
        if ($list) { ?>
            <table class="list">
                <tr>
                    <th class="text-center p-2">STT</th>
                    <th class="text-center p-2">Tên sản phẩm</th>
                    <th class="text-center p-2">Hình ảnh</th>
                    <th class="text-center p-2">Giá gốc</th>
                    <th class="text-center p-2">Giá khuyến mãi</th>
                    <th class="text-center p-2">Tạo bởi</th>
                    <th class="text-center p-2">Số lượng</th>
                    <th class="text-center p-2">Trạng thái</th>
                    <th class="text-center p-2">Thao tác</th>
                </tr>
                <?php foreach ($list as $key => $value) { ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= $value['name'] ?></td>
                        <td><img class="image-cart" src="uploads/<?= $value['image'] ?>" alt=""></td>
                        <td><?= number_format($value['originalPrice'], 0, '', ',') ?> VND</td>
                        <td><?= number_format($value['promotionPrice'], 0, '', ',') ?> VND</td>
                        <td><?= $value['fullName'] ?></td>
                        <td><?= $value['qty'] ?></td>
                        <td><?= ($value['status']) ? "Active" : "Block" ?></td>
                        <td class="p-2">
                            <a href="edit_product.php?id=<?= $value['id'] ?>">Xem/Sửa</a>
                            <?php
                            if ($value['status']) { ?>
                                <form action="productlist.php" method="post">
                                    <input type="text" name="id" hidden value="<?= $value['id'] ?>" style="display: none;">
                                    <input type="submit" value="Khóa" name="block">
                                </form>
                            <?php } else { ?>
                                <form action="productlist.php" method="post">
                                    <input type="text" name="id" hidden value="<?= $value['id'] ?>" style="display: none;">
                                    <input type="submit" value="Mở" name="active">
                                </form>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <h3>Chưa có sản phẩm nào...</h3>
        <?php } ?>
    </div>
    <div class="pagination">
        <a href="productlist.php?page=<?= (isset($_GET['page'])) ? (($_GET['page'] <= 1) ? 1 : $_GET['page'] - 1) : 1 ?>">&laquo;</a>
        <?php
        for ($i = 1; $i <= $pageCount; $i++) {
            if (isset($_GET['page'])) {
                if ($i == $_GET['page']) { ?>
                    <a class="active" href="productlist.php?page=<?= $i ?>"><?= $i ?></a>
                <?php } else { ?>
                    <a href="productlist.php?page=<?= $i ?>"><?= $i ?></a>
                <?php  }
            } else {
                if ($i == 1) { ?>
                    <a class="active" href="productlist.php?page=<?= $i ?>"><?= $i ?></a>
                <?php  } else { ?>
                    <a href="productlist.php?page=<?= $i ?>"><?= $i ?></a>
                <?php   } ?>
            <?php  } ?>
        <?php }
        ?>
        <a href="productlist.php?page=<?= (isset($_GET['page'])) ? $_GET['page'] + 1 : 2 ?>">&raquo;</a>
    </div>

    <?php
    include '../inc/footer.php'
    ?>
</body>

</html>