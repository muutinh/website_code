<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="Khung.css">    
    <style>
        /* CSS hiện tại của bạn */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: -10px;
        }
        th, td {
            border: 1px solid black;
            text-align: center;
            padding: 5px 7px;
            font-size: 12.5px; /* Giảm kích thước chữ */
            font-family: 'Barlow', sans-serif;
        }
        input[type="text"] {
            padding: 8px;
            margin-bottom: 10px;
            width: 200px;
        }
        button {
            font-family: 'Barlow', sans-serif;
            padding: 6px 10px; /* Giảm kích thước button */
            background-color: #DF8A8A;
            border: none;
            cursor: pointer;
            border-radius: 7px;
            margin-right: 5px; /* Giảm khoảng cách giữa các button */
        }
        button:hover {
            background-color: #6a4141;
        }
        #search {
            display: block;
            justify-content: center; 
            align-items: center; 
            padding: 20px;
            margin-top: 50px; 
            text-align: center;
            margin-top: 60px;
        }
        input[type="text"] {
            margin-right: 10px; 
            margin-top: 8px; 
        }
        /* CSS mới để cố định footer ở dưới trang */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            position: relative;
        }
        
        /* Thêm CSS cho dòng đầu tiên */
        .pink-row th {
            background-color: #FFC0CB; /* Màu hồng */
        }
        .pagination {
            text-align: center;
        }

        .pagination-button {
            font-family: Barlow, sans-serif;
            padding: 8px 16px;
            background-color: #DF8A8A;
            border: none;
            cursor: pointer;
            margin: 0 5px; /* Khoảng cách giữa các button */
        }

        .pagination-button:hover {
            background-color: #6a4141;
        }

        .product-name,
        .product-description {
            text-align: left;
        }
        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px; /* Điều chỉnh độ rộng của sidebar theo mong muốn */
            height: 100%;
            background-color: #F9F2E6; /* Màu nền của sidebar */
        }
</style>

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
            <p>ADMIN / QUẢN LÝ SẢN PHẨM / SẢN PHẨM </p>
        </div>
        <?php
            include("SanPham.php");
        ?>
    </div>

    <div id="footer">
        <p>© 2024 Công Ty Cổ Phần Vàng Bạc Đá Quý Flamingo.</p>
    </div>

</body>
</html>