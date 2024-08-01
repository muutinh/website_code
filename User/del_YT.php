<?php
session_start();
// Kết nối đến cơ sở dữ liệu
require_once ("db_module.php");
$link = null;
taoKetNoi($link);

if (isset($_POST['favID'])) {
    // Lấy dữ liệu từ form
    $favID = $_POST['favID'];
    
    // Kiểm tra xem favID có tồn tại không
    if (!empty($favID)) {
        // Câu lệnh SQL để xóa sản phẩm yêu thích dựa trên favID
        $sql = "DELETE FROM favproduct WHERE favID = '$favID'";
        
        // Thực thi truy vấn
        $result = chayTruyVanKhongTraVeDL($link, $sql);

        if ($result) {
            // Redirect hoặc chuyển hướng tới trang khác sau khi xóa thành công
            header("Location: YT.php");
            exit();
        } else {
            // Xử lý lỗi nếu cần
            echo "Xóa sản phẩm yêu thích thất bại";
        }
    } else {
        echo "favID không được truyền vào";
    }
} else {
    echo "Dữ liệu từ biểu mẫu không được gửi đi";
}

giaiPhongBoNho($link,$result);
?>
