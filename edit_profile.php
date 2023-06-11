<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
    header("Location: login.php");
    exit();
}

// Kết nối đến cơ sở dữ liệu
include 'util/connectDB.php';

// Kiểm tra xem người dùng đã nhấn nút Sửa chưa
if (isset($_POST['submit'])) {
    // Lấy thông tin từ form chỉnh sửa thông tin cá nhân
    $fullName = $_POST['fullName'];
    $password = $_POST['password'];
    $phoneNumber = $_POST['phoneNumber'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];

    // Kiểm tra xem người dùng đã nhập mật khẩu mới hay chưa
    if (!empty($password)) {
        // Nếu đã nhập mật khẩu mới, mã hóa mật khẩu
        $password = password_hash($password, PASSWORD_DEFAULT);

        // Cập nhật thông tin người dùng vào cơ sở dữ liệu (không cập nhật email)
        $sql = "UPDATE users SET fullname = ?, password = ?, phone_number = ?, address = ?, dob = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssi", $fullName, $password, $phoneNumber, $address, $dob, $_SESSION['user_id']);
    } else {
        // Nếu không nhập mật khẩu mới, không mã hóa mật khẩu
        $sql = "UPDATE users SET fullname = ?, phone_number = ?, address = ?, dob = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $fullName, $phoneNumber, $address, $dob, $_SESSION['user_id']);
    }

    if (mysqli_stmt_execute($stmt)) {
        // Cập nhật thông tin thành công, hiển thị thông báo
        $_SESSION['user_fullname'] = $fullName; // Cập nhật lại biến $_SESSION['user_fullname']

        echo "<script>alert('Cập nhật thông tin thành công');</script>";
    } else {
        // Cập nhật thông tin thất bại, hiển thị thông báo lỗi
        echo "<script>alert('Cập nhật thông tin thất bại');</script>";
    }
}

// Lấy thông tin người dùng từ cơ sở dữ liệu
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 1) {
    // Lấy thông tin người dùng từ kết quả truy vấn
    $user = mysqli_fetch_assoc($result);
} else {
    // Người dùng không tồn tại, xử lý tương ứng (ví dụ: chuyển hướng về trang đăng nhập)
    header("Location: login.php");
    exit();
}

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
                <form action="edit_profile.php" method="post" class="form-login">
                    <label for="fullName">Họ tên</label>
                    <input type="text" id="fullName" name="fullName" placeholder="Họ tên..." required value="<?= $user['fullname'] ?>">

                    <label for="password">Mật khẩu (để trống nếu không thay đổi)</label>
                    <input type="password" id="password" name="password" placeholder="Mật khẩu...">

                    <label for="phoneNumber">Số điện thoại</label>
                    <input type="text" id="phoneNumber" name="phoneNumber" placeholder="Số điện thoại..." required value="<?= $user['phone_number'] ?>">

                    <label for="address">Địa chỉ</label>
                    <textarea name="address" id="address" cols="30" rows="5" required><?= $user['address'] ?></textarea>

                    <label for="dob">Ngày sinh</label>
                    <input type="date" name="dob" id="dob" required value="<?= $user['dob'] ?>">

                    <input class="btn-dark" type="submit" value="Sửa" name="submit">
                </form>
            </div>
        </div>
    </div>

</body>
<?php include 'inc/footer.php' ?>

</html>

<?php
// Đóng kết nối đến cơ sở dữ liệu
mysqli_close($conn);
?>