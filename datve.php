<?php

$sql_phim = "SELECT * FROM phim";
$result_phim = mysqli_query($conn, $sql_phim);


$phimoption = "";
while ($row_phim = mysqli_fetch_assoc($result_phim)) {
    $phimoption .= "<option value='" . $row_phim['IDPhim'] . "'>" . $row_phim['TenPhim'] . "</option>";
}

$sql_kv = "SELECT * FROM danhmuckhuvuc";
$result_kv = mysqli_query($conn, $sql_kv);

$khuvucoption = "";
while ($row_kv = mysqli_fetch_assoc($result_kv)) {
    $khuvucoption .= "<option value='" . $row_kv['IDKhuVuc'] . "'>" . $row_kv['TenKhuVuc'] . "</option>";
}

$sql_rap = "SELECT * FROM rap";
$result_rap = mysqli_query($conn, $sql_rap);

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
            var selectedKhuVuc = $("#selectedKhuVucInput").val();

            $.ajax({
                type: "POST",
                url: "get_rapselection.php",
                data: { phim: selectedPhim, khuvuc: selectedKhuVuc},
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
                    <form method="post" action="?page=chonghe">
                        <div class="mb-3">
                            <label for="phim" class="text-white">Phim</label>
                            <select class="form-select mb-3" name="phim" id="selectedPhimInput"
                                aria-label="Default select example" onchange="updateRap()" required>
                                <option value="">-----Chọn Phim-----</option>
                                <?php echo $phimoption; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="khuvuc" class="text-white">Khu Vực</label>
                            <select class="form-select mb-3" name="khuvuc" id="selectedKhuVucInput"
                                aria-label="Default select example" onchange="updateRap()" required>
                                <option value="">-----Chọn Khu Vực-----</option>
                                <?php echo $khuvucoption; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="rap" class="form-label text-white">Rạp</label>
                            <select class="form-select mb-3 rapSelect" name="rap" id="rapSelect"
                                aria-label="Default select example" onchange="updateSuatChieu()" required>

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="suatchieu" class="form-label text-white">Suất Chiếu</label>
                            <select class="form-select mb-3 suatchieuSelect" name="suatchieu" id="suatchieuSelect"
                                aria-label="Default select example" required>

                            </select>
                        </div>
                        <button button type="submit" class="btn btn-primary">Tiếp Tục</button>
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