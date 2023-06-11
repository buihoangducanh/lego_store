<?php
$filepath = realpath(dirname(__FILE__));
include_once('util/connectDB.php');
include_once($filepath . '/../lib/session.php');
?>

<?php
/**
 * 
 */
class product
{


    public static function insert($data)
    {
        $name = $data['name'];
        $originalPrice = $data['originalPrice'];
        $promotionPrice = $data['promotionPrice'];
        $cateId = $data['cateId'];
        $des = $data['des'];
        $qty = $data['qty'];

        // Check image and move to upload folder
        $file_name = $_FILES['image']['name'];
        $file_temp = $_FILES['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "uploads/" . $unique_image;

        move_uploaded_file($file_temp, $uploaded_image);
        $query = "INSERT INTO products VALUES (NULL,'$name','$originalPrice','$promotionPrice','$unique_image'," . Session::get('userId') . ",'" . date('Y/m/d') . "','$cateId','$qty','$des',1,0) ";


        $result = mysqli_query($conn, $query);
        $conn->close();
        if ($result) {
            $alert = "<span class='success'>Sản phẩm đã được thêm thành công</span>";
            return $alert;
        } else {
            $alert = "<span class='error'>Thêm sản phẩm thất bại</span>";
            return $alert;
        }
    }

    public static function getAllAdmin($page = 1, $total = 8)
    {
        if ($page <= 0) {
            $page = 1;
        }
        $tmp = ($page - 1) * $total;
        $query =
            "SELECT products.*, categories.name as cateName, users.fullName
			 FROM products INNER JOIN categories ON products.cateId = categories.id INNER JOIN users ON products.createdBy = users.id
			 order by products.id desc 
             limit $tmp,$total";
        $conn = connectDB();
        $result = mysqli_query($conn, $query);
        $conn->close();
        return $result;
    }

    public static function getAll()
    {
        $query =
            "SELECT products.*, categories.name as cateName
			 FROM products INNER JOIN categories ON products.cateId = categories.id INNER JOIN users ON products.createdBy = users.id
			 WHERE products.status = 1
             order by products.id desc ";
        $conn = connectDB();
        $result = mysqli_query($conn, $query);
        $conn->close();
        return $result;
    }

    public static function getCountPaging($row = 8)
    {
        $query = "SELECT COUNT(*) FROM products";

        $mysqli_result = mysqli_query($conn, $query);
        $conn->close();
        if ($mysqli_result) {
            $totalrow = intval((mysqli_fetch_all($mysqli_result, MYSQLI_ASSOC)[0])['COUNT(*)']);
            $result = ceil($totalrow / $row);
            return $result;
        }
        return false;
    }

    public static function getCountPagingClient($cateId, $row = 8)
    {
        $query = "SELECT COUNT(*) FROM products WHERE cateId = $cateId";

        $mysqli_result = mysqli_query($conn, $query);

        if ($mysqli_result) {
            $totalrow = intval((mysqli_fetch_all($mysqli_result, MYSQLI_ASSOC)[0])['COUNT(*)']);
            $result = ceil($totalrow / $row);
            return $result;
        }
        return false;
    }

    public static function getFeaturedProducts()
    {
        $query =
            "SELECT *
			 FROM products
			 WHERE products.status = 1
             order by products.soldCount DESC
             LIMIT 8";
        $conn = connectDB();
        $result = mysqli_query($conn, $query);
        $conn->close();
        return $result;
    }

    public static function getProductsByCateId($page = 1, $cateId, $total = 8)
    {
        if ($page <= 0) {
            $page = 1;
        }
        $tmp = ($page - 1) * $total;
        $query =
            "SELECT *
			 FROM products
			 WHERE status = 1 AND cateId = $cateId
             LIMIT $tmp,$total";
        $conn = connectDB();
        $mysqli_result = mysqli_query($conn, $query);
        $conn->close();
        if ($mysqli_result) {
            $result = mysqli_fetch_all($mysqli_result, MYSQLI_ASSOC);
            return $result;
        }
        return false;
    }

    public static function update($data, $files)
    {
        $name = $data['name'];
        $originalPrice = $data['originalPrice'];
        $promotionPrice = $data['promotionPrice'];
        $cateId = $data['cateId'];
        $des = $data['des'];
        $qty = $data['qty'];

        $file_name = $_FILES['image']['name'];
        $file_temp = $_FILES['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "uploads/" . $unique_image;

        //If user has chooose new image
        if (!empty($file_name)) {
            move_uploaded_file($file_temp, $uploaded_image);
            $query = "UPDATE products SET 
					name ='$name',
					cateId = '$cateId',
					originalPrice = '$originalPrice',
					promotionPrice = '$promotionPrice',
					des = '$des',
					qty = '$qty',
					image = '$unique_image'
					 WHERE id = " . $data['id'] . " ";
        } else {
            $query = "UPDATE products SET 
					name ='$name',
					cateId = '$cateId',
					originalPrice = '$originalPrice',
					promotionPrice = '$promotionPrice',
					des = '$des',
					qty = '$qty'
					 WHERE id = " . $data['id'] . " ";
        }
        $conn = connectDB();
        $result = mysqli_query($conn, $query);
        $conn->close();
        if ($result) {
            $alert = "<span class='success'>Cập nhật sản phẩm thành công</span>";
            return $alert;
        } else {
            $alert = "<span class='error'>Cập nhật sản phẩm thất bại</span>";
            return $alert;
        }
    }

    public static function getProductbyIdAdmin($id)
    {
        $query = "SELECT * FROM products where id = '$id'";
        $conn = connectDB();
        $result = mysqli_query($conn, $query);
        $conn->close();
        return $result;
    }

    public static function getProductbyId($id)
    {
        $query = "SELECT * FROM products where id = '$id' AND status = 1";
        $conn = connectDB();
        $mysqli_result = mysqli_query($conn, $query);
        $conn->close();
        if ($mysqli_result) {
            $result = mysqli_fetch_all($mysqli_result, MYSQLI_ASSOC)[0];
            return $result;
        }
        return false;
    }

    public static function block($id)
    {
        $query = "UPDATE products SET status = 0 where id = '$id' ";
        $conn = connectDB();
        $result = mysqli_query($conn, $query);
        $conn->close();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public static function active($id)
    {
        $query = "UPDATE products SET status = 1 where id = '$id' ";
        $conn = connectDB();
        $result = mysqli_query($conn, $query);
        $conn->close();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public static function updateQty($id, $qty)
    {
        $query = "UPDATE products SET qty = qty - $qty, soldCount = soldCount + $qty WHERE id = $id";
        $conn = connectDB();
        $mysqli_result = mysqli_query($conn, $query);
        $conn->close();
        if ($mysqli_result) {
            return true;
        }
        return false;
    }
}
?>