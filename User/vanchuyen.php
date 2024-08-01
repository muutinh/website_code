    <html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
            integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
            rel="stylesheet">
            <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">



        <link rel="stylesheet" href="vanchuyen.css">
    </head>
    <body>
    <?php include "header.php"; ?>
    <?php
        if (session_status() === PHP_SESSION_NONE) {
            // Phiên chưa được kích hoạt, bắt đầu một phiên mới
            session_start();
        }

        require_once "db_module.php";
        $link = null;
        taoKetNoi($link);

        if (!isset($_SESSION["customerID"])) {
            header("Location:dangnhap.php");
        };

        if (isset($_SESSION['cart'])) {

            $sql = "SELECT CONCAT(customer.lastName, ' ', customer.firstName) AS customerName,
            customer.phone,
            customer.email,
            CONCAT(location.address, ', ', d.district, ', ', province.province) AS address
            FROM customer
            LEFT JOIN location ON customer.locationID = location.locationID
            LEFT JOIN district d ON location.districtID = d.districtID
            LEFT JOIN province ON d.provinceID = province.provinceID
            WHERE customer.customerID = '" . $_SESSION['customerID'] . "'";

            $rs = chayTruyVanTraVeDL($link, $sql);
            if (mysqli_num_rows($rs) > 0) {
                // Nếu có dòng dữ liệu trả về, tức là người dùng đã đặt địa chỉ giao hàng mặc định
                $row = mysqli_fetch_assoc($rs);
            }
    ?>
     <!-- HEADER -->
        <div id="container">
            <div class="content">
                <div class = "navigate"><a href="">Trang chủ</a> / <a href="">Tạo đơn hàng</a></div>
                <div class="navigation-bar">
                    <section class="step-wizard">
                        <ul class="step-wizard-list">
                            <li class="step-wizard-item current-item">
                                <!--Nếu chưa đăng nhập mà mua hàng thì bắt buộc người dùng phải đăng nhập-->
                                <span class="progress-count">1</span>
                                <span class="progress-label">Vận chuyển</span>
                            </li>
                            <!--Nếu đăng nhập hoàn tất thì nhảy xuống bước này-->
                            <li class="step-wizard-item">
                                <span class="progress-count">2</span>
                                <span class="progress-label">Thanh Toán</span>
                            </li>
                            <li class="step-wizard-item">
                                <span class="progress-count">3</span>
                                <span class="progress-label">Xác nhận</span>
                            </li>
                        </ul>
                    </section>
                </div>
                <div class="infor">
                    <!--Thông tin đăng nhập, nhấn đăng nhập sẽ điều hướng qua trang đăng nhập, ngược lại đã đăng nhập sẵn sẽ điều hướng qua bước hai-->

                    <div class="personal-infor">
                        <h3>Địa chỉ vận chuyển</h3>
                        <form action="xacnhan.php" id="dangnhapForm" method="POST">
                            <!--thông tin vận chuyển-->
                            <div class="row">
                                <div class="col-trai">
                                    <label for="name">Họ và tên</label>
                                </div>
                                <div class="col-phai">
                                    <input type="text" id="name" name="name" placeholder="Nhập họ và tên" required
                                        value="<?php echo htmlspecialchars($row['customerName']); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-trai">
                                    <label for="address">Địa chỉ</label>
                                </div>
                                <div class="col-phai">
                                    <input type="text" id="address" name="street-address" placeholder="Nhập tên đường"
                                        required value="<?php echo htmlspecialchars($row['address']); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-trai">
                                    <label for="address">Quận</label>
                                </div>
                                <div class="col-phai">
                                    <input type="text" id="address-con" name="district" placeholder="Nhập quận"
                                    value="<?php echo htmlspecialchars(explode(', ', $row['address'])[1]); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-trai">
                                    <label for="city">Thành phố</label>
                                </div>
                                <div class="col-phai">
                                    <input type="text" id="city" name="city" placeholder="Nhập thành phố" required
                                        value="<?php echo htmlspecialchars(explode(', ', $row['address'])[2]); ?>">
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col-trai">
                                    <input type="submit" class = "submit" value="Tiếp >>">
                                </div>
                                <div class="col-phai">
                                    <button type="button" onclick="goback()" style="float: right; border: none; background-color: white; cursor: pointer;">
                                    <a href="viewcart.php">Quay lại</a></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="img-order">
                        <div class="order-items">
                            <h3 style="padding-left: 15px;">ĐƠN HÀNG</h3>
                            <select id="country" name="country" style="border: none;">
                                <option value="none">Loại hàng hoá có trong giỏ hàng</option>
                                <?php
                                foreach ($_SESSION['cart'] as $sp) {
                                    echo '<option value="' . $sp[2] . '">' . $sp[2] . '</option>';
                                }
                                ?>
                            </select>
                            <hr width="95%">
                            <div class="row">

                                <?php
                                foreach ($_SESSION['cart'] as $sp) {
                                    $tong = 0;
                                    $thanhtien = $sp[4] * $sp[3];
                                    $tong += $thanhtien;
                                    echo '  <div class="col-trais" style="margin-top: 3%;">
                                                <img src="' . $sp[1] . '" alt="" width="70%" height="10%" style="border: 1px solid black; margin-left: 10px;">
                                            </div>
                                            <div class="col-giua">
                                                <span style="float: left; font-size: 10px;">' . $sp[2] . '</span>
                                                <br>
                                                <span style="float: left; font-size: 10px;">Số lượng: <span>' . $sp[3] . '</span></span>
                                                <br>
                                                <span style="float: left; font-size: 10px;"><a href="product.php?product_id=' . $sp[0] . '">Xem chi tiết</a></span>
                                            </div>
                                            <div class="col-phais">
                                                <span style="float: right; font-size: 10px;">' . $thanhtien . '</span>
                                            </div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </body>
    <?php
    include 'footer.php';
}
    ?>

    </html>