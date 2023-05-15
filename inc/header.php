<header>
    <nav style="background-color: #ffcf00;">
        <div class="logo text-danger

"><img src="images/LEGO_logo.svg.png" alt=""></div>
        <ul>
            <li><a href="index.php" class="">Trang chủ</a></li>
            <li><a href="productList.php">Sản phẩm</a></li>
            <?php
            if (isset($_SESSION['user']) && $_SESSION['user']) { ?>
                <li><a href="logout.php" id="signin">Đăng xuất</a></li>
            <?php } else { ?>
                <li><a href="register.php" id="signup">Đăng ký</a></li>
                <li><a href="login.php" id="signin">Đăng nhập</a></li>
            <?php } ?>
            <li><a href="order.php" id="order">Đơn hàng</a></li>
            <li>
                <a href="checkout.php">
                    <i class="fa fa-shopping-bag"></i>
                    <span class="sumItem">
                        <!-- <?php ($totalQty['total']) ? $totalQty['total'] : "0" ?> -->
                    </span>
                </a>
            </li>
        </ul>
    </nav>
</header>