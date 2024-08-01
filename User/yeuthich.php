<?php
require_once "config.php";
require_once "db_module.php";

// Kết nối database
$link = null;
taoKetNoi($link);
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Nếu phương thức yêu cầu là POST, người dùng đang thêm sản phẩm vào danh sách yêu thích
    if (!empty($_POST['idofpro'])) {
        $productID = $_POST['idofpro'];
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            // Truy vấn SQL để kiểm tra xem sản phẩm đã có trong danh sách yêu thích của người dùng chưa
            $query = "SELECT * FROM favProduct WHERE productID = '$productID' AND accountID = (
                        SELECT accountID FROM UserAccount WHERE username = '$username'
                      )";
            $result = mysqli_query($link, $query);
            
            if ($result && mysqli_num_rows($result) > 0) {
                // Sản phẩm đã có trong danh sách yêu thích của người dùng, loại bỏ khỏi danh sách
                $sql = "DELETE FROM favProduct WHERE productID = '$productID' AND accountID = (
                            SELECT accountID FROM UserAccount WHERE username = '$username'
                        )";
                $result = chayTruyVanKhongTraVeDL($link, $sql);
                if ($result) {
                    echo "removed";
                } else {
                    echo "error";
                }
            } else {
                // Thêm sản phẩm vào danh sách yêu thích của người dùng
                $sql = "INSERT INTO favProduct (productID, accountID) VALUES ('$productID', (
                            SELECT accountID FROM UserAccount WHERE username = '$username'
                        ))";
                $result = chayTruyVanKhongTraVeDL($link, $sql);
                if ($result) {
                    echo "added";
                } else {
                    echo "error";
                }
            }
        }
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    // Nếu phương thức yêu cầu là DELETE, người dùng đang xoá sản phẩm khỏi danh sách yêu thích
    parse_str(file_get_contents("php://input"), $_DELETE);
    if (!empty($_DELETE['idofpro'])) {
        $productID = $_DELETE['idofpro'];
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            // Truy vấn để xóa dữ liệu khỏi database
            $sql = "DELETE FROM favProduct WHERE productID = '$productID' AND accountID = (
                        SELECT accountID FROM UserAccount WHERE username = '$username'
                    )";
            $result = chayTruyVanKhongTraVeDL($link, $sql);
            if ($result) {
                echo "removed";
            } else {
                echo "error";
            }
        }
    }
}

// Giải phóng kết quả và đóng kết nối
giaiPhongBoNho($link, $result);
?>
