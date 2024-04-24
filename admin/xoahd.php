<?php
include '../assets/connect.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Lấy ID của vé từ URL và làm sạch để tránh tấn công SQL Injection
    $hd_id = $_GET['id'];

    // Thực hiện câu truy vấn SQL để xóa vé
    $sql = "DELETE FROM hoadon WHERE IDHoaDon = '$hd_id'";
    $result_delete = mysqli_query($conn, $sql);
    if ($result_delete) {
        header("Location: listhoadon.php");
    } else {
        $msg = '<div class="alert alert-danger" role="alert">
        Xóa thất bại
    </div>';
    }
} else {
    // Nếu không có ID vé được truyền từ URL, cung cấp thông báo lỗi hoặc chuyển hướng người dùng đến trang khác
    echo "Không có ID vé được cung cấp hoặc ID hóa đơn không hợp lệ.";
}
?>