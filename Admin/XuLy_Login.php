<?php
    session_start(); 
    require_once ("db_module.php");
    $link = null;
    taoKetNoi($link);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM staffaccount WHERE employeeID = ? AND password = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $username, $password);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) > 0) {
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $username;

                    header("Location: Khung.php");
                    exit();
                } else {
                    
                    echo "<script>alert('Thông tin đăng nhập không đúng'); window.location.href='login.php';</script>";
                    exit(); 
                }
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "<script>alert('SQL statement failed to prepare.'); window.location.href='login.php';</script>";
            exit();
        }
    }

