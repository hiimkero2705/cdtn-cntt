<?php
if (!isset ($_SESSION['loggedin_customer'])) {
    header('Location: ?page=login');
}

if (isset ($_SESSION['loggedin_customer'])) {
    $sql = "SELECT * FROM khachhang WHERE IDKH = '" . $_SESSION['IDKH'] . "'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $info = mysqli_fetch_assoc($result);
        if (isset($_POST['doimk'])) { // Change to POST meth
            $old_password = $_POST['matkhaucu'];
            $new_password = $_POST['matkhaumoi'];
            $confirm_password = $_POST['nhaplaimk'];

            $options = [
                'cost' => 12,
            ];
            if (preg_match("/^(?=.*[A-Z])(?=.*[a-z]).{8,}$/", $new_password)) {
                if (password_verify($old_password, $info['Password'])) {
                    if ($new_password === $confirm_password) {
                        // Hash the new password
                        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT, $options);

                        // Update the password in the database
                        $update_sql = "UPDATE khachhang SET Password = ? WHERE IDKH = ?";
                        $update_statement = mysqli_prepare($conn, $update_sql);
                        mysqli_stmt_bind_param($update_statement, "ss", $hashed_password, $_SESSION['IDKH']);
                        $update_result = mysqli_stmt_execute($update_statement);


                        if ($update_result) {
                            $msg = "Đổi mật khẩu thành công.";
                        } else {
                            $msg = "Đổi mật khẩu thất bại : " . mysqli_error($conn);
                        }
                    } else {
                        $msg = "Mật khẩu không khớp";
                    }
                } else {
                    $msg = "Mật khẩu hiện tại không chính xác.";
                }
            } else {
                $msg = "Mật khẩu mới phải chứa ít nhất 1 ký tự viết hoa, 1 số và 1 ký tự đặc biệt.";
            }
        }
    }

    if (isset ($_POST['capnhattt'])) {
        $ho_ten = $_POST['name'];
        $email = $_POST['email'];
        $sdt = $_POST['phone'];
        $sql = "UPDATE khachhang SET TenKH='$ho_ten', Email='$email', SDT='$sdt' WHERE IDKH = '" . $_SESSION['IDKH'] . "'";
        if ($conn->query($sql) === TRUE) {
            $msg = '<div class="css-1tj8dpi">
                    <div class="css-rac23i" style="text-align: center;">Cập nhật thành công</div>
                </div>';
            $sql = "SELECT * FROM khachhang WHERE IDKH = '" . $_SESSION['IDKH'] . "'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $info = mysqli_fetch_assoc($result);
            }
        } else {
            echo "Lỗi: " . $conn->error;
        }
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
                        <h2>QUẢN LÝ THÔNG TIN</h2>
                        <p>WE DONT NEED MOTIVATION, WE NEED SPIRIT.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->

    <!-- Signup Section Begin -->
    <div class="row">
        <div class="p-5 col-lg-6 col-md-6 container">
            <div class="anime__details__review">
                <div class="section-title">
                    <h5>QUẢN LÝ THÔNG TIN</h5>
                </div>
                <div class="login__form">
                    <form method="post" action="#">
                        <div class="input__item">
                            <input type="text" placeholder="Địa chỉ email" name="email"
                                value="<?php echo $info['Email']; ?>">
                            <span class="icon_mail"></span>
                        </div>
                        <div class="input__item">
                            <input type="text" placeholder="Họ và tên" name="name"
                                value="<?php echo $info['TenKH']; ?>">
                            <span class="icon_profile"></span>
                        </div>
                        <div class="input__item">
                            <input type="text" placeholder="Số điện thoại" name="phone"
                                value="<?php echo $info['SDT']; ?>">
                            <span class="icon_phone"></span>
                        </div>
                        <button type="submit" name="capnhattt" class="btn btn-success">Lưu</button>
                    </form>
                </div>
            </div>
            <div class="anime__details__form">
                <div class="section-title">
                    <h5>Đổi mật khẩu</h5>
                </div>
                <div class="login__form">
                    <form action="#" method="post">
                        <div class="input__item">
                            <input type="text" placeholder="Mật khẩu cũ" name="matkhaucu" value="">
                            <span class="icon_lock"></span>
                        </div>
                        <div class="input__item">
                            <input type="text" placeholder="Mật khẩu mới" name="matkhaumoi">
                            <span class="icon_lock"></span>
                        </div>
                        <div class="input__item">
                            <input type="text" placeholder="Nhập lại mật khẩu" name="nhaplaimk">
                            <span class="icon_lock"></span>
                        </div>
                        <button type="submit" name="doimk">Đổi mật khẩu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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

    <!-- Js Plugins -->

</body>

</html>