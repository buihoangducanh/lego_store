<?php
// Kết nối đến cơ sở dữ liệu
include_once("util/connectDB.php");

// Kiểm tra xem người dùng đã nhấn nút Đăng ký chưa
if (isset($_POST['submit'])) {
    // Lấy thông tin từ form đăng ký
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $phoneNumber = $_POST['phoneNumber'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];

    // Kiểm tra xem mật khẩu đã khớp chưa
    if ($password != $repassword) {
        // Nếu mật khẩu không khớp, hiển thị thông báo lỗi và dừng việc xử lý
        $result = "Mật khẩu không khớp";
    } else {
        // Mật khẩu khớp, tiến hành thêm thông tin người dùng vào cơ sở dữ liệu
        // Hash mật khẩu trước khi lưu vào cơ sở dữ liệu
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Kiểm tra xem email đã tồn tại trong cơ sở dữ liệu hay chưa
        $checkEmailQuery = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $checkEmailQuery);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            // Nếu email đã tồn tại, hiển thị thông báo lỗi và dừng việc xử lý
            $result = "Email bạn vừa nhập đã được đăng ký trước đó";
        } else {
            // Mật khẩu khớp và email chưa tồn tại, tiến hành thêm thông tin người dùng vào cơ sở dữ liệu

            // Tạo truy vấn INSERT để thêm thông tin người dùng mới vào bảng "users"
            $insertQuery = "INSERT INTO users (email, fullname, dob, password, role_id, phone_number, address) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $user_role = 2;
            $stmt = mysqli_prepare($conn, $insertQuery);
            mysqli_stmt_bind_param($stmt, "ssssiss", $email, $fullName, $dob, $hashedPassword, $user_role, $phoneNumber, $address);


            // Thực thi truy vấn INSERT
            if (mysqli_stmt_execute($stmt)) {
                // Nếu thêm người dùng thành công, hiển thị thông báo đăng ký thành công và chuyển hướng đến trang đăng nhập
                echo "<script>alert('Đăng ký thành công'); 
                window.location.href = 'login.php';</script>";
                exit();
            } else {
                // Nếu có lỗi xảy ra trong quá trình thêm người dùng, hiển thị thông báo lỗi
                echo "<script>alert('Đăng ký thất bại'); 
                </script>";
                exit();
            }
        }
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
                    <input type="email" id="email" name="email" placeholder="Email..." required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                    <p class="error"><?= !empty($result) ? $result : '' ?></p>

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