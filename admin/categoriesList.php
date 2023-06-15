<?php
session_start();
require '../util/connectDB.php'; // Kết nối đến cơ sở dữ liệu
$role_id = $_SESSION['user_role'];
if ($role_id !== 1) {
    header("Location:../index.php");
    exit();
}

// Xử lý khóa/mở danh mục
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['block'])) {
        $categoryId = $_POST['id'];
        // Thực hiện khóa danh mục (cập nhật trạng thái)
        $query = "UPDATE categories SET status = 0 WHERE id = '$categoryId'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "<script>
                    alert('Đã khoá danh mục với id $categoryId');
                 </script>";
        }
    } elseif (isset($_POST['active'])) {
        $categoryId = $_POST['id'];
        // Thực hiện mở danh mục (cập nhật trạng thái)
        $query = "UPDATE categories SET status = 1 WHERE id = '$categoryId'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "<script>
                    alert('Mở khoá danh mục với id $categoryId');
                 </script>";
        }
    } elseif (isset($_POST['delete'])) {
        $categoryId = $_POST['id'];
        // Thực hiện xoá danh mục
        $query = "DELETE FROM categories WHERE id = '$categoryId'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "<script>
                    alert('Đã xoá danh mục với id $categoryId');
                 </script>";
        }
    }
}
// Lấy danh sách danh mục từ cơ sở dữ liệu
$perPage = 5; // Số danh mục hiển thị trên mỗi trang
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Trang hiện tại

// Tính toán số lượng trang và vị trí bắt đầu
$queryCount = "SELECT COUNT(*) AS total FROM categories";
$resultCount = mysqli_query($conn, $queryCount);
$rowCount = mysqli_fetch_assoc($resultCount);
$totalCategories = $rowCount['total'];
$pageCount = ceil($totalCategories / $perPage);
$start = ($page - 1) * $perPage;

$queryList = "SELECT * FROM categories ORDER BY id ASC LIMIT $start, $perPage";
$resultList = mysqli_query($conn, $queryList);
$list = mysqli_fetch_all($resultList, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'inc/metadata_libs.php' ?>
    <title>Danh sách danh mục</title>
</head>

<body>
    <?php include 'inc/admin_header.php' ?>
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
                                    <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                    <input type="submit" value="Khóa" name="block">
                                </form>
                            <?php } else { ?>
                                <form action="categoriesList.php" method="post">
                                    <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                    <input type="submit" value="Mở" name="active">
                                </form>
                            <?php } ?>
                            <form action="categoriesList.php" method="post" style="display: inline;">
                                <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                <input type="submit" value="Xoá" name="delete" onclick="return confirm('Bạn có chắc chắn muốn xoá danh mục này?')">
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <h3>Chưa có danh mục nào...</h3>
        <?php } ?>
        <div class="pagination">
            <?php if ($page > 1) { ?>
                <a href="categoriesList.php?page=<?= $page - 1 ?>">&laquo;</a>
            <?php } else { ?>
                <span class="disabled">&laquo;</span>
            <?php } ?>
            <?php for ($i = 1; $i <= $pageCount; $i++) { ?>
                <?php if ($i == $page) { ?>
                    <a class="active" href="categoriesList.php?page=<?= $i ?>"><?= $i ?></a>
                <?php } else { ?>
                    <a href="categoriesList.php?page=<?= $i ?>"><?= $i ?></a>
                <?php } ?>
            <?php } ?>
            <?php if ($page < $pageCount) { ?>
                <a href="categoriesList.php?page=<?= $page + 1 ?>">&raquo;</a>
            <?php } else { ?>
                <span class="disabled">&raquo;</span>
            <?php } ?>
        </div>
    </div>

    <?php include '../inc/footer.php' ?>
</body>

</html>