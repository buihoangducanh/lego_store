<?php
include 'classes/user.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sử dụng Prepared Statements để tránh tấn công SQL Injection

    $result = user::insert($_POST);
    if ($result == true) {
        // Hiển thị thông báo JavaScript và chuyển hướng trang
        echo "<script>alert('Đăng ký thành công!'); window.location.href='./login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'inc/metadata_cdnLib.php'
    ?>
    <title>Đăng ký</title>
</head>

<body>
    <?php
    include 'inc/header.php'
    ?>
    <section class="banner"></section>
    <div class="main-login-register">
        <h1 class="text-center">Đăng ký</h1>

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

                    <input class="btn-dark" type="submit" value="Đăng ký" name="submit">
                </form>
            </div>
        </div>
    </div>
    <?php
    include 'inc/footer.php'
    ?>
</body>
<script language='javascript' type='text/javascript'>
    function check(input) {
        if (input.value != document.getElementById('password').value) {
            input.setCustomValidity('Password Must be Matching.');
        } else {
            input.setCustomValidity('');
        }
    }
    // Lấy đối tượng input số điện thoại
    var phoneNumberInput = document.getElementById('phoneNumber');

    // Sử dụng biểu thức chính quy để kiểm tra số điện thoại
    var phoneNumberPattern = /^\d{10}$/;

    // Lắng nghe sự kiện submit form
    document.querySelector('form').addEventListener('submit', function(event) {
        // Kiểm tra giá trị của input số điện thoại
        if (!phoneNumberPattern.test(phoneNumberInput.value)) {
            // Nếu giá trị không hợp lệ, ngăn chặn sự kiện submit form và hiển thị thông báo lỗi
            event.preventDefault();
            alert('Số điện thoại không hợp lệ');
        }
    });
</script>

</html>