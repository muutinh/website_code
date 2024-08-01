<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="product-list.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script>
            function toggleFilter(filterId) {
                const filterContent = document.getElementById(filterId);
                filterContent.classList.toggle('collapsed');
                }

            // Hàm kiểm tra URL và đánh dấu các ô checkbox tương ứng
            function checkCheckboxFromUrlParams() {
                var urlParams = new URLSearchParams(window.location.search);
                var category = urlParams.get('category');
                var subcategory = urlParams.get('subcategory');

                // Đánh dấu checkbox cho category
                if (category) {
                    $('input[name="selected_categories[]"][value="' + category + '"]').prop('checked', true);
                }

                // Đánh dấu checkbox cho subcategory
                if (subcategory) {
                    $('input[name="selected_subcategories[]"][value="' + subcategory + '"]').prop('checked', true);
                }

                // Sau khi đánh dấu các checkbox, kiểm tra nếu có checkbox được đánh dấu từ URL, thì kích hoạt sự kiện click cho nút "Áp dụng bộ lọc"
                if (category || subcategory) {
                    $('.apply-filters-button').click(); // Kích hoạt sự kiện click cho nút "Áp dụng bộ lọc"
                }
            }

            //Chọn tất cả các product có giảm giá khi user bấm nút xem tất cả bên trang index-2.php
            function checkAllDiscounts() {
                var urlParams = new URLSearchParams(window.location.search);
                var discount = urlParams.get('discount');
                console.log(discount);
                if (discount) {
                    var checkboxes = document.querySelectorAll('input[name="selected_discounts[]"]');
                    checkboxes.forEach(function(checkbox) {
                        checkbox.checked = true;
                    });
                    $('.apply-filters-button').click(); 
                }
            }

            // Áp dụng bộ lọc khi trang được tải
            $(document).ready(function() {
                checkCheckboxFromUrlParams(); 
                checkAllDiscounts();
            });
    </script>
