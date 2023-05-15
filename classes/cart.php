<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../lib/session.php');
include_once($filepath . '/../classes/product.php');
?>


 
<?php
/**
 * 
 */
class cart
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }
    public function add($productId)
    {
        $userId = Session::get('userId');

        $query = "SELECT * FROM products WHERE id = '$productId' ";
        $result = $this->db->select($query)->fetch_assoc();
        $productName = $result["name"];
        $productPrice = $result["promotionPrice"];
        $image = $result["image"];
        $checkcart = "SELECT qty FROM cart WHERE productId = '$productId' AND userId = '$userId' ";
        $check_cart = $this->db->select($checkcart);
        if ($check_cart) {
            //Check qty product in db
            $qtyInCart = mysqli_fetch_row($check_cart)[0];
            $product = new product();
            $productCheck = $product->getProductbyId($productId);
            if (intval($qtyInCart) >= intval($productCheck['qty'])) {
                return 'out of stock';
            }

            $query_insert = "UPDATE cart SET qty = qty + 1 WHERE productId = $productId AND userId = $userId";
            $insert_cart = $this->db->update($query_insert);
            if ($insert_cart) {
                return true;
            } else {
                return false;
            }
        } else {
            $query_insert = "INSERT INTO cart VALUES(NULL,'$userId','$productId',1,'$productName','$productPrice','$image' )";
            $insert_cart = $this->db->insert($query_insert);
            if ($insert_cart) {
                return true;
            } else {
                return false;
            }
        }
    }
    public function update($productId, $qty)
    {
        $userId = Session::get('userId');
        //Check qty product in db
        $product = new product();
        $productCheck = $product->getProductbyId($productId);
        if (intval($qty) > intval($productCheck['qty'])) {
            return 'out of stock';
        }

        $query_insert = "UPDATE cart SET qty = $qty WHERE productId = $productId AND userId = $userId";
        $insert_cart = $this->db->update($query_insert);
        if ($insert_cart) {
            return true;
        } else {
            return false;
        }
    }
    public function get()
    {
        $userId = Session::get('userId');
        $query = "SELECT * FROM cart WHERE userId = '$userId' ";
        $mysqli_result = $this->db->select($query);
        if ($mysqli_result) {
            $result = mysqli_fetch_all($this->db->select($query), MYSQLI_ASSOC);
            return $result;
        }
        return false;
    }
    public function delete($cartId)
    {
        $userId = Session::get('userId');
        $query = "DELETE FROM cart WHERE userId = '$userId' AND id = $cartId";
        $row = $this->db->delete($query);
        if ($row) {
            return true;
        }
        return false;
    }
    public function getTotalPriceByUserId()
    {
        $userId = Session::get('userId');
        $query = "SELECT SUM(productPrice*qty) as total FROM cart WHERE userId = '$userId' ";
        $mysqli_result = $this->db->select($query);
        if ($mysqli_result) {
            $result = mysqli_fetch_all($this->db->select($query), MYSQLI_ASSOC)[0];
            return $result;
        }
        return false;
    }
    public function getTotalQtyByUserId()
    {
        $userId = Session::get('userId');
        $query = "SELECT SUM(qty) as total FROM cart WHERE userId = '$userId' ";
        $mysqli_result = $this->db->select($query);
        if ($mysqli_result) {
            $result = mysqli_fetch_all($this->db->select($query), MYSQLI_ASSOC)[0];
            return $result;
        }
        return false;
    }
}
?>