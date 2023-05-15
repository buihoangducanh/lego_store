<?php
include 'classes/user.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = new user();
    $result = $user->confirm($_POST['userId'], $_POST['captcha']);
    if ($result === true) {
        echo '<script type="text/javascript">alert("Xác minh tài khoản thành công!"); window.location.href = "login.php";</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'inc/metadata_cdnLib.php' ?>
    <title>Xác minh Email</title>
</head>

<body>
    <?php include 'inc/header.php' ?>
    <section class="banner"></section>
    <div class="container-intro-section d-flex justify-content-center align-items-center " style="padding-bottom: 50px;padding-bottom: 0; margin-bottom: 0;">
        <h1>Xác minh Email</h1>
    </div>
    <div class=" container-single " style="min-height: 35vh;">
        <div class="login">
            <b class="error"><?= !empty($result) ? $result : '' ?></b>
            <form action="confirm.php" method="post" class="form-login">
                <label for="fullName">Mã xác minh</label>
                <!-- <input type="text" id="userId" name="userId" hidden style="display: none;" value="<?= (isset($_GET['id'])) ? $_GET['id'] : $_POST['userId'] ?>"> -->
                <input type="text" id="captcha" name="captcha" placeholder="Mã xác minh...">
                <input class="btn-dark" type="submit" value="Xác minh" name="submit">
            </form>
        </div>
    </div>

</body>
<?php include 'inc/footer.php' ?>


</html>