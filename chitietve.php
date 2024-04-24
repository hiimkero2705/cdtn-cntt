<?php
include "phpqrcode/qrlib.php";

if (isset($_GET['IDHoaDon'])) {
    $idhd = $_GET['IDHoaDon'];
    $sql_hd = "SELECT * FROM hoadon JOIN phim ON hoadon.IDPhim = phim.IDPhim
                                JOIN rap ON hoadon.IDRap = rap.IDRap
                                JOIN suatchieu ON hoadon.IDSuat = suatchieu.IDSuat
                                WHERE IDHoaDon = '" . mysqli_real_escape_string($conn, $idhd) . "'";
    $result_hd = mysqli_query($conn, $sql_hd);
    $row_hd = mysqli_fetch_assoc($result_hd);

    // Dữ liệu để tạo mã QR
    $data = $idhd . " Phim: " . $row_hd['TenPhim'] . " Rạp: " . $row_hd['TenRap'] . " Suất: " . $row_hd['GioChieu'] . " " . $row_hd['NgayChieu'] . " Ghế: " . $row_hd["Ghe"];

    // Tạo mã QR và lưu vào file
    QRcode::png($data, "img/qr-code/$idhd.png");
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
                        <h2>CHI TIẾT VÉ</h2>
                        <p>WE DONT NEED MOTIVATION, WE NEED SPIRIT.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->

    <!-- Signup Section Begin -->
    <div class="row">
    <div class="p-5 col-lg-6 col-md-6 container d-flex justify-content-center align-items-center">
        <div>
            <div>
                <img src="./img/qr-code/<?php echo $idhd ?>.png" alt="" style="width: 200px; height: 200px; display: block; margin: 0 auto;">
                <div class="text-white" style="font-size: 20px; text-align: center;">Phim: <?php echo $row_hd['TenPhim'] ?></div>
                <div class="text-white" style="font-size: 20px; text-align: center;">Rạp: <?php echo $row_hd['TenRap'] . " tại " . $row_hd['DiaChi'] ?></div>
                <div class="text-white" style="font-size: 20px; text-align: center;">Suất: <?php echo $row_hd['GioChieu'] . " vào " . $row_hd['NgayChieu'] ?></div>
                <div class="text-white" style="font-size: 20px; text-align: center;">Ghế: <?php echo $row_hd['Ghe'] ?></div>
                <div class="text-white" style="font-size: 20px; text-align: center;">Giá tiền: <?php echo $row_hd['TongTien'] . " VND" ?></div>
                <a href="javascript:history.go(-1)" class="btn btn-primary">Quay lại</a>
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