<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css'> 
    <title>Trang sức Flamingo</title>
</head>
<body>
    <div class="main-container2"  id="animate-on-scroll">
        <div class="content-container2">
          <div class="feature-section"> 
            <div class="feature-item">
              <img
                loading="lazy"
                src="https://cdn.builder.io/api/v1/image/assets/TEMP/28ae41166a70e2cd6af30cd0d458f4342701a904db3fc29fb50f9dc594648377?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&"
                class="feature-img"
              />
              <div class="feature-text">TÚI HỘP TRANG NHÃ <br>Sẵn sàng trao tặng</div>
            </div>
            <div class="feature-item">
              <img
                loading="lazy"
                src="https://cdn.builder.io/api/v1/image/assets/TEMP/233d513438babadda4bf2860f7de736a88c8e2654f268dab5ddc325d8e8a6af9?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&"
                class="feature-img"
              />
              <div class="feature-text">Đổi trả MIỄN PHÍ <br>Trong vòng 30 NGÀY</div>
            </div>
            <div class="feature-item">
              <div class="service-item">
                <img
                  loading="lazy"
                  src="https://cdn.builder.io/api/v1/image/assets/TEMP/5e5f38c738d97e2b2c91d4e8c5bf5a88c3eaf16d122be8794fc0fb19c86a21e2?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&"
                  class="feature-img"
                />
                <div class="service-text">Dịch vụ BẢO HÀNH <br>TRỌN ĐỜI</div>
              </div>
            </div>
            <div class="feature-item">
              <img
                loading="lazy"
                src="https://cdn.builder.io/api/v1/image/assets/TEMP/6cbacfe4ea173ec17eaabee0ad9b57fa865d6a67e800b14fb6dc89cc94161f48?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&"
                class="feature-img"
              />
              <div class="feature-text">MIỄN PHÍ vận chuyển <br>Đơn Hàng từ 950.000 VNĐ</div>
            </div>
          </div>
        </div>
      </div>      
<br>
<br>
<br>
  <?php   
   require_once "db_module.php";

   $link = null;
   taoKetNoi($link);
    //Tạo kết nối vào CSDL
      $sql = "SELECT 
            p.productName,
            p.description,
            p.image,
            sc.subcategoryName
        FROM 
            product p
        JOIN
            subcategory sc ON p.subcategoryID = sc.subcategoryID        
            LIMIT 1";


$result = chayTruyVanTraVeDL($link,$sql);


