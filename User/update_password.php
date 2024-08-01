<?php
require_once("db_module.php");
require_once("users_module.php");
require_once("validate_module.php");

// Kết nối đến cơ sở dữ liệu
$link = null;
taoKetNoi($link);

// Đảm bảo session đã được bắt đầu
session_start();

// Lấy customerID từ session
$customerID = $_SESSION['customerID'];

if(isset($_POST['submit'])) {
    // Lấy dữ liệu từ form
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Kiểm tra mật khẩu cũ có đúng không
    $sql = "SELECT password FROM useraccount WHERE customerID = '$customerID' AND password = '$oldPassword'";
    $result = chayTruyVanTraVeDL($link, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        // Kiểm tra xác nhận mật khẩu mới
        if ($newPassword == $confirmPassword) {
            // Kiểm tra độ dài mật khẩu mới
            if (validateLenUP($newPassword)) {
                // Cập nhật mật khẩu mới vào cơ sở dữ liệu
                $updateSql = "UPDATE useraccount SET password = '$newPassword' WHERE customerID = '$customerID'";
                $updateResult = chayTruyVanKhongTraVeDL($link, $updateSql);

                if ($updateResult) {
                    echo "<script>alert('Đổi mật khẩu thành công');</script>";
                    // Redirect hoặc chuyển hướng tới trang khác sau khi đổi mật khẩu thành công
                    echo "<script>window.location.href='TTKH.php';</script>";
                    exit(); // Thoát để ngăn code phía sau chạy khi đã chuyển hướng
                } else {
                    echo "<script>alert('Đổi mật khẩu thất bại');</script>";
                    echo "<script>window.location.href='TTKH.php';</script>";
                    exit();
                }
            } else {
                echo "<script>alert('Mật khẩu phải có độ dài từ 8 đến 30 ký tự');</script>";
                echo "<script>window.location.href='TTKH.php';</script>";
                exit();
            }
        } else {
            echo "<script>alert('Mật khẩu mới và xác nhận mật khẩu không khớp');</script>";
            echo "<script>window.location.href='TTKH.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Mật khẩu cũ không chính xác');</script>";
        echo "<script>window.location.href='TTKH.php';</script>";
        exit();
    }
}

// Giải phóng bộ nhớ và đóng kết nối
giaiPhongBoNho($link, $result);
?>
