<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />
    <script src="script.js"></script>
    </script>
    <link rel="stylesheet" href="./product.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600&display=swap"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Baloo Bhaina 2:wght@400;500;700&display=swap"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500&display=swap"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;700&display=swap"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@400&display=swap"
    />
  </head>

<body>
<!--HEADER + MENU -->
  <?php  require_once "header.php"; ?>
  <?php  require_once "menu.php"; ?>
<!--PRODUCT DETAIL -->
  <?php
        require_once "db_module.php";
        $link = null;
        taoKetNoi($link);
        
        // Kiểm tra xem ID sản phẩm đã được truyền qua URL hay chưa
        if(isset($_GET['product_id'])) {
            // Kết nối đến cơ sở dữ liệu và thực hiện truy vấn
            $productId = $_GET['product_id'];
            $sql = "SELECT *   
                  FROM product p 
                  LEFT JOIN subcategory sc ON p.subcategoryID = sc.subcategoryID
                  LEFT JOIN category c ON sc.categoryID = c.categoryID
                  WHERE productID = '$productId'"; 
            $result = chayTruyVanTraVeDL($link, $sql);
            if ($result->num_rows > 0) {
              // Lấy dữ liệu từ kết quả truy vấn
              $row = $result->fetch_assoc();
              $product = $row['productID']; 
              $unitPrice = $row['unitPrice'];
              $color = $row['color'];
              $size = $row['size'];
              $formattedPrice = number_format($unitPrice, 0, ',', ',');
              $description = $row['description'];
              $productName = $row['productName'];
              $image = $row['image'];
              $catID = $row['categoryID'];
              $subcat = $row['subcategoryName'];
          //giaiPhongBoNho($link, $result);
        } else {
            echo "Không có ID sản phẩm được cung cấp!";
        }
      }
 ?>  

<!--Nội dung tiêu đề của sản phẩm -->
  <div class="breadcrumb">
    <div>Home / <?php echo $productName; ?></div>
  </div>
  <div class="product-details">
    <div class="product-layout">
    <div class="image-container">
      <div class="image-wrapper">
        <img class="image-4-icon" alt="" src="<?php echo $image; ?>" />
        <img class="zoom-image-icon" alt="Zoom Image" src="./img/zoom-image.svg" />
        <div class="zoom-frame">
          <img class="zoomed-image" alt="" src="<?php echo $image; ?>" />
        </div>
      </div>
      <img class="image-8-icon" alt="" src="<?php echo $image; ?>" />
    </div>

    <br>
       <div class="product-info">
        <div class="product-header">
          <div class="brand-info">
              <div class="brand-name"><?php echo $subcat; ?></div>
              <a href="#review" class="review-link">Xem Đánh giá</a> 
          </div>
          <div class="product-name"><?php echo $productName; ?></div>

<!--Button số lượng và tổng tiền-->
          <div class="price-info">
            <div class="price-labels">
              <div>SỐ LƯỢNG</div>
            </div>
            <div class="price-details">
              <div class="quantitybtn">
                  <div class="input-group">
                    <button id="decrement" onclick="totalClick(-1)">-</button> 
                    <div class ="input-number">
                    <span id ="number"> 1</span>               
                    </div> 
                    <button id="increment" onclick="totalClick(1)">+</button>
                  </div>
              </div>
              <div class="total-price"><?php echo $formattedPrice;?> VNĐ</div>
            </div>
        </div>

<!--Button Thêm vào giỏ hàng-->
        <div class="product-actions">
            <div class="add-to-cart">
              <form id="add-to-cart-form" action="addtocart.php" method="post" onsubmit="return addToCart()">
                <input type="hidden" name="idofpro" value="<?php echo $product; ?>">
                <input type="hidden" name="img" value="<?php echo $image; ?>">
                <input type="hidden" name="tensp" value="<?php echo $productName; ?>">
                <input type="hidden" name="soluong" id="input-quantity" value="">
                <input type="hidden" name="tongtien" value="<?php echo round ($unitPrice);?> VNĐ">
                <input type="submit" name="addtocart" value="THÊM VÀO GIỎ HÀNG" class="add-to-bag">
              </form>
            </div>

