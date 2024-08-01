
<?php

require_once ("db_module.php");
require_once ("users_module.php");


// Đảm bảo rằng customerID có trong session
if (!isset($_SESSION['customerID'])) {
  // Xử lý trường hợp không tìm thấy customerID, ví dụ chuyển hướng đến trang đăng nhập
  header('Location: dangnhap.php');
  exit();
}



function view_TTKH()
{
  global $customerID;
  $customerID = $_SESSION['customerID'];
  $link = null;
  taoKetNoi($link);

  $_sql = "SELECT CONCAT(customer.lastName, ' ', customer.firstName) AS customerName,
    customer.phone,
    customer.email,
    CASE
        WHEN customer.gender = 'F' THEN 'Nữ'
        WHEN customer.gender = 'M' THEN 'Nam'
        ELSE 'khác'
    END AS gender,
    customer.dateOfBirth,
    CONCAT(location.address, ', ', d.district, ', ', province.province) AS address
    FROM customer
    LEFT JOIN location ON customer.locationID = location.locationID
    LEFT JOIN district d ON location.districtID = d.districtID
    LEFT JOIN province ON d.provinceID = province.provinceID
    WHERE customerID = '" . $_SESSION['customerID'] . "'";

  $result = chayTruyVanTraVeDL($link, $_sql);

  echo "<table>";

  // Lấy một hàng dữ liệu từ kết quả truy vấn
  if ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td colspan='2' style='line-height: 2; font-family: Barlow, -apple-system, Roboto, Helvetica, sans-serif; white-space: nowrap;'>Tên đầy đủ</td>";
    echo "<td style='font-family: Barlow, -apple-system, Roboto, Helvetica, sans-serif; font-weight: bold; padding-left: 100px;'>" . $row["customerName"] . "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td colspan='2' style='line-height: 2; font-family: Barlow, -apple-system, Roboto, Helvetica, sans-serif; white-space: nowrap;'>Số điện thoại</td>";
    echo "<td style='font-family: Barlow, -apple-system, Roboto, Helvetica, sans-serif; font-weight: bold; padding-left: 100px;'>" . $row["phone"] . "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td colspan='2' style='line-height: 2; font-family: Barlow, -apple-system, Roboto, Helvetica, sans-serif; white-space: nowrap;'>Địa chỉ Email</span></td>";
    echo "<td style='font-family: Barlow, -apple-system, Roboto, Helvetica, sans-serif; font-weight: bold; padding-left: 100px;'>" . $row["email"] . "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td colspan='2' style='line-height: 2; font-family: Barlow, -apple-system, Roboto, Helvetica, sans-serif; white-space: nowrap;'>Giới tính</span></td>";
    echo "<td style='font-family: Barlow, -apple-system, Roboto, Helvetica, sans-serif; font-weight: bold; padding-left: 100px;'>" . $row["gender"] . "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td colspan='2' style='line-height: 2; font-family: Barlow, -apple-system, Roboto, Helvetica, sans-serif; white-space: nowrap;'>Ngày sinh</span></td>";
    echo "<td style='font-family: Barlow, -apple-system, Roboto, Helvetica, sans-serif; font-weight: bold; padding-left: 100px;'>" . $row["dateOfBirth"] . "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td colspan='2' style='line-height: 2; font-family: Barlow, -apple-system, Roboto, Helvetica, sans-serif; white-space: nowrap;'>Địa chỉ</span></td>";
    echo "<td colspan='2' style='font-family: Barlow, -apple-system, Roboto, Helvetica, sans-serif; font-weight: bold; padding-left: 100px;'>" . $row["address"] . "</td>";
    echo "</tr>";
  }

  echo "</table>";
  giaiPhongBoNho($link, $result);
}

function view_DC()
{global $customerID;
  $link = null;
  taoKetNoi($link);
  $result = chayTruyVanTraVeDL($link, "SELECT CONCAT(customer.lastName, ' ', customer.firstName) AS customerName,phone,CONCAT(location.address, ', ', d.district, ', ', province.province) AS address
 FROM customer
 LEFT JOIN location ON customer.locationID = location.locationID
 LEFT JOIN district d ON location.districtID = d.districtID
 LEFT JOIN province ON d.provinceID = province.provinceID WHERE customer.customerID = '" . $_SESSION['customerID'] . "'");
  if (mysqli_num_rows($result) > 0) {
    // Nếu có dòng dữ liệu trả về, tức là người dùng đã đặt địa chỉ giao hàng mặc định
    $row = mysqli_fetch_assoc($result);
    // Hiển thị thông tin địa chỉ giao hàng mặc định
    echo "<div class='div-21'>" . $row['customerName'] . "</div>";
    echo "<div class='div-21'>" . $row['phone'] . "</div>";
    echo "<div class='div-21'>" . $row['address'] . "</div>";
    
  } else {
    // Nếu không có dòng dữ liệu trả về, tức là người dùng chưa đặt địa chỉ giao hàng mặc định
    echo "<div class='div-21'>Bạn chưa đặt địa chỉ giao hàng mặc định</div>";
  }
}


function view_SDC()
{
    $link = null;
    taoKetNoi($link);
    $result = chayTruyVanTraVeDL($link, "SELECT CONCAT(customer.lastName, ' ', customer.firstName) AS customerName,
      customer.phone,
      customer.email,
      CONCAT(location.address, ', ', d.district, ', ', province.province) AS address
  FROM customer
  LEFT JOIN location ON customer.locationID = location.locationID
  LEFT JOIN district d ON location.districtID = d.districtID
  LEFT JOIN province ON d.provinceID = province.provinceID
  WHERE customer.customerID = '" . $_SESSION['customerID'] . "'");

  echo "<table>";

  // Lấy một hàng dữ liệu từ kết quả truy vấn
  if ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td colspan='2' style='line-height: 2; font-family: Barlow, -apple-system, Roboto, Helvetica, sans-serif; white-space: nowrap;'>Tên đầy đủ</td>";
    echo "<td style='font-family: Barlow, -apple-system, Roboto, Helvetica, sans-serif; font-weight: bold; padding-left: 100px;'>" . $row["customerName"] . "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td colspan='2' style='line-height: 2; font-family: Barlow, -apple-system, Roboto, Helvetica, sans-serif; white-space: nowrap;'>Số điện thoại</td>";
    echo "<td style='font-family: Barlow, -apple-system, Roboto, Helvetica, sans-serif; font-weight: bold; padding-left: 100px;'>" . $row["phone"] . "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td colspan='2' style='line-height: 2; font-family: Barlow, -apple-system, Roboto, Helvetica, sans-serif; white-space: nowrap;'>Địa chỉ Email</span></td>";
    echo "<td style='font-family: Barlow, -apple-system, Roboto, Helvetica, sans-serif; font-weight: bold; padding-left: 100px;'>" . $row["email"] . "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td colspan='2' style='line-height: 2; font-family: Barlow, -apple-system, Roboto, Helvetica, sans-serif; white-space: nowrap;'>Địa chỉ</span></td>";
    echo "<td colspan='2' style='font-family: Barlow, -apple-system, Roboto, Helvetica, sans-serif; font-weight: bold; padding-left: 100px;'>" . $row["address"] . "</td>";
    echo "</tr>";
  }

  echo "</table>";
  giaiPhongBoNho($link, $result);
}
?>