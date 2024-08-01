    <?php
        session_start();
        if(isset($_SESSION['cart'])) {
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript" src="script.js" language="JavaScript"></script>
        <script type="text/javascript" src="vanchuyen.js" language="JavaScript"></script>
        <style>
    table {
        margin: 5%;
        border-collapse: collapse;
        width: 90%;
    }

    th, td {
        border: 2px solid black;
        padding: 8px;
        text-align: center;
    }

    th {
        text-align: center;
    }

    /* Thiết lập độ rộng của cột dựa trên nội dung */
    th, td {
        width: auto;
    }
    a.button {
        /*display: inline-block; */
        padding: 10px 20px;
        background-color: white; /* Nền trắng */
        color: black; /* Màu chữ đen */
        border: 2px solid #ff678d; /* Viền màu #ff678d */
        text-align: center;
        text-decoration: none;
        border-radius: 5px; /* Bo tròn viền */
        cursor: pointer; /* Biểu tượng chuột khi di chuột qua */
        transition: background-color 0.3s; /* Hiệu ứng khi hover */
        float: left;
        margin-right: 2%;

        }
            /* Phong cách cho button khi hover */
            .button:hover {
                background-color: #ff678d; /* Nền màu #ff678d */
                color: white; /* Màu chữ trắng */
            }


        a.button:hover {
            background-color: #ff678d; /* Nền màu #ff678d */
            color: white; /* Màu chữ trắng */
        }

</style>
    </head>
    <body>
     <!-- HEADER -->
     <?php include "header.php"; ?>
        <!-- MENU -->
        <?php include "menu.php"; ?>
        <h2 style="text-align: center; margin-top:5%">Đơn hàng của bạn</h2>
        <table >
            <tr>
                <th>Số thứ tự</th>
                <th>ID sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Số lượng sản phẩm</th>
                <th>Giá tiền</th>
                <th>Thành tiền</th>
                <th>Di chuyển khỏi giỏ hàng</th>
            </tr>

            <?php
            if(isset($_GET['id']) && ($_GET['id'] >=0)) {
                array_splice($_SESSION['cart'], $_GET['id'], 1);  
            }
            if(empty($_SESSION['cart'])) {
                header('location: index.php');
            }
                $stt = 0;
                $tong = 0;
                foreach ($_SESSION['cart'] as $sp) {
                    $thanhtien = $sp[4] * $sp[3];
                    $tong += $thanhtien;
                    echo '<tr>
                            <td>'.($stt+1).'</td>
                            <td>'.$sp[0].'</td>
                            <td><img src="'.$sp[1].'" width="100"></td>
                            <td>'.$sp[2].'</td>
                            <td><span id="quantity-display">'.$sp[3].'</span></td>
                            <td>'.number_format($sp[4]).'</td>
                            <td>'.number_format($thanhtien).'</td>
                            <td style="text-align: center; text-decoration: underline; color: #ff678d;  "><a href="viewcart.php?id='.$stt.'">Di chuyển</a></td>
                        </tr>';
                        $stt++;
                }
            ?>
            <tr>
                <td colspan="6" style="font-weight: bold;">Tổng đơn hàng</td>
                <td style="background-color: #ccc; font-weight: bold;"><?=number_format($tong); ?></td>
                <td></td>
            </tr>
        </table>
        <p><a href="index.php" class="button" style="margin-left: 5%;">Tiếp tục đặt hàng</a></p>
        <p><a href="delcart.php" class="button">Xoá giỏ hàng</a></p>
        <p><a href="vanchuyen.php" onclick="taoSanPham()" class="button">Thanh toán</a></p>
        <br>    
        <br>
        <br>    
        <br>
        <?php    include 'footer.php'; ?>      

      </body>
    </html>
    <?php       
        } else {
            ?>
            <html>
                <head>
                <style>
                .popup-container {
                    display: none;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: rgba(255, 192, 203, 0.8);
                padding: 20px;
                border-radius: 10px;
                }

                .popup {
                text-align: center;
                }

                .close-btn {
                position: absolute;
                top: 10px;
                right: 10px;
                font-size: 20px;
                cursor: pointer;
                }

                .check-icon {
                width: auto;
                height: 50px;
                margin-bottom: 10px;
                }
            </style>      
        </head>
        <body>         
            <div id="popup-container" class="popup-container">
                <div class="popup">
                    <span class="close-btn" onclick="closePopup()">&times;</span>
                    <img src="https://www.svgrepo.com/show/93424/exclamation-mark-inside-a-circle.svg" alt="Check icon" class="check-icon" >
                    <p><br>Giỏ hàng rỗng. Bạn <a href="index.php">đặt hàng</a> không?</p>
                </div>
            </div>
            <?php
        }
    ?>
   
   <script>
            function showPopup() {
            document.getElementById("popup-container").style.display = "block";
            }

            function closePopup() {
            document.getElementById("popup-container").style.display = "none";
            window.location.href='index.php'
            }
            window.onload = function() {
            showPopup();
            };
    </script>
      </body>
</html>