<!--Button Thích-->       
            <div class="add-to-wishlist" onclick="addToWishlist()">
              <div class="wishlist-icon">
                  <img src="./img/heartoutline.svg" alt="Heart icon" />
                  <form id="addToWishlistForm" method="post">
                      <input type="hidden" name="idofpro" value="<?php echo $product; ?>">
                      <button type="button" class="wishlist-icon-button">
                          <span class="wishlist-text">THÍCH</span>
                      </button>
                  </form>
              </div>
            </div>
        </div>
        <script>
          function addToWishlist() {
            var addToWishlistDiv = document.querySelector('.add-to-wishlist');
            var formData = new FormData(document.getElementById('addToWishlistForm'));
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var response = xhr.responseText;
                        if (response === 'added') {
                            // Sản phẩm được thêm vào danh sách yêu thích
                            addToWishlistDiv.classList.add('active');
                            addToWishlistDiv.style.backgroundColor = 'rgba(251, 111, 146, 1)';
                            alert('Thêm sản phẩm yêu thích thành công');
                        } else if (response === 'removed') {
                            // Sản phẩm được xoá khỏi danh sách yêu thích
                            addToWishlistDiv.classList.remove('active');
                            addToWishlistDiv.style.backgroundColor = ''; // Xoá background color
                            alert('Bạn đã hủy thích sản phẩm');
                        }
                    } else {
                        alert('Có lỗi xảy ra, không thể thêm/xóa sản phẩm yêu thích');
                    }
                }
            };
            var method = addToWishlistDiv.classList.contains('active') ? 'DELETE' : 'POST';
            var url = 'yeuthich.php';
            xhr.open(method, url, true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            var params = 'idofpro=' + encodeURIComponent(formData.get('idofpro'));
            xhr.send(params);
        }
        </script>

<!--Icon phí vận chuyển và chính sách đổi trả-->  
      <section class="shipping-info">
        <div class="shipping-row">
          <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/bffce2d7fdd8eadb4e16c6cd31c15c8bea06339b2eb3d9cc20f4b276a5130d98?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&" alt="" class="shipping-icon" />
          <div class="return-policy-details">
            <h3 class="return-policy-title">Phí vận chuyển</h3>
            <p class="shipping-description">Miễn phí vận chuyển đối với đơn hàng trên 1,000,000 VNĐ</p>
          </div>
        </div>
        <div class="shipping-separator"></div>
        <div class="return-policy-row">
          <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/f0bae9f3bbce71e43dedfb0e84c5922c64508050ed7296b2364955f916008c9b?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&" alt="" class="shipping-icon" />
          <div class="return-policy-details">
            <h3 class="return-policy-title">Chính sách đổi trả</h3>
            <p class="shipping-description">
            Đổi trả miễn phí trong vòng  <span style="text-decoration: underline">30 ngày</span>
            </p>
          </div>
        </div>
      </section>
      </div>
    </div>
  </div>

    <br>
    <br>
    <br>
    <br>
    <br>

<!--Mô tả sản phẩm-->
    <div class="add-margin">
       <section class="description-container">
          <div class="description-title-container">
            <h2 class="description-title">MÔ TẢ</h2>
            <div class="description-title-underline"></div>
          </div>
        </section>

      <section class="product-description">
        <h2 class="product-title">THÔNG TIN SẢN PHẨM</h2>
        <p class="product-summary">
            <?php echo $description; ?>
        </p>
        <p class="product-summary">
            Màu sắc: <?php echo $color; ?>
        </p>
        <p class="product-summary">
            Size: <?php echo $size; ?>
        </p>
      </section>

      <section class="shipping-container">
        <br>
        <h2 class="product-title">VẬN CHUYỂN</h2>
        <br>
        <p class="shipping-description">
          Flamingo cung cấp Miễn phí Giao hàng Tiêu chuẩn cho tất cả các đơn hàng trị giá trên 1,000,000 VNĐ. Giá trị đơn hàng tối thiểu phải là 1,000,000 VNĐ trước thuế, phí vận chuyển và xử lý.
        </p>
        <p class="shipping-description">
          Phí vận chuyển không được hoàn lại.
        </p>
        <p class="shipping-description-shipping-info2">
           Vui lòng cho đến tối đa 2 ngày làm việc (ngoại trừ cuối tuần, ngày lễ và ngày bán hàng) để xử lý đơn hàng của bạn.
        </p>
        <p class="shipping-description-shipping-info2">
        Thời gian xử lý + Thời gian vận chuyển = Thời gian giao hàng
        </p>
      </section>

