<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="Khung.css">    
    <style> 
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px; 
        }
        th, td {
            border: 1px solid black;
            text-align: center;
            padding: 5px 1px;
            font-size: 14px; 
            font-family: 'Barlow', sans-serif;
        }
        input[type="text"] {
            padding: 8px;
            margin-bottom: 10px;
            width: 200px;
        }
        button {
            font-family: Barlow, sans-serif; 
            padding: 8px 12px; /* Giảm kích thước button */
            background-color: #DF8A8A;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            margin-right: 5px; /* Giảm khoảng cách giữa các button */
        }
        button:hover {
            background-color: #6a4141;
        }
        #search {
            display: flex;
            justify-content: center; 
            align-items: center; 
            padding: 20px;
            margin-top: 50px; 
            text-align: center;
        }
        #search h3 {
            margin-right: 10px; 
        }
        input[type="text"] {
            flex: 1; 
            margin-right: 10px; 
            margin-top: 8px; 
        }
        #pagination {
            margin-top: 10px;
            text-align: center;
        }
        #table-container {
            margin-top: -50px; /* Đẩy bảng lên trên 20px */
        }
        /* CSS mới để cố định footer ở dưới trang */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            position: relative;
        }

        #footer {
            width: 100%;
            position: absolute;
            bottom: 0;
            left: 0;
            background-color: #FFE5EC; /* Màu nền của footer */
            padding-top: 5px; /* Khoảng cách từ chữ trong footer đến đỉnh của footer */
        }

        /* Thêm CSS cho dòng đầu tiên */
        th.pink-header {
            background-color: #FFC0CB; /* Màu hồng */
        }
    </style>
    <script>
        function searchData() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("reportTable");
            tr = table.getElementsByTagName("tr");
            
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td");
                for (var j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        }
    </script>
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
            <p>ADMIN / QUẢN LÝ SẢN PHẨM / BÁO CÁO BÁN HÀNG </p>
        </div>
        
        <div id="search">
            <h3>Tra cứu</h3>
            <input type="text" id="searchInput" placeholder="Nhập từ khóa...">
            <button onclick="searchData()">Tìm</button>
            <a href="Overview_Chart.php"><button>Thống kê</button></a>
        </div>
        <div id="table-container">
        <?php
        //Tạo kết nối vào CSDL
        require_once("db_module.php");

        function view_BaoCao()
        {
            $link = null;
            taoKetNoi($link);
            $rows_per_page = 12;
            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
            $start_from = ($current_page - 1) * $rows_per_page;
            $result = chayTruyVanTraVeDL($link, "SELECT fr.DateID, fr.reportID, fr.orderID, fr.revenue, fr.cost, fr.discountAmount, fr.profit, fr.totalOrders, e.name 
                                        FROM financialreport fr
                                        INNER JOIN employee e ON fr.employeeID = e.employeeID
                                        LIMIT $start_from, $rows_per_page");
            echo "<table id='reportTable'>";
            echo "<tr>";
            echo "<th class='pink-header'>Ngày bán hàng</th>"; 
            echo "<th class='pink-header'>ID</th>"; 
            echo "<th class='pink-header'>Đơn hàng</th>"; 
            echo "<th class='pink-header'>Doanh thu</th>"; 
            echo "<th class='pink-header'>Chi phí</th>"; 
            echo "<th class='pink-header'>Giảm giá</th>"; 
            echo "<th class='pink-header'>Lợi nhuận</th>"; 
            echo "<th class='pink-header'>Tổng đơn hàng</th>";
            echo "<th class='pink-header'>Nhân viên bán hàng</th>"; 
            echo "</tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                $formatted_date = date_create_from_format('Ymd', $row["DateID"]);
                if ($formatted_date !== false) {
                    echo "<td>" . date_format($formatted_date, 'd-m-Y') . "</td>";
                } else {
                    echo "<td>" . $row["DateID"] . "</td>";
                }
                echo "<td>" . $row["reportID"] . "</td>";
                echo "<td>" . $row["orderID"] . "</td>";
                echo "<td>" . number_format($row["revenue"], 0, ',', '.') . "</td>";
                echo "<td>" . number_format($row["cost"], 0, ',', '.') . "</td>";
                echo "<td>" . number_format($row["discountAmount"], 0, ',', '.') . "</td>";
                echo "<td>" . number_format($row["profit"], 0, ',', '.') . "</td>";
                echo "<td>" . $row["totalOrders"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "</tr>";
            }                           
            echo "</table>";

            echo "<div id='pagination'>";
            $total_rows = mysqli_num_rows(chayTruyVanTraVeDL($link, "SELECT * FROM financialreport"));
            $total_pages = ceil($total_rows / $rows_per_page);
            if ($current_page > 1) {
                echo "<a href='?page=".($current_page - 1)."'><button><</button></a>";
            }
        
            if ($current_page < $total_pages) {
                echo "<a href='?page=".($current_page + 1)."'><button>></button></a>";
            }
            
            giaiPhongBoNho($link, $result);
        }
        if (isset($_GET["opt"])) {
            $_opt = $_GET["opt"];
        } else {
           
            $_opt = ""; 
        }
        switch ($_opt) {
            case "view_BaoCao":
                view_BaoCao();
                break;
            default:
                view_BaoCao();
        }
        ?>
    </div>

    <div id="footer">
        <p>© 2024 Công Ty Cổ Phần Vàng Bạc Đá Quý Flamingo.</p>
    </div>

</body>
</html>
