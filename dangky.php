<?php
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
                        header("Location: ?page=login");
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
                        <h5>Bạn đã có tài khoản? <a href="?page=login">Đăng nhập</a></h5>
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

</body>

</html>