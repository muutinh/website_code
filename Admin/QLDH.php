<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        function ConfirmDel() {
            var confirmed = confirm("Bạn chắc chắn muốn xóa không?");
            if (confirmed) {
                console.log("Đã xóa");
            }
        }
    </script>

<link rel="stylesheet" type="text/css" href="Khung.css">    
<style>
            
            #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px; /* Điều chỉnh độ rộng của sidebar theo mong muốn */
            height: 100%;
            background-color: #F9F2E6; /* Màu nền của sidebar */
        }

    </style>

</head>

<body>
    <div id="container">
        <div id="sidebar">
            <h2><img src="Picture/Logo.png" alt="Logo"></h2>
            <ul>
            <li><a href="Overview.php">Overview</a></li>
            <li><a href="QLSP.php">Quản lý sản phẩm</a></li>
            <li><a href="QLNV.php">Quản lý nhân viên</a></li>
            <li><a href="QLDH.php">Quản lý đơn hàng</a></li>
        </div>

        <div id="header" >
            <h2>ADMIN / QUẢN LÝ ĐƠN HÀNG</h2>
        </div id="content">
        <?php include "DonHang.php"; ?>
    </div>
    <div id="footer">
        <p>© 2024 Công Ty Cổ Phần Vàng Bạc Đá Quý Flamingo</p>
    </div>

    </div>
</body>

</html>