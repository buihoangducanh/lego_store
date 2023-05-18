<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/session.php');
include_once($filepath . '/../classes/cart.php');
?>


 
<?php
/**
 * 
 */
class orderDetails
{


    public static function getOrderDetails($orderId)
    {
        $query = "SELECT * FROM order_details WHERE orderId = $orderId ";
        $conn = connectDB();
        $mysqli_result = mysqli_query($conn, $query);
        $conn->close();
        if ($mysqli_result) {
            $result = mysqli_fetch_all($mysqli_result, MYSQLI_ASSOC);
            return $result;
        }
        return false;
    }
}
?>