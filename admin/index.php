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

$month = date("m"); // Lấy tháng hiện tại, bạn có thể thay đổi thành tháng khác nếu cần
$year = date("Y"); // Lấy năm hiện tại

// Tạo truy vấn SQL để lấy tổng doanh thu từ bảng hóa đơn cho tháng và năm đã chọn
$sql = "SELECT SUM(TongTien) AS TotalRevenue FROM hoadon WHERE MONTH(ThoiGianThanhToan) = '$month' AND YEAR(ThoiGianThanhToan) = '$year'";

$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalRevenue = $row['TotalRevenue'];

} else {
    echo "Đã xảy ra lỗi khi truy vấn cơ sở dữ liệu";
}

// Tạo truy vấn SQL để đếm số lượng vé đã đặt cho mỗi tháng trong năm đã chọn
$sqlTicketsPerMonth = "SELECT COUNT(*) AS TotalTickets FROM Ve WHERE MONTH(TimeBooking) = '$month' AND YEAR(TimeBooking) = '$year'";

$resultTicketsPerMonth = mysqli_query($conn, $sqlTicketsPerMonth);

if ($resultTicketsPerMonth) {
    $rowTicketsPerMonth = mysqli_fetch_assoc($resultTicketsPerMonth);
    $totalTicketsPerMonth = $rowTicketsPerMonth['TotalTickets'];
} else {
    echo "Đã xảy ra lỗi khi truy vấn cơ sở dữ liệu";
}


$sql_thongke = "SELECT IDPhim, COUNT(*) AS SoVeDaDat FROM Ve GROUP BY IDPhim";
$result_thongke = mysqli_query($conn, $sql_thongke);

// Kiểm tra và xử lý kết quả
if (mysqli_num_rows($result_thongke) > 0) {
    $movies = array();
    $tickets = array();

    // Lặp qua các hàng kết quả
    while ($row_thongke = mysqli_fetch_assoc($result_thongke)) {
        // Lấy tên phim và số vé đã đặt cho mỗi phim
        $movies[] = $row_thongke['IDPhim'];
        $tickets[] = $row_thongke['SoVeDaDat'];
    }
} else {
    echo "Không có dữ liệu";
}

// Truy vấn SQL để lấy thông tin từ bảng Phim
$sql_phim = "SELECT IDPhim, TenPhim FROM Phim";
$result_phim = mysqli_query($conn, $sql_phim);

// Kiểm tra và xử lý kết quả
if (mysqli_num_rows($result_phim) > 0) {
    $phim_data = array();

    // Lặp qua các hàng kết quả
    while ($row_phim = mysqli_fetch_assoc($result_phim)) {
        // Lưu trữ thông tin tên phim theo ID phim
        $phim_data[$row_phim['IDPhim']] = $row_phim['TenPhim'];
    }
} else {
    echo "Không có dữ liệu từ bảng Phim";
}

// Sau khi có dữ liệu từ cả hai bảng, thay thế ID phim bằng tên phim trong mảng $movies
for ($i = 0; $i < count($movies); $i++) {
    $id_phim = $movies[$i];
    if (isset($phim_data[$id_phim])) {
        $movies[$i] = $phim_data[$id_phim];
    }
}

// Truy vấn SQL để đếm số lượng vé đã đặt cho mỗi rạp
$sql_rap = "SELECT IDRap, COUNT(*) AS SoVeDaDat FROM Ve GROUP BY IDRap";
$result_rap = mysqli_query($conn, $sql_rap);

// Kiểm tra và xử lý kết quả
if (mysqli_num_rows($result_rap) > 0) {
    $rap_data = array();

    // Lặp qua các hàng kết quả
    while ($row_rap = mysqli_fetch_assoc($result_rap)) {
        // Lưu trữ thông tin số vé đã đặt theo ID rạp
        $rap_data[$row_rap['IDRap']] = $row_rap['SoVeDaDat'];
    }
} else {
    echo "Không có dữ liệu từ bảng Ve";
}

// Truy vấn SQL để lấy thông tin từ bảng Rap
$sql_ten_rap = "SELECT IDRap, TenRap FROM Rap";
$result_ten_rap = mysqli_query($conn, $sql_ten_rap);

