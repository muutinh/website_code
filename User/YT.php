<html>
    <head></head>
    <body> 
    <?php require 'header.php'; ?>
    <?php require 'menu.php'; ?>    
        <div class="div" id ="YT" style ="width : 100%; margin: 0 auto;">
            <div class="div-2"></div>
            <div class="div-3" style=" font-weight : bold;font-size : 35px;">Yêu thích</div>
            <div class="div-4">
              <div class="div-5">
                <div class="column">
                  <div class="div-6">
                    <div class="div-7" onclick="window.location.href='TTKH.php'" style="cursor: pointer;" >Thông tin khách hàng</div>
                    <div class="div-8" onclick="window.location.href='SDC.php'" style="cursor: pointer;">Sổ địa chỉ</div>
                    <div class="div-9" onclick="window.location.href='DDH.php'" style="cursor: pointer;">Đơn đặt hàng</div>
                    <div class="div-10" onclick="window.location.href='YT.php'" style="cursor: pointer;">Yêu thích</div>
                  </div>
                </div>
                
</br>
<div class="likeprod"  id="animate-on-scroll">
<?php
require_once "db_module.php";
require_once "users_module.php";
$link = null;
taoKetNoi($link);

// Kiểm tra xem có session customerID và accountID không
if(isset($_SESSION['customerID']) && isset($_SESSION['accountID'])) {
    // Lấy customerID và accountID từ session
    $customerID = $_SESSION['customerID'];
    $accountID = $_SESSION['accountID'];
    // Tiếp tục truy vấn để lấy thông tin các sản phẩm yêu thích từ bảng product
    $query = "SELECT DISTINCT favID,product.image,product.productID, product.discountID, 
              product.productName, subcategory.subcategoryName, CONCAT(FORMAT(product.unitPrice, 0), ' VNĐ') AS formattedUnitPrice , 
              favproduct.accountID, CONCAT(FORMAT(d.discountAmount * 100, 0), '%') AS discountPercentage
    FROM product JOIN `subcategory` ON product.subcategoryID = `subcategory`.subcategoryID 
    JOIN `favproduct` ON product.productID = favproduct.productID 
    JOIN useraccount u ON u.accountID = favproduct.accountID
    JOIN discount d ON product.discountID = d.discountID WHERE u.accountID = '$accountID'";
    $result = chayTruyVanKhongTraVeDL($link, $query);
    
    // Kiểm tra kết quả truy vấn
    if($result) {
        // Kiểm tra xem có dữ liệu không
        if (mysqli_num_rows($result) > 0) {
            // Hiển thị thông tin sản phẩm yêu thích
            while ($row = mysqli_fetch_assoc($result)) {
        ?>


            <div class="product-item">
            <a href="product.php?product_id=<?php echo $row['productID']; ?>">
                <img loading="lazy" srcset="<?php echo $row['image']; ?>" class="img" />
                <?php if ($row['discountID'] !== 'NONE')  { ?>
                <div class="discount-tag"><?php echo $row['discountPercentage']; ?></div>
               <?php } ?>
                </br>
                <div class="product-info">
                    <div class="product-name"><?php echo $row['productName']; ?></div>
                    <div class="product-category"><?php echo $row['subcategoryName']; ?></div>
                    <div class="product-price"><?php echo $row['formattedUnitPrice']; ?></div>
                </div>
                </a>
                <form action="del_YT.php" method="post" id="deleteForm">
                  <input type="hidden" name="favID" value="<?php echo $row['favID']; ?>">
                  <button type="submit" >
                      <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/b92a98a450a77c4e2c9857a326b6a5d33a717d4c5870690f94eef140a2a49c80?apiKey=eb23b2963eda46448725d8ef1c3cf67d&"class="trash" />
                </button>
    </div>
</form>
      <?php
            }
        } else {
          echo '<div class="tb" style="text-align: center; vertical-align: top;">Không có sản phẩm yêu thích nào được tìm thấy.</div>';
        }
              } else {
                  // Hiển thị thông báo nếu có lỗi trong quá trình truy vấn
                  echo "Không có sản phẩm yêu thích nào được tìm thấy.";

              }
          } else {
              // Nếu không có session, chuyển hướng người dùng đến trang đăng nhập
              header("Location: dangnhap.php");
              exit(); // Kết thúc chương trình để ngăn mã tiếp tục thực thi
          }

          // Đóng kết nối
          giaiPhongBoNho($link, $result);
              ?>
        </div>
        </div>
      </div>
    </div>
  </div>

