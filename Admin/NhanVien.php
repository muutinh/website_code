<head>
    <link rel="stylesheet" type="text/css" href="form.css" />
    <style>
    table {
            width: 100%;
            border-collapse: collapse;
        }
            #toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            margin: 2% 0;
            flex-wrap: wrap;
            margin-top: 20px;
        }
          /* Thêm CSS cho dòng đầu tiên */
          .pink-row th {
            background-color: #FFC0CB; /* Màu hồng */
        }
        th, td {
            border: 1px solid black;
            text-align: center;
            padding: 5px 7px;
            font-size: 12.5px; /* Giảm kích thước chữ */
            font-family: 'Barlow', sans-serif;
        }
        input[type="text"] {
            padding: 8px;
            margin-bottom: 10px;
            width: 200px;
        }
    button, .add-nv-container {
        height: 40px; 
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 20px;
        margin: 5px;
    }

    button {
        cursor: pointer;
        border-radius: 5px;
        border: none; 
        background-color: #DF8A8A;
        color: black; 
    }

    .add-nv-container {
        background-color: #DF8A8A; /* Màu nền cho container */
        border-radius: 5px; /* Bo tròn góc */
        text-decoration: none; /* Xóa gạch chân của liên kết */
    }
    .form-container{
        margin-top: 10%;
    }

    .add-nv-container img {
        height: 20px; /* Điều chỉnh kích thước ảnh */
        margin-right: 5px; /* Khoảng cách giữa ảnh và chữ */
    }

        #search {
            display: flex;
            justify-content: center; 
            align-items: center; 
            padding: 20px;
            margin-top: 50px; 
            text-align: center;
            margin-top: 60px;
        }
    </style>
    <script type=text/JavaScript>
    function confirmDel() {
        if (confirm('Bạn có chắc chắn muốn xóa nhân viên này?')) {
            return true;
        } else {
            return false;
        }
    }

    function resetForm() {
    document.querySelector("form").reset();
}


    function hideToolBar() {
    document.getElementById("toolbar").style.display = "none";
    }

    function Search(){
        let valueSearchInput = document.getElementById("searchInput").value;
        window.location.href = '?opt=view_NV&search=' + encodeURIComponent(valueSearchInput);
    }
    
    function ValidateForm() {
 // Lấy giá trị từ các trường trong form
    var manv = document.formNV.employeeid.value;
    var hoten = document.formNV.hoten.value;
    var ngaysinh = document.formNV.ngaysinh.value;
    var sodienthoai = document.formNV.sodienthoai.value;
    var email = document.formNV.email.value;
    var diachi = document.formNV.diachi.value;

    // Kiểm tra mã nhân viên không được để trống và theo định dạng NVXXX
    if (manv == "" || !manv.match(/^NV\d{3}$/)) {
        alert("Mã nhân viên không hợp lệ. Mã nhân viên không được để trống và phải theo định dạng NVXXX, với XXX là các số.");
        return false;
    }

    // Kiểm tra họ tên không được để trống
    if (hoten.trim() == "") {
        alert("Họ tên không được để trống.");
        return false;
    }

    // Kiểm tra ngày sinh không được để trống
    if (ngaysinh == "") {
        alert("Ngày sinh không được để trống.");
        return false;
    }

    // Kiểm tra số điện thoại không được để trống và phải là 10 chữ số, bắt đầu bằng số 0
    if (sodienthoai == "" || !sodienthoai.match(/^0[0-9]{9}$/)) {
        alert("Số điện thoại không hợp lệ. Số điện thoại phải là 10 chữ số và bắt đầu bằng số 0.");
        return false;
    }

    // Kiểm tra email không được để trống và phải theo định dạng email
    if (email == "" || !email.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)) {
        alert("Email không hợp lệ.");
        return false;
    }

    // Kiểm tra địa chỉ không được để trống
    if (diachi.trim() == "") {
        alert("Địa chỉ không được để trống.");
        return false;
    }
    // Nếu tất cả các điều kiện kiểm tra đều được thoả mãn
    return true; // Cho phép form được submit
}

