<?php
if (!isset ($_SESSION['loggedin_customer'])) {
    header('Location: ?page=login');
}

$sql_hd = "SELECT * FROM hoadon JOIN phim ON hoadon.IDPhim = phim.IDPhim
                                JOIN rap ON hoadon.IDRap = rap.IDRap
                                JOIN suatchieu ON hoadon.IDSuat = suatchieu.IDSuat
                                WHERE IDKH = '" . $_SESSION['IDKH'] . "'";
$result_hd = mysqli_query($conn, $sql_hd);

$hd_array = array();
while ($row_hd = mysqli_fetch_array($result_hd)) {
    $hd_array[] = $row_hd;
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
                        <h2>LỊCH SỬ ĐẶT VÉ</h2>
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
                    <h5>LỊCH SỬ ĐẶT VÉ</h5>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="text-white">ID Vé</th>
                            <th scope="col" class="text-white">Tên Phim</th>
                            <th scope="col" class="text-white">Tên Rạp</th>
                            <th scope="col" class="text-white">Suất Chiếu</th>
                            <th scope="col" class="text-white">Ghế</th>
                            <th scope="col" class="text-white">QR-CODE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($hd_array as $key => $hd) { ?>
                            <tr>
                                <td scope="row" class="text-white">
                                    <?php echo $hd['IDHoaDon']; ?>
                                </td>
                                <td class="text-white">
                                    <?php echo $hd['TenPhim']; ?>
                                </td>
                                <td class="text-white">
                                    <?php echo $hd['TenRap']; ?>
                                </td>
                                <td class="text-white">
                                    <?php echo $hd['GioChieu'] . " vào " . $hd['NgayChieu']; ?>
                                </td>
                                <td class="text-white">
                                    <?php echo $hd['Ghe']; ?>
                                </td>
                                <td>
                                    <a href="?page=chitietve&IDHoaDon=<?php echo $hd['IDHoaDon']; ?>"
                                        class="btn btn-square btn-outline-danger m-2"><i class="fa fa-qrcode"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
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