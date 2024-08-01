<?php 
 $link = null; // Khởi tạo biến $link
 taoKetNoi($link); // Tạo kết nối đến cơ sở dữ liệu
 require_once "db_module.php";
function validateLenUP($up){
    return strlen($up) >=8&&strlen($up)<=30;
}

function existsUsername ($link, $username)
{ 
    $result = chayTruyVanTraVeDL ($link, "Select count(*) from useraccount where username ='".$username."'");
    $row = mysqli_fetch_row($result);
    mysqli_free_result ($result);
    return $row[0] >0;
}
function kiemTraMatKhau($password, $password2) {
    if ($password === $password2) {
        return true;
    } else {
        return false;
    }
}

?>


