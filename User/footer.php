<html>
<head>
  <style>
  a {
    text-decoration: none;
    color: inherit; 
  }
  .footer {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-around;
  flex-direction: row; 
  background-color: #f9f2e6;
  padding: 20px;
}
  
.footer::before {
  content: ""; 
  display: block;
  width: 100%;
  height: 1px; 
  margin-bottom: 10px; 
}

.shopping-section,
.information-section{
  flex: 0 1 calc(30% - 20px);
  margin: 10px;
} 


.mobile-app-section,
.Noti {
  flex: 1 1 calc(50% - 20px);
  text-align: left;
}
.mobile-app-section{
  margin-left: 40px;
}

@media only screen and (max-width: 767px) {
  .mobile-app-section {
    display: none; /* Ẩn phần mobile-app-section khi độ rộng màn hình nhỏ hơn 768px */
  }
}
@media only screen and (max-width: 768px) {
  .Noti {
    flex: 1 1 calc(100% - 20px); /* Chiếm toàn bộ chiều rộng */
    text-align: center; /* Căn giữa nội dung */
    margin-bottom: 20px; /* Thêm khoảng cách dưới cùng giữa các .Noti */
    font-size: 16px;
  }

  .Noti > * {
    margin: 10px auto; /* Căn giữa theo chiều ngang */
    display: block; /* Đảm bảo các phần tử con hiển thị dạng khối để có thể căn giữa */
  }

}



.product-categories,
.information-section,
.mobile-app-section,
.quality-guarantee,
.return-policy,
.newsletter-section {
  margin-bottom: 20px;
}

.quality-guarantee{
  margin-top: 50px;
}

.category-list ul,
.information-details ul {
  padding: 10px;
}
.category-list li,
.information-details li {
  margin-bottom: 8px;
  list-style: none;
}

.category-list li:hover,
.information-details li:hover {
    text-decoration: underline; /* Gạch chân khi hover */
    color: #FB6F92; /* Màu chữ khi hover */
}

.app-icons,
.social-icons {
  display: flex;
  margin-top: 10px;
  gap: 20px;
  margin-right: 20px;
  width: 100%;
  height: auto;
}

.contact-icon {
    width: 20px; 
    height: auto; 
    margin-right: 5px; 
    margin-top: 10px;
  }

.guarantee-content,
.return-policy-content,
.newsletter-content {
  display: flex;
  align-items: center;
}
.return-icon,
.guarantee-icon,
.return-policy-icon {
  width: 50px;
  height: auto;
  margin-right: 10px;
}

.category-title,
.information-title,
.app-title,
.return-policy-title,
.guarantee-title {
  color: #fb6f92; 
  font-family: Lora, sans-serif;
  font-weight: bold;
  margin-top: 20px;
}

.contact-title {
  color: #fb6f92; 
  font-family: Lora, sans-serif;
  font-weight: bold;
}

.return-policy-title,
.guarantee-content,
.return-policy-description,
.guarantee-description {
  margin-bottom: 10px;
}

.category-list,
.information-details,
.guarantee-content,
.return-policy-details,
.newsletter-section,
.copyright-section {
  color: #888;
  font-family: Lora, sans-serif;
}
.copyright-section {
  flex-basis: 100%;
  text-align: center;
  margin-top: 20px;
  padding-top: 10px;
  border-top: 2px solid white;
}

.Noti {
  width: 100%;
  max-width: 500px;
  margin: 10px auto;
  font-family: Lora, sans-serif;
}
.button {
  background-color:#fb6f92;
  color: white;
  border: none;
  padding: 10px 20px;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
}

.title {
  margin-bottom: 10px;
  font-size: 24px;
}

.email {
  width: 80%;
  padding: 10px;
  border: 1px solid #000000;
  margin-bottom: 20px;
  background-color: #f9f2e6;
  transition: border-color 0.3s;
  outline: none;
  margin-top: 10px;
}
.email:focus {
  border: 1px solid #fb6f92;
}
.popup-container {
  display: none;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: rgba(255, 192, 203, 0.8);
  padding: 20px;
  border-radius: 10px;
}

.popup {
  text-align: center;
}

.close-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 20px;
  cursor: pointer;
}

.check-icon {
  width: auto;
  height: 50px;
  margin-bottom: 10px;
}

