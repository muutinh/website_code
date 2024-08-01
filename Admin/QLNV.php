
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="Khung.css">    
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px; /* Điều chỉnh độ rộng của sidebar theo mong muốn */
            height: 100%;
            background-color: #F9F2E6; /* Màu nền của sidebar */
        }
        /* Thêm CSS cho dòng đầu tiên */
        .pink-row th {
            background-color: #FFC0CB; /* Màu hồng */
        }
        .pagination {
            text-align: center;
        }
        
    </style>
        <script>
            function ConfirmDel() {
                var confirmed = confirm("Bạn chắc chắn muốn xóa không?");
                if (confirmed) {
                    // Thực hiện hành động xóa nếu người dùng chọn OK
                    // Ví dụ: gọi hàm xóa hoặc gửi yêu cầu xóa tới server
                    console.log("Đã xóa");
                }
            }
        </script>
    </head>

    <body>
        <div id="container">
            <div id="sidebar">
                <h2><img src="Picture/Logo.png" alt="Logo"></h2>
                <ul>
                    <li><a href="Overview.php">Overview</a></li>
                    <li><a href="QLSP.php">Quản lý sản phẩm</a></li>
                    <li><a href="QLNV.php">Quản lý nhân viên</li></a>
                    <li><a href="QLDH.php">Quản lý đơn hàng</li></a>
                </ul>
            </div>
        
            <div id="header">
                <h2>ADMIN / QUẢN LÝ NHÂN VIÊN</h2> 
            </div id="content">
                <?php include "NhanVien.php"; ?>
            </div>
            <div id="footer">
                <p>© 2024 Công Ty Cổ Phần Vàng Bạc Đá Quý Flamingo</p>
            </div>

        </div>
    </body>
</html>