<?php
session_start();
$role_id = $_SESSION['user_role'];
if ($role_id !== 1) {
    header("Location:../index.php");
    exit();
}
?>

<?php
include '../util/connectDB.php';

// Lấy danh sách danh mục
$queryCategories = "SELECT * FROM categories";
$resultCategories = mysqli_query($conn, $queryCategories);
$categoriesList = mysqli_fetch_all($resultCategories, MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $originalPrice = $_POST['originalPrice'];
        $promotionPrice = $_POST['promotionPrice'];
        $image = basename($_FILES['image']['name']);
        $tmpImage = $_FILES['image']['tmp_name'];
        $cateId = $_POST['cateId'];
        $qty = $_POST['qty'];
        $description = $_POST['des'];
        $creator = $_SESSION['user_id'];
        // Kiểm tra xem sản phẩm đã tồn tại hay chưa
        $queryCheckProduct = "SELECT * FROM products WHERE name = '$name'";
        $resultCheckProduct = mysqli_query($conn, $queryCheckProduct);

        if (mysqli_num_rows($resultCheckProduct) > 0) {
            echo "<script>alert('Sản phẩm đã tồn tại!');</script>";
        } else {
            // Upload hình ảnh
            $uploadPath = 'uploads/' . $image;
            move_uploaded_file($tmpImage, $uploadPath);

            // Thực hiện thêm mới sản phẩm
            $queryAddProduct = "INSERT INTO products (name, originalPrice, promotionPrice, image,createdBy, cateId, qty, des) VALUES ('$name', $originalPrice, $promotionPrice, '$image',$creator, $cateId, $qty, '$description')";
            $resultAddProduct = mysqli_query($conn, $queryAddProduct);

            if ($resultAddProduct) {
                echo "<script>alert('Thêm mới sản phẩm thành công!');</script>";
            } else {
                echo "<script>alert('Đã xảy ra lỗi. Vui lòng thử lại!');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'inc/metadata_libs.php'
    ?>
    <title>Thêm mới sản phẩm</title>
</head>

<body>
    <?php
    include 'inc/admin_header.php'
    ?>
    <div class="title">
        <h1>Thêm mới sản phẩm</h1>
    </div>
    <div class="container">
        <div class="form-add" style="background-color: unset;">
            <form action="add_product.php" method="post" enctype="multipart/form-data">
                <label for="name">Tên sản phẩm</label>
                <input type="text" id="name" name="name" placeholder="Tên sản phẩm.." required>

                <label for="originalPrice">Giá gốc</label>
                <input type="number" id="originalPrice" name="originalPrice" placeholder="Giá.." required min="1">

                <label for="promotionPrice">Giá khuyến mãi</label>
                <input type="number" id="promotionPrice" name="promotionPrice" placeholder="Giá.." required min="1">

                <label for="image">Hình ảnh</label>
                <input type="file" id="image" name="image" required>

                <label for="cateId">Loại sản phẩm</label>
                <select id="cateId" name="cateId">
                    <?php
                    foreach ($categoriesList as $key => $value) { ?>
                        <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                    <?php }
                    ?>
                </select>

                <label for="qty">Số lượng</label>
                <input type="number" id="qty" name="qty" required min="1">

                <label for="des">Mô tả</label>
                <textarea name="des" id="des" cols="30" rows="10" required></textarea>

                <input type="submit" value="Lưu" name="submit">
            </form>
        </div>
    </div>
    <?php
    include '../inc/footer.php'
    ?>
</body>

</html>