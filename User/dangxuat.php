<?php
session_start();
require_once "db_module.php";
require_once "users_module.php";

$link = NULL;
taoKetNoi($link);

if (dangxuat()) {
    unset($_SESSION['username']);
    unset($_SESSION['customerID']);
    unset($_SESSION['accountID']); // Xóa thông tin về tên người dùng khỏi session
    giaiPhongBoNho($link, true);
    header("Location: index.php");
    exit();
} else {
    giaiPhongBoNho($link, true);
    header("Content-type: text/html; charset=utf8");
    echo "Không thể đăng xuất!";
}
?>