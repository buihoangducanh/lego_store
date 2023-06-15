<?php
session_start();
$role_id = $_SESSION['user_role'];
if ($role_id !== 1) {
    header("Location:../index.php");
    exit();
}
require '../util/connectDB.php'; // Kết nối đến cơ sở dữ liệu

// Xử lý khóa/mở/xoá sản phẩm
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['block'])) {
        // Khóa sản phẩm
        $productId = $_POST['id'];
        $query = "UPDATE products SET status = 0 WHERE id = '$productId'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "<script>
                    alert('Đã khóa sản phẩm ID $productId');
                 </script>";
        }
    } elseif (isset($_POST['active'])) {
        // Mở sản phẩm
        $productId = $_POST['id'];
        $query = "UPDATE products SET status = 1 WHERE id = '$productId'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "<script>
                    alert('Đã mở sản phẩm ID $productId');
                 </script>";
        }
    } elseif (isset($_POST['delete'])) {
        // Xoá sản phẩm
        $productId = $_POST['id'];
        $query = "DELETE FROM products WHERE id = '$productId'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "<script>
                    alert('Đã xoá sản phẩm ID $productId');
                 </script>";
        }
    }
}

// Phân trang
$perPage = 8; // Số sản phẩm hiển thị trên mỗi trang
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Trang hiện tại
$start = ($page - 1) * $perPage; // Vị trí bắt đầu lấy dữ liệu trong cơ sở dữ liệu

// Truy vấn dữ liệu sản phẩm từ cơ sở dữ liệu, sử dụng LIMIT và OFFSET để phân trang
$query = "SELECT * FROM products LIMIT $perPage OFFSET $start";
$result = mysqli_query($conn, $query);
$list = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Đếm tổng số sản phẩm
$queryCount = "SELECT COUNT(*) AS total FROM products";
$resultCount = mysqli_query($conn, $queryCount);
$rowCount = mysqli_fetch_assoc($resultCount);
$totalProducts = $rowCount['total'];

// Tính tổng số trang
$pageCount = ceil($totalProducts / $perPage);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'inc/metadata_libs.php'; ?>
    <title>Danh sách sản phẩm</title>
</head>

<body>
    <?php include 'inc/admin_header.php'; ?>

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
                        <td>
                            <?php
                            $userId = $value['createdBy'];
                            $query = "SELECT fullname FROM users WHERE id = '$userId'";
                            $result = mysqli_query($conn, $query);
                            if ($result && mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                echo $row['fullname'];
                            } else {
                                echo "Unknown";
                            }
                            ?>
                        </td>
                        <td><?= $value['qty'] ?></td>
                        <td><?= ($value['status']) ? "Active" : "Block" ?></td>
                        <td class="p-2">
                            <a href="edit_product.php?id=<?= $value['id'] ?>">Xem/Sửa</a>
                            <?php if ($value['status']) { ?>
                                <form action="productlist.php" method="post">
                                    <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                    <input type="submit" value="Khóa" name="block">
                                </form>
                            <?php } else { ?>
                                <form action="productlist.php" method="post">
                                    <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                    <input type="submit" value="Mở" name="active">
                                </form>
                            <?php } ?>
                            <form id="deleteForm_<?= $value['id'] ?>" action="productlist.php" method="post">
                                <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                <input onclick="return confirm('Bạn có chắc chắn muốn xoá sản phẩm này?')" type="submit" value="Xoá" name="delete">
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <h3>Chưa có sản phẩm nào...</h3>
        <?php } ?>
    </div>
    <div class="pagination">
        <a href="productlist.php?page=<?= ($page <= 1) ? 1 : $page - 1 ?>">&laquo;</a>
        <?php for ($i = 1; $i <= $pageCount; $i++) {
            if ($i == $page) { ?>
                <a class="active" href="productlist.php?page=<?= $i ?>"><?= $i ?></a>
            <?php } else { ?>
                <a href="productlist.php?page=<?= $i ?>"><?= $i ?></a>
        <?php }
        } ?>
        <a href="productlist.php?page=<?= ($page < $pageCount) ? $page + 1 : $pageCount ?>">&raquo;</a>
    </div>

    <?php include '../inc/footer.php'; ?>
</body>

</html>