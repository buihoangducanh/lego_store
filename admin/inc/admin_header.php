<header>
    <nav>
        <div class="logo"><img src="../images/LEGO_logo.svg.png" alt=""></div>
        <ul>
            <li><a href="../index.php" <?php if (basename($_SERVER['PHP_SELF']) == 'index.php') {
                                            echo 'class="active"';
                                        } ?>>Lego Store</a></li>
            <li><a href="productlist.php" <?php if (basename($_SERVER['PHP_SELF']) == 'productlist.php') {
                                                echo 'class="active"';
                                            } ?>>Quản lý Sản phẩm</a></li>
            <li><a href="categoriesList.php" <?php if (basename($_SERVER['PHP_SELF']) == 'categoriesList.php') {
                                                    echo 'class="active"';
                                                } ?>>Quản lý Danh mục</a></li>
            <li><a href="orderlist.php" <?php if (basename($_SERVER['PHP_SELF']) == 'orderlist.php') {
                                            echo 'class="active"';
                                        } ?>>Quản lý Đơn hàng</a></li>
        </ul>
    </nav>
</header>