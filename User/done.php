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

        <link rel="stylesheet" href="vanchuyen.css">
        <script type="text/javascript" src="vanchuyen.js" language="javascript"></script>
    </head>

    <body>
        <?php
        include 'header.php';
        ?>

        <div id="container">
                 <br>
                    <br>
            <div class="content">
            <div class="navigate"> <a href="">Trang chủ</a> / <a href="">Tạo đơn hàng</a></div>
                <div class="navigation-bar">
                    <section class="step-wizard">
                        <ul class="step-wizard-list">
                            <li class="step-wizard-item ">
                                <!--Nếu chưa đăng nhập mà mua hàng thì bắt buộc người dùng phải đăng nhập-->
                                <span class="progress-count">1</span>
                                <span class="progress-label">Vận chuyển</span>
                            </li>
                            <!--Nếu đăng nhập hoàn tất thì nhảy xuống bước này-->
                            <li class="step-wizard-item">
                                <span class="progress-count">2</span>
                                <span class="progress-label">Thanh Toán</span>
                            </li>
                            <li class="step-wizard-item current-item">
                                <span class="progress-count">3</span>
                                <span class="progress-label">Xác nhận</span>
                            </li>
                        </ul>
                    </section>
                </div>
                <div class="navigate">Thanh toán thành công! Vui lòng kiểm tra Email</div>
                <div class="navigate"><a href="index.php">Tiếp tục đặt hàng</a>  <div class="navigate">
                    <br>
                    <br>
  
            </div>
        </div>
        </div>
 
    </body>
    <?php
    include 'footer.php';
    ?>
    </html>