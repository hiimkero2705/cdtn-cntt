<?php

include 'assets/connect.php';
if (isset($_POST['submit-register'])) {

    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $options = [
        'cost' => 12,
    ];

    //========= TẠO MÃ KHÁCH HÀNG TỰ ĐỘNG ==============
    $sql_max_MaKH = "SELECT MAX(CAST(SUBSTRING(IDKH,  3) AS SIGNED)) AS max_IDKH FROM khachhang WHERE IDKH LIKE 'KH%';";
    $result_max_MaKH = $conn->query($sql_max_MaKH);

    $row = $result_max_MaKH->fetch_assoc();
    $max_maKH = $row["max_IDKH"]; //Tìm mã khách hàng lớn nhất
    $next_maKH = "KH" . str_pad($max_maKH + 1, 3, '0', STR_PAD_LEFT); //Tạo mã khách hàng tiếp theo dựa trên mã khách hàng lớn nhất đã tìm

    //========= TIẾN HÀNH THỰC HIỆN ĐĂNG KÝ ===========
    if (preg_match("/^[a-zA-Z0-9.-_]+@[a-zA-Z]+\.[a-zA-Z]{2,}$/", $email)) { //Kiểm tra email có hợp lệ không
        if (preg_match("/^(?=.*[A-Z])(?=.*[a-z]).{8,}$/", $password)) { //Kiểm tra password có hợp lệ không
            if ($password == $confirm_password) {
                $emailAlready = "SELECT * FROM `khachhang` WHERE Email = '$email'"; //Check email đã tồn tại chưa
                $result = mysqli_query($conn, $emailAlready);

                if (mysqli_num_rows($result) > 0) {
                    $msg = "Email đã tồn tại";
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT, $options);
                    $sql = "INSERT INTO `khachhang`(`IDKH`, `TenKH`, `Email`, `Password`) 
                        VALUES ('$next_maKH','$full_name','$email','$hashedPassword')"; //Chèn thông tin khách hàng
                    if (mysqli_query($conn, $sql)) {
                        $msg = "Đăng ký thành công!";
                        header("Location: login.php");
                    } else {
                        $msg = "Lỗi" . mysqli_error($conn);
                    }
                }
            } else {
                $msg = "Mật khẩu không khớp";
            }
        } else {
            $msg = "Mật khẩu không hợp lệ";
        }
    } else {
        $msg = "Email không hợp lệ";
    }
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Anime Template">
    <meta name="keywords" content="Anime, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Anime | Template</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/plyr.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header__logo">
                        <a href="./index.php">
                            <img src="img/logo.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="header__nav">
                        <nav class="header__menu mobile-menu">
                            <ul>
                                <li class="active"><a href="./index.php">Trang chủ</a></li>
                                <li><a href="./categories.html">Góc Điện Ảnh <span class="arrow_carrot-down"></span></a>
                                    <ul class="dropdown">
                                        <li><a href="./categories.php">Đang công chiếu</a></li>
                                        <li><a href="./anime-watching.php">Anime Watching</a></li>
                                        <li><a href="./blog-details.php">Blog Details</a></li>
                                        <li><a href="./login.php">Đăng Nhập</a></li>
                                    </ul>
                                </li>
                                <li><a href="./blog.php">Our Blog</a></li>
                                <li><a href="#">Contacts</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="header__right">
                        <a href="#" class="search-switch"><span class="icon_search"></span></a>
                        <a href="./login.php"><span class="icon_profile"></span></a>
                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Normal Breadcrumb Begin -->
    <section class="normal-breadcrumb set-bg" data-setbg="img/normal-breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="normal__breadcrumb__text">
                        <h2>ĐĂNG KÝ</h2>
                        <p>ALL ROADS LEAD TO ME.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->

    <!-- Signup Section Begin -->
    <section class="signup spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login__form">
                        <h3>ĐĂNG KÝ</h3>
                        <?php
                        if (isset($msg))
                            echo $msg;
                        ?>
                        <form method="post">
                            <div class="input__item">
                                <input type="text" placeholder="Địa chỉ email" name="email" required>
                                <span class="icon_mail"></span>
                            </div>
                            <div class="input__item">
                                <input type="text" placeholder="Họ và tên" name="full_name" required>
                                <span class="icon_profile"></span>
                            </div>
                            <div class="input__item">
                                <input type="text" placeholder="Mật khẩu" name="password" required>
                                <span class="icon_lock"></span>
                            </div>
                            <div class="input__item">
                                <input type="text" placeholder="Nhập lại mật khẩu" name="confirm_password" required>
                                <span class="icon_lock"></span>
                            </div>
                            <button type="submit" name="submit-register" class="site-btn">ĐĂNG KÝ</button>
                        </form>
                        <h5>Bạn đã có tài khoản? <a href="#">Đăng nhập</a></h5>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login__social__links">
                        <h3>Login With:</h3>
                        <ul>
                            <li><a href="#" class="facebook"><i class="fa fa-facebook"></i> Sign in With Facebook</a>
                            </li>
                            <li><a href="#" class="google"><i class="fa fa-google"></i> Sign in With Google</a></li>
                            <li><a href="#" class="twitter"><i class="fa fa-twitter"></i> Sign in With Twitter</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Signup Section End -->

    <!-- Footer Section Begin -->
    <footer class="footer">
        <div class="page-up">
            <a href="#" id="scrollToTopButton"><span class="arrow_carrot-up"></span></a>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="footer__logo">
                        <a href="./index.html"><img src="img/logo.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="footer__nav">
                        <ul>
                            <li class="active"><a href="./index.php">Homepage</a></li>
                            <li><a href="./categories.php">Categories</a></li>
                            <li><a href="./blog.php">Our Blog</a></li>
                            <li><a href="#">Contacts</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;
                        <script>document.write(new Date().getFullYear());</script> All rights reserved | This template
                        is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com"
                            target="_blank">Colorlib</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>

                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch"><i class="icon_close"></i></div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search model end -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/player.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>