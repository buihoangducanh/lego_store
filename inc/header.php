<header>
    <nav style="background-color: #ffcf00;">
        <div class="logo text-danger"><img src="images/LEGO_logo.svg.png" alt=""></div>
        <ul>
            <li><a href="index.php" <?php if (basename($_SERVER['PHP_SELF']) == 'index.php') {
                                        echo 'class="active"';
                                    } ?>>Trang chủ</a></li>
            <li><a href="productList.php" <?php if (basename($_SERVER['PHP_SELF']) == 'productList.php') {
                                                echo 'class="active"';
                                            } ?>>Sản phẩm</a></li>
            <?php if (isset($_SESSION['user']) && $_SESSION['user']) { ?>
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
                        <!-- <?php ($totalQty['total']) ? $totalQty['total'] : "0" ?> -->
                    </span>
                </a>
            </li>
        </ul>
    </nav>
</header>