<?php
//bảng Orders
$tong=0;

session_start();
ob_start();
require_once "db_module.php";
$link = null;

taoKetNoi($link);
if (isset($_POST['paymentMethod']) && !empty($_POST['paymentMethod'])) {
    $ptthanhtoan = $_POST['labelValue'];
} elseif (isset($_POST['Cash']) && !empty($_POST['Cash'])) {
    $ptthanhtoan = $_POST['Cash'];
} else {
    $ptthanhtoan = null;
}


// Lấy số lượng bản ghi hiện có trong bảng Order
$query = "SELECT COUNT(*) AS num_records FROM orders";
$result = chayTruyVanTraVeDL($link, $query);
$row = mysqli_fetch_assoc($result);

// Lấy số lượng bản ghi hiện có
$num_records = $row['num_records'];

// Tạo mới orderID dựa trên số lượng bản ghi hiện có
$new_order_id = 'OD' . str_pad($num_records + 1, 5, '0', STR_PAD_LEFT);


foreach ($_SESSION['cart'] as $sp) {
    $thanhtien = $sp[4] * $sp[3];
    $tong += $thanhtien;
    $sl = $sp[3];
    $id = $sp[0];
}
// Chèn dữ liệu vào bảng orderID
$insert_query = "INSERT INTO orders (orderID, totalAmount, status, paymentMethod,DateID,TimeAltKey, customerID) 
                        VALUES('$new_order_id', '$tong', 'Đã xác nhận' ,'$ptthanhtoan','20220106', '73000' ,'" . $_SESSION['customerID'] . "')";
$rs = chayTruyVanKhongTraVeDL($link, $insert_query);


//OrderDetail
// Lấy số lượng bản ghi hiện có trong bảng Order
$query = "SELECT COUNT(*) AS num_record FROM orderdetail";
$result = chayTruyVanTraVeDL($link, $query);
$row = mysqli_fetch_assoc($result);

// Lấy số lượng bản ghi hiện có
$num_record = $row['num_record'];

// Tạo mới orderID dựa trên số lượng bản ghi hiện có
$new_orderdetail_id = 'DT' . str_pad($num_record + 1, 5, '0', STR_PAD_LEFT);

// Chèn dữ liệu vào bảng 
    $orderID = $new_order_id;
    foreach ($_SESSION['cart'] as $sp) {
        $new_orderdetail_id = 'DT' . str_pad($num_record + 1, 5, '0', STR_PAD_LEFT);
        $orderID = $new_order_id;
        $sls = $sp[3];
        $ids = $sp[0];
        $insert_detail = "INSERT INTO orderdetail (detailsID, orderID, quantity, productID) VALUES('$new_orderdetail_id', '$orderID' , '$sls','$ids')";
        $rss = chayTruyVanKhongTraVeDL($link, $insert_detail);
        echo $insert_detail;

        $num_record++;
    }

/*
$insert_detail = "INSERT INTO orderdetail (detailsID, orderID, quantity, productID) VALUES('$new_orderdetail_id', '$new_order_id' , '$sl','$id')";
$rss = chayTruyVanKhongTraVeDL($link, $insert_detail);
*/
if ($rss) {
    echo "<script>alert('Đặt hàng thành công');</script>";
    header("Location:done.php");
} else {
    echo "<script>alert('Cập nhật thất bại');</script>";
    header("Location:vanchuyen.php");
}
?>