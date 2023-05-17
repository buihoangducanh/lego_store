<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/session.php');
include_once($filepath . '/../util/connectDB.php');
?>

<?php

class user
{

	public static function login($email, $password)
	{
		// Chuẩn bị truy vấn SQL với Prepared Statement
		$query = "SELECT * FROM users WHERE email = ? AND password = ?";
		$conn = connectDB();
		$stmt = mysqli_prepare($conn, $query);
		mysqli_stmt_bind_param($stmt, "ss", $email, $password);

		// Thực thi truy vấn SQL với Prepared Statement
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		if (mysqli_num_rows($result) > 0) {
			// Truy vấn trả về ít nhất một kết quả
			$value = $result->fetch_assoc();
			Session::set('user', true);
			Session::set('userId', $value['id']);
			Session::set('role_id', $value['role_id']);
			if ($value['role_id'] == 1)
				header("Location:admin/indexadmin.php");
			else
				header("Location:index.php");
			$stmt->close();
			$conn->close();
		} else {
			// Truy vấn không trả về kết quả
			$alert = "Tên đăng nhập hoặc mật khẩu không đúng!";
			return $alert;
		}
	}

	public static function insert($data)
	{
		$fullName = $data['fullName'];
		$email = $data['email'];
		$dob = $data['dob'];
		$address = $data['address'];
		$password = md5($data['password']);
		// admin_role=1
		// user_role= 2
		$user_role_id = 2;
		$check_email = "SELECT * FROM users WHERE email='$email' LIMIT 1";
		$conn = connectDB();

		$result_check = mysqli_query($conn, $check_email);
		if (mysqli_num_rows($result_check) > 0) {
			return 'Email đã tồn tại!';
		} else {
			// Thực hiện thêm bản ghi mới vào CSDL
			$insert_query = "INSERT INTO users (fullName, email, dob, address, password,role_id) VALUES ('$fullName', '$email', '$dob', '$address', '$password','$user_role_id')";
			$result_insert = mysqli_query($conn, $insert_query);

			$conn->close();
			if ($result_insert) {
				return true;
			} else {
				return false;
			}
		}
	}

	public static function get()
	{
		$userId = Session::get('userId');
		$conn = connectDB();
		$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
		$stmt->bind_param("i", $userId);
		$stmt->execute();
		$result = $stmt->get_result()->fetch_assoc();
		$stmt->close();
		$conn->close();

		return $result ? $result : false;
	}

	public static function getLastUserId()
	{
		$query = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
		$conn = connectDB();
		$mysqli_result = mysqli_query($conn, $query);
		if ($mysqli_result) {
			$result = mysqli_fetch_assoc($mysqli_result);
			return $result['id'];
		}
		$conn->close();
		return false;
	}
}
?>