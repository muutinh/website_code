<html>
<head>
    <link rel="stylesheet" type="text/css" href="Khung.css">    
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: -10px;
        }
        th, td {
            border: 1px solid black;
            text-align: center;
            padding: 12px 1px;
            font-size: 13px;
        }
        input[type="text"] {
            padding: 8px;
            margin-bottom: 10px;
            width: 200px;
        }

        button {
            font-family: Barlow, sans-serif;
            padding: 8px 16px;
            background-color: #DF8A8A;
            border: none;
            cursor: pointer;
            margin-right: 10px;
            border-radius: 7px;
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
            margin-top: 20px;
            text-align: center;
        }
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            position: relative;
        }

        #footer {
            font-size: 11px;
            width: 100%;
            position: absolute;
            bottom: 0;
            left: 0;
            background-color: #FFE5EC; /* Màu nền của footer */
            padding-top: 5px; /* Khoảng cách từ chữ trong footer đến đỉnh của footer */
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
            <p>ADMIN / OVERVIEW / SỔ GIAO HÀNG</p>
        </div>
    
        <script>
            function searchDeliveryBook() {
                var keyword = document.getElementById("searchInput").value.trim();
                window.location.href = '?keyword=' + encodeURIComponent(keyword);
            }
        </script>
        <div id="search">
            <h3>Tra cứu</h3>
            <input type="text" id="searchInput" placeholder="Nhập từ khóa...">
            <button onclick="searchDeliveryBook()">Tìm</button>
        </div>

<?php
// Kết nối vào CSDL
require_once("db_module.php");
function show_delivery_book($page = 1, $rows_per_page = 7) {
    $link = null;
    taoKetNoi($link);
    $offset = ($page - 1) * $rows_per_page;
    $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
    $search_condition = '';
    if (!empty($keyword)) {
        $search_condition = "WHERE DATE_FORMAT(O.DateID, '%d-%m-%Y') LIKE '%$keyword%' OR O.orderID LIKE '%$keyword%' OR O.status LIKE '%$keyword%' OR CONCAT(C.lastName, ' ', C.firstName) LIKE '%$keyword%'";
    }
    // Truy vấn CSDL để lấy dữ liệu từ bảng Orders với LIMIT và OFFSET
    $result = chayTruyVanTraVeDL($link, "SELECT DATE_FORMAT(O.DateID, '%d-%m-%Y') AS formattedDate, O.orderID, O.status, CONCAT(C.lastName, ' ', C.firstName) AS customerName FROM Orders O LEFT JOIN Customer C ON O.customerID = C.customerID $search_condition LIMIT $offset, $rows_per_page");
    // Bắt đầu hiển thị bảng
    echo "<table>";
    echo "<thead>";
    echo "<tr style='background-color: pink'>";
    echo "<th>Ngày</th>";
    echo "<th>Số hóa đơn</th>";
    echo "<th>Trạng thái HD</th>";
    echo "<th>Khách hàng</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["formattedDate"] . "</td>"; 
        echo "<td>" . $row["orderID"] . "</td>";
        echo "<td>" . $row["status"] . "</td>";
        echo "<td>" . $row["customerName"] . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    // Giải phóng bộ nhớ và đóng kết nối
    giaiPhongBoNho($link, $result);
}
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
show_delivery_book($current_page);
?>

    <div id="pagination">
        <?php
        // Số lượng hàng dữ liệu
        $total_rows = 100; // Giả sử có 100 hàng dữ liệu

        // Số trang
        $total_pages = ceil($total_rows / 6); // Số trang là tổng số hàng dữ liệu chia cho số hàng trên mỗi trang

        // Hiển thị nút chuyển trang
    if ($current_page > 1) {
        echo "<a href='?page=".($current_page - 1)."'><button><</button></a>"; // Nút chuyển đến trang trước đó
    }

    if ($current_page < $total_pages) {
        echo "<a href='?page=".($current_page + 1)."'><button>></button></a>"; // Nút chuyển đến trang tiếp theo
    }
    
    ?>
    </div>

    <div id="footer">
        <p>© 2024 Công Ty Cổ Phần Vàng Bạc Đá Quý Flamingo.</p>
    </div>
</body>
</html>
