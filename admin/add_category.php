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
        $name = $_POST['name'];

        // Kiểm tra tên danh mục đã tồn tại hay chưa
        $query = "SELECT * FROM categories WHERE name = '$name'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('Danh mục đã tồn tại!');</script>";
        } else {
            // Thực hiện thêm mới danh mục
            $query = "INSERT INTO categories (name) VALUES ('$name')";
            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "<script>alert('Thêm mới danh mục thành công!');</script>";
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
    <title>Thêm mới danh mục</title>
</head>

<body>
    <?php
    include 'inc/admin_header.php'
    ?>
    <div class="title">
        <h1>Thêm mới danh mục</h1>
    </div>
    <div class="container">
        <div class="form-add" style="background-color: unset;">
            <form action="add_category.php" method="post">
                <label for="name">Tên danh mục</label>
                <input type="text" id="name" name="name" placeholder="Tên danh mục.." required>

                <input type="submit" value="Lưu" name="submit">
            </form>
        </div>
    </div>
    <?php
    include '../inc/footer.php'
    ?>
</body>

</html>