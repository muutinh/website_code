<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="upperstyles.css">
  <link rel="stylesheet" href="banner-slider.css">
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <title>Trang sức Flamingo</title>
</head>


<body>  
  <div class="main-container">
    <div class="content-container">
      <!-- HEADER -->
    <?php include "header.php"; ?> 
    <!-- MENU -->
    <?php include "menu.php"; ?>
        <!-- BANNER -->
        <div class="banner-container" id="animate-on-scroll">
    <div class="slider">
        <img
          id="img-1"
          src="img/img4.png"
          alt="Image 1"
        />
        <img
          id="img-2"
          src="img/img5.jpg"
          alt="Image 2"
        />
        <img
          id="img-3"
          src="img/img9.jpg"
          alt="Image 3"
        />
      </div>
      <div class="navigation-button">
        <span class="dot active" onclick="changeSlide(0)"></span>
        <span class="dot" onclick="changeSlide(1)"></span>
        <span class="dot" onclick="changeSlide(2)"></span>
      </div>
      <script src="banner-slider.js"></script>
        <div class="content-on-banner">
          <div class="text-on-banner">
            <div class="banner-text">
              <div class="banner-text1">50%</div>
              <div class="banner-text2"></div>
              <div class="banner-text3">
                Chương trình
                <br />
                khuyến mãi
                <br />
                Quốc tế Phụ Nữ
              </div>
            </div>
            <div class="banner-text4">
              Áp dụng cho toàn bộ hệ thống cửa hàng Flamingo trên toàn quốc
              <br />
              Từ 8/3/2024 đến hết 31/3/2024
            </div>
          </div>
          <div class="whitelines-on-banner">
            <div class="whitelines-banner">
              <div class="whiteline1"></div>
              <div class="whiteline2"><div class="whiteline3"></div></div>
              <div class="whiteline4"></div>
            </div>
          </div>
        </div>
      </div>
      <br>
      <br>
      <!-- LIST PRODUCT -->
      <div class = "listproduct-container"  id="animate-on-scroll">
        <a href="product-list.php?category=C001">
          <div class = "prod1">
            <div class="overlay" ></div>
            <div class="text-on-overlay">Lắc</div>
            <img src="img/frame1.png" width = 100% height = 100% alt="">
         </div>
        </a>
        <a href="product-list.php?category=C002">
        <div class = "prod2">
            <div class="overlay"></div>
            <div class="text-on-overlay">Mặt dây chuyền</div>
            <img src="img/frame2.png" width = 100% height = 100% alt="">
        </div>
        </a>
        <a href="product-list.php?category=C003">
        <div class = "prod3">
            <div class="overlay"></div>
            <div class="text-on-overlay">Bông tai</div>
            <img src="img/frame3.png" width = 100% height = 100% alt="">
        </div>
        </a>
        <a href="product-list.php?category=C004">
        <div class = "prod4">
            <div class="overlay"></div>
            <div class="text-on-overlay">Dây chuyền</div>
            <img src="img/frame4.png" width = 100% height = 100% alt="">
        </div>
        </a>
        <a href="product-list.php?category=C005">
        <div class = "prod5">
            <div class="overlay"></div>
            <div class="text-on-overlay">Nhẫn</div>
            <img src="img/frame5.png" width = 100% height = 100% alt="">
        </div>
        </a>
        <a href="product-list.php?category=C006">
        <div class = "prod6">
            <div class="overlay"></div>
            <div class="text-on-overlay">Phụ kiện rời</div>
            <img src="img/frame6.png" width = 100% height = 100% alt="">
        </div>
        </a>
      </div>
      <br>
      <br>
      <br>
      <!-- BEST SELLER -->
      <div class="bestseller-template"  id="animate-on-scroll">SẢN PHẨM BÁN CHẠY</div>
      <br>
      <br>
      <div class="best-seller"  id="animate-on-scroll">
        <?php
          require_once "db_module.php";
          $link = null;
          taoKetNoi($link);

          $sql = "SELECT 
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
                  GROUP BY p.productName, formattedUnitPrice, p.image, discountPercentage, c.categoryName, sc.subcategoryName 
                  ORDER BY SUM(od.quantity) DESC
                  LIMIT 5;
                  ";

          $result = chayTruyVanTraVeDL($link, $sql);
          if ($result->num_rows > 0) {
            // Duyệt qua các hàng kết quả và hiển thị dữ liệu trong HTML
            while ($row = $result->fetch_assoc()) {
                ?>
                  <div class="bestsellerproduct-item">
                  <a href="product.php?product_id=<?php echo $row['productID']; ?>">
                      <img src="<?php echo $row['image']; ?>" class="img">     
                      <?php if ($row['discountPercentage'] !== null) { ?>
                          <div class="discount-tag"><?php echo $row['discountPercentage']; ?></div>
                      <?php } ?>        
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
                    echo "0 kết quả";
                }
                giaiPhongBoNho($link, $result);
                ?>
    </div>

    <?php include "index-2.php"; ?>
  </div>
  <a name="contact"></a>
  </body>
</html>