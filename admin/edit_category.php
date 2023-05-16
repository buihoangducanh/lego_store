<?php
include '../lib/session.php';
include '../classes/categories.php';
Session::checkSession('admin');
$role_id = Session::get('role_id');
if ($role_id == 1) {
    $categories = new categories();
    $categoryUpdate = mysqli_fetch_assoc($categories->getByIdAdmin($_GET['id']));
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $result = $categories->update($_POST, $_FILES);
        $categoryUpdate = mysqli_fetch_assoc($categories->getByIdAdmin($_GET['id']));
    }
} else {
    header("Location:../index.php");
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
    <div class="container d-flex align-items-center justify-content-center">
        <?php
        if (isset($result)) {
            echo $result;
        }
        ?>
        <div class="form-add d-flex align-items-center" style="background-color: unset;">
            <form action="edit_category.php?id=<?= $categoryUpdate['id'] ?>" method="post">
                <input type="text" hidden name="id" style="display: none;" value="<?= (isset($_GET['id']) ? $_GET['id'] : $categoryUpdate['id']) ?>">
                <label for="name">Tên danh mục</label>
                <input type="text" id="name" name="name" placeholder="Tên danh mục.." value="<?= $categoryUpdate['name'] ?>">

                <input type="submit" value="Lưu" name="submit">
            </form>
        </div>
    </div>
    </div>

    <?php
    include '../inc/footer.php'
    ?>
</body>

</html>