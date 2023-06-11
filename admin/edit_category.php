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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
        $categoryId = $_POST['id'];
        $name = $_POST['name'];

        // Kiểm tra danh mục với tên này đã tồn tại hay chưa
        $checkQuery = "SELECT id FROM categories WHERE name = '$name' AND id != '$categoryId'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            $result = "<p style='color: red;text-align: center;'>Danh mục với tên này đã tồn tại. Vui lòng chọn tên khác.</p>";
        } else {
            // Thực hiện cập nhật danh mục
            $query = "UPDATE categories SET name = '$name' WHERE id = '$categoryId'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                $result = "<p style='color: green;text-align: center;'>Cập nhật danh mục thành công!</p>";
            } else {
                $result = "<p style='color: red;text-align: center;'>Đã xảy ra lỗi. Vui lòng thử lại!</p>";
            }
        }
    }
}

// Lấy thông tin danh mục cần chỉnh sửa từ cơ sở dữ liệu
if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];
    $categoryQuery = "SELECT * FROM categories WHERE id = '$categoryId'";
    $categoryResult = mysqli_query($conn, $categoryQuery);
    $categoryUpdate = mysqli_fetch_assoc($categoryResult);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'inc/metadata_libs.php'
    ?>
    <title>Chỉnh sửa danh mục</title>
</head>

<body>
    <?php
    include 'inc/admin_header.php'
    ?>
    <div class="title">
        <h1>Chỉnh sửa danh mục</h1>
    </div>
    <?php
    if (isset($result)) {
        echo $result;
    }
    ?>
    <div class="container d-flex align-items-center justify-content-center">

        <div class="form-add d-flex align-items-center" style="background-color: unset;">
            <form action="edit_category.php?id=<?= $categoryId ?>" method="post">
                <input type="text" hidden name="id" style="display: none;" value="<?= $categoryId ?>">
                <label for="name">Tên danh mục</label>
                <input type="text" id="name" name="name" placeholder="Tên danh mục.." value="<?= $categoryUpdate['name'] ?>">

                <input type="submit" value="Lưu" name="submit">
            </form>
        </div>
    </div>
</body>

</html>