// Kiểm tra và xử lý kết quả
if (mysqli_num_rows($result_ten_rap) > 0) {
    $ten_rap_data = array();

    // Lặp qua các hàng kết quả
    while ($row_ten_rap = mysqli_fetch_assoc($result_ten_rap)) {
        // Lưu trữ thông tin tên rạp theo ID rạp
        $ten_rap_data[$row_ten_rap['IDRap']] = $row_ten_rap['TenRap'];
    }
} else {
    echo "Không có dữ liệu từ bảng Rap";
}

// Sau khi có dữ liệu từ cả hai bảng, thay thế ID rạp bằng tên rạp trong mảng $rap
foreach ($rap_data as $id_rap => $so_ve_da_dat) {
    if (isset($ten_rap_data[$id_rap])) {
        $rap_data[$ten_rap_data[$id_rap]] = $so_ve_da_dat;
        unset($rap_data[$id_rap]);
    }
}


// Truy vấn SQL để lấy tất cả các phim và tổng doanh thu của mỗi phim
$sql_doanh_thu_phim = "SELECT Phim.TenPhim, SUM(hoadon.TongTien) AS TongDoanhThu 
                       FROM Phim LEFT JOIN hoadon ON Phim.IDPhim = hoadon.IDPhim 
                       GROUP BY Phim.IDPhim";
$result_doanh_thu_phim = mysqli_query($conn, $sql_doanh_thu_phim);

$doanhthuphim_array = array();
while ($row_doanhthuphim = mysqli_fetch_array($result_doanh_thu_phim)) {
    $doanhthuphim_array[] = $row_doanhthuphim;
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
                    <a href="index.php" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Thống
                        kê</a>
                    <a href="listhoadon.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Hóa Đơn</a>
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


            <!-- Sale & Revenue Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4 justify-content-center">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-line fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Doanh Thu Theo Tháng</p>
                                <h6 class="mb-0"><?php echo number_format($totalRevenue, 0, ',', '.') . " đ" ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-bar fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Số Vé Đã Đặt Trong Tháng</p>
                                <h6 class="mb-0"><?php echo $totalTicketsPerMonth ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Số vé đã đặt</h6>
                            <canvas id="bar-chart"></canvas>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Thống kê rạp</h6>
                            <canvas id="bar-chart-rap"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sale & Revenue End -->


            <!-- Sales Chart Start -->

            <!-- Sales Chart End -->


            <!-- Recent Sales Start -->

            <!-- Recent Sales End -->


            <!-- Widgets Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h3 class="mb-0 mx-auto">Doanh Thu Các Phim</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-white">
                                    <th scope="col">Tên Phim</th>
                                    <th scope="col">Doanh Thu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($doanhthuphim_array as $key => $doanhthu) { ?>
                                    <tr>
                                        <th scope="row">
                                            <?php echo $doanhthu['TenPhim']; ?>
                                        </th>
                                        <th scope="row">
                                            <?php echo number_format($doanhthu['TongDoanhThu'], 0, ',', '.') . " đ"; ?>
                                        </th>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Widgets End -->


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
    <script>
        var movies = <?php echo json_encode($movies); ?>;
        var tickets = <?php echo json_encode($tickets); ?>;

        // Tạo biểu đồ sử dụng dữ liệu vừa lấy được
        var ctx4 = document.getElementById('bar-chart').getContext('2d');
        var myChart4 = new Chart(ctx4, {
            type: 'bar',
            data: {
                labels: movies,
                datasets: [{
                    label: 'Số vé đã đặt',
                    data: tickets,
                    backgroundColor: 'rgba(235, 22, 22, .7)',
                    borderColor: 'rgba(235, 22, 22, .7)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Lấy context của canvas
        var ctx = document.getElementById('bar-chart-rap').getContext('2d');

        // Khởi tạo biểu đồ bar
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_keys($rap_data)); ?>, // Tên của các rạp
                datasets: [{
                    label: 'Số vé đã đặt',
                    data: <?php echo json_encode(array_values($rap_data)); ?>, // Số vé đã đặt cho từng rạp
                    backgroundColor: 'rgba(54, 162, 235, 0.7)', // Màu nền của các thanh trong biểu đồ
                    borderColor: 'rgba(54, 162, 235, 1)', // Màu viền của các thanh trong biểu đồ
                    borderWidth: 1 // Độ dày của viền
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true // Đặt giá trị y bắt đầu từ 0
                    }
                }
            }
        });
    </script>
</body>

</html>