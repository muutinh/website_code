<?php

require_once "db_module.php";
require_once "users_module.php";
require_once "validate_module.php";
if (session_status() === PHP_SESSION_NONE) {
    // Phiên chưa được kích hoạt, bắt đầu một phiên mới
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["password2"])) {
        $username = mysqli_real_escape_string($link, $_POST["username"]);
        $password = mysqli_real_escape_string($link, $_POST["password"]);
        $password2 = mysqli_real_escape_string($link, $_POST["password2"]);

        if (kiemTraMatKhau($password, $password2)) {
            $valid = true;
            $valid = $valid && validateLenUP($username);
            $valid = $valid && validateLenUP($password);

            if ($valid) {
                $link = null;
                taoKetNoi($link);
                if (!existsUsername($link, $username)) {
                    $query = "SELECT COUNT(*) AS num_records FROM useraccount WHERE username = '$username'";
                    $result = chayTruyVanTraVeDL($link, $query);
                    $row = mysqli_fetch_assoc($result);
                    if ($row['num_records'] == 0) {
                        // Generate new IDs
                        $query = "SELECT COUNT(*) AS num_records FROM useraccount";
                        $result = chayTruyVanTraVeDL($link, $query);
                        $row = mysqli_fetch_assoc($result);
                        $num_records = $row['num_records'];

                        $new_account_id = 'A' . str_pad($num_records + 1, 6, '0', STR_PAD_LEFT);
                        $new_cus_id = 'CS0' . str_pad($num_records + 1, 5, '0', STR_PAD_LEFT);

                        // Insert into customer table first
                        $insertCustomerQuery = "INSERT INTO customer (customerID) VALUES ('$new_cus_id')";
                        if (chayTruyVanKhongTraVeDL($link, $insertCustomerQuery)) {
                            
                            $insertQuery = "INSERT INTO useraccount (accountID, username, password, customerID) VALUES ('$new_account_id', '$username', '$password', '$new_cus_id')";
                            if (chayTruyVanKhongTraVeDL($link, $insertQuery)) {
                                echo "<script>alert('Đăng kí thành công');</script>";
                                echo "<script>window.location.href='dangnhap.php';</script>";
                               
                                exit();
                            } else {
                                $_SESSION['error'] = "Có lỗi xảy ra trong quá trình đăng ký tài khoản";
                            }
                        } else {
                            $_SESSION['error'] = "Không thể tạo mới khách hàng";
                        }
                    } else {
                        $_SESSION['error'] = "Tài khoản đã tồn tại";
                    }
                } else {
                    $_SESSION['error'] = "Tài khoản đã tồn tại";
                }
            } else {
                $_SESSION['error'] = "Tên đăng nhập và mật khẩu phải từ 8 ký tự trở lên";
            }
        } else {
            $_SESSION['error'] = "Mật khẩu không trùng khớp";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Ký</title>
    <style>
        .signup {
            background-image: url("img/LoginBG.png");
            background-size: cover; 
            display: flex;
            justify-content: flex-start; 
            align-items: center;
            height: 100vh;
        }
        @media screen and (max-width: 768px) {
            .signup {
                justify-content: center; /* Căn giữa khung đăng nhập */
                margin-left: 0; /* Để khung đăng nhập căn giữa */
                background-size: 200% 100%; /* Phủ nền toàn màn hình */
                background-position: left; 
            }
        }

        .registration-container {
            background-color: #fff; /* Khung trắng bao quanh */
            padding: 28px 33px 50px;
            max-width: 584px;
            width: 100%;    
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Hiệu ứng khung trắng */
            margin-left: 2%;
        }

        @media screen and (max-width: 768px) {
            . .registration-container {
                margin-left: 0; 
            }
        }
        .registration-container img {
            display: block;
            margin-left: auto;
            margin-right: 0%;
            width: 35px;
        }
        .registration-title {
            text-align: center;
            margin-top: 15px;
            margin-bottom : 20px;
            font: 600 30px Barlow, sans-serif;
            color: #333;
        }
        .input-field {
            font-family: Barlow, sans-serif;
            width: 100%; /* Hoặc một giá trị cụ thể khác để giảm chiều rộng và cho phép căn giữa */
            padding: 15px;
            margin-top: 20px;
            margin-bottom: 20px; 
            border: 1px solid rgba(212, 213, 217, 1);
            box-sizing: border-box; 
            display: block; 
            margin-left: auto; 
            margin-right: auto;
         }

        .name-fields {
            display: flex;
            width: 100%;
            margin-top: 20px;
        }
        #ho {
            width: 20%;
            padding: 15px;
            margin-right: 3px; /* Điều chỉnh theo nhu cầu để tạo khoảng cách giữa hai trường */
            border: 1px solid rgba(212, 213, 217, 1);
            box-sizing: border-box; /* Đảm bảo padding không làm thay đổi kích thước tổng thể */
        }
        #ten {
            width: 80%; /* Điều chỉnh để tổng chiều rộng không vượt quá 100% khi tính cả margin */
            padding: 15px;
            border: 1px solid rgba(212, 213, 217, 1);
            box-sizing: border-box;
        }
        .registration-button {
            background-color: #fb6f92;
            color: #f9f2e6;
            padding: 15px;
            border: none;
          
            margin-top: 20px;
            cursor: pointer;
            font-weight: 600;
            text-transform: uppercase;
            width: 100%;
            font-family: Oswald, sans-serif;
            letter-spacing: 1.35px;
        }
       
        .msg.success {
            font-size: bigger;
            padding: 10px;
            margin-bottom: 0px;
            border-radius: 5px;
            text-align: center;
            background-color: #dff0d8; /* Màu nền cho thông báo thành công */
            color: #3c763d; /* Màu chữ cho thông báo thành công */
            font-weight : bold;
            font-family: Barlow, sans-serif;
        }

        .msg.error {
            font-size: bigger;
            padding: 10px;
            margin-bottom: 0px;
            border-radius: 5px;
            text-align: center;
            background-color: #f2dede; /* Màu nền cho thông báo lỗi */
            color: #a94442; /* Màu chữ cho thông báo lỗi */
            font-weight : bold;
            font-family: Barlow, sans-serif;

        }

        .cctk {
                    text-align: center;
                    margin-top: 15px;          
                    font: 400 15px Barlow, sans-serif;
                    color: #fb6f92;
                }

        .cctk a {
                color: purple; /* Màu tím */
                text-decoration: underline; /* Gạch chân */
            }

    </style>
</head>
<body>
<?php require "header.php"; ?>
<?php require "menu.php"; ?>
<div class="signup"> 
    <div class="registration-container"> 
        <div class="registration-title">Đăng Ký</div>
        <form action="dangki.php" method="POST" enctype="multipart/form-data">
            <input type="text" class="input-field" name="username" placeholder="Tên Đăng Nhập" required>
            <input type="password" class="input-field" placeholder="Mật khẩu" name="password" required>
            <input type="password" class="input-field" placeholder="Nhập lại mật khẩu" name="password2" required>
            <?php if(isset($_SESSION['error'])): ?>
            <div class="msg error"><?php echo $_SESSION['error']; ?></div>
            <?php unset($_SESSION['error']); ?> <!-- Đảm bảo thông báo lỗi chỉ hiển thị một lần -->
        <?php endif; ?>
            <button type="submit" class="registration-button">Đăng Ký</button>
            <div class="cctk">Đã có tài khoản? <a href="dangnhap.php">Đăng nhập ngay</a></div>
        </form>
        </div>
    </div>
    <?php require "footer.php"; ?>
</body>
</html>