<?php
include '../lib/session.php';
include '../classes/categories.php';
Session::checkSession('admin');
$role_id = Session::get('role_id');
if ($role_id == 1) {
    # code...
} else {
    header("Location:../index.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $categories = new categories();
    if (isset($_POST['block'])) {
        $result = $categories->block($_POST['id']);
        if ($result) {
            echo '<script type="text/javascript">alert("Khóa danh mục thành công!");</script>';
        } else {
            echo '<script type="text/javascript">alert("Khóa danh mục thất bại!");</script>';
        }
    } else if (isset($_POST['active'])) {
        $result = $categories->active($_POST['id']);
        if ($result) {
            echo '<script type="text/javascript">alert("Kích hoạt danh mục thành công!");</script>';
        } else {
            echo '<script type="text/javascript">alert("Kích hoạt danh mục thất bại!");</script>';
        }
    } else {
        echo '<script type="text/javascript">alert("Có lỗi xảy ra!");</script>';
        die();
    }
}

$categories = new categories();
$list = $categories->getAllAdmin((isset($_GET['page']) ? $_GET['page'] : 1));
$pageCount = $categories->getCountPaging();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'inc/metadata_libs.php' ?>
    <title>Danh sách danh mục</title>
</head>

<body>
    <?php
    include 'inc/admin_header.php'
    ?>
    <div class="title">
        <h1>Danh sách danh mục</h1>
    </div>
    <div class="addNew">
        <a class="btn btn-dark ml-5" href="add_category.php">Thêm mới</a>
    </div>
    <div class="container">
        <?php $count = 1;
        if ($list) { ?>
            <table class="list">
                <tr>
                    <th class="text-center p-2">STT</th>
                    <th class="text-center p-2">Tên danh mục</th>
                    <th class="text-center p-2">Trạng thái</th>
                    <th class="text-center p-2">Thao tác</th>
                </tr>
                <?php foreach ($list as $key => $value) { ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= $value['name'] ?></td>
                        <td><?= ($value['status']) ? "Active" : "Block" ?></td>
                        <td class="p-2">
                            <a href="edit_category.php?id=<?= $value['id'] ?>">Xem/Sửa</a>
                            <?php
                            if ($value['status']) { ?>
                                <form action="categoriesList.php" method="post">
                                    <input type="text" name="id" hidden value="<?= $value['id'] ?>" style="display: none;">
                                    <input type="submit" value="Khóa" name="block">
                                </form>
                            <?php } else { ?>
                                <form action="categoriesList.php" method="post">
                                    <input type="text" name="id" hidden value="<?= $value['id'] ?>" style="display: none;">
                                    <input type="submit" value="Mở" name="active">
                                </form>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <h3>Chưa có danh mục nào...</h3>
        <?php } ?>
        <div class="pagination">
            <a href="categoriesList.php?page=<?= (isset($_GET['page'])) ? (($_GET['page'] <= 1) ? 1 : $_GET['page'] - 1) : 1 ?>">&laquo;</a>
            <?php
            for ($i = 1; $i <= $pageCount; $i++) {
                if (isset($_GET['page'])) {
                    if ($i == $_GET['page']) { ?>
                        <a class="active" href="categoriesList.php?page=<?= $i ?>"><?= $i ?></a>
                    <?php } else { ?>
                        <a href="categoriesList.php?page=<?= $i ?>"><?= $i ?></a>
                    <?php  }
                } else { ?>
                    <a href="categoriesList.php?page=<?= $i ?>"><?= $i ?></a>
                <?php  } ?>
            <?php }
            ?>
            <a href="categoriesList.php?page=<?= (isset($_GET['page'])) ? $_GET['page'] + 1 : 2 ?>">&raquo;</a>
        </div>
    </div>
    </div>

    <?php
    include '../inc/footer.php'
    ?>
</body>

</html>