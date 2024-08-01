<head>
    <link rel="stylesheet" type="text/css" href="form.css" />
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            /* Loại bỏ khoảng cách giữa các border của cell */
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
        .pink-row th {
            background-color: #FFC0CB; /* Màu hồng */
        }
        .form-container{
            margin-top: 10%;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: 200px;
            justify-content: flex-start;
            
        }

        .form-group label {
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select,
        .form-group button {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            /* Đảm bảo padding không làm thay đổi kích thước tổng thể */
        }
        #toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            margin-top: 70px;

        }
        #toolbar button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;

        }

        #toolbar button:hover {
            background-color: #0056b3;
        }
        
    </style>
    <script type=text/JavaScript>

    function hideToolBar() {
    document.getElementById("toolbar").style.display = "none";
    }

    function Search() {
    let valueSearchInput = document.getElementById("searchInput").value;
    let ptttSearch = document.getElementById("ptttSearch").value;
    let statusSearch = document.getElementById("statusSearch").value;
    let fromDate = document.getElementById("fromDate").value;
    let toDate = document.getElementById("toDate").value;

    window.location.href = '?opt=view_DH&search=' + encodeURIComponent(valueSearchInput) +
        '&pttt=' + encodeURIComponent(ptttSearch) +
        '&status=' + encodeURIComponent(statusSearch) +
        '&fromDate=' + encodeURIComponent(fromDate) +
        '&toDate=' + encodeURIComponent(toDate);
}

    function ValidateForm() {

        var orderID = document.formDH.orderID.value;
        var makh = document.formDH.makh.value;
        var sodienthoai = document.formDH.sodienthoai.value;
        var tensp = document.formDH.tensp.value;
        var soluong = document.formDH.soluong.value;
        var diachi = document.formDH.diachi.value;

        if (orderID.trim() == "") {
            alert("Mã đơn hàng không được để trống.");
            return false;
        }


        if (makh.trim() == "") {
            alert("Mã khách hàng không được để trống.");
            return false;
        }

        if (sodienthoai == "" || !sodienthoai.match(/^0[0-9]{9}$/)) {
            alert("Số điện thoại không hợp lệ. Số điện thoại phải là 10 chữ số và bắt đầu bằng số 0.");
            return false;
        }

        if (tensp.trim() == "") {
            alert("Tên sản phẩm không được để trống.");
            return false;
        }

        if (soluong <= 0 || !Number.isInteger(Number(soluong))) {
            alert("Số lượng phải là một số nguyên dương.");
            return false;
        }

        if (diachi.trim() == "") {
            alert("Địa chỉ không được để trống.");
            return false;
        }

        return true;
    }

</script>
</head>