<!--Đánh gía sản phẩm-->
        <section class="description-container">
              <div class="description-title-container">
                <a name="review"> <h2 class="description-title">ĐÁNH GIÁ</h2></a>
                <div class="description-title-underline"></div>
              </div>
        </section>

        <?php
          $sql = "SELECT 
                      c.lastname, c.firstname, r.rating, r.comment
                  FROM 
                      product p
                  JOIN
                      review r ON  p.productID = r.productID
                  JOIN
                      userAccount u ON r.accountID = u.accountID
                  JOIN
                      customer c ON u.customerID = c.customerID
                  WHERE 
                      p.productID = '$productId'";

          $result = chayTruyVanTraVeDL($link, $sql);

          if ($result) {
              if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                      ?>
                      <div class="wrapper">
                          <p class="actor-name"><?php echo $row['lastname'] . ' ' . $row['firstname']; ?></p>
                          <div class="star-wrapper">
                              <?php
                              // Hiển thị số sao tương ứng với rating
                              for ($i = 1; $i <= $row['rating']; $i++) {
                                  ?>
                                  <div class="star"></div>
                                  <?php
                              }
                              ?>
                          </div>
                      </div>
                     <article class="comment-container">
                          <p class="comment-text">
                              <?php echo $row['comment']; ?>
                          </p>
                      </article>
                      <?php
                  }
              } else {
                  echo "Chưa có đánh giá!";
              }
          } else {
              echo "Lỗi trong quá trình truy vấn.";
          }
          giaiPhongBoNho($link, $result);
        ?>
    <br>
    <br>
<!--Khách hàng viết đánh giá-->
        <section class="review-section">
        <h2 class="review-title">Viết Đánh giá</h2>
        <div class="wrapper1">
            <p class="actor-name">Hãy chia sẻ trải nghiệm của bạn khi dùng sản phẩm</p>
            <div class="star-wrapper" id="star-rating-cmt">
                <form method="post">
                    <select name="rating" id="star-dropdown" style="background-color: transparent; color: #fb6f92; border: NONE; font-size: 16px;">
                        <option value=" "> </option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    <div class="star"></div>
                    </div>
                </div>
                <div class="comment-container1">
                    <textarea class="great-products" name="comment" id="comment-section"></textarea>
                    <input type="hidden" name="product_id" value="<?php echo $product; ?>">
                    <input type="submit" id = "comment-button" name="submit" value="Bình luận">
            </form>
        </div>
    </section>

    <?php
      // Kiểm tra xem người dùng đã nhấn nút "Bình luận" chưa
      if(isset($_POST['submit'])){
        $link = null;
        taoKetNoi($link);
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
        
                // Truy vấn SQL trực tiếp
                $query = "SELECT accountID FROM UserAccount WHERE username = '$username'";
                $result = chayTruyVanTraVeDL($link, $query);
        
                if ($result && mysqli_num_rows($result) > 0) {
                    // Lấy accountID từ kết quả
                    $row = mysqli_fetch_assoc($result);
                    $accountID = $row['accountID'];
                } else {
                    echo "<div class='popup-container'><div class='popup'><span class='close-btn' onclick='closePopup()'>&times;</span><img src='exclamation_mark.svg' alt='Error icon' class='check-icon'><p>Không tìm thấy thông tin tài khoản!</p></div></div>";
                    return;
                }
                // Giải phóng kết quả
              mysqli_free_result($result);
                // Lấy dữ liệu từ biểu mẫu
            $comment = $_POST['comment'];
            $rating = $_POST['rating'];
            $productID = $_POST['product_id'];
            // Tạo reviewID
            $query = "SELECT COUNT(*) as count FROM Review";
            $rs = chayTruyVanTraVeDL($link, $query);
            $row = mysqli_fetch_assoc($rs);
            $num_records = $row['count'];

            $new_review_id = 'R' . str_pad($num_records + 1, 5, '0', STR_PAD_LEFT);
            // Thêm dữ liệu vào bảng Review
            $sql = "INSERT INTO Review (reviewID, rating, comment, accountID, productID)
                          VALUES ('$new_review_id', '$rating', '$comment', '$accountID', '$productID')";
            $result = chayTruyVanKhongTraVeDL($link, $sql);
            if ($result) {
              ?>
              <div id="popup-container" class="popup-container">
                  <div class="popup">
                      <span class="close-btn" onclick="closePopup()">&times;</span>
                      <img src="https://static-00.iconduck.com/assets.00/checkmark-icon-512x426-8re0u9li.png" alt="Check icon" class="check-icon">
                      <p>Đánh giá thành công!</p>
                  </div>
              </div>
              <?php
              giaiPhongBoNho($link, $result);
            } else {
              ?>
              <div id="popup-container" class="popup-container">
                  <div class="popup">
                      <span class="close-btn" onclick="closePopup()">&times;</span>
                      <img src="https://www.svgrepo.com/show/93424/exclamation-mark-inside-a-circle.svg" alt="Check icon" class="check-icon">
                      <p>Vui lòng nhập đánh giá!</p>
                  </div>
              </div>
              <?php
            }   
          } else {
            ?>
            <div id="popup-container" class="popup-container">
                <div class="popup">
                    <span class="close-btn" onclick="closePopup()">&times;</span>
                    <img src="https://www.svgrepo.com/show/93424/exclamation-mark-inside-a-circle.svg" alt="Check icon" class="check-icon">
                    <p>Vui lòng đăng nhập để đánh giá!</p>
                </div>
            </div>
            <?php
          }
        }
      ?>
