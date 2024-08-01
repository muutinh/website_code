<?php
session_start();
// Kết nối đến cơ sở dữ liệu
require_once ("db_module.php");
$link = null;
taoKetNoi($link);

if (isset($_POST['orderID'])) {
    // Lấy dữ liệu từ form
    $orderID = $_POST['orderID'];
    
    // Kiểm tra xem favID có tồn tại không
    if (!empty($orderID)) {
        // Câu lệnh SQL để xóa sản phẩm yêu thích dựa trên favID
        $sql = "UPDATE orders SET status = 'Hủy bỏ' WHERE orderID = '$orderID'";

        
        // Thực thi truy vấn
        $result = chayTruyVanKhongTraVeDL($link, $sql);

        if ($result) {
            echo "<script>alert('Hủy đơn hàng thành công');</script>";
            echo "<script>window.location.href='DDH.php';</script>";
            exit();
        } else {
            // Xử lý lỗi nếu cần
            echo "Hủy đơn hàng thất bại";
        }
    } else {
        echo "orderID không được truyền vào";
    }
} else {
    echo "Dữ liệu từ biểu mẫu không được gửi đi";
}

giaiPhongBoNho($link,$result);
?>