.footer-line {
  border: none; 
  border-top: 2px solid #fb6f92; 
  margin: 0 0 0px 0; 
}

  @media only screen and (max-width: 768px) {

  .footer {
   flex-direction: column; /* Chuyển sang hiển thị dạng cột ở màn hình nhỏ */
  }

  .shopping-section,
  .information-section {
    margin-left: 20px;
  }
    .contact-details {
      font-size: 14px; 
    }

    .social-icon {
      width: 20px; 
      height: auto;
    }

    .footer-section {
      margin: 20px;
    }

    .title {
      font-size: 20px; 
    }
}


</style>
</head>
<body>
<hr class="footer-line">
<div class="footer">
    <div class="shopping-section">
      <div class="product-categories">
        <div class="category-header">
          <div class="category-title">ONLINE SHOPPING</div>
          <div class="category-list">
            <ul>
            <a href="product-list.php?category=C001"><li>Lắc</li></a>
            <a href="product-list.php?category=C002"><li>Mặt dây chuyền</li></a>
            <a href="product-list.php?category=C003"><li>Bông tai</li></a>
            <a href="product-list.php?category=C004"><li>Dây chuyền</li></a>
            <a href="product-list.php?category=C005"><li>Nhẫn</li></a>
            <a href="product-list.php?category=C006"><li>Phụ kiện rời</li></a>
            </ul>
        </div>      
        </div>
      </div>
    </div>
    <div class="information-section">
    <div class="information-header">
      <div class="information-title">THÔNG TIN</div>
      <div class="information-details">
        <ul>
          <a href="aboutUs.php"><li>Về Flamingo</li></a>
        </ul>
      <div class="contact-title">Liên hệ</div>
      <div class="contact-details">
            <a href="https://maps.app.goo.gl/rnHXeAdWpGF2gv7y5"><li><img loading="lazy" src="https://cdn-icons-png.freepik.com/512/3678/3678566.png" class="contact-icon"> 279 Nguyễn Tri Phương, Phường 5, Quận 10</li></a>
            <li><img loading="lazy" src="https://uxwing.com/wp-content/themes/uxwing/download/communication-chat-call/pink-phone-icon.png" class="contact-icon"> 0931104291</li>
            <li><img loading="lazy" src="https://logodix.com/logo/689225.png" class="contact-icon"> info@flamingo.com</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
    <div class="footer-section">
    <div class="app-title">Kết nối với chúng tôi</div>
        <div class="social-icons">
          <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/a83812e396b6a258d8509dc01d6ec77f5825380962dace1d1788cb0cd3dc3b15?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&" class="social-icon" />
          <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/37bd4d23db3b53ce0a5edea0fa9eb6feb87c680064b4f8c4cedb233b56d833f1?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&" class="social-icon" />
          <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/ace2ff80b4eafe06c81e5c420166ee391066b0b067faa6db13e4e18940315db1?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&" class="social-icon" />
          <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/f21335ae84e5b9cfb992f641bb654ab406167cad8733128d7c7035762c289e73?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&" class="social-icon" />
        </div>
      <div class="quality-guarantee">
        <div class="guarantee-content">
          <img style="margin-right: 10px;"
             loading="lazy" 
             src="https://cdn.builder.io/api/v1/image/assets/TEMP/ca7dc1658f2f49e5494a2a360c02134ba92fc12ec2b2d63dcd5c2558b5b530e8?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&" 
             class="guarantee-icon" />
          <div class="guarantee-text">
            <span class="guarantee-title">100% Hàng thật nguyên gốc</span>
            <br />
            <span class="guarantee-description">Toàn bộ sản phẩm</span>
          </div>
        </div>
      </div>
      <div class="return-policy">
        <div class="return-policy-content">
          <div class="return-policy-column">
            <img style="margin-right: 10px"
            loading="lazy"
            src="https://cdn.builder.io/api/v1/image/assets/TEMP/44feb6f2dbeb1a245196db586a7883cd2a7728c92aafc125e257d2a116a1d6b6?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=100 100w, https://cdn.builder.io/api/v1/image/assets/TEMP/44feb6f2dbeb1a245196db586a7883cd2a7728c92aafc125e257d2a116a1d6b6?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=200 200w, https://cdn.builder.io/api/v1/image/assets/TEMP/44feb6f2dbeb1a245196db586a7883cd2a7728c92aafc125e257d2a116a1d6b6?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=400 400w, https://cdn.builder.io/api/v1/image/assets/TEMP/44feb6f2dbeb1a245196db586a7883cd2a7728c92aafc125e257d2a116a1d6b6?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=800 800w, https://cdn.builder.io/api/v1/image/assets/TEMP/44feb6f2dbeb1a245196db586a7883cd2a7728c92aafc125e257d2a116a1d6b6?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=1200 1200w, https://cdn.builder.io/api/v1/image/assets/TEMP/44feb6f2dbeb1a245196db586a7883cd2a7728c92aafc125e257d2a116a1d6b6?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=1600 1600w, https://cdn.builder.io/api/v1/image/assets/TEMP/44feb6f2dbeb1a245196db586a7883cd2a7728c92aafc125e257d2a116a1d6b6?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&width=2000 2000w, https://cdn.builder.io/api/v1/image/assets/TEMP/44feb6f2dbeb1a245196db586a7883cd2a7728c92aafc125e257d2a116a1d6b6?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77&"
            class="return-icon"/>
            </div>
          <div class="return-policy-column">
            <div class="return-policy-details">
              <span class="return-policy-title">Đổi trả</span>
              <br />
              <span class="return-policy-description">Đổi trả miễn phí trong vòng 30 ngày</span>
            </div>
          </div>
        </div>
      </div>
      </div>
      <div class="mobile-app-section">
  <div class="app-title">Tải App flamingo</div>
      <div class="app-icons">
        <!-- Nút liên kết đến Play Store -->
        <a href="https://play.google.com/store/apps" class="app-download-link">
          <img
            loading="lazy"
            src="https://cdn.builder.io/api/v1/image/assets/TEMP/19735369f0fc4c688cb933aaebc9174062798376f0e817995defa685d9e1df29?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77"
            class="img"/>
        </a>
        
        <!-- Nút liên kết đến App Store -->
        <a href="https://www.apple.com/vn/app-store/" class="app-download-link">
          <img
            loading="lazy"
            src="https://cdn.builder.io/api/v1/image/assets/TEMP/132e4fcefd23d3cb391b25dabcb2dd68a5b23175ebdc5705a0201169ea2faff5?apiKey=bccb907b8ab04fd1b7a4acf52ff78b77"
            class="img"/>
        </a>
      </div>
    </div>
  
    <div class="Noti">
    <h1 class="title">JOIN US</h1>
    <p>NHẬN THÔNG TIN KHUYẾN MÃI HẤP DẪN</p>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="email" class="email" name="email" placeholder="Email"> <br>
        <input type="submit" class="button" name="register" value="ĐĂNG KÝ!">
    </form>
    <?php 
        require_once "db_module.php"; 
        $link = null;
        taoKetNoi($link);

        if(isset($_POST['register'])) {
            $email = $_POST['email'];
            if (!empty($email)) {
                $query = "SELECT COUNT(*) AS num_records FROM Customer";
                $result = chayTruyVanTraVeDL($link, $query);
                $row = mysqli_fetch_assoc($result);
                $num_records = $row['num_records'];
                $new_cus_id = 'CS0' . str_pad($num_records + 1, 5, '0', STR_PAD_LEFT);

                // Truy vấn SQL để thêm dữ liệu vào bảng Customer
                $sql = "INSERT INTO Customer (customerID, email) VALUES ('$new_cus_id', '$email')";
                $result = chayTruyVanKhongTraVeDL($link, $sql);
                if ($result) {
                    ?>
                    <div id="popup-container" class="popup-container">
                        <div class="popup">
                            <span class="close-btn" onclick="closePopup()">&times;</span>
                            <img src="https://static-00.iconduck.com/assets.00/checkmark-icon-512x426-8re0u9li.png" alt="Check icon" class="check-icon">
                            <p>Đăng ký nhận thông tin thành công!</p>
                        </div>
                    </div>
                    <?php
                    giaiPhongBoNho($link, $result);
                  }
            } else {
              ?>
              <div id="popup-container" class="popup-container">
                  <div class="popup">
                      <span class="close-btn" onclick="closePopup()">&times;</span>
                      <img src="https://www.svgrepo.com/show/93424/exclamation-mark-inside-a-circle.svg" alt="Check icon" class="check-icon">
                      <p>Vui lòng nhập email!</p>
                  </div>
              </div>
              <?php
            }
        }
    ?>
    </div>
    <div class="copyright-section">
      © 2024 Công Ty Cổ Phần Vàng Bạc Đá Quý Flamingo
    </div>

    </div>
  </div>
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

  </script>
</body>
</html>