<!--Sản phẩm tương tự-->
    <div class="bestseller-template"  id="animate-on-scroll">SẢN PHẨM TƯƠNG TỰ</div>
      <br>
      <br>
      <div class="best-seller"  id="animate-on-scroll">
        <?php
          require_once "db_module.php";
          $link = null;
          taoKetNoi($link);
          // Lấy dữ liệu từ database
          $sql = "SELECT Distinct
                      p.productName, 
                      p.productID,
                      CONCAT(FORMAT(p.unitPrice, 0), ' VNĐ') AS formattedUnitPrice, 
                      p.image,
                      CONCAT(FORMAT(d.discountAmount * 100, 0), '%') AS discountPercentage,
                      c.categoryName,
                      sc.subcategoryName
                  FROM product p 
                  LEFT JOIN subcategory sc ON p.subcategoryID = sc.subcategoryID
                  LEFT JOIN category c ON sc.categoryID = c.categoryID
                  LEFT JOIN orderdetail od ON p.productID = od.productID
                  LEFT JOIN orders o ON o.orderID = od.orderID
                  LEFT JOIN discount d ON p.discountID = d.discountID
                  WHERE c.categoryID = '$catID'
                  AND p.productID <> '$productId'
                  LIMIT 5;";
          $result = chayTruyVanTraVeDL($link, $sql);
          if ($result->num_rows > 0) {
            // Duyệt qua các hàng kết quả và hiển thị dữ liệu trong HTML
            while ($row = $result->fetch_assoc()) {
                ?>
                  <div class="bestsellerproduct-item">
                  <a href="product.php?product_id=<?php echo $row['productID']; ?>">
                       <?php if ($row['discountPercentage'] !== null) { ?>
                          <div class="discount-tag"><?php echo $row['discountPercentage']; ?></div>
                      <?php } ?>        
                      <img src="<?php echo $row['image']; ?>" class="img">     
                      <div class="bestsellerproduct-info">
                          <div class="bestsellerproduct-name"><?php echo $row['productName']; ?></div>
                          <div class="bestsellerproduct-category"><?php echo $row['categoryName']; ?> | <?php echo $row['subcategoryName']; ?></div>
                          <div class="bestsellerproduct-price"><?php echo $row['formattedUnitPrice']; ?></div>
                    </div>
                    </a>
                  </div>
            
                <?php
                    }
                } else {
                    echo "0 results";
                }
                giaiPhongBoNho($link, $result);
                ?>
    </div>
<!--FOOTER-->
    <?php  require "footer.php"; ?>

    <script>
    function showPopup() {
      document.getElementById("popup-container").style.display = "block";
    }

    function closePopup() {
      document.getElementById("popup-container").style.display = "none";
    }
    window.onload = function() {
      showPopup();
    };

    document.addEventListener('DOMContentLoaded', function () {
            var addToWishlistDiv = document.querySelector('.add-to-wishlist');
            var productId = "<?php echo $product; ?>";
            // Function to check if the product is in the user's favorites list
            function checkFavoritesAndUpdateButton() {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            var response = xhr.responseText;
                            if (response === 'exists') {
                                // Product is in favorites list, apply the active class and pink background color
                                addToWishlistDiv.classList.add('active');
                                addToWishlistDiv.style.backgroundColor = 'rgba(251, 111, 146, 1)';
                            }
                        }
                    }
                };
                xhr.open('GET', 'check_favorites.php?idofpro=' + productId, true);
                xhr.send();
            }

            // Call the function to check favorites and update button on page load
            checkFavoritesAndUpdateButton();
        });
    </script>
</body>
</html>