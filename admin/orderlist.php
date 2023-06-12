<?php
session_start();
require '../util/connectDB.php'; // Kết nối đến cơ sở dữ liệu
$role_id = $_SESSION['user_role'];
if ($role_id !== 1) {
    header("Location:../index.php");
    exit();
}
// Lấy danh sách đơn hàng đang xử lý
$processingOrderList = array();
$sqlProcessing = "SELECT * FROM orders WHERE status = 'Processing'";
$resultProcessing = mysqli_query($conn, $sqlProcessing);
if (mysqli_num_rows($resultProcessing) > 0) {
    while ($rowProcessing = mysqli_fetch_assoc($resultProcessing)) {
        $processingOrderList[] = $rowProcessing;
    }
}

// Lấy danh sách đơn hàng đã xử lý
$processedOrderList = array();
$sqlProcessed = "SELECT * FROM orders WHERE status = 'Processed'";
$resultProcessed = mysqli_query($conn, $sqlProcessed);
if (mysqli_num_rows($resultProcessed) > 0) {
    while ($rowProcessed = mysqli_fetch_assoc($resultProcessed)) {
        $processedOrderList[] = $rowProcessed;
    }
}

// Lấy danh sách đơn hàng đang giao
$deliveringOrderList = array();
$sqlDelivering = "SELECT * FROM orders WHERE status = 'Delivering'";
$resultDelivering = mysqli_query($conn, $sqlDelivering);
if (mysqli_num_rows($resultDelivering) > 0) {
    while ($rowDelivering = mysqli_fetch_assoc($resultDelivering)) {
        $deliveringOrderList[] = $rowDelivering;
    }
}

