<?php
include 'assets/connect.php';

// Đặt số bản ghi mỗi trang
$IDPhim = isset($_GET['IDPhim']) ? $_GET['IDPhim'] : '';
$reviews_per_page = 6;

// Xác định trang hiện tại từ yêu cầu AJAX
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start = ($current_page - 1) * $reviews_per_page;

// Truy vấn SQL để lấy dữ liệu đánh giá cho trang hiện tại
$sql_reviews = "SELECT * FROM danhgiaphim JOIN Phim ON danhgiaphim.IDPhim = Phim.IDPhim
                JOIN khachhang ON danhgiaphim.IDKH = khachhang.IDKH 
                WHERE danhgiaphim.IDPhim = '$IDPhim' ORDER BY danhgiaphim.IDPhim DESC LIMIT $start, $reviews_per_page";
$result_review = mysqli_query($conn, $sql_reviews);

// Kiểm tra và hiển thị dữ liệu đánh giá
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

// Tính tổng số trang
$sql_count = "SELECT COUNT(*) AS count FROM danhgiaphim WHERE IDPhim = '$IDPhim'";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_pages = ceil($row_count['count'] / $reviews_per_page);

// Hiển thị liên kết phân trang

?>
