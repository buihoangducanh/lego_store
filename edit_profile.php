<?php
include_once 'lib/session.php';
Session::checkSession('client');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'inc/metadata_cdnLib.php'
    ?>
    <title>Chỉnh sửa thông tin</title>
</head>

<body>
    <?php include 'inc/header.php' ?>
    <section class="banner"></section>

    <div class="main-login-register">
        <h1 class="text-center">Sửa thông tin cá nhân</h1>

        <div class="container-single">
            <div class="login">
                <form action="register.php" method="post" class="form-login">
                    <label for="fullName">Họ tên</label>
                    <input type="text" id="fullName" name="fullName" placeholder="Họ tên..." required>

                    <label for="email">Email</label>
                    <p class="error"><?= !empty($result) ? $result : '' ?></p>
                    <input type="email" id="email" name="email" placeholder="Email..." required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">

                    <label for="password">Mật khẩu</label>
                    <input type="password" id="password" name="password" placeholder="Mật khẩu..." required>

                    <label for="repassword">Nhập lại mật khẩu</label>
                    <input type="password" id="repassword" name="repassword" required placeholder="Nhập lại mật khẩu..." oninput="check(this)">
                    <label for="phoneNumber">Số điện thoại</label>
                    <input type="text" id="phoneNumber" name="phoneNumber" placeholder="Số điện thoại..." required>

                    <label for="address">Địa chỉ</label>
                    <textarea name="address" id="address" cols="30" rows="5" required></textarea>

                    <label for="dob">Ngày sinh</label>
                    <input type="date" name="dob" id="dob" required>

                    <input class="btn-dark" type="submit" value="Sửa" name="submit">
                </form>
            </div>
        </div>
    </div>

</body>
<?php
include 'inc/footer.php'
?>

</html>