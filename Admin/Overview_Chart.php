<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Khung.css">    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        #main-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            font-family: 'Barlow', sans-serif;
            margin-top:7px;
        }

        .chart-row1 {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            max-width: 100%;
        }

        .chart-container {
            width: 105%;
            margin-right: 53px; /* Add space between charts */
            margin-left: 43px; /* Add space between charts */

        }

        .chart-canvas {
            max-width: 100%;

        }

        .view-report-btn {
    padding: 8px 12px; /* Giảm kích thước button */
    background-color: #DF8A8A;
    border-radius: 7px;
    border: none;
    cursor: pointer;
    margin-right: 5px; /* Giảm khoảng cách giữa các button */
    position: absolute;
    top: 100px;
    right: 10px;
    font-family: 'Barlow', sans-serif;
}

.view-report-btn:hover {
    background-color: #6a4141;
}
#footer {
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
            <li>Quản lý nhân viên</li>
            <li>Quản lý đơn hàng</li>
        </ul>
    </div>

    <div id="content">
        <div id="header">
            <p>ADMIN / QUẢN LÝ SẢN PHẨM / THỐNG KÊ </p>
        </div>
        <button class="view-report-btn" onclick="window.location.href='Overview_Chart2.php';">Doanh thu</button>
        <div id="main-content">
            <h2>Thống kê doanh thu và đơn hàng năm 2022</h2>
            <?php
            require_once("db_module.php");
            $link = null;
            taoKetNoi($link);
            $result = chayTruyVanTraVeDL($link, "SELECT SUM(profit) AS total_profit FROM financialreport WHERE DateID BETWEEN '20220101' AND '20221231'");
            $row = mysqli_fetch_assoc($result);
            $totalProfit = $row['total_profit'];
            $result = chayTruyVanTraVeDL($link, "SELECT MONTH(DateID) AS month, SUM(totalOrders) AS total_orders FROM financialreport WHERE YEAR(DateID) = 2022 AND MONTH(DateID) >= 10 GROUP BY MONTH(DateID)");
            $orderSalesData = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $orderSalesData[$row['month']] = $row['total_orders'];
            }
            $result = chayTruyVanTraVeDL($link, "SELECT od.productID, SUM(od.quantity) AS total_quantity FROM orderdetail od INNER JOIN financialreport fr ON od.orderID = fr.orderID WHERE YEAR(fr.DateID) = 2022 AND MONTH(fr.DateID) >= 10 GROUP BY od.productID ORDER BY total_quantity DESC LIMIT 10");
            $productSalesData = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $productSalesData[$row['productID']] = $row['total_quantity'];
            }
            $result = chayTruyVanTraVeDL($link, "SELECT productID, COUNT(*) AS product_count FROM favproduct GROUP BY productID ORDER BY product_count DESC LIMIT 10");
            $productPopularityData = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $productPopularityData[$row['productID']] = $row['product_count'];}
            ?>

            <div class="chart-row1">
                <div class="chart-container">
                    <canvas id="orderSalesChart" class="chart-canvas"></canvas>
                </div>
                <div class="chart-container">
                    <canvas id="topProductsChart" class="chart-canvas"></canvas>
                </div>
            </div>


            <div class="chart-row2">
                <div class="chart-container">
                    <canvas id="productPopularityChart" class="chart-canvas"></canvas>
                </div>
            </div>

                <div id="footer">
                    <p>© 2024 Công Ty Cổ Phần Vàng Bạc Đá Quý Flamingo.</p>
                </div>

                <script>
                    var ctxOrderSales = document.getElementById('orderSalesChart').getContext('2d');
                    var orderSalesChart = new Chart(ctxOrderSales, {
                        type: 'bar',
                        data: {
                            labels: ['Tháng 10', 'Tháng 11', 'Tháng 12'],
                            datasets: [{
                                label: 'Tổng đơn hàng đã bán',
                                data: [<?= isset($orderSalesData[10]) ? $orderSalesData[10] : 0; ?>, <?= isset($orderSalesData[11]) ? $orderSalesData[11] : 0; ?>, <?= isset($orderSalesData[12]) ? $orderSalesData[12] : 0; ?>],
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });

                    var ctxTopProducts = document.getElementById('topProductsChart').getContext('2d');
                    var topProductsChart = new Chart(ctxTopProducts, {
                        type: 'bar',
                        data: {
                            labels: [<?= "'" . implode("', '", array_keys($productSalesData)) . "'"; ?>],
                            datasets: [{
                                label: 'Sản phẩm bán chạy',
                                data: [<?= implode(', ', $productSalesData); ?>],
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });

                    var ctxProductPopularity = document.getElementById('productPopularityChart').getContext('2d');
                var productPopularityChart = new Chart(ctxProductPopularity, {
                    type: 'bar',
                    data: {
                        labels: [<?= "'" . implode("', '", array_keys($productPopularityData)) . "'"; ?>],
                        datasets: [{
                            label: 'Sản phẩm được yêu thích',
                            data: [<?= implode(', ', $productPopularityData); ?>],
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
    </script>
</body>
</html>