<?php require 'footer.php'; ?>

      <style>
        .tb {
          font-family: Barlow, sans-serif;
          margin-top : 0px;
          margin-bottom : 30px;
        }
       body {
            margin :0;
            padding :0;
          }
          .div-7:hover,
          .div-8:hover,
          .div-9:hover,
          .div-10:hover {
            box-shadow: 0 0 5px 0 #fb6f92; /* Hiệu ứng nổi lên nhẹ màu hồng */
            transform: translateY(-3px); /* Nổi lên full ô */
          }
              .div {
              display: flex;
              flex-direction: column;
              align-items: center;
              padding: 0 20px;
              
            }
            .div-2 {
              color: var(--Gray-1, #828282);
              text-align: center;
              align-self: stretch;
              width: 100%;
              font: 500 14px/68px Barlow, sans-serif;
            }
            @media (max-width: 991px) {
              .div-2 {
                max-width: 100%;
              }
            }
            .div-3 {
              color: #fb6f92;
          text-align: center;
          white-space: nowrap;
          margin-top : 100px;
          
                    text-align: center;
                    white-space: nowrap;
                    font: 400 48px Barlow, sans-serif;
            }
            @media (max-width: 991px) {
              .div-3 {
                font-size: 40px;
                white-space: initial;
              }
            }
            .div-4 {
              margin-top: 40px;
              width: 100%;
              max-width: 1263px;
            }
            @media (max-width: 991px) {
              .div-4 {
                max-width: 100%;
              }
            }
            .div-5 {
              gap: 20px;
              display: flex;
            }
            @media (max-width: 991px) {
              .div-5 {
                flex-direction: column;
                align-items: stretch;
                gap: 0px;
              }
            }
            .column {
              display: flex;
              flex-direction: column;
              line-height: normal;
              width: 40%;
              margin-left: 0px;
              margin-bottom: 100px; /* Thêm khoảng cách dưới cùng cho cột */
          }

/* Media query cho màn hình có chiều rộng nhỏ hơn hoặc bằng 991px */
@media (max-width: 991px) {
    .column {
        width: 100%; /* Chiều rộng của cột trở thành 100% khi màn hình nhỏ hơn hoặc bằng 991px */
        margin-bottom: 30px;
        
    }
}

            .div-6 {
                    display: flex;
                    flex-direction: column;
                    font-size: 16px;
                    color: #000;
                    font-weight: 400;
                    line-height: 144%;
                }

                .div-7 {
                    font-family: Barlow, sans-serif;
                    ;
                    background-color: #fff;
                    justify-content: center;
                    align-items: start;
                    font-weight: 400;
                    padding: 14px 60px 14px 13px;
                }

                @media (max-width: 991px) {
                    .div-7 {
                        padding-right: 20px;
                    }
                }

                .div-8 {
                    font-family: Barlow, sans-serif;
                  color : black;
                    background-color: #fff;
                    justify-content: center;
                    align-items: start;
                    font-weight: 400;
                    padding: 14px 60px 14px 13px;
                }

                @media (max-width: 991px) {
                    .div-8 {
                        padding-right: 20px;
                    }
                }

                .div-9 {
                    font-family: Barlow, sans-serif;
                    ;
                    background-color: #fff;
                    justify-content: center;
                    align-items: start;
                    font-weight: 400;
                    padding: 14px 60px 14px 13px;
                    font-weight: 400;
                }

                @media (max-width: 991px) {
                    .div-9 {
                        padding-right: 20px;
                    }
                }

                .div-10 {
                    font-family: Barlow, sans-serif;
                    ;
                    background-color: #fb6f92;
                    color: #fff;
                    justify-content: center;
                    align-items: start;
                    font-weight: 400;
                    padding: 16px 60px 16px 13px;
                }

                @media (max-width: 991px) {
                    .div-10 {
                        padding-right: 20px;
                    }
                }

                .column-2 {
                    display: flex;
                    flex-direction: column;
                    line-height: normal;
                    width: 60%;
                    margin-left: 20px;
                  
                    
                }

                @media (max-width: 991px) {
                    .column-2 {
                        width: 100%;
                      
                      
                    }
                }
    .product-item {
      margin-right: 20px;
      margin-bottom: 20px;
      padding: 15px;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
      background-color: #fff;
      position: relative;
      box-sizing: border-box; 
      flex: 0 1 240px;
    }

    .product-item:last-child {
      margin-right: 0; 
    }


    .img {
      width: 100%;
        height: auto;
      

    }

    .discount-tag {
      background-color: #fb6f92;
      color: #fff;
      font-family: 'Barlow', sans-serif;
      font-weight: bold;
      font-size: 14px;
      padding: 5px;
      position: absolute;
      top: 17;
      left: 0;
    }

    .product-info {
      margin-top: 10px;
      justify-content: center;
      align-items: center;
      text-align: center; 
      display: flex;
      flex-direction: column;
      color: #212121;
      padding: 10px 33px;
      width : 120px;
    }

    .product-name {
      align-self: stretch;
      font-family: Barlow, sans-serif;
      display: -webkit-box;
      -webkit-box-orient: vertical;
      -webkit-line-clamp: 2; /* Số dòng tối đa */
      overflow: hidden; /* Ẩn phần văn bản ra khỏi phần tử cha */
      text-overflow: ellipsis; /* Hiển thị dấu "..." khi văn bản bị ẩn */
    }

    .product-category {
      color: #777;
      text-transform: capitalize;
      margin-top: 6px;
      font: 400 14px Barlow, sans-serif;
      display: -webkit-box;
      -webkit-line-clamp: 1; 
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .product-price {
      color: #fb6f92;
      text-align: center;
      margin-top: 6px;
      font: 18px/135% Barlow, sans-serif;
    }
    .trash {
      aspect-ratio: 1;
      object-fit: auto;
      width: 30px;
      padding: 5px;
      position: absolute;
      bottom: 10;
      right: 0;
    }
    .likeprod {
        display: flex;
        justify-content: flex-start;
        flex-wrap: wrap;
      }
    @media (max-width: 984px) {
        .product-item {
          justify-content: center;
          height: 60%; 
          margin-bottom: 20px; /* Khoảng cách giữa các dòng */
          box-sizing: border-box;
          padding: 0 5px; /* Khoảng cách giữa các sản phẩm */
          flex: 0 1 200px;
        }
      }


          </style>
    </body>
</html>