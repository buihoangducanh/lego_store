<?php
session_start();
?>
<?php
// Kết nối đến cơ sở dữ liệu
include 'util/connectDB.php';

// Kiểm tra xem người dùng đã nhấn nút Đăng nhập chưa
if (isset($_POST['submit'])) {
    // Lấy thông tin từ form đăng nhập
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Tạo truy vấn SELECT để lấy thông tin người dùng từ cơ sở dữ liệu
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Kiểm tra xem có người dùng tồn tại hay không
    if (mysqli_num_rows($result) == 1) {
        // Lấy thông tin người dùng từ kết quả truy vấn
        $user = mysqli_fetch_assoc($result);

        // Kiểm tra mật khẩu
        if (password_verify($password, $user['password'])) {
            // Mật khẩu đúng, lưu thông tin người dùng vào session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_fullname'] = $user['fullname'];
            $_SESSION['user_role'] = $user['role_id'];

            // Hiển thị thông báo đăng nhập thành công bằng JavaScript
            echo '<script>alert("Đăng nhập thành công!");</script>';

            // Chuyển hướng đến trang tương ứng (ví dụ: trang chủ hoặc trang admin)
            if ($user['role_id'] == 1) {
                echo '<script>window.location.href = "admin/index.php";</script>'; // Chuyển hướng đến trang admin
            } else {
                echo '<script>window.location.href = "index.php";</script>'; // Chuyển hướng đến trang chủ
            }
            exit();
        } else {
            // Mật khẩu không đúng, hiển thị thông báo lỗi
            $login_check = "Sai email hoặc mật khẩu";
        }
    } else {
        // Người dùng không tồn tại, hiển thị thông báo lỗi
        $login_check = "Sai email hoặc mật khẩu";
    }
}

// Đóng kết nối đến cơ sở dữ liệu
mysqli_close($conn);
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

                    <input class="btn-dark" type="submit" name="submit" value="Đăng nhập">
                </form>
            </div>
        </div>
    </div>
</body>

<?php
include 'inc/footer.php'
?>

</html>