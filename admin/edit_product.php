<?php
session_start();
require '../util/connectDB.php'; // Kết nối đến cơ sở dữ liệu
$role_id = $_SESSION['user_role'];
if ($role_id !== 1) {
    header("Location:../index.php");
    exit();
}

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Fetch product details from the database
    $sql = "SELECT * FROM products WHERE id = '$productId'";
    $result = mysqli_query($conn, $sql);
    $productUpdate = mysqli_fetch_assoc($result);

    // Fetch categories list
    $categoriesList = array();
    $sql = "SELECT * FROM categories";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $categoriesList[] = $row;
    }

    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $originalPrice = $_POST['originalPrice'];
        $promotionPrice = $_POST['promotionPrice'];
        $cateId = $_POST['cateId'];
        $qty = $_POST['qty'];
        $des = $_POST['des'];

        // Check if a new image is uploaded
        if (!empty($_FILES['image']['name'])) {
            $image = $_FILES['image']['name'];
            $target = "uploads/" . basename($image);

            // Upload the new image
            move_uploaded_file($_FILES['image']['tmp_name'], $target);
        } else {
            // If no new image is uploaded, retain the existing image
            $image = $productUpdate['image'];
        }

        // Update the product in the database
        $sql = "UPDATE products SET name='$name', originalPrice='$originalPrice', promotionPrice='$promotionPrice', image='$image', cateId='$cateId', qty='$qty', des='$des' WHERE id='$id'";
        mysqli_query($conn, $sql);

        if (mysqli_affected_rows($conn) > 0) {
            echo "<script>alert('Sản phẩm đã được cập nhật thành công.'); window.location.href = 'productList.php';</script>";
            exit();
        } else {
            echo "<script>alert('Có lỗi xảy ra. Vui lòng thử lại sau.'); history.back();</script>";
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
    <title>Chỉnh sửa sản phẩm</title>
</head>

<body style="background-color: white;">
    <?php include 'inc/admin_header.php' ?>
    <div class="title">
        <h1>Chỉnh sửa sản phẩm</h1>
    </div>
    <div class="container">
        <div class="form-add" style="padding-top: 30px; padding-bottom: 30px;">
            <form action="edit_product.php?id=<?= $productUpdate['id'] ?>" method="post" enctype="multipart/form-data">
                <input type="text" hidden name="id" style="display: none;" value="<?= $productUpdate['id'] ?>">
                <label for="name">Tên sản phẩm</label>
                <input type="text" id="name" name="name" placeholder="Tên sản phẩm.." value="<?= $productUpdate['name'] ?>">

                <label for="originalPrice">Giá gốc</label>
                <input type="number" id="originalPrice" name="originalPrice" value="<?= $productUpdate['originalPrice'] ?>">

                <label for="promotionPrice">Giá khuyến mãi</label>
                <input type="number" id="promotionPrice" name="promotionPrice" value="<?= $productUpdate['promotionPrice'] ?>">

                <label for="image">Hình ảnh</label>
                <img src="uploads/<?= $productUpdate['image'] ?>" style="height: 200px;" id="image"> <br>

                <label for="imageNew">Chọn hình ảnh mới</label>
                <input type="file" id="imageNew" name="image">

                <label for="cateId">Loại sản phẩm</label>
                <select id="cateId" name="cateId">
                    <?php foreach ($categoriesList as $key => $value) {
                        if ($value['id'] == $productUpdate['cateId']) { ?>
                            <option selected value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                        <?php  } else { ?>
                            <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                        <?php   } ?>
                    <?php } ?>
                </select>

                <label for="qty">Số lượng</label>
                <input type="number" id="qty" name="qty" value="<?= $productUpdate['qty'] ?>">

                <label for="des">Mô tả</label>
                <textarea name="des" id="des" cols="30" rows="10"><?= $productUpdate['des'] ?></textarea>

                <input type="submit" value="Lưu" name="submit">
            </form>
        </div>
    </div>
    </div>

    <?php include '../inc/footer.php' ?>
</body>

</html>