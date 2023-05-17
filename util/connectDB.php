<?php
// Include file config.php chứa các hằng số cấu hình kết nối cơ sở dữ liệu
$filepath = realpath(dirname(__FILE__));
include($filepath . '/../config/config.php');

// Hàm kết nối cơ sở dữ liệu
function connectDB()
{
    // Kết nối đến cơ sở dữ liệu
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Kiểm tra kết nối
    if (!$conn) {
        die("Kết nối thất bại: " . mysqli_connect_error());
    }

    return $conn;
}
