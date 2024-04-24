<?php
if (isset($_GET['IDPhim'])) {
    $IDPhim = $_GET['IDPhim'];

    $sql_phim = "SELECT * FROM Phim JOIN danhmuctheloai ON Phim.IDTheLoai = danhmuctheloai.IDTheLoai
                                JOIN danhmucdotuoi ON Phim.IDDotuoi = danhmucdotuoi.IDDotuoi
                                WHERE Phim.IDPhim = '$IDPhim' ";
    $result_phim = $conn->query($sql_phim);

    // Xác định trang hiện tại và kích thước trang
    $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $reviews_per_page = 6;
    // Tính toán vị trí bắt đầu của kết quả
    $start = ($current_page - 1) * $reviews_per_page;
    if ($start < 0) {
        $start = 0;
    }
    // Truy vấn SQL với LIMIT và OFFSET
    $sql_reviews = "SELECT * FROM danhgiaphim JOIN Phim ON danhgiaphim.IDPhim = Phim.IDPhim
                                              JOIN khachhang ON danhgiaphim.IDKH = khachhang.IDKH 
                                              WHERE danhgiaphim.IDPhim = '$IDPhim' ORDER BY danhgiaphim.IDPhim DESC LIMIT $start, $reviews_per_page";
    $result_review = mysqli_query($conn, $sql_reviews);

    $sql_count = "SELECT COUNT(*) AS count FROM danhgiaphim";
    $result_count = $conn->query($sql_count);
    $row_count = $result_count->fetch_assoc();
    $total_pages = ceil($row_count['count'] / $reviews_per_page);

    // $sql_review_in
    if (isset($_POST['danhgia'])) {
        $danhgia = $_POST['noidung'];
        $idkh = $_SESSION['IDKH'];
        $sql_insert_review = "INSERT INTO danhgiaphim (IDKH, IDPhim, NoiDung) VALUES ('$idkh', '$IDPhim', '$danhgia')";
        if (mysqli_query($conn, $sql_insert_review)) {
            $msg = '<div class="alert alert-success" role="alert">
            Thêm thành công !
        </div>';
            $idphim = $_GET['IDPhim'];
            header("Location: ?page=chitietphim&IDPhim=$idphim");
        } else {
            $msg = '<div class="alert alert-danger" role="alert">
            Thêm thất bại
        </div>';
        }
    }

    if ($result_phim->num_rows > 0) {
        $row = $result_phim->fetch_assoc();
        $IDMovie = $row['IDPhim'];
        $TenPhim = $row['TenPhim'];
        $DaoDien = $row['DaoDien'];
        $DienVien = $row["DienVien"];
        $TheLoai = $row["TenTheLoai"];
        $ThoiLuong = $row['ThoiLuong'];
        $MoTa = $row['MoTa'];
        $Image = $row['HinhAnh'];
        $Dotuoi = $row['Dotuoi'];
        ?>


        <!DOCTYPE html>
        <html lang="zxx">

        <body>
            <!-- Page Preloder -->
            <div id="preloder">
                <div class="loader"></div>
            </div>

            <!-- Breadcrumb Begin -->
            <div class="breadcrumb-option">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="breadcrumb__links">
                                <a href="?page=home"><i class="fa fa-home"></i> Trang chủ</a>
                                <a href="?page=phimdangchieu">Phim đang chiếu</a>
                                <span><?php echo $TenPhim ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Breadcrumb End -->

            <!-- Anime Section Begin -->
            <section class="anime-details spad">
                <div class="container">
                    <div class="anime__details__content">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="anime__details__pic set-bg" data-setbg="img/phim/<?php echo $Image ?>">
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="anime__details__text">
                                    <div class="anime__details__title">
                                        <h3>
                                            <?php echo $TenPhim ?>
                                        </h3>
                                        <span>
                                            <?php echo $DaoDien ?>
                                        </span>
                                    </div>
                                    <div class="anime__details__rating">
                                        <div class="rating">
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star-half-o"></i></a>
                                        </div>
                                        <span>1.029 Votes</span>
                                    </div>
                                    <p>
                                        <?php echo $MoTa ?>
                                    </p>
                                    <div class="anime__details__widget">
                                        <div class="row">
                                            <div class="col-lg-9 col-md-6">
                                                <ul>
                                                    <li><span>Diễn viên:</span>
                                                        <?php echo $DienVien ?>
                                                    </li>
                                                    <li><span>Thời lượng:</span>
                                                        <?php echo $ThoiLuong ?> phút
                                                    </li>
                                                    <li><span>Đạo diễn:</span>
                                                        <?php echo $DaoDien ?>
                                                    </li>
                                                    <li><span>Thể loại:</span>
                                                        <?php echo $TheLoai ?>
                                                    </li>
                                                    <li><span>Độ tuổi:</span>
                                                        <?php echo $Dotuoi ?>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="anime__details__btn">
                                        <a href="?page=trailerphim&IDPhim=<?php echo $IDPhim ?>" class="follow-btn"><i
                                                class="fa fa-video-camera"></i> TRAILER</a>
                                        <a href="?page=datve" class="watch-btn"><span>ĐẶT VÉ NGAY</span> <i
                                                class="fa fa-angle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-8">
                            <div class="anime__details__review">
                                <div class="section-title">
                                    <h5>Đánh Giá</h5>
                                    <div id="reviews-container">
                                        <?php
                                        if ($result_review->num_rows > 0) {
                                            while ($row_review = mysqli_fetch_array($result_review)) {
                                                $tenKH = $row_review["TenKH"];
                                                $noidung = $row_review["NoiDung"];
                                                echo '<div class="anime__review__item">
                                                     <div class="anime__review__item__pic">
                                                         <img src="img/anime/review-1.jpg" alt="">
                                                     </div>
                                                     <div class="anime__review__item__text">
                                                         <h6>' . $tenKH . '</h6>
                                                        <p>' . $noidung . '</p>
                                                     </div>
                                                </div>';
                                            }
                                        } else {
                                            echo "Không có đánh giá.";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php if ($result_review->num_rows > 0): ?>
                                    <div class='pagination'>
                                        <?php
                                            for ($i = 1; $i <= $total_pages; $i++) {
                                                echo "<a href='#' onclick='loadPage($i)'>$i</a>";
                                            }
                                                ?>
                                    </div>
                                <?php endif; ?>

                                
                                <script>
                                    function loadPage(page) {
                                        // Gửi yêu cầu AJAX để lấy dữ liệu đánh giá cho trang mới
                                        var xhr = new XMLHttpRequest();
                                        var IDPhim = <?php echo json_encode($IDPhim); ?>; // Lấy giá trị IDPhim từ biến PHP
                                        xhr.open('GET', 'ajax.php?IDPhim=' + IDPhim + '&page=' + page, true);
                                        xhr.onload = function () {
                                            if (xhr.status >= 200 && xhr.status < 400) {
                                                // Cập nhật nội dung của reviews-container và pagination với dữ liệu mới
                                                var response = xhr.responseText;
                                                var reviewsContainer = document.getElementById('reviews-container');
                                                reviewsContainer.innerHTML = response;
                                            }
                                        };
                                        xhr.send();
                                    }
                                </script>
                            </div>
                            <div class="anime__details__form">
                                <div class="section-title">
                                    <h5>Đánh Giá</h5>
                                </div>
                                <form method="post" action="#">
                                    <textarea placeholder="Your Comment" name="noidung"></textarea>
                                    <?php
                                    if (isset($_SESSION['loggedin_customer']) && $_SESSION['loggedin_customer'] === true) {
                                        echo '<button type="submit" name="danhgia"><i class="fa fa-location-arrow"></i> Đánh giá</button>';
                                    } else {
                                        echo '<a href="?page=login" class="btn btn-danger"><i class="fa fa-location-arrow"></i> ĐĂNG NHẬP ĐỂ ĐÁNH GIÁ</a>';
                                    } ?>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="anime__details__sidebar">
                                <div class="section-title">
                                    <h5>you might like...</h5>
                                </div>
                                <div class="product__sidebar__view__item set-bg" data-setbg="img/sidebar/tv-1.jpg">
                                    <div class="ep">18 / ?</div>
                                    <div class="view"><i class="fa fa-eye"></i> 9141</div>
                                    <h5><a href="#">Boruto: Naruto next generations</a></h5>
                                </div>
                                <div class="product__sidebar__view__item set-bg" data-setbg="img/sidebar/tv-2.jpg">
                                    <div class="ep">18 / ?</div>
                                    <div class="view"><i class="fa fa-eye"></i> 9141</div>
                                    <h5><a href="#">The Seven Deadly Sins: Wrath of the Gods</a></h5>
                                </div>
                                <div class="product__sidebar__view__item set-bg" data-setbg="img/sidebar/tv-3.jpg">
                                    <div class="ep">18 / ?</div>
                                    <div class="view"><i class="fa fa-eye"></i> 9141</div>
                                    <h5><a href="#">Sword art online alicization war of underworld</a></h5>
                                </div>
                                <div class="product__sidebar__view__item set-bg" data-setbg="img/sidebar/tv-4.jpg">
                                    <div class="ep">18 / ?</div>
                                    <div class="view"><i class="fa fa-eye"></i> 9141</div>
                                    <h5><a href="#">Fate/stay night: Heaven's Feel I. presage flower</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Anime Section End -->


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
        <?php
    } else {
        echo "Không tìm thấy sản phẩm với MaMH: $IDPhim";
    }
} else {
    echo "IDPhim không được cung cấp $IDPhim";
}
?>