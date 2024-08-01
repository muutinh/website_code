<?php
require_once("db_module.php");

// Kiểm tra xem có dữ liệu được gửi từ yêu cầu AJAX không
if (isset($_POST['tp'])) {
    $selectedCity = $_POST['tp'];

    // Kết nối đến cơ sở dữ liệu và truy vấn các quận tương ứng
    $link = null;
    taoKetNoi($link);

    $sql = "SELECT district FROM district 
            LEFT JOIN province ON province.provinceID = district.provinceID 
            WHERE province.province = '$selectedCity'";
    $result = chayTruyVanTraVeDL($link, $sql);

    // Xây dựng danh sách các quận để trả về
    $districtOptions = "";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $districtOptions .= "<option value='" . $row["district"] . "'>" . $row["district"] . "</option>";
        }
    } else {
        $districtOptions = "<option value='' disabled>Không có dữ liệu</option>";
    }

    // Trả về danh sách quận dưới dạng phản hồi AJAX
    echo $districtOptions;

    // Đóng kết nối
    dongKetNoi($link);
}
?>