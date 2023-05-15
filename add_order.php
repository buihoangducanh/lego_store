<?php
include_once 'lib/session.php';
Session::checkSession('client');
include_once 'classes/order.php';
$order = new order();
$result = $order->add();
if ($result) {
    echo '<script type="text/javascript">alert("Đặt hàng thành công!"); history.back();</script>';
} else {
    echo '<script type="text/javascript">alert("Đặt hàng thất bại!"); history.back();</script>';
}
