<?php
include_once 'lib/session.php';
Session::checkSession('client');
include_once 'classes/cart.php';

$cart = new cart();
$result = $cart->update($_POST['productId'], $_POST['qty']);

$totalPrice = $cart->getTotalPriceByUserId();
$totalQty = $cart->getTotalQtyByUserId();
$data = [$totalPrice, $totalQty];
header('Content-Type: application/json; charset=utf-8');

if ($result === 'out of stock') {
    http_response_code(501);
} else if ($result) {
    http_response_code(200);
} else {
    http_response_code(403);
}
echo json_encode($data);
exit;
