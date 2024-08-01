<?php
// Kết nối đến cơ sở dữ liệu
require_once("db_module.php");
session_start();

$link = null;
taoKetNoi($link);

global $customerID;
if(isset($_POST['submit'])) {
    // Lấy dữ liệu từ form
    $diachi = $_POST['diachi'];
    $quan = $_POST['quan'];
    $tp = $_POST['tp'];
    $pttt = $_POST['pttt'];

    
        // Lấy districtID từ bảng District dựa trên tên quận
        $sql_district = "SELECT districtID FROM District WHERE district = '$quan'";
        $result_district = chayTruyVanTraVeDL($link, $sql_district);

        if($result_district && mysqli_num_rows($result_district) > 0) {
            $row_district = mysqli_fetch_assoc($result_district);
            $districtID = $row_district['districtID'];
        
            // Tạo một locationID mới
            // Đây là một ví dụ đơn giản, bạn có thể cải tiến hơn để tạo locationID duy nhất hơn
            $sql_max_location = "SELECT MAX(CAST(SUBSTRING(locationID, 4) AS UNSIGNED)) AS max_location FROM location";
            $result_max_location = chayTruyVanTraVeDL($link, $sql_max_location);
        
            $max_location = 0;
            if($result_max_location && mysqli_num_rows($result_max_location) > 0) {
                $row_max_location = mysqli_fetch_assoc($result_max_location);
                $max_location = $row_max_location['max_location'];
            }
        
            $new_locationID = "LOC" . ($max_location + 1);
        
            // Thêm mới location vào bảng location
            $sql_insert_location = "INSERT INTO location (locationID, address, districtID) VALUES ('$new_locationID', '$diachi', '$districtID')";
            $result_insert_location = chayTruyVanKhongTraVeDL($link, $sql_insert_location);
        
            if($result_insert_location) {
                
                // Sau khi thêm mới location thành công, cập nhật locationID vào bảng customer
                $sql_update_customer = "UPDATE customer SET locationID='$new_locationID' WHERE customer.customerID = '" . $_SESSION['customerID']  . "'";
                $result_update_customer = chayTruyVanKhongTraVeDL($link, $sql_update_customer);

                if($result_update_customer) {
                    echo "<script>alert('Thêm Địa chỉ giao hàng thành công');</script>";
                    // Chuyển hướng người dùng đến trang SDC.php
                    echo "<script>window.location.href='SDC.php';</script>";
                } 
            } else {
                echo "<script>alert('Thêm Địa chỉ giao hàng thất bại');</script>";
            }
        } else {
            echo "<script>alert('Không tìm thấy quận');</script>";
        }
    }

?>
