
<?php
if (isset($_POST['submit-login'])) {
    $input_email = $_POST['input_email'];
    $input_password = $_POST['input_password'];

    $check_email_customer = "SELECT * FROM `khachhang` WHERE Email = '$input_email'";
    $result_email_customer = mysqli_query($conn, $check_email_customer);

    if ($result_email_customer) {
        if (mysqli_num_rows($result_email_customer) > 0) {
            $row = mysqli_fetch_assoc($result_email_customer);
            $hashedPassword = $row['Password'];

            if (password_verify($input_password, $hashedPassword)) {
                $_SESSION['loggedin_customer'] = true; // Lưu trạng thái đăng nhập
                // if (!isset($_SESSION['cart'][$row['MaKH']])) {
                //     $_SESSION['cart'][$row['MaKH']] = array();
                // }
                $_SESSION['IDKH'] = $row['IDKH'];
                header("Location: index.php");
            } else {
                $msg = "Mật khẩu không đúng";
            }
        } else {
            $msg = "Tài khoản không tồn tại";
        }
    } else {
        echo "Lỗi truy vấn: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="zxx">


<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Normal Breadcrumb Begin -->
    <section class="normal-breadcrumb set-bg" data-setbg="img/normal-breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="normal__breadcrumb__text">
                        <h2>ĐĂNG NHẬP</h2>
                        <p>ALL ROADS LEAD TO ME.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->

    <!-- Login Section Begin -->
    <section class="login spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login__form">
                        <h3>Đăng nhập</h3>
                        <form action="#" method="post">
                            <div class="input__item">
                                <input type="text" placeholder="Email" name="input_email" required value="<?php
                                if (isset($input_email))
                                    echo $input_email;
                                ?>">>
                                <span class="icon_mail"></span>
                            </div>
                            <div class="input__item">
                                <input type="password" placeholder="Mật khẩu" name="input_password" required>
                                <span class="icon_lock"></span>
                            </div>
                            <button type="submit" name="submit-login" class="site-btn">ĐĂNG NHẬP</button>
                        </form>
                        <a href="?page=quenmatkhau" class="forget_pass">Bạn quên mật khẩu?</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login__register">
                        <h3>BẠN CHƯA CÓ TÀI KHOẢN?</h3>
                        <a href="?page=dangky" class="primary-btn">ĐĂNG KÝ TẠI ĐÂY</a>
                    </div>
                </div>
            </div>
            <div class="login__social">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-6">
                        <div class="login__social__links">
                            <span>or</span>
                            <ul>
                                <li><a href="#" class="facebook"><i class="fa fa-facebook"></i> Sign in With
                                        Facebook</a></li>
                                <li><a href="#" class="google"><i class="fa fa-google"></i> Sign in With Google</a></li>
                                <li><a href="#" class="twitter"><i class="fa fa-twitter"></i> Sign in With Twitter</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Login Section End -->

    <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch"><i class="icon_close"></i></div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>

</body>

</html>