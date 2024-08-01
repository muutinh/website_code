<head> 
    <link rel="stylesheet" type="text/css" href="form.css" />
    <script>
    function confirmDel() {
        if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này này?')) {
            return true;
        } else {
            return false;
        }
    }

    function hideToolBar() {
        document.getElementById("toolbar").style.display = "none";
    }


    function Search() {
        let valueSearchInput = document.getElementById("searchInput").value;
        window.location.href = '?opt=view_SP&search=' + encodeURIComponent(valueSearchInput);
    }
</script>

<div id="search">
    <input type="text" id="searchInput" placeholder="Nhập từ khóa...">
    <button onclick="Search()">Tìm sản phẩm</button>
    <a href="?opt=add_SP"><button>Thêm sản phẩm</button></a>   

</div>
</head>

<?php
// Kết nối vào CSDL
require_once ("db_module.php");

// Hàm hiển thị sản phẩm
function view_SP()
{
    $link = null;
    taoKetNoi($link);

    // Số lượng sản phẩm trên mỗi trang
    $rows_per_page = 3;

    // Trang hiện tại, mặc định là trang 1
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

    // Tính toán vị trí bắt đầu lấy dữ liệu từ CSDL
    $start_from = ($current_page - 1) * $rows_per_page;

    // Thực hiện truy vấn SQL để lấy số lượng sản phẩm trong CSDL
    $total_rows_query = chayTruyVanTraVeDL($link, "SELECT COUNT(*) AS total_rows FROM product");
    $total_rows_data = mysqli_fetch_assoc($total_rows_query);
    $total_rows = $total_rows_data['total_rows'];

    // Tính toán tổng số trang dựa trên số lượng sản phẩm và số sản phẩm trên mỗi trang
    $total_pages = ceil($total_rows / $rows_per_page);

    
    // Cập nhật câu truy vấn SQL để lấy dữ liệu từ vị trí bắt đầu mới này
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $query = "SELECT * FROM product WHERE 1";

    $search = isset($_GET['search']) ? $_GET['search'] : '';
    if (!empty($search)) {
        $query .= " AND (productID LIKE '%$search%' OR 
                          productName LIKE '%$search%' OR 
                          quantityAvailable LIKE '%$search%' OR 
                          description LIKE '%$search%' OR 
                          unitPrice LIKE '%$search%' OR 
                          status LIKE '%$search%' OR 
                          discountID LIKE '%$search%')";
    }
    $query .= " LIMIT $start_from, $rows_per_page";
    // Thực thi câu truy vấn SQL cập nhật
    $result = chayTruyVanTraVeDL($link, $query);

    echo "<table id='productTable' width='100%' border='1' style='margin-bottom: 2%;'>";
    echo "<tr class='pink-row'>"; 
    echo "<th>Mã sản phẩm</th>";
    echo "<th>Tên sản phẩm</th>";
    echo "<th>Số lượng</th>";
    echo "<th>Mô tả</th>";
    echo "<th>Giá sản phẩm</th>";
    echo "<th>Tình trạng</th>";
    echo "<th>Khuyến mãi</th>";
    echo "<th>Thao tác</th>";

    echo "</tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["productID"] . "</td>";
        echo "<td class='product-name'>" . $row["productName"] . "</td>"; 
        echo "<td>" . $row["quantityAvailable"] . "</td>";
        echo "<td class='product-description'>" . $row["description"] . "</td>"; 
        echo "<td>" . number_format($row["unitPrice"], 0, ',', '.') . "</td>";
        echo "<td>" . $row["status"] . "</td>";

        $discountID = $row["discountID"];
        $discountPercentage = ""; 

        
        if ($discountID === NULL) {
            $discountPercentage = "0%";
        } elseif ($discountID === "DC001") {
            $discountPercentage = "15%";
        } elseif ($discountID === "DC002") {
            $discountPercentage = "50%";
        } else 

        echo "<td>" . $discountPercentage . "</td>";
        echo "<td><a href='?opt=edit_SP&productID=" . $row["productID"] . "'><img src='Picture/Icon Sua.png' alt='Sửa' style='width: 20px; height: 20px;'></a>
                <a href='?opt=del_SP&productID=" . $row["productID"] . "' onclick='return confirmDel()'><img src='Picture/Icon Xoa.png' alt='Xóa' style='width: 20px; height: 20px;'></a></td>";
        echo "</tr>";
    }

    echo "</table>";
    giaiPhongBoNho($link, $result);

    // Hiển thị nút chuyển trang
        echo "<div class='pagination'>";
        if ($current_page > 1) {
            echo "<a href='?page=".($current_page - 1)."'><button class='pagination-button'><</button></a>"; // Nút chuyển đến trang trước đó
        }

        if ($current_page < $total_pages) {
            echo "<a href='?page=".($current_page + 1)."'><button class='pagination-button'>></button></a>"; // Nút chuyển đến trang tiếp theo
        }
        echo "</div>";
}
function add_SP()
{
    $link = null;
    taoKetNoi($link);
    $km = "SELECT discountID, discountAmount FROM discount";
    $result_km = chayTruyVanTraVeDL($link, $km);

    $sct = "SELECT subcategoryID , subcategoryName FROM subcategory";
    $result_sct = chayTruyVanTraVeDL($link, $sct);

    ?>
    <div class="form-container" id="ThemSP">
        <form action="?opt=add_SP" method="post" enctype="multipart/form-data">
            Mã sản phẩm: <input type="text" name="masp"
                value="<?php echo isset($_POST['masp']) ? htmlspecialchars($_POST['masp']) : ''; ?>">
            Tên sản phẩm: <input type="text" name="tensp"
                value="<?php echo isset($_POST['tensp']) ? htmlspecialchars($_POST['tensp']) : ''; ?>">
            Số lượng: <input type="number" name="soluong" min="1">
            Mô tả: <input type="text" name="mota"
                value="<?php echo isset($_POST['mota']) ? htmlspecialchars($_POST['mota']) : ''; ?>">
            Giá sản phẩm: <input type="number" name="giatien" min="0"
                value="<?php echo isset($_POST['giatien']) ? htmlspecialchars($_POST['giatien']) : ''; ?>">
            Phân loại phụ:
            <select name="subct">
                <?php
                if ($result_sct) {
                    while ($row = mysqli_fetch_assoc($result_sct)) {
                        echo "<option value='{$row['subcategoryID']}'>{$row['subcategoryName']}</option>";
                    }
                }
                ?>
            </select>
            Khuyến mãi:
            <select name="khuyenmai">
                <?php
                if ($result_km) {
                    while ($row = mysqli_fetch_assoc($result_km)) {
                        echo "<option value='{$row['discountID']}'>{$row['discountAmount']}</option>";
                    }
                }
                ?>
            </select>
            <div class="form-buttons">
                <input type="submit" value="Lưu">
                <input type="reset" value="Nhập lại">
                <button type="button" onclick="window.location.href='QLSP_XemSP.php?opt=view_NV';">Quay lại</button>
            </div>
        </form>
        <?php
        if (!empty($_POST)) {
            // Lấy và xử lý dữ liệu từ form
            $_masp = isset($_POST["masp"]) ? trim($_POST["masp"]) : '';
            $_tensp = isset($_POST["tensp"]) ? trim($_POST["tensp"]) : '';
            $_soluong = isset($_POST["soluong"]) ? trim($_POST["soluong"]) : '';
            $_mota = isset($_POST["mota"]) ? trim($_POST["mota"]) : '';
            $_giatien = isset($_POST["giatien"]) ? trim($_POST["giatien"]) : '';
            $_khuyenmai = isset($_POST["khuyenmai"]) ? trim($_POST["khuyenmai"]) : '';
            $_subct = isset($_POST["subct"]) ? trim($_POST["subct"]) : '';


            // Kiểm tra xem tất cả các trường đã được nhập chưa
            if (empty($_masp) || empty($_tensp) || empty($_soluong) || empty($_mota) || empty($_giatien) || empty($_khuyenmai)) {
                echo "<script>alert('Vui lòng nhập đầy đủ thông tin.');</script>";
                return; // Dừng xử lý nếu có trường nào đó bỏ trống
            }

            $_status = intval($_soluong) > 0 ? "Còn hàng" : "Hết hàng";
            $sql = "INSERT INTO product(productName, productID, description, unitPrice, quantityAvailable, status, discountID, subcategoryID)
        VALUES ('$_tensp', '$_masp', '$_mota', '$_giatien', '$_soluong', '$_status', '$_khuyenmai', '$_subct')";


            $rs = chayTruyVanKhongTraVeDL($link, $sql);

            if ($rs) {
                echo "<script>alert('Thêm sản phẩm thành công');</script>";
                echo "<script>window.location.href='QLSP_XemSP.php?opt=add_NV';</script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra, không thể thêm sản phẩm');</script>";
                return;
            }

        }

}

