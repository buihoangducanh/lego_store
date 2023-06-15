<?php
$role_id = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : null;
?>

<header>
    <nav style="background-color: #ffcf00;">
        <div class="logo text-danger"><img src="images/LEGO_logo.svg.png" alt=""></div>
        <ul>
            <?php if ($role_id == 1) { ?>
                <li><a href="admin/index.php">Admin</a></li>
            <?php } ?>
            <li><a href="index.php" <?php if (basename($_SERVER['PHP_SELF']) == 'index.php') {
                                        echo 'class="active"';
                                    } ?>>Trang chủ</a></li>
            <li><a href="productList.php" <?php if (basename($_SERVER['PHP_SELF']) == 'productList.php') {
                                                echo 'class="active"';
                                            } ?>>Sản phẩm</a></li>
            <?php if (isset($_SESSION['user_id'])) { ?>
                <li><a href="edit_profile.php" id="edit_profile" <?php if (basename($_SERVER['PHP_SELF']) == 'edit_profile.php') {
                                                                        echo 'class="active"';
                                                                    } ?>>Chỉnh sửa thông tin</a></li>
                <li><a href="logout.php" id="signin">Đăng xuất</a></li>
            <?php } else { ?>
                <li><a href="register.php" id="signup" <?php if (basename($_SERVER['PHP_SELF']) == 'register.php') {
                                                            echo 'class="active"';
                                                        } ?>>Đăng ký</a></li>
                <li><a href="login.php" id="signin" <?php if (basename($_SERVER['PHP_SELF']) == 'login.php') {
                                                        echo 'class="active"';
                                                    } ?>>Đăng nhập</a></li>
            <?php } ?>
            <li><a href="order.php" id="order" <?php if (basename($_SERVER['PHP_SELF']) == 'order.php') {
                                                    echo 'class="active"';
                                                } ?>>Đơn hàng</a></li>
            <li>
                <a href="checkout.php" <?php if (basename($_SERVER['PHP_SELF']) == 'checkout.php') {
                                            echo 'class="active"';
                                        } ?>>
                    <i class="fa fa-shopping-bag"></i>
                    <span class="sumItem">
                        <?php
                        $totalQty = 0;
                        if (isset($_SESSION['cart'])) {
                            foreach ($_SESSION['cart'] as $item) {
                                $totalQty += $item['quantity'];
                            }
                        }
                        echo $totalQty;
                        ?>
                    </span>
                </a>
            </li>
        </ul>
    </nav>
</header>