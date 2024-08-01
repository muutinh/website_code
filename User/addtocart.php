<?php
    session_start();
    ob_start();
    // Khởi tạo giỏ hàng nếu chưa tồn tại
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if (isset($_POST['addtocart']) && $_POST['addtocart']) {
    $id = $_POST['idofpro']; // ID của sản phẩm
    $hinh = $_POST['img']; // Đường dẫn đến hình ảnh
    $tensp = $_POST['tensp']; // Tên sản phẩm
    $sl = (int)$_POST['soluong']; // Số lượng
    $totalCash = (int)$_POST['tongtien']; // Tổng tiền

    // Kiểm tra sản phẩm đã tồn tại trong giỏ hàng hay chưa
    $product_exists = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item[0] == $id) {
            // Nếu sản phẩm đã tồn tại trong giỏ hàng, cập nhật số lượng
            if($sl != 0) {
                $item[3] += $sl;
                $product_exists = true;
                break;
            } else {
                $sl = 1;
                $item[3] += $sl;
                $product_exists = true;
                break;            
            }

        }
    }

    // Nếu sản phẩm chưa tồn tại trong giỏ hàng, thêm mới
    if (!$product_exists) {
        if ($sl == 0) {
            $sl = 1; // Đảm bảo số lượng ít nhất là 1
            
        }
        $sp = array($id, $hinh, $tensp, $sl, $totalCash);
        array_push($_SESSION['cart'], $sp);
    }
    header('Location: viewcart.php');
}

?>