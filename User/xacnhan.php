
<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Thu thập dữ liệu từ form
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $address = isset($_POST['street-address']) ? $_POST['street-address'] : '';
    $district = isset($_POST['district']) ? $_POST['district'] : '';
    $city = isset($_POST['city']) ? $_POST['city'] : '';

     // Lưu dữ liệu vào session
     $_SESSION['name'] = $name;
     $_SESSION['address'] = $address;
     $_SESSION['district'] = $district;
     $_SESSION['city'] = $city;
}
if (isset($_SESSION['cart'])) {

    ?>
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


        <link rel="stylesheet" href="xacnhan.css">
        <script type="text/javascript" src="xacnhan.js" language="javascript"></script>
    </head>

    <body>
    <?php include "header.php"; ?>
        <div id="container">
            <div class="content">
                <div class = "navigate"><a href="">Trang chủ</a> / <a href="">Tạo đơn hàng</a></div>
                <p><strong>Xác nhận thông tin</strong></p>
                <div class="navigation-bar">
                    <section class="step-wizard">
                        <ul class="step-wizard-list">
                            <li class="step-wizard-item">
                                <!--Nếu chưa đăng nhập mà mua hàng thì bắt buộc người dùng phải đăng nhập-->
                                <span class="progress-count">1</span>
                                <span class="progress-label">Vận chuyển</span>
                            </li>
                            <!--Nếu đăng nhập hoàn tất thì nhảy xuống bước này-->
                            <li class="step-wizard-item current-item">
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
                    <form id="mainForm" action="hoantat.php" method="POST"> 
                        <h2>Thông tin vận chuyển</h2>
                        <div class="row">
                            <div class="col-trai">
                                <label for="name">Họ và tên: </label>
                            </div>
                            <div class="col-phai">
                                <!-- Display user name from session -->
                                <span id="hovaten">
                                    <?php echo htmlspecialchars($_SESSION['name']); ?>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-trai">
                                <label for="address">Địa chỉ: </label>
                            </div>
                            <div class="col-phai">
                                <!-- Display user address from session -->
                                <span id="diachi">
                                    <?php echo htmlspecialchars($_SESSION['address']); ?>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-trai">
                                <label for="district">Quận:</label>
                            </div>
                            <div class="col-phai">
                                <!-- Display district from session -->
                                <span id="quan">
                                    <?php echo htmlspecialchars($_SESSION['district']); ?>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-trai">
                                <label for="city">Thành phố:</label>
                            </div>
                            <div class="col-phai">
                                <!-- Display city from session -->
                                <span id="thanhpho">
                                    <?php echo htmlspecialchars($_SESSION['city']); ?>
                                </span>
                            </div>
                        </div>
                        <br>
                        <h2>Phương thức thanh toán</h2>
                    <div>
                            
                        <input type="radio" id="tienmat" value="Tiền mặt" name="Cash">
                        <label for="tienmat">Tiền mặt</label>
                    </div>   
                    <div>
                        <input type="radio" id="banking" value="xulythanhtoanmomo.php" name="paymentMethod">
                         <label for="banking">Momo QR Code</label>
                           <!-- Input ẩn để lưu giá trị của label -->
                         <input type="hidden" id="labelValue" name="labelValue" value ="Momo QR Code">
                    </div> 
                    <div>
                        <input type="radio" id="momo" value="xulythanhtoanmomoatm.php" name="paymentMethod" >
                         <label for="momo">Momo Banking</label>
                           <!-- Input ẩn để lưu giá trị của label -->
                         <input type="hidden" id="labelValue" name="labelValue" value ="Momo Banking">
                    </div>
               
                        <div class="row">
                            <div class="col-trai">
                            <input type="submit" name="tieptheo" value="Tiếp theo >>>" class="btn btn-danger" onclick="handleSubmit(event)">
                            </div>
                            <div class="col-phai">
                                <button type="button" onclick="goback()"
                                    style="float: right; border: none; background-color: white; cursor: pointer;">Quay
                                    lại</button>
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
                                                <img src="' . $sp[1] . '" alt="" width="70%" height="5%" style="border: 1px solid black; margin-left: 10px;">
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
        <script>
        function handleSubmit(event) {
            // Ngăn chặn form gửi đi ngay lập tức
            event.preventDefault();

            // Lấy form chính
            var mainForm = document.getElementById('mainForm');

            // Gửi form chính tới "hoantat.php"
            mainForm.submit();

            // Lấy lựa chọn radio button cho phương thức thanh toán
            var selectedPaymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;

            // Điều hướng đến trang thanh toán Momo dựa trên lựa chọn của người dùng
            if (selectedPaymentMethod) {
                window.open(selectedPaymentMethod, '_blank');
            }
        }


    </script>
    </body>
    <?php include "footer.php"; ?>


    </html>
    <?php
}
?>