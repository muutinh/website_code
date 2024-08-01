<?php
session_start();
// Kết nối đến cơ sở dữ liệu
require_once ("db_module.php");
$link = null;
taoKetNoi($link);

if (isset($_POST['submit'])) {
    // Lấy dữ liệu từ form
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $dateOfBirth = $_POST['dateOfBirth'];
    // Biến $gender là giới tính cần cập nhật
// Giới tính Nam sẽ được lưu là 'M', Nữ là 'F', và Khác là 'unknown'

    // Câu lệnh SQL để cập nhật dữ liệu với giới tính đã được chuyển đổi
    $sql = "UPDATE customer SET lastName='$lastName', firstName='$firstName', phone='$phone', email='$email', gender='$gender', dateOfBirth='$dateOfBirth' WHERE customer.customerID = '" . $_SESSION['customerID'] . "'";

    // Thực thi truy vấn
    $result = chayTruyVanKhongTraVeDL($link, $sql);

    if ($result) {
        echo "<script>alert('Cập nhật thông tin thành công');</script>";
        // Redirect hoặc chuyển hướng tới trang khác sau khi cập nhật thành công
        echo "<script>window.location.href='TTKH.php';</script>";
    } else {
        echo "<script>alert('Cập nhật thông tin thất bại');</script>";
    }
}


giaiPhongBoNho($link, $result);
?>