// Lấy danh sách đơn hàng đã hoàn thành
$completeOrderList = array();
$sqlComplete = "SELECT * FROM orders WHERE status = 'Complete'";
$resultComplete = mysqli_query($conn, $sqlComplete);
if (mysqli_num_rows($resultComplete) > 0) {
    while ($rowComplete = mysqli_fetch_assoc($resultComplete)) {
        $completeOrderList[] = $rowComplete;
    }
}
// Lấy danh sách đơn hàng bị hủy
$cancelledOrderList = array();
$sqlCancelled = "SELECT * FROM orders WHERE status = 'Cancelled'";
$resultCancelled = mysqli_query($conn, $sqlCancelled);
if (mysqli_num_rows($resultCancelled) > 0) {
    while ($rowCancelled = mysqli_fetch_assoc($resultCancelled)) {
        $cancelledOrderList[] = $rowCancelled;
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Quản lý đơn đặt hàng</title>
    <?php include 'inc/metadata_libs.php'; ?>
</head>

<body>
    <?php include 'inc/admin_header.php'; ?>
    <div class="title">
        <h1>Danh sách đơn đặt hàng</h1>
    </div>
    <div class="container">
        <!-- Tab links -->
        <div class="tab mb-5">
            <button class="tablinks" style="width: 200px;" onclick="openTab(event, 'Processing')">Đang xử lý</button>
            <button class="tablinks" style="width: 200px;" onclick="openTab(event, 'Processed')">Đã xử lý</button>
            <button class="tablinks" style="width: 200px;" onclick="openTab(event, 'Delivering')">Đang giao hàng</button>
            <button class="tablinks" style="width: 200px;" onclick="openTab(event, 'Complete')">Đã hoàn thành</button>
            <button class="tablinks" style="width: 200px;" onclick="openTab(event, 'Cancelled')">Đã hủy</button>
        </div>

        <!-- Tab content -->
        <div id="Processing" class="tabcontent">
            <?php if (!empty($processingOrderList)) { ?>
                <table class="list">
                    <tr>
                        <th class="text-center p-2">STT</th>
                        <th class="text-center p-2">Mã đơn hàng</th>
                        <th class="text-center p-2">Ngày đặt</th>
                        <th class="text-center p-2">Ngày giao</th>
                        <th class="text-center p-2">Tình trạng</th>
                        <th class="text-center p-2">Thao tác</th>
                    </tr>
                    <?php
                    $count = 1;
                    foreach ($processingOrderList as $order) {
                    ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $order['id']; ?></td>
                            <td><?php echo $order['createdDate']; ?></td>
                            <td>
                                <?php
                                if ($order['status'] != "Processing") {
                                    echo $order['receivedDate'];
                                } else {
                                    echo "Dự kiến 3 ngày sau khi đơn hàng đã được xử lý";
                                }
                                echo ($order['status'] != "Complete" && $order['status'] != "Processing") ? "(Dự kiến)" : "";
                                ?>
                            </td>
                            <td><?php echo $order['status']; ?></td>
                            <td>
                                <a href="orderlistdetail.php?orderId=<?php echo $order['id']; ?>">Chi tiết</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <h3>Chưa có đơn hàng nào đang xử lý</h3>
            <?php } ?>
        </div>

        <div id="Processed" class="tabcontent">
            <?php if (!empty($processedOrderList)) { ?>
                <table class="list">
                    <tr>
                        <th class="text-center p-2">STT</th>
                        <th class="text-center p-2">Mã đơn hàng</th>
                        <th class="text-center p-2">Ngày đặt</th>
                        <th class="text-center p-2">Ngày giao</th>
                        <th class="text-center p-2">Tình trạng</th>
                        <th class="text-center p-2">Thao tác</th>
                    </tr>
                    <?php
                    $count = 1;
                    foreach ($processedOrderList as $order) {
                    ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $order['id']; ?></td>
                            <td><?php echo $order['createdDate']; ?></td>
                            <td>
                                <?php
                                if ($order['status'] != "Processing") {
                                    echo $order['receivedDate'];
                                } else {
                                    echo "Dự kiến 3 ngày sau khi đơn hàng đã được xử lý";
                                }
                                echo ($order['status'] != "Complete" && $order['status'] != "Processing") ? "(Dự kiến)" : "";
                                ?>
                            </td>
                            <td><?php echo $order['status']; ?></td>
                            <td>
                                <a href="delivering_order.php?orderId=<?php echo $order['id']; ?>">Giao hàng</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <h3>Chưa có đơn hàng nào đã xử lý</h3>
            <?php } ?>
        </div>

        <div id="Delivering" class="tabcontent">
            <?php if (!empty($deliveringOrderList)) { ?>
                <table class="list">
                    <tr>
                        <th class="text-center p-2">STT</th>
                        <th class="text-center p-2">Mã đơn hàng</th>
                        <th class="text-center p-2">Ngày đặt</th>
                        <th class="text-center p-2">Ngày nhận</th>
                        <th class="text-center p-2">Tình trạng</th>
                        <th class="text-center p-2">Thao tác</th>
                    </tr>
                    <?php
                    $count = 1;
                    foreach ($deliveringOrderList as $order) {
                    ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $order['id']; ?></td>
                            <td><?php echo $order['createdDate']; ?></td>
                            <td>
                                <?php
                                if ($order['status'] != "Processing") {
                                    echo $order['receivedDate'];
                                } else {
                                    echo "Dự kiến 3 ngày sau khi đơn hàng đã được xử lý";
                                }
                                echo ($order['status'] != "Complete" && $order['status'] != "Processing") ? "(Dự kiến)" : "";
                                ?>
                            </td>
                            <td><?php echo $order['status']; ?></td>
                            <td>
                                <a href="orderlistdetail.php?orderId=<?php echo $order['id']; ?>">Chi tiết</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <h3>Chưa có đơn hàng nào đang giao</h3>
            <?php } ?>
        </div>

        <div id="Complete" class="tabcontent">
            <?php if (!empty($completeOrderList)) { ?>
                <table class="list">
                    <tr>
                        <th class="text-center p-2">STT</th>
                        <th class="text-center p-2">Mã đơn hàng</th>
                        <th class="text-center p-2">Ngày đặt</th>
                        <th class="text-center p-2">Ngày nhận</th>
                        <th class="text-center p-2">Tình trạng</th>
                        <th class="text-center p-2">Thao tác</th>
                    </tr>
                    <?php
                    $count = 1;
                    foreach ($completeOrderList as $order) {
                    ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $order['id']; ?></td>
                            <td><?php echo $order['createdDate']; ?></td>
                            <td>
                                <?php
                                if ($order['status'] != "Processing") {
                                    echo $order['receivedDate'];
                                } else {
                                    echo "Dự kiến 3 ngày sau khi đơn hàng đã được xử lý";
                                }
                                echo ($order['status'] != "Complete" && $order['status'] != "Processing") ? "(Dự kiến)" : "";
                                ?>
                            </td>
                            <td><?php echo $order['status']; ?></td>
                            <td>
                                <a href="orderlistdetail.php?orderId=<?php echo $order['id']; ?>">Chi tiết</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <h3>Chưa có đơn hàng nào đã hoàn thành</h3>
            <?php } ?>
        </div>

        <div id="Cancelled" class="tabcontent">
            <?php if (!empty($cancelledOrderList)) { ?>
                <table class="list">
                    <tr>
                        <th class="text-center p-2">STT</th>
                        <th class="text-center p-2">Mã đơn hàng</th>
                        <th class="text-center p-2">Ngày đặt</th>
                        <th class="text-center p-2">Ngày hủy</th>
                        <th class="text-center p-2">Tình trạng</th>
                        <th class="text-center p-2">Thao tác</th>
                    </tr>
                    <?php
                    $count = 1;
                    foreach ($cancelledOrderList as $order) {
                    ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $order['id']; ?></td>
                            <td><?php echo $order['createdDate']; ?></td>
                            <td><?php echo $order['cancelled_date']; ?></td>
                            <td><?php echo $order['status']; ?></td>
                            <td>
                                <a href="orderlistdetail.php?orderId=<?php echo $order['id']; ?>">Chi tiết</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <h3>Chưa có đơn hàng nào bị hủy</h3>
            <?php } ?>
        </div>

    </div>


    <?php include '../inc/footer.php' ?>
</body>

<script type="text/javascript">
    var tabcontent = document.getElementsByClassName("tabcontent");
    for (var i = 1; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;

        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>

</html>