function edit_SP()
{
    $link = null;
    taoKetNoi($link);

    $km = "SELECT discountID, discountAmount FROM discount";
    $result_km = chayTruyVanTraVeDL($link, $km);

    $sct = "SELECT subcategoryID , subcategoryName FROM subcategory";
    $result_sct = chayTruyVanTraVeDL($link, $sct);

    if (isset($_GET["productID"])) {
        $_productID = $_GET["productID"];

        $sql = "SELECT * FROM product WHERE productID='" . $_productID . "'";

        $result = chayTruyVanTraVeDL($link, $sql);
        //Lấy dữ liệu từ trong db ra
        if ($row = mysqli_fetch_assoc($result)) {
            ?>
                <div class="form-container">
                    <form name="formSP" action="?opt=update_SP" method="post" enctype="multipart/form-data">
                        Mã sản phẩm: <input type="text" name="masp" readonly value="<?php echo $row["productID"]; ?>"><br>
                        Tên sản phẩm: <input type="text" name="tensp" value="<?php echo $row["productName"]; ?>"><br>
                        Số lượng: <input type="number" name="soluong" min="1" value="<?php echo $row["quantityAvailable"]; ?>"><br>
                        Mô tả: <input type="text" name="mota" value="<?php echo $row["description"]; ?>"><br>
                        Giá sản phẩm: <input type="number" name="giatien" min="0" value="<?php echo $row["unitPrice"]; ?>"><br>
                        Phân loại:
                        <select name="subct">
                            <?php
                            if ($result_sct) {
                                while ($row_sct = mysqli_fetch_assoc($result_sct)) {
                                    $selected = $row_sct['subcategoryID'] == $row['subcategoryID'] ? 'selected' : '';
                                    echo "<option value='{$row_sct['subcategoryID']}' $selected>{$row_sct['subcategoryName']}</option>";
                                }
                            }
                            ?>
                        </select>
                        Khuyến mãi:
                        <select name="khuyenmai">
                            <?php
                            if ($result_km) {
                                while ($row_km = mysqli_fetch_assoc($result_km)) {
                                    $selected = $row_km['discountID'] == $row['discountID'] ? 'selected' : '';
                                    echo "<option value='{$row_km['discountID']}' $selected>{$row_km['discountAmount']}</option>";
                                }
                            }
                            ?>
                        </select>
                        <div class="form-buttons"> 
                            <input type="submit" value="Lưu">
                            <input type="reset" value="Nhập lại">
                            <button type="button" onclick="window.location.href='QLSP_XemSP.php?opt=view_SP';">Quay lại</button>
                        </div>
                    </form>
                </div>
                <?php
        }
    }
}

