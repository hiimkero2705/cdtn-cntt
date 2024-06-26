<?php
session_start(); // Bắt đầu session

if (isset($_SESSION['loggedin_customer']) && $_SESSION['loggedin_customer'] === true) {
    // Người dùng đã đăng nhập
    $userID = $_SESSION['IDKH']; // Lấy ID của người dùng đã đăng nhập
    // Các mã lệnh khác bạn muốn thực hiện khi người dùng đã đăng nhập
} else {
    header('Location: signin.php');
}

include '../assets/connect.php';

$msg = ''; // Khởi tạo biến để lưu thông báo

if (isset($_GET['idPhim'])) {
    $idPhim = $_GET['idPhim'];
    $sql_phim = "SELECT * FROM Phim JOIN danhmuctheloai ON Phim.IDTheLoai = danhmuctheloai.IDTheLoai
    JOIN danhmucdotuoi ON Phim.IDDotuoi = danhmucdotuoi.IDDotuoi WHERE Phim.IDPhim = '$idPhim'";

    $result_phim = mysqli_query($conn, $sql_phim);
    $row_phim = mysqli_fetch_assoc($result_phim);
    if (mysqli_num_rows($result_phim) <> 0) {
        $phim_array = mysqli_fetch_assoc($result_phim);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        $tenPhim = $_POST['tenPhim'];
        $daoDien = $_POST['daoDien'];
        $dienVien = $_POST['dienVien'];
        $theLoai = $_POST['theLoai'];
        $thoiLuong = $_POST['thoiLuong'];
        $moTa = $_POST['moTa'];
        $posterPhim = $_FILES['posterPhim']['name'];
        $doTuoi = $_POST['doTuoi'];
        $banner = $_FILES['bannerPhim']['name'];
        $trailer = $_FILES['trailerPhim']['name'];

        // Upload poster phim vào thư mục trên server
        if ($_FILES['posterPhim']['name'] != '') {
            $posterPhim = $_FILES['posterPhim']['name'];
            $target_dir = "../img/phim/";
            $target_file = $target_dir . basename($_FILES["posterPhim"]["name"]);
            move_uploaded_file($_FILES["posterPhim"]["tmp_name"], $target_file);
        } else {
            $posterPhim = $row_phim['Poster'];
        }


        if ($_FILES['bannerPhim']['name'] != '') {
            $banner = $_FILES['bannerPhim']['name'];
            $target_dir2 = "../img/banner/";
            $target_file2 = $target_dir2 . basename($_FILES["bannerPhim"]["name"]);
            move_uploaded_file($_FILES["bannerPhim"]["tmp_name"], $target_file2);
        } else {
            $banner = $row_phim['Banner'];
        }

        if ($_FILES['trailerPhim']['name'] != '') {
            $trailer = $_FILES['trailerPhim']['name'];
            $target_dir1 = "../videos/";
            $target_file1 = $target_dir1 . basename($_FILES["trailerPhim"]["name"]);
            move_uploaded_file($_FILES["trailerPhim"]["tmp_name"], $target_file1);
        } else {
            $trailer = $row_phim['Trailer'];
        }
        // Cập nhật dữ liệu vào cơ sở dữ liệu
        $sql_update = "UPDATE Phim SET TenPhim='$tenPhim', DaoDien='$daoDien', DienVien='$dienVien', IDTheLoai='$theLoai', ThoiLuong='$thoiLuong', MoTa='$moTa', HinhAnh='$posterPhim', IDDotuoi='$doTuoi', Banner='$banner', Trailer='$trailer' WHERE IDPhim='$idPhim'";
        $result_update = mysqli_query($conn, $sql_update);
        if ($result_update) {
            $msg = '<div class="alert alert-success" role="alert">
            Chỉnh sửa thành công !
        </div>';
        } else {
            $msg = '<div class="alert alert-danger" role="alert">
            Sửa thất bại
        </div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DarkPan - Bootstrap 5 Admin Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="index.php" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>AdminPages</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                        <div
                            class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                        </div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">Hehe</h6>
                        <span>Admin</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="index.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Thống
                        kê</a>
                    <a href="listhoadon.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Hóa
                        Đơn</a>
                    <a href="listkh.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Khách Hàng</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown"><i
                                class="fa fa-video me-2"></i>Phim</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="listphim.php" class="dropdown-item">Danh sách phim</a>
                            <a href="themphim.php" class="dropdown-item">Thêm phim</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                                class="fa fa-calendar me-2"></i>Suất Chiếu</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="listsuatchieu.php" class="dropdown-item">Danh sách suất chiếu</a>
                            <a href="themsuatchieu.php" class="dropdown-item">Thêm suất chiếu</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                                class="fa fa-book me-2"></i>Vé Đã Đặt</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="listve.php" class="dropdown-item">Danh sách Vé</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                                class="far fa-file-alt me-2"></i>Pages</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="signin.html" class="dropdown-item">Sign In</a>
                            <a href="signup.html" class="dropdown-item">Sign Up</a>
                            <a href="404.html" class="dropdown-item">404 Error</a>
                            <a href="blank.html" class="dropdown-item active">Blank Page</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="img/user.jpg" alt=""
                                style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex">Admin</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="logout.php" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->


            <!-- Blank Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row bg-secondary rounded align-items-center justify-content-center mx-0">

                    <div class="bg-secondary rounded h-100 p-4">
                        <h2 class="mb-4 text-center">Chỉnh sửa Phim</h2>
                        <?php if (isset($msg))
                            echo $msg; ?>
                        <form method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="tenPhim" class="form-label">Tên Phim</label>
                                <input type="tenPhim" class="form-control" name="tenPhim"
                                    value="<?php echo $row_phim['TenPhim'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="daoDien" class="form-label">Đạo Diễn</label>
                                <input type="daoDien" class="form-control" name="daoDien"
                                    value="<?php echo $row_phim['DaoDien'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="dienVien" class="form-label">Diễn Viên</label>
                                <input type="dienVien" class="form-control" name="dienVien"
                                    value="<?php echo $row_phim['DienVien'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="theLoai" class="form-label">Thể Loại</label>
                                <select class="form-select mb-3" name="theLoai" aria-label="Default select example">
                                    <option value="<?php echo $row_phim['IDTheLoai'] ?>">
                                        <?php echo $row_phim['TenTheLoai']; ?>
                                    </option>
                                    <?php
                                    $selectedID = $row_phim['IDTheLoai']; // ID của thể loại phim đã được chọn từ cơ sở dữ liệu
                                    $sql_the_loai = "SELECT * FROM danhmuctheloai";
                                    $result_the_loai = mysqli_query($conn, $sql_the_loai);

                                    while ($row = mysqli_fetch_assoc($result_the_loai)) {
                                        $optionID = $row['IDTheLoai'];
                                        $optionName = $row['TenTheLoai'];

                                        if ($optionID != $selectedID) {
                                            echo '<option value="' . $optionID . '">' . $optionName . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="thoiLuong" class="form-label">Thời Lượng</label>
                                <input type="thoiLuong" class="form-control" name="thoiLuong"
                                    value="<?php echo $row_phim['ThoiLuong'] ?>">
                            </div>
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Mô tả" name="moTa"
                                    style="height: 150px;"><?php echo $row_phim['MoTa']; ?></textarea>
                                <label for="floatingTextarea">Mô tả</label>
                            </div>
                            <div class="mb-3">
                                <label for="posterPhim" class="form-label">Hình ảnh Poster Phim</label>
                                <input class="form-control bg-dark" type="file" id="posterPhim" name="posterPhim"
                                    onchange="previewImage(this)">
                                <img id="preview" src="#" alt="Preview Image"
                                    style="display: none; max-width: 200px; max-height: 200px;">
                                <div id="previewText" style="display: none;">Xem trước hình ảnh trước khi thay đổi</div>
                            </div>

                            <script>
                                function previewImage(input) {
                                    var preview = document.getElementById('preview');
                                    var previewText = document.getElementById('previewText');

                                    if (input.files && input.files[0]) {
                                        var reader = new FileReader();

                                        reader.onload = function (e) {
                                            preview.src = e.target.result;
                                            preview.style.display = 'block';
                                            previewText.style.display = 'none'; // Ẩn dòng chữ khi hình ảnh đã được chọn

                                        }

                                        reader.readAsDataURL(input.files[0]); // Convert to base64 string
                                    }
                                }
                            </script>

                            <div class="mb-3">
                                <label for="posterPreview" class="form-label">Xem trước Poster Phim</label>
                                <br>
                                <img src="../img/phim/<?php echo $row_phim['HinhAnh']; ?>" alt="Poster Phim"
                                    width="150">
                            </div>

                            <div class="mb-3">
                                <label for="posterPhim" class="form-label">Hình ảnh Banner Phim</label>
                                <input class="form-control bg-dark" type="file" id="bannerPhim" name="bannerPhim"
                                    onchange="previewImage1(this)">
                                <img id="preview1" src="#" alt="Preview Image"
                                    style="display: none; max-width: 200px; max-height: 200px;">
                                <div id="previewText" style="display: none;">Xem trước hình ảnh trước khi thay đổi</div>
                            </div>

                            <script>
                                function previewImage1(input) {
                                    var preview = document.getElementById('preview1');
                                    var previewText = document.getElementById('previewText');

                                    if (input.files && input.files[0]) {
                                        var reader = new FileReader();

                                        reader.onload = function (e) {
                                            preview.src = e.target.result;
                                            preview.style.display = 'block';
                                            previewText.style.display = 'none'; // Ẩn dòng chữ khi hình ảnh đã được chọn

                                        }

                                        reader.readAsDataURL(input.files[0]); // Convert to base64 string
                                    }
                                }
                            </script>

                            <div class="mb-3">
                                <label for="posterPreview" class="form-label">Xem trước Banner Phim</label>
                                <br>
                                <img src="../img/banner/<?php echo $row_phim['Banner']; ?>" alt="Banner Phim"
                                    width="150">
                            </div>

                            <div class="mb-3">
                                <label for="posterPhim" class="form-label">Trailer Phim</label>
                                <input class="form-control bg-dark" type="file" id="trailerPhim" name="trailerPhim"
                                    onchange="previewImage2(this)">
                            </div>

                            <script>
                                function previewImage2(input) {
                                    if (input.files && input.files[0]) {
                                        var reader = new FileReader();

                                        reader.onload = function (e) {
                                            preview.src = e.target.result;
                                            preview.style.display = 'block';
                                            previewText.style.display = 'none'; // Ẩn dòng chữ khi hình ảnh đã được chọn
                                        }
                                        reader.readAsDataURL(input.files[0]); // Convert to base64 string
                                    }
                                }
                            </script>

                            <div class="mb-3">
                                <label for="theLoai" class="form-label">Độ Tuổi</label>
                                <select class="form-select mb-3" name="doTuoi" aria-label="Default select example">
                                    <option value="<?php echo $row_phim['IDDotuoi'] ?>">
                                        <?php echo $row_phim['Dotuoi']; ?>
                                    </option>
                                    <?php
                                    $selectedID = $row_phim['IDDotuoi']; // ID của thể loại phim đã được chọn từ cơ sở dữ liệu
                                    $sql_do_tuoi = "SELECT * FROM danhmucdotuoi";
                                    $result_do_tuoi = mysqli_query($conn, $sql_do_tuoi);

                                    while ($row = mysqli_fetch_assoc($result_do_tuoi)) {
                                        $optionID = $row['IDDotuoi'];
                                        $optionName = $row['Dotuoi'];

                                        // Kiểm tra nếu ID tùy chọn trùng khớp với ID của thể loại phim đã được chọn từ cơ sở dữ liệu
                                        if ($optionID != $selectedID) {
                                            echo '<option value="' . $optionID . '">' . $optionName . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-warning m-2" name="update">Sửa Phim</button>
                            <button type="button" class="btn btn-danger m-2" onclick="history.back()"
                                name="update">Hủy</button>
                        </form>
                    </div>
                </div>
                <!-- Blank End -->


                <!-- Footer Start -->
                <div class="container-fluid pt-4 px-4">
                    <div class="bg-secondary rounded-top p-4">
                        <div class="row">
                            <div class="col-12 col-sm-6 text-center text-sm-start">
                                &copy; <a href="#">Your Site Name</a>, All Right Reserved.
                            </div>
                            <div class="col-12 col-sm-6 text-center text-sm-end">
                                <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                                Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                                <br>Distributed By: <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer End -->
            </div>
            <!-- Content End -->


            <!-- Back to Top -->
            <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
        </div>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="lib/chart/chart.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="lib/tempusdominus/js/moment.min.js"></script>
        <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
        <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

        <!-- Template Javascript -->
        <script src="js/main.js"></script>
</body>

</html>