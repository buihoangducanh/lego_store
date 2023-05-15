<?php
include_once 'lib/session.php';
Session::checkSession('client');
include_once 'classes/cart.php';

if (isset($_GET['id'])) {
    $cart = new cart();
    $result = $cart->delete($_GET['id']);
    if ($result) {
        echo '<script type="text/javascript">alert("Xóa sản phẩm khỏi giỏ hàng thành công!"); history.back();</script>';
    } else {
        echo '<script type="text/javascript">alert("Xóa sản phẩm khỏi giỏ hàng thất bại!"); history.back();</script>';
    }
}
