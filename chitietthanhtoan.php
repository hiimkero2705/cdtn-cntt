<?php
if (!isset($_SESSION['loggedin_customer'])) {
    header('Location: ?page=login');
}
// Lấy dữ liệu từ form ẩn
$idphim = $_POST['idphim'];
$idrap = $_POST['idrap'];
$idSuatchieu = $_POST['idSuatchieu'];
$idghe = $_POST['idghe'];
$tongtien = $_POST['tongtien'];
$giamgia = 0;

$sql_kh = "SELECT * FROM khachhang WHERE IDKH = '" . $_SESSION['IDKH'] . "'";
$result_kh = $conn->query($sql_kh);
$row_kh = mysqli_fetch_assoc($result_kh);
if($row_kh['bac'] == 1){
    $giamgia = 0;
}elseif($row_kh['bac'] == 2){
    $giamgia = 0.05;
}else{
    $giamgia = 0.1;
}

$tongtiensaugiamgia = $tongtien * (1 - $giamgia);

$sql_phim = "SELECT * FROM phim WHERE IDPhim = '$idphim'";
$result_phim = $conn->query($sql_phim);
$row_phim = mysqli_fetch_assoc($result_phim);

$sql_rap = "SELECT * FROM rap WHERE IDRap = '$idrap'";
$result_rap = $conn->query($sql_rap);
$row_rap = mysqli_fetch_assoc($result_rap);

$sql_suat = "SELECT * FROM suatchieu WHERE IDSuat = '$idSuatchieu'";
$result_suat = $conn->query($sql_suat);
$row_suat = mysqli_fetch_assoc($result_suat);

$idve = "VE" . date("YmdHis");
// In ra dữ liệu

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
                        <h2>CHI TIẾT THANH TOÁN</h2>
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
                    <h5>CHI TIẾT THANH TOÁN</h5>
                </div>
                <div class="text-white" style="font-size: 20px; text-align: center;">Phim:
                    <?php echo $row_phim['TenPhim'] ?>
                </div>
                <div class="text-white" style="font-size: 20px; text-align: center;">Rạp:
                    <?php echo $row_rap['TenRap'] ?>
                </div>
                <div class="text-white" style="font-size: 20px; text-align: center;">Suất:
                    <?php echo $row_suat['GioChieu'] . " vào " . $row_suat['NgayChieu'] ?>
                </div>
                <div class="text-white" style="font-size: 20px; text-align: center;">Ghế: <?php echo $idghe ?></div>
                <div class="text-white" style="font-size: 20px; text-align: center;">Tổng tiền: <?php echo $tongtiensaugiamgia ?>
                    VND</div>
                <br/>
                <form class="" method="POST" target="_blank" enctype="application/x-www-form-urlencoded"
                    action="thanhtoan.php">
                    <input type="hidden" id="idve" name="idve" value="<?php echo $idve ?>">
                    <input type="hidden" id="idphim" name="idphim" value="<?php echo $idphim ?>">
                    <input type="hidden" id="idrap" name="idrap" value="<?php echo $idrap ?>">
                    <input type="hidden" id="idSuatchieu" name="idSuatchieu" value="<?php echo $idSuatchieu ?>">
                    <input type="hidden" id="idghe" name="idghe" value="<?php echo $idghe ?>">
                    <input type="hidden" id="tongtien" name="tongtien" value="<?php echo $tongtiensaugiamgia ?>">
                    <input type="hidden" id="idkh" name="idkh" value="<?php echo $_SESSION['IDKH'] ?>">

                    <label><input type="radio" name="payment_method" value="momo" checked>
                        <img src="img/logothanhtoan/momo.png" alt="MOMO" style="width: 100px;"><span class="text-white"> <em>   Ưu đãi giảm 5% khi thanh toán qua MOMO</em></span>
                    </label><br/>
                    <label><input type="radio" name="payment_method" value="atm">
                        <img src="img/logothanhtoan/atm.jpg" alt="ATM" style="width: 100px; border-radius: 10%">
                    </label><br/>
                    <label><input type="radio" name="payment_method" value="cod"> <img src="img/logothanhtoan/cod.png"
                            alt="ATM" style="width: 100px; border-radius: 10%">
                    </label><br/>
                    <label><input type="radio" name="payment_method" value="vnpay">
                        <img src="img/logothanhtoan/vnpay.png" alt="vnpay" style="width: 100px; border-radius: 10%"><span class="text-white"> <em>   Ưu đãi giảm 5% khi thanh toán qua VNPay</em></span>
                    </label><br/>
                    <input type="submit" value="Thanh toán" class="btn btn-primary">
                </form>

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