function update_SP()
{
    $link = null;
    taoKetNoi($link);


    //Kiểm tra có phương thức POST gửi lên hay không
    if (isset($_POST)) {
        $_masp = $_POST["masp"];
        $_tensp = $_POST["tensp"];
        $_soluong = $_POST["soluong"];
        $_mota = $_POST["mota"];
        $_gia = $_POST["giatien"];
        $_subct = $_POST["subct"];
        $_km = $_POST["khuyenmai"];


        $sql = "UPDATE product SET productName = '$_tensp', quantityAvailable = '$_soluong', description = '$_mota',
             unitPrice = '$_gia',subcategoryID='$_subct' ,discountID = '$_km' WHERE productID = '$_masp' ";

        //echo $sql;
        if ($_masp != "") {
            $rs = chayTruyVanKhongTraVeDL($link, $sql);
            //Kiểm tra insert
            if ($rs) {
                echo "<script>alert('Cập nhật thành công');</script>";
                echo "<script>window.location.href='QLSP_XemSP.php?opt=view_SP';</script>";
            } else {
                echo "<script>alert('Cập nhật thất bại');</script>";
                echo "<script>window.location.href='QLSP_XemSP.php?opt=view_SP';</script>";
            }
        }

    }
    giaiPhongBoNho($link, $rs);
}

function del_SP()
{
    $link = null;
    taoKetNoi($link);

    if (isset($_GET["productID"])) {
        $_productid = $_GET["productID"];

        $sqlReviews = "DELETE FROM review WHERE productID = '$_productid'";
        $resultReviews = chayTruyVanKhongTraVeDL($link, $sqlReviews);

        // Then, delete the product
        $sqlProduct = "DELETE FROM product WHERE productID = '$_productid'";
        $resultProduct = chayTruyVanKhongTraVeDL($link, $sqlProduct);

        if ($resultProduct) {
            echo "<script>alert('Xóa thành công');</script>";
            echo "<script>window.location.href='QLSP_XemSP.php?opt=view_SP';</script>";
        } else {
            echo "<script>alert('Xóa thất bại');</script>";
            echo "<script>window.location.href='QLSP_XemSP.php?opt=view_SP';</script>";
        }
    }
}

if (isset($_GET["opt"])) {
    $_opt = $_GET["opt"];
} else {
    $_opt = "";
}

switch ($_opt) {
    case "add_SP":
        add_SP();
        break;
    case "edit_SP":
        edit_SP();
        break;
    case "del_SP":
        del_SP();
        break;
    case "update_SP":
        update_SP();
        break;
    default:
        view_SP();
}
?>