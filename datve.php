<?php

$sql_phim = "SELECT * FROM phim";
$result_phim = mysqli_query($conn, $sql_phim);


$phimoption = "";
while ($row_phim = mysqli_fetch_assoc($result_phim)) {
    $phimoption .= "<option value='" . $row_phim['IDPhim'] . "'>" . $row_phim['TenPhim'] . "</option>";
}

$sql_rap = "SELECT * FROM rap";
$result_rap = mysqli_query($conn, $sql_rap);






if (isset($_POST['submit'])) {


    // Tạo mã phim tự động
    $sql_ve = "SELECT MAX(CAST(SUBSTRING(IDVe,  5) AS SIGNED)) AS max_IDVe FROM Ve WHERE IDVe LIKE 'VE00%' AND CAST(SUBSTRING(IDVe,  5) AS SIGNED) > 7;";
    $result_max_IDVe = $conn->query($sql_ve);
    $row = $result_max_IDve->fetch_assoc();
    $max_IDVe = $row["max_IDVe"]; //Tìm mã khách hàng lớn nhất
    $next_IDVe = "VE" . str_pad($max_IDPhim + 1, 3, '0', STR_PAD_LEFT);


    // Upload poster phim vào thư mục trên sserver


    // Thêm dữ liệu vào cơ sở dữ liệu
    // $sql = "INSERT INTO Phim (IDPhim, TenPhim, DaoDien, DienVien, IDTheLoai, ThoiLuong, MoTa, HinhAnh, IDDotuoi, Banner, Trailer) 
    //         VALUES ('$next_IDPhim', '$tenPhim', '$daoDien', '$dienVien', '$theLoai', '$thoiLuong', '$moTa', '$posterPhim', '$doTuoi', '$banner', '$trailer')";

    if (mysqli_query($conn, $sql)) {
        $msg = '<div class="alert alert-success" role="alert">
        Thêm thành công !
    </div>';
    } else {
        $msg = '<div class="alert alert-danger" role="alert">
        Thêm thất bại
    </div>';
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
    <script>
        $(document).ready(function () {
            // Gọi hàm updateSuatChieu khi trang được tải lần đầu
            updateSuatChieu();
        });
        // Hàm gửi yêu cầu AJAX khi người dùng chọn một bộ phim
        function updateSuatChieu() {
            var selectedRap = $("#rapSelect").val();
            $.ajax({
                type: "POST",
                url: "get_suatchieu.php",
                data: { rap: selectedRap },
                success: function (response) {
                    // Xóa tất cả các tùy chọn hiện có
                    $('.suatchieuSelect').empty();
                    // Thêm các tùy chọn mới từ phản hồi
                    $('.suatchieuSelect').append(response);
                    $(".suatchieuSelect").prepend("<option value=''>----- Chọn Suất -----</option>");

                    // Đặt tùy chọn mặc định cho phần tử select
                    var defaultOptionValue = ""; // Để tùy chọn mặc định trống
                    $(".suatchieuSelect").val(defaultOptionValue);
                    console.log(response)
                },
                error: function () {
                    // Xử lý lỗi nếu cần thiết
                    alert('Đã xảy ra lỗi khi tải dữ liệu suất chiếu.');
                }
            });
        }


        function updateRap() {
            var selectedPhim = $("#selectedPhimInput").val();
            $.ajax({
                type: "POST",
                url: "get_rapselection.php",
                data: { phim: selectedPhim },
                success: function (response) {
                    // Xóa tất cả các tùy chọn hiện có
                    $('.rapSelect').empty();
                    // Thêm các tùy chọn mới từ phản hồi
                    $('.rapSelect').append(response);
                    $(".rapSelect").prepend("<option value=''>----- Chọn Rạp -----</option>");

                    // Đặt tùy chọn mặc định cho phần tử select
                    var defaultOptionValue = ""; // Để tùy chọn mặc định trống
                    $(".rapSelect").val(defaultOptionValue);
                    console.log(response)
                },
                error: function () {
                    // Xử lý lỗi nếu cần thiết
                    alert('Đã xảy ra lỗi khi tải dữ liệu suất chiếu.');
                }
            });
        }
    </script>
    <!-- Signup Section Begin -->
    <div class="row">
        <div class="p-5 col-lg-6 col-md-6 container">
            <div class="anime__details__review">
                <div class="section-title">
                    <h5>Đặt Vé</h5>
                </div>
                <div>
                    <form method="post" action="#">
                        <div class="mb-3">
                            <label for="phim" class="text-white">Phim</label>
                            <select class="form-select mb-3" name="phim" id="selectedPhimInput"
                                aria-label="Default select example" onchange="updateRap()">
                                <option value="">-----Chọn Phim-----</option>
                                <?php echo $phimoption; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="rap" class="form-label text-white">Rạp</label>
                            <select class="form-select mb-3 rapSelect" name="rap" id="rapSelect"
                                aria-label="Default select example" onchange="updateSuatChieu()">

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="suatchieu" class="form-label text-white">Suất Chiếu</label>
                            <select class="form-select mb-3 suatchieuSelect" name="suatchieu" id="suatchieuSelect"
                                aria-label="Default select example">

                            </select>
                        </div>
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