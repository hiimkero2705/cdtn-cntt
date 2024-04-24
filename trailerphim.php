<?php

if (isset($_GET['IDPhim'])) {
    $IDPhim = $_GET['IDPhim'];

    $sql_phim = "SELECT * FROM Phim JOIN danhmuctheloai ON Phim.IDTheLoai = danhmuctheloai.IDTheLoai
                                JOIN danhmucdotuoi ON Phim.IDDotuoi = danhmucdotuoi.IDDotuoi
                                WHERE Phim.IDPhim = '$IDPhim' ";
    $result_phim = $conn->query($sql_phim);

    $sql_suat = "SELECT DISTINCT suatchieu.IDRap, rap.TenRap 
             FROM suatchieu 
             JOIN rap ON suatchieu.IDRap = rap.IDRap
             WHERE suatchieu.IDPhim = '$IDPhim'";
    $result_suat = mysqli_query($conn, $sql_suat);

    $suat_array = array();
    while ($row_suat = mysqli_fetch_array($result_suat)) {
        $suat_array[] = $row_suat;
    }

    if ($result_phim->num_rows > 0) {
        $row = $result_phim->fetch_assoc();
        $TenPhim = $row['TenPhim'];
        $DaoDien = $row['DaoDien'];
        $DienVien = $row["DienVien"];
        $TheLoai = $row["TenTheLoai"];
        $ThoiLuong = $row['ThoiLuong'];
        $MoTa = $row['MoTa'];
        $Image = $row['HinhAnh'];
        $Dotuoi = $row['Dotuoi'];
        $Trailer = $row['Trailer'];

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
                                <a href="./index.php"><i class="fa fa-home"></i> Trang chủ</a>
                                <a href="./categories.php">Đang Công Chiếu</a>
                                <span>
                                    <?php echo $TenPhim ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Breadcrumb End -->

            <!-- Anime Section Begin -->
            <section class="anime-details spad">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="anime__video__player">
                                <video id="player" playsinline controls data-poster="./videos/anime-watch.jpg">
                                    <source src="videos/<?php echo $Trailer ?>" type="video/mp4" />
                                    <!-- Captions are optional -->
                                    <track kind="captions" label="English captions" src="#" srclang="en" default />
                                </video>
                            </div>
                            <div class="anime__details__episodes">
                                <div class="section-title">
                                    <h5>CÁC RẠP ĐANG CHIẾU</h5>
                                </div>
                                <?php foreach ($suat_array as $row_suat) {
                                    $tenrap = $row_suat['TenRap'];
                                    echo "<a href='#'>$tenrap</a>";
                                } ?>
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
            <!-- Search model end -->

            <!-- Js Plugins -->

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