<body>
    <div id="content">
        <div id="toolbar">
            <!-- Nhóm input tìm kiếm -->
            <div class="form-group">
                <label for="searchInput">Nhập thông tin</label>
                <input id="searchInput" type="text" placeholder="Nhập thông tin" />
            </div>

            <!-- Nhóm chọn tình trạng đơn -->
            <div class="form-group">
                <label for="statusSearch">Tình trạng đơn</label>
                <select id="statusSearch">
                    <option value="">Chọn tình trạng đơn</option> <!-- Tùy chọn mặc định -->
                    <option value="Đã xác nhận">Đã xác nhận</option>
                    <option value="Đang xử lý">Đang xử lý</option>
                    <option value="Đã hoàn tất">Đã hoàn tất</option>
                    <option value="Huỷ bỏ">Huỷ bỏ</option>
                </select>
            </div>

            <!-- Nhóm nhập từ ngày -->
            <div class="form-group">
                <label for="fromDate">Từ ngày</label>
                <input id="fromDate" type="date">
            </div>

            <!-- Nhóm nhập đến ngày -->
            <div class="form-group">
                <label for="toDate">Đến ngày</label>
                <input id="toDate" type="date">
            </div>
            
            <!-- Nhóm chọn phương thức thanh toán -->
            <div class="form-group">
                <label for="ptttSearch">PT thanh toán</label>
                <select id="ptttSearch">
                    <option value="">Chọn phương thức thanh toán</option> <!-- Tùy chọn mặc định -->
                    <option value="Tiền mặt">Tiền mặt</option>
                    <option value="Momo">Momo</option>
                    <option value="Mobile Banking">Mobile Banking</option>
                </select>
            </div>
            <!-- Nhóm nút tìm kiếm -->
            <div class="form-group">
                <button onclick="Search()" style="padding: 10px;margin-top: 13%; background-color: #DF8A8A;color:black;">Tìm kiếm</button>
            </div>
        </div>


        <?php
        require_once ("db_module.php");
        function view_DH()
        {
            $link = null;
            taoKetNoi($link);
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $pttt = isset($_GET['pttt']) ? $_GET['pttt'] : '';
            $status = isset($_GET['status']) ? $_GET['status'] : '';
            $fromDate = isset($_GET['fromDate']) ? $_GET['fromDate'] : '';
            $toDate = isset($_GET['toDate']) ? $_GET['toDate'] : '';

            $sql = "SELECT c.customerID, c.phone, pd.productName, pd.color, pd.size, ot.quantity, o.totalAmount, o.paymentMethod,o.status,l.address, d.FullDateVN,d.Date, o.orderID, l.locationID, ot.detailsID
                FROM orders o JOIN customer c ON o.customerID = c.customerID JOIN date d on o.DateID = d.DateID JOIN orderdetail ot ON ot.orderID = o.orderID JOIN product pd ON pd.productID = ot.productID JOIN location l ON l.locationID = c.locationID WHERE 1";

            // Thêm điều kiện tìm kiếm dựa trên các bộ lọc
            if (!empty($search)) {
                $sql .= " AND (c.customerID LIKE '%$search%' OR pd.productName LIKE '%$search%' OR  o.orderID LIKE '%$search%' OR c.phone LIKE '%$search%' OR pd.color LIKE '%$search%' OR pd.size LIKE '%$search%' OR ot.quantity LIKE '%$search%' OR l.address LIKE '%$search%'  )";
            }
            if (!empty($pttt)) {
                $sql .= " AND o.paymentMethod = '$pttt'";
            }
            if (!empty($status)) {
                $sql .= " AND o.status = '$status'";
            }
            if (!empty($fromDate)) {
                $sql .= " AND d.Date >= '$fromDate'";
            }
            if (!empty($toDate)) {
                $sql .= " AND d.Date <= '$toDate'";
            }

            // Thực hiện truy vấn và hiển thị kết quả
            $result = chayTruyVanTraVeDL($link, $sql);

            echo "<table width='100%' cellspacing='5' cellpadding='5' border='1' style='margin-bottom: 3%;margin-top: 2%' >";
            echo "<tr class='pink-row'>"; 
            echo "<th>Mã đơn</th>";
            echo "<th>Khách hàng</th>";
            echo "<th>SDT</th>";
            echo "<th>Tên sản phẩm</th>";
            echo "<th>Màu</th>";
            echo "<th>Size</th>";
            echo "<th>Số lượng</th>";
            echo "<th>PTTT</th>";
            echo "<th>Tình trạng</th>";
            echo "<th>Địa chỉ</th>";
            echo "<th>Ngày đặt</th>";
            echo "<th>Thao tác</th>";
            echo "</tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td style='max-width:10%'>" . $row["orderID"] . "</td>";
                echo "<td style='max-width:10%'>" . $row["customerID"] . "</td>";
                echo "<td style='max-width:5%'>" . $row["phone"] . "</td>";
                echo "<td style='max-width:200px'>" . $row["productName"] . "</td>";
                echo "<td style='max-width:5%'>" . $row["color"] . "</td>";
                echo "<td style='max-width:150px'>" . $row["size"] . "</td>";
                echo "<td style='max-width:5%'>" . $row["quantity"] . "</td>";
                echo "<td style='max-width:10%'>" . $row["paymentMethod"] . "</td>";
                echo "<td style='max-width:10%'>" . $row["status"] . "</td>";
                echo "<td style='max-width:10%'>" . $row["address"] . "</td>";
                echo "<td style='max-width:10%'>" . $row["FullDateVN"] . "</td>";
                echo "<td><a href='?opt=edit_DH&customerID=" . $row["customerID"] . "&orderID=" . $row["orderID"] . "&locationID=" . $row["locationID"] . "&detailsID=" . $row["detailsID"] . "'><img src='Picture/Group 17.png' alt='Sửa' style='width: 20px; height: 20px;'></a></td>";
                echo "</tr>";
            }
            echo "</table>";
            giaiPhongBoNho($link, $result);
        }

        function edit_DH()
        {
            $link = null;
            taoKetNoi($link);
            if (isset($_GET["customerID"], $_GET["orderID"], $_GET["locationID"], $_GET["detailsID"])) {
                $customerID = $_GET["customerID"];
                $orderID = $_GET["orderID"];
                $locationID = $_GET["locationID"];
                $detailsID = $_GET["detailsID"];

                $sql = "SELECT c.customerID, c.phone, pd.productName, pd.color, pd.size, ot.quantity, o.totalAmount, o.paymentMethod, o.status, l.address, d.FullDateVN, o.orderID, l.locationID, ot.detailsID,pd.unitPrice
                    FROM orders o 
                    JOIN customer c ON o.customerID = c.customerID 
                    JOIN date d ON o.DateID = d.DateID 
                    JOIN orderdetail ot ON ot.orderID = o.orderID 
                    JOIN product pd ON pd.productID = ot.productID 
                    JOIN location l ON l.locationID = c.locationID
                    WHERE o.orderID = '" . $orderID . "' 
                    AND c.customerID = '" . $customerID . "' 
                    AND l.locationID = '" . $locationID . "' 
                    AND ot.detailsID = '" . $detailsID . "'";


                $result = chayTruyVanTraVeDL($link, $sql);
                //Lấy dữ liệu từ trong db ra
                if ($row = mysqli_fetch_assoc($result)) {
                    ?>
        <div class="form-container">
            <form name="formDH" action="?opt=update_DH" method="post" enctype="multipart/form-data"
                onsubmit="return ValidateForm()">
                Mã đơn hàng: <input type="text" name="orderID" readonly value="<?php echo $row["orderID"]; ?>"><br>
                Mã khách hàng: <input type="text" name="makh" readonly value="<?php echo $row["customerID"]; ?>"><br>
                Số điện thoại: <input type="text" name="sodienthoai" value="<?php echo $row["phone"]; ?>"><br>
                Tên sản phẩm: <input type="text" name="tensp" value="<?php echo $row["productName"]; ?>"><br>
                Số lượng: <input type="number" name="soluong" value="<?php echo $row["quantity"]; ?>" min="1">
                Phương thức thanh toán: <select name="pttt">
                    <option value="Tiền mặt" <?php echo ($row["paymentMethod"] == "Tiền mặt" ? "selected" : ""); ?>>
                        Tiền mặt
                    </option>
                    <option value="Momo" <?php echo ($row["paymentMethod"] == "Momo" ? "selected" : ""); ?>>Momo
                    </option>
                    <option value="Mobile Banking" <?php echo ($row["paymentMethod"] == "Mobile Banking" ? "selected" : ""); ?>>Mobile Banking</option>
                </select><br>
                Tình trạng: <select name="status">
                    <option value="Đã xác nhận" <?php echo ($row["status"] == "Đã xác nhận" ? "selected" : ""); ?>>Đã xác
                        nhận</option>
                    <option value="Đang xử lý" <?php echo ($row["status"] == "Đang xử lý" ? "selected" : ""); ?>>Đang xử
                        lý</option>
                    <option value="Đã hoàn tất" <?php echo ($row["status"] == "Đã hoàn tất" ? "selected" : ""); ?>>Đã hoàn
                        tất</option>
                    <option value="Huỷ bỏ" <?php echo ($row["status"] == "Huỷ bỏ" ? "selected" : ""); ?>>Huỷ bỏ</option>
                </select><br>
                Địa chỉ: <input type="text" name="diachi" value="<?php echo $row["address"]; ?>"><br>
                <input type="hidden" name="detailsID" value="<?php echo $row['detailsID']; ?>">

                <div class="form-buttons">
                    <input type="submit" value="Cập nhật">
                    <input type="reset" value="Nhập lại">
                    <button type="button" onclick="window.location.href='QLDH.php?opt=view_DH';">Quay lại</button>
                            </div>
                        </form>
                    </div>
                    <?php
                }
            }
        }

        function update_DH()
        {
            $link = null;
            taoKetNoi($link);

            if (isset($_POST)) {
                $_orderID = $_POST["orderID"];
                $_makh = $_POST["makh"];
                $_sodienthoai = $_POST["sodienthoai"];
                $_soluong = $_POST["soluong"];
                $_pttt = $_POST["pttt"];
                $_diachi = $_POST["diachi"];
                $_detailsID = $_POST["detailsID"];
                $_status = $_POST["status"];

                $sqlCustomer = "UPDATE customer SET phone = '$_sodienthoai' WHERE customerID = '$_makh'";
                $sqlLocation = "UPDATE location SET address = '$_diachi' WHERE locationID = (SELECT locationID FROM customer WHERE customerID = '$_makh')";
                $sqlOrder = "UPDATE orders SET paymentMethod = '$_pttt', `status` = '$_status' WHERE orderID = '$_orderID'";
                $sqlOrderDetail = "UPDATE orderdetail SET quantity = '$_soluong' WHERE detailsID = '$_detailsID' AND orderID = '$_orderID'";

                $rsCustomer = chayTruyVanKhongTraVeDL($link, $sqlCustomer);
                $rsLocation = chayTruyVanKhongTraVeDL($link, $sqlLocation);
                $rsOrder = chayTruyVanKhongTraVeDL($link, $sqlOrder);
                $rsOrderDetail = chayTruyVanKhongTraVeDL($link, $sqlOrderDetail);


                if ($rsCustomer && $rsLocation && $rsOrder && $rsOrderDetail) {
                    echo "<script>alert('Cập nhật đơn hàng thành công');</script>";
                    echo "<script>window.location.href='QLDH.php?opt=view_DH';</script>";
                } else {
                    echo "<script>alert('Cập nhật đơn hàng thất bại');</script>";
                    echo "<script>window.location.href='QLDH.php?opt=view_DH';</script>";
                }
            }
        }



        if (isset($_GET["opt"])) {
            $_opt = $_GET["opt"];
        } else {
            $_opt = "";
        }
        switch ($_opt) {
            case "edit_DH":
                edit_DH();
                break;
            case "update_DH":
                update_DH();
                break;
            default:
                view_DH();
        }

        if (in_array($_opt, ["edit_DH"])) {
            echo "<script>hideToolBar();</script>";
        }
        ?>

    </div>
</body>