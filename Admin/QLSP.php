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

            #sanpham, #khuyenmai {
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

        #sanpham img, #khuyenmai img {
            width: 70px; 
        }

        #sanpham:hover, #khuyenmai:hover {
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
            <li><a href="QLNV.php">Quản lý nhân viên</li>
            <li><a href="QLDH.php">Quản lý đơn hàng</li>
        </ul>
    </div>

    <div id="content">
        <div id="header">
            <p>ADMIN / QUẢN LÝ SẢN PHẨM</p>
        </div>
    </div>

    <div id="Button">
        <a href="QLSP_XemSP.php">
            <button id="sanpham">
                <img src="Picture/Icon Sanpham.png" alt="Icon Sản phẩm">
                <br>
                Sản phẩm
            </button>
        </a>
        <a href="QLSP_KhuyenMai.php">
            <button id="khuyenmai">
                <img src="Picture/Icon Khuyenmai.png" alt="Icon Khuyến mãi">
                <br>
                Khuyến mãi
            </button>
        </a>
    </div>    
    
    <div id="footer">
        <p>© 2024 Công Ty Cổ Phần Vàng Bạc Đá Quý Flamingo.</p>
    </div>

</body>
</html>