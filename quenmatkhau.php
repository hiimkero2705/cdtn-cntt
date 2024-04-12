<?php
// Load Composer's autoloader

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $options = [
        'cost' => 12,
    ];

    // Kiểm tra email trong cơ sở dữ liệu
    $sql = "SELECT * FROM khachhang WHERE Email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Email hợp lệ, tạo mật khẩu mới
        $new_password = substr(md5(rand()), 0, 8); // Mật khẩu mới có 8 ký tự
        $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT, $options);

        // Cập nhật mật khẩu mới vào cơ sở dữ liệu
        $sql_update = "UPDATE khachhang SET Password='$hashedPassword' WHERE Email='$email'";
        if ($conn->query($sql_update) === TRUE) {
            // Gửi email chứa mật khẩu mới bằng PHPMailer
            require "PHPMailer/src/PHPMailer.php";
            require "PHPMailer/src/SMTP.php";
            require 'PHPMailer/src/Exception.php';
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);//true:enables exceptions
            try {
                $mail->SMTPDebug = 0; //0,1,2: chế độ debug
                $mail->isSMTP();
                $mail->CharSet = "utf-8";
                $mail->Host = 'smtp.gmail.com';  //SMTP servers
                $mail->SMTPAuth = true; // Enable authentication
                $mail->Username = 'tien.pm.62cntt@ntu.edu.vn'; // SMTP username
                $mail->Password = '221510235';   // SMTP password
                $mail->SMTPSecure = 'ssl';  // encryption TLS/SSL 
                $mail->Port = 465;  // port to connect to                
                $mail->setFrom('tien.pm.62cntt@ntu.edu.vn', 'ĐẶT LẠI MẬT KHẨU');
                $mail->addAddress($email);
                $mail->isHTML(true);  // Set email format to HTML
                $mail->Subject = 'ĐỔI MẬT KHẨU';
                $noidungthu = 'Mật khẩu mới là :' . $new_password;
                $mail->Body = $noidungthu;
                $mail->smtpConnect(
                    array(
                        "ssl" => array(
                            "verify_peer" => false,
                            "verify_peer_name" => false,
                            "allow_self_signed" => true
                        )
                    )
                );
                $mail->send();
                $msg = 'Đã gửi mail xong';
            } catch (Exception $e) {
                $msg = 'Error: '. $mail->ErrorInfo;
            }
        } else {
            $msg = "Error updating password: " . $conn->error;
        }
    } else {
        $msg = "Email not found.";
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
                        <h2>QUÊN MẬT KHẨU</h2>
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
                        <h3>QUÊN MẬT KHẨU</h3>
                        <form action="#" method="post">
                            <div class="input__item">
                                <input type="text" placeholder="Email" name="email" required>
                                <span class="icon_mail"></span>
                            </div>
                            <button type="submit" name="submit" class="site-btn">XÁC NHẬN</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login__register">
                        <h3>QUAY LẠI ĐĂNG NHẬP</h3>
                        <a href="?page=login" class="primary-btn">ĐĂNG NHẬP</a>
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