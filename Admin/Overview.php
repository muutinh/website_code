<html>
<head>
    <link rel="stylesheet" type="text/css" href="Khung.css">
<style>
        #Button {
            margin-top: 50px; 
            text-align: center; 
        }

        #Button button {
            margin: 10px; 
        }

            #baocaobanhang, #sogiaohang, #thongke {
            background-color: #FFE5EC; 
            color: #832E43; 
            border: none; 
            cursor: pointer; 
            font-family: Barlow, sans-serif; 
            font-size: 14px; 
            width: 950px; 
            text-align: center; 
            height: 100px;
        }

        #baocaobanhang img, #sogiaohang img, #thongke img {
            width: 70px;
        }

        #baocaobanhang:hover, #sogiaohang:hover, #thongke:hover {
            background-color: #dea3a385; 
            color: #fff;
        }
    </style>
</head>
<body>
    <div id="sidebar">
        <h2><img src="Picture/Logo.png" alt="Logo"></h2>
        <ul>
            <li><a href="Overview.php">Overview</a></li>
            <li><a href="QLSP.php">Quản lý sản phẩm</a></li>
            <li><a href="QLNV.php">Quản lý nhân viên</a></li>
            <li><a href="QLDH.php">Quản lý đơn hàng</a></li>
        </ul>
    </div>

    <div id="content">
        <div id="header">
            <p>ADMIN / OVERVIEW</p>
        </div>
    </div>

    <div id="Button">
    <a href="Overview_Baocaobanhang.php">
        <button id="baocaobanhang">
            <img src="Picture/Icon Baocao.png" alt="Icon Báo cáo">
            <br> Báo cáo bán hàng
        </button>
    </a>
    <a href="Overview_Chart.php">
        <button id="thongke">
            <img src="Picture/Icon Chart.png" alt="Icon Chart">
            <br>Thống kê
        </button>
    </a>
    <a href="Overview_SoGiaoHang.php">
        <button id="sogiaohang">
            <img src="Picture/Icon Sogiaohang.png" alt="Icon Sổ giao hàng">
            <br>Sổ giao hàng
        </button>
    </a>
    </div>

    <div id="footer">
        <p>© 2024 Công Ty Cổ Phần Vàng Bạc Đá Quý Flamingo.</p>
    </div>
</body>
</html>