</head>
<body>
    <?php
        require_once "db_module.php";
        $link = null;
        taoKetNoi($link);
    ?>
    <a name="top"></a>
         <!-- HEADER -->
         <?php include "header.php"; ?>
        <!-- MENU -->
        <?php include "menu.php"; ?>
        <form action="?opt=applyFilters" method="POST">
        <div class="head-content">
            <!-- Sidebar -->
            <div class="head-content__sidebar">
                <!-- Danh mục -->
                <div class="sidebar-section" style="margin-top: 50px;">
                    <button type="button" class="sidebar-title" onclick="toggleFilter('category')">- Danh mục</button>
                    <div class="filter-content collapsed" id="category">
                        
                        <?php
                        $sql = "SELECT * FROM Category"; // Truy vấn để lấy danh sách các danh mục
                        $result = chayTruyVanTraVeDL($link, $sql);
 
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<div class="form-check">';
                                echo '<input type="checkbox" class="form-check-input" id="category' . $row['categoryID'] . '" name="selected_categories[]" value="' . $row['categoryID'] . '">';
                                echo '<label class="form-check-label" for="category' . $row['categoryID'] . '">' . $row['categoryName'] . '</label>';
                                echo '</div>';
                            }
                        }
                        ?>
                          <script>
                                if (category) {
                                    $('input[name="selected_categories[]"][value="' + category + '"]').prop('checked', true);
                                }
                            </script>
                    </div>
                    <hr/>
                    <!-- Danh mục phụ -->
                    <button type="button" class="sidebar-title" onclick="toggleFilter('subcategory')">- Danh mục phụ</button>
                    <div class="filter-content collapsed" id="subcategory">
                        <?php
                        $sql = "SELECT * FROM Subcategory"; // Truy vấn để lấy danh sách các subcategory
                        $result = chayTruyVanTraVeDL($link, $sql);
 
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<div class="form-check">';
                                echo '<input class="form-check-input" type="checkbox" value="' . $row['subcategoryID'] . '" name="selected_subcategories[]" id="subcategory' . $row['subcategoryID'] . '">';
                                echo '<label class="form-check-label" for="subcategory' . $row['subcategoryID'] . '">' . $row['subcategoryName'] . '</label>';    
                                echo '</div>';
                            }
                        }
                        ?>
                    <script>
                        if (subcategory) {
                            $('input[name="selected_subcategories[]"][value="' + subcategory + '"]').prop('checked', true);
                        }
                    </script>
                    </div>
                    <hr />
                    <!-- Giảm giá -->
                    <button type="button" class="sidebar-title" onclick="toggleFilter('sale')">- Giảm giá</button>
                    <div class="filter-content collapsed" id="sale">
                        <?php
                        $sql = "SELECT distinct
                                    p.discountID,
                                    CONCAT(FORMAT(d.discountAmount * 100, 0), '%') AS discountPercentage
                                FROM
                                    product p
                                JOIN
                                    discount d ON p.discountID = d.discountID
                                WHERE
                                    d.discountID IS NOT NULL AND d.discountAmount IS NOT NULL";
 
                        $result = chayTruyVanTraVeDL($link, $sql);
 
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<div class="form-check">';
                                echo '<input class="form-check-input" type="checkbox" value="' . $row['discountID'] . '" name="selected_discounts[]" id="discount' . $row['discountID'] . '">';
                                echo '<label class="form-check-label" for="discount' . $row['discountID'] . '">' . $row['discountPercentage'] . '</label>';                                
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                    <hr />
                    <!-- Giá -->
                    <button type="button" class="sidebar-title" onclick="toggleFilter('price')">- Giá</button>
                    <div class="filter-content collapsed" id="price">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="under500" name="price_range[]" value="under500">
                                <label class="form-check-label" for="under500">Dưới 500.000</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="500to1000000" name="price_range[]" value="500to1000000">
                                <label class="form-check-label" for="500to1000000">500.000 - 1.000.000</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="1000000to1500000" name="price_range[]" value="1000000to1500000">
                                <label class="form-check-label" for="1000000to1500000">1.000.000 - 1.500.000</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="1500000to2000000" name="price_range[]" value="1500000to2000000">
                                <label class="form-check-label" for="1500000to2000000">1.500.000 - 2.000.000</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="over2000000" name="price_range[]" value="over2000000">
                                <label class="form-check-label" for="over2000000">Trên 2.000.000</label>
                            </div>              
                        </div>
                    </div>
                     </div>              
                    <hr />
                    <!-- Màu -->
                    <button type="button" class="sidebar-title" onclick="toggleFilter('color')">- Màu</button>
                    <div class="filter-content collapsed" id="color">
                        <?php
                        $sql = "SELECT distinct color FROM Product";
                        $result = chayTruyVanTraVeDL($link, $sql);
 
                        $colorCodes = array(
                            "Vàng" => "#ffd700",
                            "Bạc" => "#c0c0c0",
                            "Không" => "#ffffff"
                        );
 
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $colorCode = isset($colorCodes[$row['color']]) ? $colorCodes[$row['color']] : "#000000";
                                echo '<div>';
                                echo '<label>';
                                echo '<input type="checkbox" class="form-check-input" name="selected_colors[]" value="' . $row['color'] . '" style="margin-right: 5px;">';
                                echo '<div style="width: 20px; height: 20px; border-radius: 50%; background-color: ' . $colorCode . '; display: inline-block; margin-right: 5px;"></div>';
                                echo $row['color'];
                                echo '</label>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                    <hr />
                    <input type="hidden" name="apply_filters" id="apply_filters" value="0">
                    <div class="apply-filters-container">
                        <input type="submit" class="apply-filters-button" value="Áp dụng bộ lọc" onclick="document.getElementById('apply_filters').value = '1';">
                    </div>
                </form>
            </div>
    <!-- Hiển thị dropdown để sort-->
    <div class="head-content__product-list">
    <div class="sort-dropdown-wrapper">
        <select class="form-select" aria-label="Default select example" name="sort_order">
            <option value="p.unitPrice ASC">Giá (Tăng dần)</option>
            <option value="p.unitPrice DESC">Giá (Giảm dần)</option>
        </select>
        <select class="form-select" aria-label="Default select example" name="sort_by">
            <option value="p.productName ASC">Tên sản phẩm (A-Z)</option>
            <option value="p.productName DESC">Tên sản phẩm (Z-A)</option>
        </select>
    </div>
    <!-- Hiển thị danh sách sản phẩm -->
    <div class="product-container row d-flex flex-wrap mt-3">
        <?php  
            applyFilters();
 
        function applyFilters(){
            global $link;
            $whereClause = ''; 
            if (!empty($_SESSION['keyword'])) {
                $keyword = $_SESSION['keyword']; 
                
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
            JOIN
                subcategory sc ON p.subcategoryID = sc.subcategoryID
            JOIN
                category c ON sc.categoryID = c.categoryID
            JOIN
                discount d ON p.discountID = d.discountID
            WHERE p.productName LIKE '%$keyword%' AND p.status = 'Còn hàng'";
                    $result = chayTruyVanTraVeDL($link, $sql);

            $num_found = mysqli_num_rows($result);
            echo "<div style='margin-top: 20px;'>
                    <p>Tìm thấy $num_found sản phẩm</p>
                </div>";

                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>        
                            <a href="product.php?product_id=<?php echo $row['productID']; ?>" class="product-info d-block" style="text-decoration: none; color: inherit;">
                                <?php if (!empty($row['discountPercentage'])) { ?>
                                    <div class="product-discount"><?php echo $row['discountPercentage']; ?></div>
                                <?php } ?>
                                <img src="<?php echo $row['image']; ?>" alt="" />
                                <div class="product-content">
                                    <p class="text-center product-title"><?php echo $row['productName']; ?></p>
                                    <p class="text-center product-desc"><?php echo $row['subcategoryName'] . ' | ' . $row['categoryName']; ?></p>
                                    <p class="text-center product-price"><?php echo $row['formattedUnitPrice']; ?></p>
                                </div>
                            </a>
                                    <?php
            } 
            unset($_SESSION['keyword']); // Xoá keyword khỏi session khi ko còn sử dụng
        }

            else {
            $apply_filters = isset($_POST['apply_filters']) ? $_POST['apply_filters'] : '0';
            if ($apply_filters == '0') {
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
                        JOIN
                            subcategory sc ON p.subcategoryID = sc.subcategoryID
                        JOIN
                            category c ON sc.categoryID = c.categoryID
                        JOIN    
                            discount d ON p.discountID = d.discountID
                        WHERE
                          p.status = 'Còn hàng'";
              $result = chayTruyVanTraVeDL($link, $sql);
          } else {
            // Thu thập các giá trị bộ lọc từ người dùng
            $selectedCategories = isset($_POST['selected_categories']) ? $_POST['selected_categories'] : [];
            $selectedSubcategories = isset($_POST['selected_subcategories']) ? $_POST['selected_subcategories'] : [];
            $selectedDiscounts = isset($_POST['selected_discounts']) ? $_POST['selected_discounts'] : [];
            $selectedColors = isset($_POST['selected_colors']) ? $_POST['selected_colors'] : [];
           
            // Xây dựng điều kiện WHERE cho câu truy vấn SQL
            $whereClause = '';
 
            // Xây dựng điều kiện WHERE cho các bộ lọc category, subcategory, discount và color
            if (!empty($selectedCategories)) {
                $whereClause .= " AND sc.categoryID IN ('" . implode("','", $selectedCategories) . "')";
            }
            if (!empty($selectedSubcategories)) {
                $whereClause .= " AND p.subcategoryID IN ('" . implode("','", $selectedSubcategories) . "')";
            }
            if (!empty($selectedDiscounts)) {
                $whereClause .= " AND p.discountID IN ('" . implode("','", $selectedDiscounts) . "')";
            }
            if (!empty($selectedColors)) {
                $whereClause .= " AND color IN ('" . implode("','", $selectedColors) . "')";
            }
 
            // Xây dựng điều kiện WHERE cho bộ lọc giá
            if (isset($_POST['price_range'])) {
                $priceRanges = $_POST['price_range'];
 
                foreach ($priceRanges as $range) {
                    switch ($range) {
                        case 'under500':
                            $whereClause .= " AND (p.unitPrice < 500000)";
                            break;
                        case '500to1000000':
                            $whereClause .= " AND (p.unitPrice >= 500000 AND p.unitPrice < 1000000)";
                            break;
                        case '1000000to1500000':
                            $whereClause .= " AND (p.unitPrice >= 1000000 AND p.unitPrice < 1500000)";
                            break;
                        case '1500000to2000000':
                            $whereClause .= " AND (p.unitPrice >= 1500000 AND p.unitPrice < 2000000)";
                            break;
                        case 'over2000000':
                            $whereClause .= " AND (p.unitPrice >= 2000000)";
                            break;
                        default:
                            break;
                    }
                }
            }
 
            // Loại bỏ phần "OR" đầu tiên nếu có
            $whereClause = ltrim($whereClause, ' OR');
            $sortOrder = isset($_POST['sort_order']) ? $_POST['sort_order'] : 'p.unitPrice';
            $sortBy = isset($_POST['sort_by']) ? $_POST['sort_by'] : 'p.productName';
            // Xây dựng câu truy vấn SQL với điều kiện WHERE được xây dựng từ form
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
            JOIN
                subcategory sc ON p.subcategoryID = sc.subcategoryID
            JOIN
                category c ON sc.categoryID = c.categoryID
            JOIN
                discount d ON p.discountID = d.discountID
            WHERE
            1=1
            $whereClause
            AND p.status = 'Còn hàng'
            ORDER BY $sortOrder, $sortBy";
            $result = chayTruyVanTraVeDL($link, $sql);
           
          }
 
            $sql = "SELECT
                        COUNT(*) AS num_items
                    FROM
                        product p
                    JOIN
                        subcategory sc ON p.subcategoryID = sc.subcategoryID
                    JOIN
                        category c ON sc.categoryID = c.categoryID
                    JOIN
                        discount d ON p.discountID = d.discountID
                    WHERE
                        1=1
                        $whereClause
                        AND p.status = 'Còn hàng'";
            $result_count = chayTruyVanTraVeDL($link, $sql);
            $row_count = mysqli_fetch_assoc($result_count);
            $num_items = $row_count['num_items'];
          ?>
            <div style="margin-top: 20px;">
                <p>    
                    Tìm thấy <?php echo $num_items; ?> sản phẩm
                </p>
            </div>
 
            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>        
                    <a href="product.php?product_id=<?php echo $row['productID']; ?>" class="product-info d-block" style="text-decoration: none; color: inherit;">
                        <?php if (!empty($row['discountPercentage'])) { ?>
                            <div class="product-discount"><?php echo $row['discountPercentage']; ?></div>
                        <?php } ?>
                        <img src="<?php echo $row['image']; ?>" alt="" />
                        <div class="product-content">
                            <p class="text-center  product-title"><?php echo $row['productName']; ?></p>
                            <p class="text-center product-desc"><?php echo $row['subcategoryName'] . ' | ' . $row['categoryName']; ?></p>
                            <p class="text-center product-price"><?php echo $row['formattedUnitPrice']; ?></p>
                        </div>
                    </a>
                    <?php
                }
            }
          }
        }
          giaiPhongBoNho($link, $result)
            ?>  
    </div>
    <a href="#top" id="back-to-top" class="back-to-top-btn" title="Go to top">↑</a>
    </div>
</div>
<?php require "footer.php"; ?>
<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>