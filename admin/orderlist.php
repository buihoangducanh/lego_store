<?php
include_once '../lib/session.php';
Session::checkSession('admin');
$role_id = Session::get('role_id');
if ($role_id == 1) {
    # code...
} else {
    header("Location:../index.php");
}
include '../classes/order.php';

$order = new order();
$processingOrderList = $order->getProcessingOrder();
$processedOrderList = $order->getProcessedOrder();
$deliveringOrderList = $order->getDeliveringOrder();
$completeOrderList = $order->getCompleteOrder();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'inc/metadata_libs.php'
    ?>
    <title>Quản lý đơn đặt hàng</title>
</head>

<body>
    <?php
    include 'inc/admin_header.php'
    ?>
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
        </div>

        <!-- Tab content -->
        <div id="Processing" class="tabcontent">
            <?php
            if ($processingOrderList) { ?>
                <table class="list">
                    <tr>
                        <th>STT</th>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt</th>
                        <th>Ngày giao</th>
                        <th>Tình trạng</th>
                        <th>Thao tác</th>
                    </tr>
                    <?php $count = 1;
                    foreach ($processingOrderList as $key => $value) { ?>
                        <tr>
                            <td><?= $count++ ?></td>
                            <td><?= $value['id'] ?></td>
                            <td><?= $value['createdDate'] ?></td>
                            <td><?= ($value['status'] != "Processing") ? $value['receivedDate'] : "Dự kiến 3 ngày sau khi đơn hàng đã được xử lý" ?> <?= ($value['status'] != "Complete" && $value['status'] != "Processing") ? "(Dự kiến)" : "" ?> </td>
                            <td><?= $value['status'] ?></td>
                            <td>
                                <a href="orderlistdetail.php?orderId=<?= $value['id'] ?>">Chi tiết</a>
                            </td>
                        </tr>
                    <?php }
                    ?>
                </table>
            <?php } else { ?>
                <h3>Chưa có đơn hàng nào đang xử lý</h3>
            <?php }
            ?>
        </div>

        <div id="Processed" class="tabcontent">
            <?php
            if ($processedOrderList) { ?>
                <table class="list">
                    <tr>
                        <th>STT</th>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt</th>
                        <th>Ngày giao</th>
                        <th>Tình trạng</th>
                        <th>Thao tác</th>
                    </tr>
                    <?php $count = 1;
                    foreach ($processedOrderList as $key => $value) { ?>
                        <tr>
                            <td><?= $count++ ?></td>
                            <td><?= $value['id'] ?></td>
                            <td><?= $value['createdDate'] ?></td>
                            <td><?= ($value['status'] != "Processing") ? $value['receivedDate'] : "Dự kiến 3 ngày sau khi đơn hàng đã được xử lý" ?> <?= ($value['status'] != "Complete" && $value['status'] != "Processing") ? "(Dự kiến)" : "" ?> </td>
                            <td><?= $value['status'] ?></td>
                            <td>
                                <a href="delivering_order.php?orderId=<?= $value['id'] ?>">Giao hàng</a>
                            </td>
                        </tr>
                    <?php }
                    ?>
                </table>
            <?php } else { ?>
                <h3>Chưa có đơn hàng nào đã xử lý</h3>
            <?php }
            ?>
        </div>

        <div id="Delivering" class="tabcontent">
            <?php
            if ($deliveringOrderList) { ?>
                <table class="list">
                    <tr>
                        <th>STT</th>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt</th>
                        <th>Ngày nhận</th>
                        <th>Tình trạng</th>
                        <th>Thao tác</th>
                    </tr>
                    <?php $count = 1;
                    foreach ($deliveringOrderList as $key => $value) { ?>
                        <tr>
                            <td><?= $count++ ?></td>
                            <td><?= $value['id'] ?></td>
                            <td><?= $value['createdDate'] ?></td>
                            <td><?= ($value['status'] != "Processing") ? $value['receivedDate'] : "Dự kiến 3 ngày sau khi đơn hàng đã được xử lý" ?> <?= ($value['status'] != "Complete" && $value['status'] != "Processing") ? "(Dự kiến)" : "" ?> </td>
                            <td><?= $value['status'] ?></td>
                            <td>
                                <a href="orderlistdetail.php?orderId=<?= $value['id'] ?>">Chi tiết</a>
                            </td>
                        </tr>
                    <?php }
                    ?>
                </table>
            <?php } else { ?>
                <h3>Chưa có đơn hàng nào đang giao</h3>
            <?php }
            ?>
        </div>

        <div id="Complete" class="tabcontent">
            <?php
            if ($completeOrderList) { ?>
                <table class="list">
                    <tr>
                        <th class="text-center p-2">STT</th>
                        <th class="text-center p-2">Mã đơn hàng</th>
                        <th class="text-center p-2">Ngày đặt</th>
                        <th class="text-center p-2">Ngày nhận</th>
                        <th class="text-center p-2">Tình trạng</th>
                        <th class="text-center p-2">Thao tác</th>
                    </tr>
                    <?php $count = 1;
                    foreach ($completeOrderList as $key => $value) { ?>
                        <tr>
                            <td><?= $count++ ?></td>
                            <td><?= $value['id'] ?></td>
                            <td><?= $value['createdDate'] ?></td>
                            <td><?= ($value['status'] != "Processing") ? $value['receivedDate'] : "Dự kiến 3 ngày sau khi đơn hàng đã được xử lý" ?> <?= ($value['status'] != "Complete" && $value['status'] != "Processing") ? "(Dự kiến)" : "" ?> </td>
                            <td><?= $value['status'] ?></td>
                            <td>
                                <a href="orderlistdetail.php?orderId=<?= $value['id'] ?>">Chi tiết</a>
                            </td>
                        </tr>
                    <?php }
                    ?>
                </table>
            <?php } else { ?>
                <h3>Chưa có đơn hàng nào đã hoàn thành</h3>
            <?php }
            ?>
        </div>
    </div>
    </div>

    <?php
    include '../inc/footer.php'
    ?>
</body>
<script type="text/javascript">
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 1; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;

        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        document.getElementById(tabName).style.display = "block";
    }
</script>

</html>