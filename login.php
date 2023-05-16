<?php
include 'classes/user.php';
$user = new user();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $login_check = $user->login($email, $password);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'inc/metadata_cdnLib.php'
    ?>
    <title>Đăng nhập</title>
</head>

<body>


    <?php

    include 'inc/header.php'
    ?>
    <section class="banner"></section>
    <div class="main-login-register">
        <h1 class="text-center">Đăng nhập</h1>
        <div class="container-single">
            <div class="login">
                <form action="login.php" method="post" class="form-login">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email..." required>

                    <label for="password">Mật khẩu</label>
                    <input type="password" id="password" name="password" placeholder="Mật khẩu..." required>
                    <p style="color: red;"><?= !empty($login_check) ? $login_check : '' ?></p>

                    <input class="btn-dark" type="submit" value="Đăng nhập">
                </form>
            </div>
        </div>
    </div>
</body>
<?php
include 'inc/footer.php'
?>

</html>