</script>
</head>

<body>
    <div id="content">
        <div id="toolbar">
            <!-- Khối chứa tra cứu và thêm nhân viên -->
            <div id="search">
            <input type="text" id="searchInput" placeholder="Nhập từ khóa...">
            <button onclick="Search()">Tìm nhân viên</button>
            <button onclick="window.location.href='?opt=add_NV'">
                <p class="add-nv-text">Thêm nhân viên</p>
            </button>

            </div>
        </div>

        <?php

        //Tạo kết nối vào CSDL
        require_once ("db_module.php");
        function kiemTraMaNhanVien($link, $manv)
        {
            $sql = "SELECT COUNT(*) AS soLuong FROM employee WHERE employeeID = '$manv'";
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_assoc($result);
            if ($row['soLuong'] > 0) {
                return true;
            } else {
                return false;
            }
        }

        function view_NV()
        {
            $link = null;
            taoKetNoi($link);
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            //Kết nối và lấy dữ liệu từ CSDL
            $searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

            $sql = "SELECT employeeID, name, DATE_FORMAT(dateOfBirth, '%d/%m/%Y') as formattedDateOfBirth, phoneNum, email, address, gender, position, shiftTime FROM employee WHERE 1";

            if (!empty($search)) {
                $sql .= " AND (employeeID LIKE '%$search%' OR 
                                name LIKE '%$search%' 
                                OR dateOfBirth LIKE '%$search%'
                                OR phoneNum LIKE '%$search%'
                                OR email LIKE '%$search%'
                                OR address LIKE '%$search%'
                                OR gender LIKE '%$search%'
                                OR position LIKE '%$search%'
                                OR shiftTime LIKE '%$search%')";
            }

            $result = chayTruyVanTraVeDL($link, $sql);

            echo "<table width='100%' cellspacing='5' cellpadding='5' border='1' style='margin-bottom: 3%;margin-top: 2%' >";
            echo "<tr class='pink-row'>"; 
            echo "<th>Mã nhân viên</th>";
            echo "<th>Họ tên</th>";
            echo "<th>Ngày sinh</th>";
            echo "<th>SĐT</th>";
            echo "<th>email</th>";
            echo "<th>Địa chỉ</th>";
            echo "<th>Giới tính</th>";
            echo "<th>Vị trí</th>";
            echo "<th>Ca làm việc</th>";
            echo "<th>Thao tác</th>";
            echo "</tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["employeeID"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["formattedDateOfBirth"] . "</td>";
                echo "<td>" . $row["phoneNum"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["address"] . "</td>";
                echo "<td>" . $row["gender"] . "</td>";
                echo "<td>" . $row["position"] . "</td>";
                echo "<td>" . $row["shiftTime"] . "</td>";
                echo "<td><a href='?opt=edit_NV&employeeID=" . $row["employeeID"] . "'><img src='Picture/Group 17.png' alt='Sửa' style='width: 20px; height: 20px;'></a> <a href='?opt=del_NV&employeeID=" . $row["employeeID"] . "' onclick='return confirmDel()'><img src='Picture/Group 18.png' alt='Xóa' style='width: 20px; height: 20px;'></a></td>";
                echo "</tr>";
            }

            echo "</table>";
            giaiPhongBoNho($link, $result);
        }

        function add_NV()
        {
            $link = null;
            taoKetNoi($link);
            ?>
            <div class="form-container" id="ThemNV">
                <form action="?opt=add_NV" method="post" enctype="multipart/form-data">
                    Mã nhân viên: <input type="text" name="manv"
                        value="<?php echo isset($_POST['manv']) ? htmlspecialchars($_POST['manv']) : ''; ?>">
                    Họ tên: <input type="text" name="hoten"
                        value="<?php echo isset($_POST['hoten']) ? htmlspecialchars($_POST['hoten']) : ''; ?>">
                    Ngày sinh: <input type="date" name="ngaysinh"
                        value="<?php echo isset($_POST['ngaysinh']) ? $_POST['ngaysinh'] : ''; ?>">
                    Số điện thoại: <input type="text" name="sdt"
                        value="<?php echo isset($_POST['sdt']) ? htmlspecialchars($_POST['sdt']) : ''; ?>">
                    Email: <input type="email" name="email"
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    Địa chỉ: <input type="text" name="diachi"
                        value="<?php echo isset($_POST['diachi']) ? htmlspecialchars($_POST['diachi']) : ''; ?>">
                    Giới tính:
                    <select name="gioitinh">
                        <option value="M" <?php echo (isset($_POST['gioitinh']) && $_POST['gioitinh'] == 'M') ? 'selected' : ''; ?>>Nam</option>
                        <option value="F" <?php echo (isset($_POST['gioitinh']) && $_POST['gioitinh'] == 'F') ? 'selected' : ''; ?>>Nữ</option>
                    </select>

                    Vị trí:
                    <select name="vitri">
                        <option value="Sale" <?php echo (isset($_POST['vitri']) && $_POST['vitri'] == 'Sale') ? 'selected' : ''; ?>>Sale</option>
                        <option value="Quản lý" <?php echo (isset($_POST['vitri']) && $_POST['vitri'] == 'Quản lý') ? 'selected' : ''; ?>>Quản lý</option>
                        <option value="Marketing" <?php echo (isset($_POST['vitri']) && $_POST['vitri'] == 'Marketing') ? 'selected' : ''; ?>>Marketing</option>
                        <option value="HR" <?php echo (isset($_POST['vitri']) && $_POST['vitri'] == 'HR') ? 'selected' : ''; ?>>HR</option>
                    </select>

                    Ca làm:
                    <select name="calam">
                        <option value="S01" <?php echo (isset($_POST['calam']) && $_POST['calam'] == 'S01') ? 'selected' : ''; ?>>S01</option>
                        <option value="S02" <?php echo (isset($_POST['calam']) && $_POST['calam'] == 'S02') ? 'selected' : ''; ?>>S02</option>
                        <option value="S03" <?php echo (isset($_POST['calam']) && $_POST['calam'] == 'S03') ? 'selected' : ''; ?>>S03</option>
                    </select>

                    <div class="form-buttons">
                        <input type="submit" value="Lưu">
                        <input type="reset" value="Nhập lại">
                        <button type="button" onclick="window.location.href='QLNV.php?opt=view_NV';">Quay lại</button>
                    </div>
                </form>
            </div>
            <?php
            if (!empty($_POST)) {
                // Lấy và xử lý dữ liệu từ form
                $_manv = isset($_POST["manv"]) ? trim($_POST["manv"]) : '';
                $_hoten = isset($_POST["hoten"]) ? trim($_POST["hoten"]) : '';
                $_birthday = isset($_POST["ngaysinh"]) ? trim($_POST["ngaysinh"]) : '';
                $_sdt = isset($_POST["sdt"]) ? trim($_POST["sdt"]) : '';
                $_email = isset($_POST["email"]) ? trim($_POST["email"]) : '';
                $_address = isset($_POST["diachi"]) ? trim($_POST["diachi"]) : '';
                $_gender = isset($_POST["gioitinh"]) ? trim($_POST["gioitinh"]) : '';
                $_position = isset($_POST["vitri"]) ? trim($_POST["vitri"]) : '';
                $_shift = isset($_POST["calam"]) ? trim($_POST["calam"]) : '';

                // Kiểm tra xem tất cả các trường đã được nhập chưa
                if (empty($_manv) || empty($_hoten) || empty($_birthday) || empty($_sdt) || empty($_email) || empty($_address) || empty($_gender) || empty($_position) || empty($_shift)) {
                    echo "<script>alert('Vui lòng nhập đầy đủ thông tin.');</script>";
                    return; // Dừng xử lý nếu có trường nào đó bỏ trống
                }

                // Kiểm tra định dạng mã nhân viên
                if (!preg_match('/^NV\d{3}$/', $_manv)) {
                    echo "<script>alert('Mã nhân viên phải theo định dạng NVXXX, với XXX là các số.');</script>";
                    return;
                }

                // Kiểm tra mã nhân viên có tồn tại chưa
                if (kiemTraMaNhanVien($link, $_manv)) {
                    echo "<script>alert('Mã nhân viên đã tồn tại, vui lòng nhập mã khác');</script>";
                    return;
                }

                // Kiểm tra định dạng số điện thoại
                if (!preg_match('/^0[0-9]{9}$/', $_sdt)) {
                    echo "<script>alert('Số điện thoại phải gồm 10 chữ số và bắt đầu bằng số 0.');</script>";
                    return;
                }

                // Thêm dữ liệu vào cơ sở dữ liệu
                $sql = "INSERT INTO employee (employeeID, name, dateOfBirth, phoneNum, email, address, gender, position, shiftTime)
                        VALUES ('$_manv', '$_hoten', '$_birthday', '$_sdt', '$_email', '$_address', '$_gender', '$_position', '$_shift')";

                $rs = chayTruyVanKhongTraVeDL($link, $sql);

                // Tạo mật khẩu ngẫu nhiên
                // hàm tạo password
                function generateRandomPassword($length = 8)
                {
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randomPassword = '';
                    for ($i = 0; $i < $length; $i++) {
                        $randomPassword .= $characters[rand(0, $charactersLength - 1)];
                    }
                    return $randomPassword;
                }

                $password = generateRandomPassword(8); // Gọi hàm tạo mật khẩu ngẫu nhiên
        
                // Thêm vào bảng staffaccount
                $sql_account = "INSERT INTO staffaccount (employeeID, password) VALUES ('$_manv', '$password')";
                $result_account = chayTruyVanKhongTraVeDL($link, $sql_account);

                if ($rs) {
                    echo "<script>alert('Thêm nhân viên thành công');</script>";
                    echo "<script>window.location.href='QLNV.php?opt=add_NV';</script>";
                } else {
                    echo "<script>alert('Có lỗi xảy ra, không thể thêm nhân viên');</script>";
                    return;
                }
            }
        }


        function edit_NV()
        {
            $link = null;
            taoKetNoi($link);
            if (isset($_GET["employeeID"])) {
                $_employeeid = $_GET["employeeID"];

                $sql = "SELECT * FROM employee WHERE employeeID='" . $_employeeid . "'";

                $result = chayTruyVanTraVeDL($link, $sql);
                //Lấy dữ liệu từ trong db ra
                if ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="form-container">
                        <form name="formNV" action="?opt=update_NV" method="post" enctype="multipart/form-data"
                            onsubmit="return ValidateForm()">
                            Mã nhân viên: <input type="text" name="employeeid" readonly
                                value="<?php echo $row["employeeID"]; ?>"><br>
                            Họ tên: <input type="text" name="hoten" value="<?php echo $row["name"]; ?>"><br>
                            Ngày sinh: <input type="date" name="ngaysinh" value="<?php echo $row["dateOfBirth"]; ?>"><br>
                            Số điện thoại: <input type="text" name="sodienthoai" value="<?php echo $row["phoneNum"]; ?>"><br>
                            Email: <input type="email" name="email" value="<?php echo $row["email"]; ?>"><br>
                            Địa chỉ: <input type="text" name="diachi" value="<?php echo $row["address"]; ?>"><br>
                            Giới tính: <select name="gioitinh">
                                <option value="M" <?php echo ($row["gender"] == "M" ? "selected" : ""); ?>>Nam</option>
                                <option value="F" <?php echo ($row["gender"] == "F" ? "selected" : ""); ?>>Nữ</option>
                            </select><br>
                            Vị trí: <select name="vitri">
                                <option value="Sale" <?php echo ($row["position"] == "Sale" ? "selected" : ""); ?>>Sale</option>
                                <option value="Quản lý" <?php echo ($row["position"] == "Quản lý" ? "selected" : ""); ?>>Quản lý
                                </option>
                                <option value="Marketing" <?php echo ($row["position"] == "Marketing" ? "selected" : ""); ?>>Marketing
                                </option>
                                <option value="HR" <?php echo ($row["position"] == "HR" ? "selected" : ""); ?>>HR</option>
                            </select><br>
                            Ca làm: <select name="calam">
                                <option value="S01" <?php echo ($row["shiftTime"] == "S01" ? "selected" : ""); ?>>S01</option>
                                <option value="S02" <?php echo ($row["shiftTime"] == "S02" ? "selected" : ""); ?>>S02</option>
                                <option value="S03" <?php echo ($row["shiftTime"] == "S03" ? "selected" : ""); ?>>S03</option>
                            </select>
                            <div class="form-buttons">
                                <input type="submit" value="Cập nhật">
                                <input type="reset" value="Nhập lại">
                                <button type="button" onclick="window.location.href='QLNV.php?opt=view_NV';">Quay lại</button>
                            </div>
                        </form>
                    </div>
                    <?php
                }
            }
        }


        function del_NV()
        {
            $link = null;
            taoKetNoi($link);

            if (isset($_GET["employeeID"])) {
                $_employeeid = $_GET["employeeID"];

                chayTruyVanKhongTraVeDL($link, "DELETE FROM staffaccount WHERE employeeID='" . $_employeeid . "'");
                chayTruyVanKhongTraVeDL($link, "UPDATE financialreport SET employeeID = NULL WHERE employeeID ='" . $_employeeid . "'");
                $sql = "DELETE FROM employee WHERE employeeID='" . $_employeeid . "'";

                $result = chayTruyVanKhongTraVeDL($link, $sql);
                if ($result) {
                    echo "<script>alert('Xóa nhân viên thành công');</script>";
                    echo "<script>window.location.href='QLNV.php?opt=view_NV';</script>";
                } else {
                    echo "<script>alert('Xóa nhân viên thất bại');</script>";
                    echo "<script>window.location.href='QLNV.php?opt=view_NV';</script>";
                }
            }
        }



        function update_NV()
        {
            $link = null;
            taoKetNoi($link);


            //Kiểm tra có phương thức POST gửi lên hay không
            if (isset($_POST)) {
                $_employeeid = $_POST["employeeid"];
                $_name = $_POST["hoten"];
                $_birthday = $_POST["ngaysinh"];
                $_phonenum = $_POST["sodienthoai"];
                $_email = $_POST["email"];
                $_address = $_POST["diachi"];
                $_gender = $_POST["gioitinh"];
                $_position = $_POST["vitri"];
                $_shift = $_POST["calam"];

                $sql = "UPDATE employee SET name = '$_name', dateOfBirth = '$_birthday', phoneNum = '$_phonenum', email = '$_email',
             address = '$_address', gender = '$_gender', position = '$_position', 
             shiftTime = '$_shift' WHERE employeeID = '$_employeeid'";

                //echo $sql;
                if ($_employeeid != "") {
                    $rs = chayTruyVanKhongTraVeDL($link, $sql);
                    //Kiểm tra insert
                    if ($rs) {
                        echo "<script>alert('Cập nhật thành công');</script>";
                        echo "<script>window.location.href='QLNV.php?opt=view_NV';</script>";
                    } else {
                        echo "<script>alert('Cập nhật thất bại');</script>";
                        echo "<script>window.location.href='QLNV.php?opt=view_NV';</script>";
                    }
                }

            }
            giaiPhongBoNho($link, $rs);
        }

        if (isset($_GET["opt"])) {
            $_opt = $_GET["opt"];
        } else {
            $_opt = "";
        }


        switch ($_opt) {
            case "add_NV":
                add_NV();
                break;
            case "edit_NV":
                edit_NV();
                break;
            case "del_NV":
                del_NV();
                break;
            case "update_NV":
                update_NV();
                break;
            default:
                view_NV();
        }

        if (in_array($_opt, ["add_NV", "edit_NV"])) {
            echo "<script>hideToolBar();</script>";
        }

        
        ?>
    </div>
</body>