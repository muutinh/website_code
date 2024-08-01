<?php
require_once "config.php";
require_once "db_module.php";

session_start();

if (isset($_GET['idofpro'])) {
    $productID = $_GET['idofpro'];

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        // Truy vấn để kiểm tra productID và accountID tồn tại trong bảng favProduct?
        $query = "SELECT * FROM favProduct WHERE productID = '$productID' AND accountID = (
                    SELECT accountID FROM UserAccount WHERE username = '$username'
                  )";
        $result = mysqli_query($link, $query);

        if ($result) {
            // Nếu đã tồn tại 
            if (mysqli_num_rows($result) > 0) {
                echo 'exists';
            } else {
                // Nếu chưa tồn tại
                echo 'not_exists';
            }
        } else {
            echo 'error';
        }
    } else {
        echo 'not_logged_in';
    }
} else {
    echo 'missing_product_id';
}

mysqli_close($link);
?>