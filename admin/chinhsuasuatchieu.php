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

if (isset($_GET['idSuat'])) {
    $idSuat = $_GET['idSuat'];
    $sql_suat = "SELECT * FROM suatchieu JOIN Phim ON suatchieu.IDPhim = Phim.IDPhim
                                        JOIN rap ON suatchieu.IDRap = rap.IDRap 
                                        WHERE suatchieu.IDSuat = '$idSuat'";

    $result_suat = mysqli_query($conn, $sql_suat);
    $row_suat = mysqli_fetch_assoc($result_suat);
    if (mysqli_num_rows($result_suat) <> 0) {
        $suat_array = mysqli_fetch_assoc($result_suat);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        $idPhim = $_POST['tenPhim'];
        $rap = $_POST['rap'];
        $ngaychieu = $_POST['ngaychieu'];
        $giochieu = $_POST['giochieu'];

        // Cập nhật dữ liệu vào cơ sở dữ liệu
        $sql_update = "UPDATE SuatChieu SET IDPhim='$idPhim', IDRap ='$rap', NgayChieu='$ngaychieu', GioChieu='$giochieu' WHERE IDSuat='$idSuat'";
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
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                                class="fa fa-video me-2"></i>Phim</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="listphim.php" class="dropdown-item">Danh sách phim</a>
                            <a href="themphim.php" class="dropdown-item">Thêm phim</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown"><i
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
                                <label for="theLoai" class="form-label">Phim</label>
                                <select class="form-select mb-3" name="tenPhim" aria-label="Default select example">
                                    <option value="<?php echo $row_suat['IDPhim'] ?>">
                                        <?php echo $row_suat['TenPhim']; ?>
                                    </option>
                                    <?php
                                    $selectedID = $row_suat['IDPhim']; // ID của thể loại phim đã được chọn từ cơ sở dữ liệu
                                    $sql_phim = "SELECT * FROM Phim";
                                    $result_phim = mysqli_query($conn, $sql_phim);

                                    while ($row = mysqli_fetch_assoc($result_phim)) {
                                        $optionID = $row['IDPhim'];
                                        $optionName = $row['TenPhim'];

                                        // Kiểm tra nếu ID tùy chọn trùng khớp với ID của thể loại phim đã được chọn từ cơ sở dữ liệu
                                        if ($optionID != $selectedID) {
                                            echo '<option value="' . $optionID . '">' . $optionName . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="theLoai" class="form-label">Thể Loại</label>
                                <select class="form-select mb-3" name="rap" aria-label="Default select example">
                                    <option value="<?php echo $row_suat['IDRap'] ?>">
                                        <?php echo $row_suat['TenRap']; ?>
                                    </option>
                                    <?php
                                    $selectedID = $row_suat['IDRap']; // ID của thể loại phim đã được chọn từ cơ sở dữ liệu
                                    $sql_rap = "SELECT * FROM rap";
                                    $result_rap = mysqli_query($conn, $sql_rap);

                                    while ($row = mysqli_fetch_assoc($result_rap)) {
                                        $optionID = $row['IDRap'];
                                        $optionName = $row['TenRap'];

                                        if ($optionID != $selectedID) {
                                            echo '<option value="' . $optionID . '">' . $optionName . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="giochieu" class="form-label">Giờ chiếu</label>
                                <input type="time" class="form-control" name="giochieu" aria-describedby="giochieu" value="<?php echo $row_suat['GioChieu'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="ngaychieu" class="form-label">Ngày chiếu</label>
                                <input type="date" class="form-control" name="ngaychieu" aria-describedby="ngaychieu" value="<?php echo $row_suat['NgayChieu'] ?>">
                            </div>
                            <button type="submit" class="btn btn-warning m-2" name="update">Sửa Suất</button>
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