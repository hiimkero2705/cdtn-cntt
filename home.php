<?php
$sql_phim = "SELECT * FROM Phim JOIN danhmuctheloai ON Phim.IDTheLoai = danhmuctheloai.IDTheLoai
                                JOIN danhmucdotuoi ON Phim.IDDotuoi = danhmucdotuoi.IDDotuoi";
$result_phim = mysqli_query($conn, $sql_phim);

$phim_array = array();
while ($row_phim = mysqli_fetch_array($result_phim)) {
    $phim_array[] = $row_phim;
}

?>


<!DOCTYPE html>
<html lang="zxx">

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>
    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="container">
            <div class="hero__slider owl-carousel">
                <?php
                foreach ($phim_array as $row_phim) {
                    $IDPhim = $row_phim["IDPhim"];
                    $TenPhim = $row_phim["TenPhim"];
                    $TheLoai = $row_phim["TenTheLoai"];
                    $MoTa = $row_phim["MoTa"];
                    $MoTaShort = strlen($MoTa) > 50 ? substr($MoTa, 0, 50) . '...' : $MoTa;
                    echo '<div class="hero__items set-bg" data-setbg="img/hero/hero-1.jpg">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="hero__text">
                                <div class="label">' . $TheLoai . '</div>
                                <h2>' . $TenPhim . '</h2>
                                <p>' . $MoTaShort . '</p>
                                <a href="?page=chitietphim&IDPhim=' . $IDPhim . '"><span>ĐẾN NGAY</span> <i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>';
                }
                ?>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="trending__product">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section-title">
                                    <h4>ĐANG CÔNG CHIẾU</h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="btn__all">
                                    <a href="./categories.php" class="primary-btn">XEM TẤT CẢ <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php
                            foreach ($phim_array as $row_phim) {
                                $IDPhim = $row_phim["IDPhim"];
                                $TenPhim = $row_phim["TenPhim"];
                                $TheLoai = $row_phim["TenTheLoai"];
                                $Dotuoi = $row_phim["IDDotuoi"];
                                $Image = $row_phim["HinhAnh"];
                                if ($Dotuoi == 'DT001') {
                                    $Dotuoigioihan = '<div class="ep">18+</div>';
                                } else if ($Dotuoi == 'DT002') {
                                    $Dotuoigioihan = '<div class="ep1">ALL</div>';
                                } else if ($Dotuoi == 'DT003') {
                                    $Dotuoigioihan = '<div class="ep2">16+</div>';
                                } else {
                                    $Dotuoigioihan = '<div class="ep3">12+</div>';
                                }
                                echo '<div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="img/phim/' . $Image . '">
                                        ' . $Dotuoigioihan . '
                                        <div class="comment"><i class="fa fa-comments"></i> 11</div>
                                        <div class="view"><i class="fa fa-eye"></i> 9141</div>
                                    </div>
                                    <div class="product__item__text">
                                        <ul>
                                            <li>' . $TheLoai . '</li>
                                        </ul>
                                        <h5><a href="?page=chitietphim&IDPhim=' . $IDPhim . '">' . $TenPhim . '</a></h5>
                                    </div>
                                </div>
                            </div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="product__sidebar">
                        <div class="product__sidebar__view">
                            <div class="section-title">
                                <h5>Top Views</h5>
                            </div>
                            <ul class="filter__controls">
                                <li class="active" data-filter="*">Day</li>
                                <li data-filter=".week">Week</li>
                                <li data-filter=".month">Month</li>
                                <li data-filter=".years">Years</li>
                            </ul>
                            <div class="filter__gallery">
                                <div class="product__sidebar__view__item set-bg mix day years"
                                    data-setbg="img/sidebar/tv-1.jpg">
                                    <div class="ep">18 / ?</div>
                                    <div class="view"><i class="fa fa-eye"></i> 9141</div>
                                    <h5><a href="#">Boruto: Naruto next generations</a></h5>
                                </div>
                                <div class="product__sidebar__view__item set-bg mix month week"
                                    data-setbg="img/sidebar/tv-2.jpg">
                                    <div class="ep">18 / ?</div>
                                    <div class="view"><i class="fa fa-eye"></i> 9141</div>
                                    <h5><a href="#">The Seven Deadly Sins: Wrath of the Gods</a></h5>
                                </div>
                                <div class="product__sidebar__view__item set-bg mix week years"
                                    data-setbg="img/sidebar/tv-3.jpg">
                                    <div class="ep">18 / ?</div>
                                    <div class="view"><i class="fa fa-eye"></i> 9141</div>
                                    <h5><a href="#">Sword art online alicization war of underworld</a></h5>
                                </div>
                                <div class="product__sidebar__view__item set-bg mix years month"
                                    data-setbg="img/sidebar/tv-4.jpg">
                                    <div class="ep">18 / ?</div>
                                    <div class="view"><i class="fa fa-eye"></i> 9141</div>
                                    <h5><a href="#">Fate/stay night: Heaven's Feel I. presage flower</a></h5>
                                </div>
                                <div class="product__sidebar__view__item set-bg mix day"
                                    data-setbg="img/sidebar/tv-5.jpg">
                                    <div class="ep">18 / ?</div>
                                    <div class="view"><i class="fa fa-eye"></i> 9141</div>
                                    <h5><a href="#">Fate stay night unlimited blade works</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </section>
    <!-- Product Section End -->
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