if ($result->num_rows > 0) {
    // Hiển thị dữ liệu
    while($row = $result->fetch_assoc()) {
        echo '<div class="main-container3" id="animate-on-scroll">';
        echo '<div id="custom-div">';
        echo '<div id="custom-column">';
        echo '<img loading="lazy" src="' . $row["image"] . '" class="custom-img" />';
        echo '</div>';
        echo '<div id="custom-column-2">';
        echo '<div id="custom-div-3">';
        echo '<div id="custom-div-4">' . $row["subcategoryName"] . '</div>';
        echo '<div id="custom-div-5">' . $row["productName"] . '</div>';
        echo '<div id="custom-div-6">' . $row["description"] . '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "0 kết quả";
}
giaiPhongBoNho($link, $result);
?>

<div class="bestseller-template" id="animate-on-scroll">SẢN PHẨM GIẢM GIÁ</div>
<div class="menu-container2" id="animate-on-scroll">
    <div class="top-products">
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
        FROM 
            product p
            LEFT JOIN
            subcategory sc ON p.subcategoryID = sc.subcategoryID
            LEFT JOIN
            category c ON sc.categoryID = c.categoryID
            LEFT JOIN
            discount d ON p.discountID = d.discountID
        WHERE 
            d.discountID IS NOT NULL
        LIMIT 5";

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
    <div class="button-container">
    <a href="product-list.php?discount=TRUE"><button class="SeeAll">Xem tất cả</button></a>
    </div>
</div>
    <div class="Insta">
      <header class="header">Follow Flamingo trên Instagram</header>
      <div class="image-wrapper">
        <a href="#" class="link">
          <img loading="lazy" srcset="https://cdn.builder.io/api/v1/image/assets/TEMP/5856724602e336b7163f276810e2879b5feb96807971f769665adb8f2e22a51d?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=100 100w, https://cdn.builder.io/api/v1/image/assets/TEMP/5856724602e336b7163f276810e2879b5feb96807971f769665adb8f2e22a51d?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=200 200w, https://cdn.builder.io/api/v1/image/assets/TEMP/5856724602e336b7163f276810e2879b5feb96807971f769665adb8f2e22a51d?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=400 400w, https://cdn.builder.io/api/v1/image/assets/TEMP/5856724602e336b7163f276810e2879b5feb96807971f769665adb8f2e22a51d?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=800 800w, https://cdn.builder.io/api/v1/image/assets/TEMP/5856724602e336b7163f276810e2879b5feb96807971f769665adb8f2e22a51d?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=1200 1200w, https://cdn.builder.io/api/v1/image/assets/TEMP/5856724602e336b7163f276810e2879b5feb96807971f769665adb8f2e22a51d?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=1600 1600w, https://cdn.builder.io/api/v1/image/assets/TEMP/5856724602e336b7163f276810e2879b5feb96807971f769665adb8f2e22a51d?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=2000 2000w, https://cdn.builder.io/api/v1/image/assets/TEMP/5856724602e336b7163f276810e2879b5feb96807971f769665adb8f2e22a51d?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&"class="image" />
        </a>
        <a href="#" class="link">
          <img loading="lazy" srcset="https://cdn.builder.io/api/v1/image/assets/TEMP/81119b784ae3dd9d4d067807d48810dc859ed132b39c019f1264607149a571ec?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=100 100w, https://cdn.builder.io/api/v1/image/assets/TEMP/81119b784ae3dd9d4d067807d48810dc859ed132b39c019f1264607149a571ec?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=200 200w, https://cdn.builder.io/api/v1/image/assets/TEMP/81119b784ae3dd9d4d067807d48810dc859ed132b39c019f1264607149a571ec?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=400 400w, https://cdn.builder.io/api/v1/image/assets/TEMP/81119b784ae3dd9d4d067807d48810dc859ed132b39c019f1264607149a571ec?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=800 800w, https://cdn.builder.io/api/v1/image/assets/TEMP/81119b784ae3dd9d4d067807d48810dc859ed132b39c019f1264607149a571ec?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=1200 1200w, https://cdn.builder.io/api/v1/image/assets/TEMP/81119b784ae3dd9d4d067807d48810dc859ed132b39c019f1264607149a571ec?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=1600 1600w, https://cdn.builder.io/api/v1/image/assets/TEMP/81119b784ae3dd9d4d067807d48810dc859ed132b39c019f1264607149a571ec?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=2000 2000w, https://cdn.builder.io/api/v1/image/assets/TEMP/81119b784ae3dd9d4d067807d48810dc859ed132b39c019f1264607149a571ec?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&"class="image" />
        </a>
        <a href="#" class="link">
          <img loading="lazy" srcset="https://cdn.builder.io/api/v1/image/assets/TEMP/6593bfec491c233a1f56b9edebebd5e2c5766c666a04cc804d37de542f7a0197?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=100 100w, https://cdn.builder.io/api/v1/image/assets/TEMP/6593bfec491c233a1f56b9edebebd5e2c5766c666a04cc804d37de542f7a0197?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=200 200w, https://cdn.builder.io/api/v1/image/assets/TEMP/6593bfec491c233a1f56b9edebebd5e2c5766c666a04cc804d37de542f7a0197?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=400 400w, https://cdn.builder.io/api/v1/image/assets/TEMP/6593bfec491c233a1f56b9edebebd5e2c5766c666a04cc804d37de542f7a0197?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=800 800w, https://cdn.builder.io/api/v1/image/assets/TEMP/6593bfec491c233a1f56b9edebebd5e2c5766c666a04cc804d37de542f7a0197?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=1200 1200w, https://cdn.builder.io/api/v1/image/assets/TEMP/6593bfec491c233a1f56b9edebebd5e2c5766c666a04cc804d37de542f7a0197?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=1600 1600w, https://cdn.builder.io/api/v1/image/assets/TEMP/6593bfec491c233a1f56b9edebebd5e2c5766c666a04cc804d37de542f7a0197?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=2000 2000w, https://cdn.builder.io/api/v1/image/assets/TEMP/6593bfec491c233a1f56b9edebebd5e2c5766c666a04cc804d37de542f7a0197?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&"class="image" />
        </a>
        <a href="#" class="link">
          <img loading="lazy" srcset="https://cdn.builder.io/api/v1/image/assets/TEMP/0663d90fe29cb55f3b58f6ab08a8f35f54011a7b06a17dd9e3d8896c4becff43?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=100 100w, https://cdn.builder.io/api/v1/image/assets/TEMP/0663d90fe29cb55f3b58f6ab08a8f35f54011a7b06a17dd9e3d8896c4becff43?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=200 200w, https://cdn.builder.io/api/v1/image/assets/TEMP/0663d90fe29cb55f3b58f6ab08a8f35f54011a7b06a17dd9e3d8896c4becff43?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=400 400w, https://cdn.builder.io/api/v1/image/assets/TEMP/0663d90fe29cb55f3b58f6ab08a8f35f54011a7b06a17dd9e3d8896c4becff43?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=800 800w, https://cdn.builder.io/api/v1/image/assets/TEMP/0663d90fe29cb55f3b58f6ab08a8f35f54011a7b06a17dd9e3d8896c4becff43?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=1200 1200w, https://cdn.builder.io/api/v1/image/assets/TEMP/0663d90fe29cb55f3b58f6ab08a8f35f54011a7b06a17dd9e3d8896c4becff43?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=1600 1600w, https://cdn.builder.io/api/v1/image/assets/TEMP/0663d90fe29cb55f3b58f6ab08a8f35f54011a7b06a17dd9e3d8896c4becff43?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=2000 2000w, https://cdn.builder.io/api/v1/image/assets/TEMP/0663d90fe29cb55f3b58f6ab08a8f35f54011a7b06a17dd9e3d8896c4becff43?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&"class="image" />
        </a>
        <a href="#" class="link">
          <img loading="lazy" srcset="https://cdn.builder.io/api/v1/image/assets/TEMP/5661a1ce6f12a5b6ba9409aead1e6abecb04e1cb242c2cdd5a1d3cb2f6d2db41?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=100 100w, https://cdn.builder.io/api/v1/image/assets/TEMP/5661a1ce6f12a5b6ba9409aead1e6abecb04e1cb242c2cdd5a1d3cb2f6d2db41?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=200 200w, https://cdn.builder.io/api/v1/image/assets/TEMP/5661a1ce6f12a5b6ba9409aead1e6abecb04e1cb242c2cdd5a1d3cb2f6d2db41?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=400 400w, https://cdn.builder.io/api/v1/image/assets/TEMP/5661a1ce6f12a5b6ba9409aead1e6abecb04e1cb242c2cdd5a1d3cb2f6d2db41?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=800 800w, https://cdn.builder.io/api/v1/image/assets/TEMP/5661a1ce6f12a5b6ba9409aead1e6abecb04e1cb242c2cdd5a1d3cb2f6d2db41?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=1200 1200w, https://cdn.builder.io/api/v1/image/assets/TEMP/5661a1ce6f12a5b6ba9409aead1e6abecb04e1cb242c2cdd5a1d3cb2f6d2db41?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=1600 1600w, https://cdn.builder.io/api/v1/image/assets/TEMP/5661a1ce6f12a5b6ba9409aead1e6abecb04e1cb242c2cdd5a1d3cb2f6d2db41?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=2000 2000w, https://cdn.builder.io/api/v1/image/assets/TEMP/5661a1ce6f12a5b6ba9409aead1e6abecb04e1cb242c2cdd5a1d3cb2f6d2db41?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&"class="image" />
        </a>
        <a href="#" class="link">
          <img loading="lazy" srcset="https://cdn.builder.io/api/v1/image/assets/TEMP/15f0d2ac882b966b32732cca797a085de627758a024e6f11d8b512cf4fb90aca?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=100 100w, https://cdn.builder.io/api/v1/image/assets/TEMP/15f0d2ac882b966b32732cca797a085de627758a024e6f11d8b512cf4fb90aca?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=200 200w, https://cdn.builder.io/api/v1/image/assets/TEMP/15f0d2ac882b966b32732cca797a085de627758a024e6f11d8b512cf4fb90aca?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=400 400w, https://cdn.builder.io/api/v1/image/assets/TEMP/15f0d2ac882b966b32732cca797a085de627758a024e6f11d8b512cf4fb90aca?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=800 800w, https://cdn.builder.io/api/v1/image/assets/TEMP/15f0d2ac882b966b32732cca797a085de627758a024e6f11d8b512cf4fb90aca?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=1200 1200w, https://cdn.builder.io/api/v1/image/assets/TEMP/15f0d2ac882b966b32732cca797a085de627758a024e6f11d8b512cf4fb90aca?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=1600 1600w, https://cdn.builder.io/api/v1/image/assets/TEMP/15f0d2ac882b966b32732cca797a085de627758a024e6f11d8b512cf4fb90aca?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=2000 2000w, https://cdn.builder.io/api/v1/image/assets/TEMP/15f0d2ac882b966b32732cca797a085de627758a024e6f11d8b512cf4fb90aca?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&"class="image" />
        </a>
      </div>
    </div>
<br>
<header class="header" style="color: #fb6f92;">ĐÁNH GIÁ CỦA KHÁCH HÀNG</header>
<br>
    <div class="container">
      <div class="swiper swiperCarousel">
          <div class="swiper-wrapper">
              <div class="swiper-slide">
                  <div class="card">
                      <img class="avatar" src="https://lavenderstudio.com.vn/wp-content/uploads/2019/10/1.jpg" />               
              </svg>
                      <div class="header">
                          <h1 class="name">Lê Thị Ngọc</h1>
                          <h2 class="title">Nhà Thiết Kế Thời Trang</h2>
                      </div>
                      <div class="quote-container">
                          <p class="quote">
                          Thời gian vận chuyển rất hợp lí. Tôi đã đặt hàng với tâm thế hào hứng chờ đợi để được trải nghiệm sản phẩm và tôi không hề bị chờ mỏi cổ. Có thể thấy bên vận chuyển không quản ngại thời tiết và đường xá xa xôi để đưa sản phẩm cho tôi trong thời gian ngắn nhất
                          </p>
                      </div>
                  </div>
              </div>
              <div class="swiper-slide">
                  <div class="card">
                      <img class="avatar" src="https://images2.thanhnien.vn/zoom/686_429/Uploaded/dieutrang.qc/2020_03_09/kingcoffe/ceolehoangdiepthao-avatar_EZOB.jpg" />                
              </svg>
                      <div class="header">
                          <h1 class="name">Nguyễn Thị Hạnh</h1>
                          <h2 class="title">CTO, Kafla</h2>
                      </div>
                      <div class="quote-container">
                          <p class="quote">
                          Mẫu nhìn đơn giản, tưởng không đẹp mà đẹp không tưởng ạ, đính đá rất chắc chắn mình mang được vài hôm rồi mới lên đánh giá, thấy sản phẩm chất lượng nên mọi người tham khảo thử xem
                          </p>
                      </div>
                  </div>
              </div>
              <div class="swiper-slide">
                  <div class="card">
                      <img class="avatar" src="https://i.pinimg.com/originals/68/7f/f5/687ff58b82cf34da0cd1369598f22104.jpg" />            
              </svg>
                      <div class="header">
                          <h1 class="name">Lưu Bích Loan</h1>
                          <h2 class="title">Sinh viên UEH</h2>
                      </div>
                      <div class="quote-container">
                          <p class="quote">
                          Đẹp hơn cả mô tả Giao hàng nhanh đóng gói hàng cẩn thận có cả giấy Hướng dẫn sử dụng và hộp nhẫn gói kèm theo. Giao hàng nhanh đóng gói đủ số lượng. Nhẫn rất đẹp mọi người nên mua và trải nghiệm sản phẩm nha
                          </p>
                      </div>
                  </div>
              </div>
              <div class="swiper-slide">
                  <div class="card">
                      <img class="avatar" src="https://upanh123.com/wp-content/uploads/2021/04/Anh-gai-xinh-lam-anh-dai-dien-facebook1.jpg" />              
              </svg>
                      <div class="header">
                          <h1 class="name">Đặng Minh Ngọc</h1>
                          <h2 class="title">
                              Influencer
                          </h2>
                      </div>
                      <div class="quote-container">
                          <p class="quote">
                          Đầu tiên là thấy shop phục vụ rất nhiệt tình. Đóng gói cẩn thận. Sản phẩm thì ok. Còn chất lượng thì đợi 1 thời gian mới biết đc
                          </p>
                      </div>
                  </div>
              </div>
              <div class="swiper-slide">
                  <div class="card">
                      <img class="avatar" src="https://scr.vn/wp-content/uploads/2020/08/H%C3%ACnh-g%C3%A1i-%C4%91%E1%BA%B9p-t%C3%B3c-d%C3%A0i-ng%E1%BA%A7u.jpg" />              
              </svg>
                      <div class="header">
                          <h1 class="name">Thảo Ngọc</h1>
                          <h2 class="title">Sinh viên UEH</h2>
                      </div>
                      <div class="quote-container">
                          <p class="quote">
                          Đẹp nè. Xinh lắm á. Trông chắc chắn. Xịn nữa. Mấy chị bên cty cứ nhờ mua hộ nhưng em báo tự vào shop đặt r Giao hàng nhanh. Hqua đặt mà trưa nay có hàng luôn r
                          </p>
                      </div>
                  </div>
              </div>
              <div class="swiper-slide">
                  <div class="card">
                      <img class="avatar" src="https://nguyenthihongdung.com/wp-content/uploads/2021/05/Cau-chuyen-cua-Nguyen-Thi-Hong-Dung.jpg" /> 
                      <div class="header">
                          <h1 class="name">Nguyễn Thị Hồng Dung</h1>
                          <h2 class="title">Chuyên Gia Phát Triển Kinh Doanh</h2>
                      </div>
                      <div class="quote-container">
                          <p class="quote">
                          Đẹp tuyệt vời, từ khi mua hàng của shop thì không muốn mua shop khác nữa 
                          </p>
                      </div>
                  </div>
              </div>
          </div>
          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
          <div class="swiper-pagination"></div>
      </div>
  </div>
  <script src='https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/textfit/2.4.0/textFit.min.js'></script>
<script>
      const swiper = new Swiper(".swiperCarousel", {
        slidesPerView: 3,
        centeredSlides: true,
        spaceBetween: 10,
        keyboard: {
          enabled: true,
        },
        loop: true,
        pagination: {
          el: ".swiper-pagination",
        },
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
      });

      const slides = document.getElementsByClassName("swiper-slide");
      for (const slide of slides) {
        slide.addEventListener("click", () => {
          const { className } = slide;
          if (className.includes("swiper-slide-next")) {
            swiper.slideNext();
          } else if (className.includes("swiper-slide-prev")) {
            swiper.slidePrev();
          }
        });
      }

      function resizeTextToFit() {
        const quoteEls = document.getElementsByClassName('quote');
        for (const el of quoteEls) {
          el.style.width = el.offsetWidth;
          el.style.height = el.offsetHeight;
        }
        textFit(quoteEls, { maxFontSize: 14 });
      }
      resizeTextToFit();
      addEventListener("resize", (event) => {
        resizeTextToFit();
    }); 
  </script>
  <?php require "footer.php"; ?>
</body>
</html>